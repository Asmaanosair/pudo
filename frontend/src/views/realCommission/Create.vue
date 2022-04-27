<template>
  <CRow>
    <CCol col="12" lg="6">

      <CCard>
        <CCardBody>
          <h1 class="text-center">
            Create  Delivery Commission
          </h1>
          <template slot="header"> </template>
          <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
            ({{ dismissCountDown }}) {{ message }}
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
            <select class="form-control" name="" id="" v-model="type" @change="FShowInput">
              <option value="0">Fixed</option>
              <option value="1">Dynamic</option>
            </select>
          </div>
          <div class="form-group" v-show="showInput">
            <label>Default Distance</label>
            <input
              type="text"
              :placeholder="$t('Default Distance') + '...'"
              v-model.trim="distance"
              :class="{
                'form-control': true
              }"
            />
          </div>
          <div class="form-group">
            <label>
              Price {{ description}}</label>
            <input
              type="text"
              :placeholder="$t(' Price' ) +description+ '...'"
              v-model.trim="price_default"
              :class="{
                'form-control': true
              }"
            />
          </div>
          <div class="form-group" v-show="showInput">
            <label>
              Price after default distance per 1KM</label>
            <input
              type="text"
              :placeholder="$t('Price after default distance') + '...'"
              v-model.trim="price_after"
              :class="{
                'form-control': true
              }"
            />
          </div>
          <div class="form-group" v-show="showInput">
            <label>Max Delivery Commission per Order</label>
            <input
              type="text"
              :placeholder="$t('max_cost') + '...'"
              v-model.trim="max_cost"
              :class="{
                'form-control': true
              }"
            />
          </div>


          <div role="group" class="form-group">
            <p>City</p>
            <select class="form-control" v-model="city_id">
              <option  v-for="item in cities " :value="item.id">{{ item.name }} </option>

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
      max_cost: 0,
      type: 0,
      price_after: 0,
      price_default: 0,
      distance: 0,
      city_id: "",
      cities: {},
      imageIndex: null,
      myLang: "",
      showMessage: false,
      message: "",
      showInput:false,
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
      formData.append("max_cost", this.max_cost);
      formData.append("price_after", this.price_after);
      formData.append("price_default", this.price_default);
      formData.append("city_id", this.city_id);
      formData.append("distance", this.distance);

      axios
        .post(
          "/api/real-commission" + "?token=" + localStorage.getItem("api_token"),
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        )
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully Created .";
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
            self.message = "unexpected error occurred in creating new .";
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
          "/api/real-commission/create" +
          "?token=" +
          localStorage.getItem("api_token")
        )
        .then(function(response) {
          console.log(response);
          self.cities = response.data.cities;
        })
        .catch(function(error) {
          console.log(error);

          self.loading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in getting .";
          self.showAlert();
        });
    },
    getLocale() {
      let locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
    },

  },

  mounted: function() {
    this.getFleets()
  }
};
</script>
