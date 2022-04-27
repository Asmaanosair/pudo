<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <h1 class="text-center">
            Edit Delivery Cost
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
          <div role="group" class="form-group" >
            <p>type</p>
            <select class="form-control" name="" id="" v-model="type"  @change="FShowInput">
              <option value="0">Fixed</option>
              <option value="1">Dynamic</option>
            </select>
          </div>

          <div class="form-group"  v-show="showInput">
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
            <label>Price {{description}}</label>
            <input
              type="text"
              :placeholder="$t('price') + description + '...'"
              v-model.trim="price"
              :class="{
                'form-control': true
              }"
            />
          </div>

          <div class="form-group"  v-show="showInput">
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
          <div class="form-group"  v-show="showInput">
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
      type: "",
      max_cost:"",
      price: "",
      distance: "",
      price_more_kilo:'',
      imageIndex: null,
      myLang: "",
      showMessage: false,
      showInput:false,
      type2: "",

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
        this.description=" ";
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
    commissionInfo() {
      let self = this;
      axios
        .get(
          "/api/commission/" +
            self.$route.params.id +
            "/edit?token=" +
            localStorage.getItem("api_token")
        )
        .then(function(response) {
          (self.name = response.data.commission.name),
            (self.price = response.data.commission.price),
            (self.distance = response.data.commission.distance),
            (self.type2 = response.data.commission.type2),
            (self.type = response.data.commission.type),
            (self.price_more_kilo = response.data.commission.price_more_kilo);
           (self.max_cost = response.data.commission.max_cost);
          if (self.type == 0) {
            self.showInput = false;
            self.description=" ";
          }
          if (self.type == 1){
            self.showInput = true;
            self.description="for default distance ";
          }
        })
        .catch(function(error) {
          console.log(error);
          self.alertColor = "danger";
          self.message =
            "unexpected error occurred in loading the delivery fees info.";
          self.showAlert();
        });
    },
    store() {
      let self = this;
      let formData = new FormData();
      formData.append("name", this.name);
      formData.append("type", this.type);
      formData.append("type2", this.type2);
      formData.append("price", this.price);
      formData.append("max_cost", this.max_cost);
      formData.append("distance", this.distance);
      formData.append("price_more_kilo", this.price_more_kilo);

      formData.append("_method", "PUT");
      axios
        .post(
          "/api/commission/" +
            self.$route.params.id +
            "?token=" +
            localStorage.getItem("api_token"),
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        )
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully updated delivery fess.";
          self.showAlert();
          self.goBack();
        })
        .catch(function(error) {
          console.log(error);
          self.alertColor = "danger";
          self.message = "unexpected error occurred in Editing .";
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

  mounted: function() {
    this.commissionInfo();
  }
};
</script>
