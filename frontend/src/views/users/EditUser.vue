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
              your first name is valid !
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
              your first phone is valid !
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
              your first email is valid !
            </div>

            <div v-if="$v.email.$error" class="invalid-feedback">
              <span v-if="!$v.email.required">
                Your email is required .
              </span>
              <span v-if="!$v.email.email">
                Your email should be valid email like(example@example.com) .
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

          <CButton color="primary" @click="update"> {{ $t("save") }}</CButton>
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
  name: "EditUser",
  props: {
    caption: {
      type: String,
      default: "User id"
    }
  },
  data: () => {
    return {
      allStatus: {},
      name: "",
      phone: "",
      address: "",
      status: "",
      password: "",
      email:"",
      role: "",
      city: "",
      kilo_price: 0,
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
      maxLength: maxLength(20)
    },
    age: {
      between: between(18, 100)
    },
    email: {
      required,
      email
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
    goBack() {
      this.$router.go(-1);
      // this.$router.replace({path: '/users'})
    },
    update() {
      let self = this;
      axios
        .post(
          "/api/users/" +
          self.$route.params.id +
          "?token=" +
          localStorage.getItem("api_token"),
          {
            _method: "PUT",
            name: self.name,
            email: self.email,
            phone: self.phone,
            role: self.role,
            status: self.status,
          }
        )
        .then(function(response) {
          self.message = "Successfully updated user.";
          self.showAlert();
        })
        .catch(function(error) {
          console.log(error);
          self.$router.push({ path: "/login" });
        });
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    getLocale() {
      let locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
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
  },
  mounted: function() {
    this.getLocale();
    this.getFleets();
    let self = this;

    axios
      .get(
        "/api/users/" +
        self.$route.params.id +
        "/edit?token=" +
        localStorage.getItem("api_token")
      )
      .then(function(response) {
        self.name = response.data.name;
        self.email = response.data.email;
        self.status = response.data.status;
        self.role = response.data.roles;
        self.phone = response.data.phone;
      })
      .catch(function(error) {
        console.log(error);
        self.$router.push({ path: "/login" });
      });
  }
};
</script>
