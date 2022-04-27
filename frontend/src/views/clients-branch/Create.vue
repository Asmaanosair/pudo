<template>
  <CRow
    :style="[myLang == 'ar' ? { direction: 'rtl', 'text-align': 'right' } : '']"
  >
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <template slot="header">
            Create Users
          </template>
          <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
            ({{ dismissCountDown }}) {{ message }}
          </CAlert>
          <div class="form-group">
            <label>{{ $t("name") }}</label>
            <input
              type="text"
              :placeholder="$t('name') + '...'"
              v-model.trim="$v.name.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.name.$error,
                'is-valid': !$v.name.$invalid
              }"
            />
            <div v-if="!$v.name.$error" class="valid-feedback">
              your name is valid !
            </div>

            <div v-if="$v.name.$error" class="invalid-feedback">
              <span v-if="!$v.name.required">
                Your name is required .
              </span>

              <span v-if="!$v.name.minLength">
                Your name must have at least
                {{ $v.name.$params.minLength.min }} letters
              </span>

              <span v-if="!$v.name.maxLength">
                Your name must have at most
                {{ $v.name.$params.maxLength.max }} letters
              </span>
            </div>
          </div>
          <div class="form-group">
            <label>{{ $t("mobile") }}</label>
            <input
              type="text"
              :placeholder="$t('mobile') + '...'"
              v-model.trim="$v.phone.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.phone.$error,
                'is-valid': !$v.phone.$invalid
              }"
            />

            <div v-if="!$v.phone.$error" class="valid-feedback">
              your phone is valid !
            </div>

            <div v-if="$v.phone.$error" class="invalid-feedback">
              <span v-if="!$v.phone.required">
                Your phone is required .
              </span>
              <span v-if="!$v.phone.numeric">
                Your phone must be numbers
              </span>

              <span v-if="!$v.phone.minLength">
                Your phone must have at least
                {{ $v.phone.$params.minLength.min }} numbers
              </span>

              <span v-if="!$v.phone.maxLength">
                Your phone must have at most
                {{ $v.phone.$params.maxLength.max }} numbers
              </span>
              <span v-if="!$v.phone.isUnique">
                this phone is already be taken .
              </span>
            </div>
          </div>
          <div class="form-group">
            <p>{{ $t("email") }}</p>
            <input
              type="email"
              :placeholder="$t('email') + '...'"
              v-model.trim="$v.email.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.email.$error,
                'is-valid': !$v.email.$invalid
              }"
            />

            <div v-if="!$v.email.$error" class="valid-feedback">
              your email is valid !
            </div>

            <div class="invalid-feedback">
              <span v-if="!$v.email.required">
                Your email is required .
              </span>

              <span v-if="!$v.email.email">
                Your email should be valid email like(example@example.com) .
              </span>

              <span v-if="!$v.email.isUnique">
                this email is already be taken .
              </span>
            </div>
          </div>
          <div class="form-group">
            <p>{{ $t("address") }}</p>
            <input
              type="text"
              id="places"
              :placeholder="$t('address') + '...'"
              v-model.trim="$v.address.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.address.$error,
                'is-valid': !$v.address.$invalid
              }"
            />

            <div v-if="!$v.address.$error" class="valid-feedback">
              your address is valid !
            </div>

            <div v-if="$v.address.$error" class="invalid-feedback">
              <span v-if="!$v.address.required">
                Your address is required .
              </span>
              <span v-if="!$v.address.minLength">
                Your address must have at least
                {{ $v.address.$params.minLength.min }} letters
              </span>
            </div>
          </div>
          <div class="form-group">
            <p>{{ $t("city") }}</p>
            <input
              type="text"
              :placeholder="$t('city') + '...'"
              v-model.trim="$v.city.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.city.$error,
                'is-valid': !$v.city.$invalid
              }"
            />

            <div v-if="!$v.city.$error" class="valid-feedback">
              your city is valid !
            </div>

            <div v-if="$v.city.$error" class="invalid-feedback">
              <span v-if="!$v.city.required">
                Your city is required .
              </span>

              <span v-if="!$v.city.minLength">
                Your city name must have at least
                {{ $v.city.$params.minLength.min }} letters
              </span>
            </div>
          </div>

          <div class="form-group">
            <p>{{ $t("password") }}</p>

            <input
              type="text"
              :placeholder="$t('password') + '...'"
              v-model="password"
              v-model.trim="$v.password.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.password.$error,
                'is-valid': !$v.password.$invalid
              }"
            />

            <div v-if="!$v.password.$error" class="valid-feedback">
              your password is valid !
            </div>

            <div v-if="$v.password.$error" class="invalid-feedback">
              <span v-if="!$v.password.required">
                Your password is required .
              </span>

              <span v-if="!$v.password.minLength">
                Your password must have at least
                {{ $v.password.$params.minLength.min }} numbers
              </span>
            </div>
          </div>

          <div role="group" class="form-group">
            <p>{{ $t("status") }}</p>
            <select
              type="text"
              v-model.trim="$v.status.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.status.$error,
                'is-valid': !$v.status.$invalid
              }"
            >
              <option
                v-for="(status, index) in allStatus"
                :value="status.name"
                :key="index"
              >
                {{ status.name }}
              </option>
            </select>

            <div class="valid-feedback">
              your status is valid !
            </div>

            <div class="invalid-feedback">
              <span v-if="!$v.status.required">
                Your status is required .
              </span>
            </div>
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
  name: "Creat",
  data: () => {
    return {
      allStatus: {},
      name: "",
      phone: "",
      address: "",
      status: "",
      showErrorEmail: false,
      email: "",
      password: "",
      city: "",
      kilo_price: "",
      apiKey: "",
      company_name: "",
      imageIndex: null,
      myLang: "",
      showMessage: false,
      message: "",
      alertColor: "",
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    };
  },
  validations: {
    name: {
      required,
      minLength: minLength(6),
      maxLength: maxLength(40)
    },
    phone: {
      required,
      numeric,
      minLength: minLength(11),
      maxLength: maxLength(20),
      isUnique(value) {
        if (value === "") return true;

        return new Promise(resolve => {
          let formData = new FormData();
          formData.append("phone", value);
          axios
            .post(
              "/api/check-phone?token=" + localStorage.getItem("api_token"),
              formData
            )
            .then(function(response) {
              resolve(response.data);
            });
        });
      }
    },
    email: {
      required,
      email,
      isUnique(value) {
        self = this;

        if (value === "") return true;

        return new Promise(resolve => {
          let formData = new FormData();
          formData.append("email", value);
          axios
            .post(
              "/api/check-email?token=" + localStorage.getItem("api_token"),
              formData
            )
            .then(function(response) {
              resolve(response.data);
            });
        });
      }
    },
    password: {
      required,
      minLength: minLength(8)
    },
    kilo_price: {
      required,
      numeric,
      minValue: minValue(1)
    },
    company_name: {
      required,
      minLength: minLength(3),
      maxLength: maxLength(20)
    },
    status: {
      required
    },
    address: {
      required,
      minLength: minLength(5)
    },
    city: {
      required,
      minLength: minLength(2)
    }
  },
  methods: {
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
      this.$router.replace({ path: "/driver-applications" });
    },
    store() {
      let self = this;
      let formData = new FormData();
      formData.append("name", this.name);
      formData.append("phone", this.phone);
      formData.append("email", this.email);
      formData.append("city", this.city);
      formData.append("password", this.password);
      formData.append("address", this.address);
      formData.append("status", this.status);
      formData.append("api_id", this.apiKey);

      axios
        .post(
          "/api/client-branch" + "?token=" + localStorage.getItem("api_token"),
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        )
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully Created Fleet.";
          self.showAlert();
          self.$router.go(-1);
          self.$router.replace({ path: "/driver-applications" });
        })
        .catch(function(error) {
          if (error.message == "Request failed with status code 500") {
            self.alertColor = "success";
            self.message = "Successfully Created Fleet.";
            self.$router.go(-1);
            self.$router.replace({ path: "/driver-applications" });
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
          "/api/client/create" + "?token=" + localStorage.getItem("api_token")
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
    this.getCity();
    this.generatApiKey();
    this.getLocale();
    this.getFleets();
  }
};
</script>
