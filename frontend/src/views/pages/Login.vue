<template>
  <div class="min-vh-100">
    <h2 class="py-4 text-center the-main-brand">
      <img class="mylogo" :src="logoImg" />
    </h2>

    <CContainer class="d-flex content-center mt-3 my-login">
      <CRow style="padding-top: 5px !important">
        <CCol col="12" lg="12">
          <CCardGroup>
            <CCard class="p-4 my-card">
              <CCardBody style="margin: 15px">
                <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
                  {{ message }}
                </CAlert>
                <CForm @submit.prevent="login" method="POST">
                  <h1 class="my-login-text">Login</h1>
                  <p class="text-muted my-login-text">
                    Sign In to your account
                  </p>
                  <CInput
                    v-model="email"
                    prependHtml="<i class='cui-user '  ></i>"
                    placeholder="Username"
                    autocomplete="username email"
                  >
                    <template #prepend-content
                      ><CIcon name="cil-user"
                    /></template>
                  </CInput>
                  <CInput
                    v-model="password"
                    prependHtml="<i class='cui-lock-locked'></i>"
                    placeholder="Password"
                    type="password"
                    autocomplete="curent-password"
                  >
                    <template #prepend-content
                      ><CIcon name="cil-lock-locked"
                    /></template>
                  </CInput>
                  <CRow style="padding-top: 10px !important">
                    <CCol col="6" style="margin: 10px">
                      <CButton type="submit" class="my-bg-orange px-4 btn-block"
                        >Login</CButton
                      >
                    </CCol>
                    <CCol col="6" class="text-right">
                      <CButton  class="px-0 my-forgot"  @click="goRegister()"
                        >Forgot password?</CButton
                      >
                    </CCol>
                  </CRow>
                </CForm>
              </CCardBody>
            </CCard>
<!--             <CCard-->
<!--              color="primary"-->
<!--              text-color="white"-->
<!--              class="text-center py-5 d-md-down-none"-->
<!--              body-wrapper-->
<!--            >-->
<!--              <h2>Who can sign in to Pudo?</h2>-->
<!--              <p>this login for our Clients Who are using our services</p>-->
<!--              <CButton-->
<!--                color="primary"-->
<!--                class="active mt-3 my-bg-white"-->
<!--                @click="goRegister()"-->
<!--              >-->
<!--                Contact Us!-->
<!--              </CButton>-->
<!--            </CCard> -->
          </CCardGroup>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
import axios from "axios";
import { asset } from "@codinglabs/laravel-asset";

export default {
  name: "Login",
  data() {
    return {
      email: "",
      password: "",
      showMessage: false,
      message: "",
      alertColor: "",
      dismissCountDown: 3,
      logoImg: asset("/img/logo.jpg"),
    };
  },
  methods: {
    goRegister() {
      this.$router.push({ path: "reset" });
    },
    login() {
      let self = this;
      axios
        .post("/api/login", {
          email: self.email,
          password: self.password,
        })
        .then(function (response) {
          self.email = "";
          self.password = "";
          localStorage.setItem("api_token", response.data.access_token);
          // localStorage.setItem("role", response.data.menuroles);
           console.log("")
          console.log(response.data)
          self.$router.push({ path: "/orders" });
        })
        .catch(function (error) {
          self.alertColor = "danger";
          self.message = "Incorrect E-mail or password";
          self.showMessage = true;
          self.showAlert();
          console.log(error);
        });
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
  },
  mounted() {
    let self = this;
    if (localStorage.getItem("api_token") !== null) {
      axios
        .post("/api/refresh?token=" + localStorage.getItem("api_token"))
        .then(function (response) {
          console.log(response);
          localStorage.setItem("api_token", response.data.access_token);
          self.$router.push({ path: "/maps/show" });
        })
        .catch(function (error) {
          localStorage.removeItem("api_token");
          self.$router.push({ path: "/login" });
        });
    }
  },
};
</script>
