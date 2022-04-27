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
            <ul v-if="message instanceof Object">
              <li v-for="item in message">
                ({{ dismissCountDown }}) {{ item[0] }}
              </li>
            </ul>
            <span v-if="alertColor=='danger' && message instanceof Object==false">
              ({{ dismissCountDown }}) unexpected error occurred in creating .
            </span>
            <span v-if="alertColor=='success'">
              ({{ dismissCountDown }}){{message}}
            </span>
          </CAlert>
          <div class="form-group">
            <p>{{ $t("company_name") }}</p>
            <input
              type="text"
              :placeholder="$t('company_name') + '...'"
              v-model.trim="$v.company_name.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.company_name.$error,
                'is-valid': !$v.company_name.$invalid
              }"
            />
            <div v-if="!$v.company_name.$error" class="valid-feedback">
              your company name is valid !
            </div>

            <div v-if="$v.company_name.$error" class="invalid-feedback">
              <span v-if="!$v.company_name.required">
                Your company name is required .
              </span>

              <span v-if="!$v.company_name.minLength">
                Your company name must have at least
                {{ $v.company_name.$params.minLength.min }} letters
              </span>

              <span v-if="!$v.company_name.maxLength">
                Your company name must have at most
                {{ $v.company_name.$params.maxLength.max }} letters
              </span>
            </div>
          </div>
          <div class="form-group">

            <label>Name of the contact person.</label>
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
            <label>Main phone number.</label>
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
               <span class="d-block" v-if="!$v.phone.isStartWith">
                  Your phone must Start With 05
                </span>
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
            <p>Main Email.</p>
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
            <label for="">Country</label>
            <select
              @change="getCities()"
              v-model.trim="$v.country.$model"
              :class="{
                  'form-control': true,
                  'is-invalid': $v.country.$error,
                  'is-valid': !$v.country.$invalid
                }"
            >
              <option
                v-for="(country, index) in countries"
                :key="index"
                :value="country.id"
              >{{ country.name }}</option
              >
            </select>
            <div class="valid-feedback">
              your country is valid !
            </div>

            <div class="invalid-feedback">
                <span class="d-block" v-if="!$v.country.required">
                  Your country is required .
                </span>
            </div>
          </div>
          <div class="form-group">
            <label for="">City</label>
            <select

              v-model.trim="$v.city_id.$model"
              :class="{
                  'form-control': true,
                  'is-invalid': $v.city_id.$error,
                  'is-valid': !$v.city_id.$invalid
                }"
            >
              <option
                v-for="(city, index) in cities"
                :key="index"
                :value="city.id"
              >{{ city.name }}</option
              >
            </select>
            <div class="valid-feedback">
              your city is valid !
            </div>

            <div class="invalid-feedback">
                <span class="d-block" v-if="!$v.city_id.required">
                  Your city is required .
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
        </CCardBody>
      </CCard>
    </CCol>

    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <div role="group" class="form-group">
            <p>Delivery Fees</p>
            <select
              type="text"
              v-model.trim="$v.commission.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.commission.$error,
                'is-valid': !$v.commission.$invalid
              }"
            >
              <option
                v-for="(commission, index) in allCommissions"
                :value="commission.id"
                :key="index"
              >
                {{ commission.name }}
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
      countries:{},
      country:{},
      cities:{},
      name: "",
      phone: "",
      address: "",
      status: "",
      showErrorEmail: false,
      email: "",
      password: "",
      city: "",
      city_id: "",
      commission: "",
      allCommissions:[],
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
      minLength: minLength(10),
      maxLength: maxLength(10),
      isStartWith(value) {
        if (value === "") return true;
        return new Promise(resolve => {
          resolve(value.startsWith("05"));
        });
      },
      isUnique(value) {
        if (value === "") return true;

        return new Promise(resolve => {
          let formData = new FormData();
          formData.append("phone", value);
          axios
            .post(
              "/api/s-check-phone?token=" + localStorage.getItem("api_token"),
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
    commission: {
      required
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
    city_id: {
      required,

    },
    country: {
      required,

    }
  },
  methods: {
    getCountries() {
      this.loading = true;
      let self = this;
      this.items = [];
      axios
        .get(
          "/api/driver-applications/create" +
          "?token=" +
          localStorage.getItem("api_token")
        )
        .then(function(response) {
          console.log(response);

          self.countries = response.data.countries;
          self.role = response.data.user.menuroles;
          console.log(response);
        })
        .catch(function(error) {
          console.log(error);
          self.loading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in getting data.";
          self.showAlert();
        });
    },
    getCities() {
      this.loading = true;
      let self = this;
      this.items = [];
      axios
        .get(
          "/api/cities/"+this.country+
          "?token=" +
          localStorage.getItem("api_token")
        )
        .then(function(response) {
          console.log(response);
          self.cities = response.data.cities;
          console.log( self.cities );
        })
        .catch(function(error) {
          console.log(error);
        });
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
      this.$router.replace({ path: "/driver-applications" });
    },
    store() {
      let self = this;
      let formData = new FormData();
      formData.append("name", this.name);
      formData.append("phone", this.phone);
      formData.append("email", this.email);
      formData.append("city_id", this.city_id);
      formData.append("password", this.password);
      formData.append("address", this.address);
      formData.append("status", this.status);
      formData.append("api_id", this.apiKey);
      formData.append("commission", this.commission);
      formData.append("company_name", this.company_name);

      axios
        .post(
          "/api/client" + "?token=" + localStorage.getItem("api_token"),
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

            self.alertColor = "danger";
            self.message = error.response.data.message;
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
          self.allCommissions = response.data.commissions;
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
    this.getCountries();
    this.generatApiKey();
    this.getLocale();
    this.getFleets();
  }
};
</script>
