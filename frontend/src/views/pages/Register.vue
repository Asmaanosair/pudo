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
                <CForm @submit.prevent="reset" method="POST">
                  <h1 class="my-login-text">Reset Password</h1>
                  <p class="text-muted my-login-text">
<!--                    New Password Will send to your Phone-->
                  </p>
                  <CInput
                    v-model="phone"
                    prependHtml="<i class='cui-user '  ></i>"
                    placeholder="Phone Number"
                    autocomplete="Phone Number"
                  >
                    <template #prepend-content
                    ><CIcon name="cil-phone"
                    /></template>
                  </CInput>

                  <CRow style="padding-top: 10px !important">
                    <CCol col="6" style="margin: 10px">
                      <CButton type="submit" class="my-bg-orange px-4 btn-block"
                      >Send</CButton
                      >
                    </CCol>

                  </CRow>
                </CForm>
              </CCardBody>
            </CCard>

          </CCardGroup>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

  <script>
    import axios from 'axios'
    import {asset} from "@codinglabs/laravel-asset";
    export default {
      data() {
        return {
          phone: '',
          showMessage: false,
          message: "",
          alertColor: "",
          dismissCountDown: 3,
          logoImg: asset("/img/logo.jpg"),
        }
      },
      methods: {
        reset() {
          var self = this;
          axios.post('/api/reset', {
            phone: self.phone,
          }).then(function (response) {
            self.phone = '';
            self.alertColor = "success";
            self.message = "  Password Sent Successfully   ";
            self.showMessage = true;
            self.showAlert();
            console.log(response);
          //  self.$router.push({ path: '/login' });
            setTimeout(() => (self.$router.push({ path: '/login' }), 5000));
          })
          .catch(function (error) {
            self.alertColor = "danger";
            self.message = "Incorrect Phone Number  ";
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
      }
    }

  </script>
