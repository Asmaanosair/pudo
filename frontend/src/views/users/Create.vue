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

            <div v-if="$v.email.$error" class="invalid-feedback">
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
          </div>
          <div role="group" class="form-group">
            <label class=""> {{ $t("role") }} </label>
            <select
              type="text"
              v-model.trim="$v.role.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.role.$error,
                'is-valid': !$v.role.$invalid
              }"
            >
              <option value="subadmin"> Sub Admin </option>
              <option value="dispatcher">dispatcher </option>
              <option value="teamleader"> team leader </option>
              <option value="support"> Support Agent </option>
            </select>

            <div class="valid-feedback">
              your role is valid !
            </div>

            <div class="invalid-feedback">
              <span v-if="!$v.role.required">
                Your role is required .
              </span>
            </div>
          </div>

          <CButton color="primary" @click="store()"> {{ $t("save") }}</CButton>
          <CButton color="primary" @click="goBack"> {{ $t("back") }}</CButton>
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
      password: "",
      role: "",
      email: "",
      city: "",
      kilo_price: 0,
      uid: "",
      company_name: "",
      myLang: "",
      imageIndex: null,
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
    age: {
      between: between(18, 100)
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
    role: {
      required
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
      this.uid = randomSerial;
    },
    goBack() {
      this.$router.go(-1);
      this.$router.replace({ path: "/driver-applications" });
    },
    store() {
      this.$v.$touch();
      let self = this;
      let formData = new FormData();
      formData.append("name", this.name);
      formData.append("phone", this.phone);
      formData.append("email", this.email);
      formData.append("role", this.role);
      formData.append("password", this.password);
      formData.append("status", this.status);
      formData.append("uid", this.uid);

      axios
        .post(
          "/api/users" + "?token=" + localStorage.getItem("api_token"),
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        )
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully Created .";
          self.showAlert();
          self.$router.go(-1);
          self.$router.replace({ path: "/users" });
        })
        .catch(function(error) {
          console.log(error);
          self.alertColor = "danger";
          self.message = "unexpected error occurred in creating .";
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
          "/api/supplier/create" + "?token=" + localStorage.getItem("api_token")
        )
        .then(function(response) {
          console.log(response);
          self.allStatus = response.data.status;
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
    }
  },

  mounted: function() {
    this.generatApiKey();
    this.getLocale();
    this.getFleets();
  }
};
</script>
