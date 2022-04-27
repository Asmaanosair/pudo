<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <h1 class="text-center">
            Delivery Cost
          </h1>
          <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
            {{ dismissCountDown }} {{ message }}
          </CAlert>
          <div class="form-group">
            <label>{{ $t("name") }}</label>
            <input
              type="text"
              :placeholder="$t('name') + '...'"
              v-model.trim="name"
              :class="{
                'form-control': true
              }"
            />
          </div>
          <div role="group" class="form-group">
            <p>type</p>
            <select class="form-control"  v-model="type" @change="FShowInput">
              <option value="0">Fixed</option>
              <option  value="1">Dynamic </option>
            </select>
          </div>

          <div class="form-group" v-show="showInput">
            <label>{{ $t("default distance") }}</label>
            <input
              type="text"
              :placeholder="$t('default distance') + '...'"
              v-model.trim="distance"
              :class="{
                'form-control': true
              }"
            />
          </div>

          <div class="form-group">
            <label>Price {{ description}}</label>
            <input
              type="text"
              :placeholder="$t('price') + description+ '...'"
              v-model.trim="price"
              :class="{
                'form-control': true
              }"
            />
          </div>


          <div class="form-group" v-show="showInput">
            <label>Price per more (1KM) </label>
            <input
              type="text"
              :placeholder="$t('price') + '...'"
              v-model.trim="price_more_kilo"
              :class="{
                'form-control': true
              }"
            />
          </div>
          <div class="form-group" v-show="showInput">
            <label>Max Delivery Cost per Order</label>
            <input
              type="text"
              :placeholder="$t('max_cost') + '...'"
              v-model.trim="max_cost"
              :class="{
                'form-control': true
              }"
            />
          </div>
          <div role="group" class="form-group" hidden>
            <p>type</p>
            <select class="form-control" name="" id="" v-model="type2" >
              <option value="Route" selected>Route</option>
              <option value="Straightline">Straightline</option>
            </select>
          </div>



          <CButton color="primary" @click="store()">{{ $t("save") }}</CButton>
          <CButton color="primary" @click="goBack">{{ $t("back") }}</CButton>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import {
  required,
  minLength,
  maxLength,
  between,
  email,
  minValue,
  numeric
} from "vuelidate/lib/validators";

import axios from "axios";
export default {
  name: "Create-commission",
  data: () => {
    return {
      name: "",
      description: "",
      type: 0,
      type2:"",
      max_cost:"",
      price: "",
      distance: "",
      price_more_kilo:'',
      imageIndex: null,
      myLang: "",
      showMessage: false,
      showInput:false,
      message: "",
      alertColor: "",
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    };
  },
  methods: {
    FShowInput() {
      if (this.type == 0) {
        this.showInput = false;
        this.description='';
      }
      if (this.type == 1){
        this.showInput = true;
        this.description="for default distance ";
      }
    },
    generatApiKey() {
      let serialList =
        "123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
      let serialLength = 64;
      let randomSerial = "";

      for (let x = 0; x < serialLength; x++) {
        let randomNum = Math.floor(Math.random() * serialList.length);

        randomSerial += serialList.substring(randomNum, randomNum + 1);
      }
      this.apiKey = randomSerial;
    },
    goBack() {
      this.$router.go(-1);
    },
    store() {
      let self = this;
      let formData = new FormData();
      formData.append("name", this.name);
      formData.append("type", this.type);
      formData.append("type2", this.type2);
      formData.append("max_cost", this.max_cost);

      formData.append("price", this.price);
      formData.append("distance", this.distance);
      formData.append("price_more_kilo", this.price_more_kilo);

      axios
        .post(
          "/api/commission" + "?token=" + localStorage.getItem("api_token"),
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        )
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully Created Fleet.";
          self.showAlert();
          self.$router.go(-1);
        })
        .catch(function(error) {
          if (error.message == "Request failed with status code 500") {
            self.alertColor = "success";
            self.message = "Successfully Created Fleet.";
            self.$router.go(-1);
          } else {
            self.alertColor = "danger";
            self.message = "unexpected error occurred in creating new fleet.";
          }
          self.showAlert();
        });
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },

    getFleets() {
      this.loading = true;
      let self = this;
      this.items = [];
      axios
        .get(
          "/api/commission/create" +
            "?token=" +
            localStorage.getItem("api_token")
        )
        .then(function(response) {
          console.log(response);
          self.allStatus = response.data.status;
        })
        .catch(function(error) {
          console.log(error);

          self.loading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in getting fleets.";
          self.showAlert();
        });
    },
    getLocale() {
      let locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
    },
    getCity() {
      self = this;
      var places = new google.maps.places.Autocomplete(
        document.getElementById("places")
      );

      google.maps.event.addListener(places, "place_changed", function() {
        var place = places.getPlace();
        self.address = place.formatted_address;
      });
    }
  },

  mounted: function() {}
};
</script>
