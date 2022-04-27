<template>
  <CRow>
    <CCol col="12" lg="8">
      <CCard no-header>
        <CCardBody>
          <CForm>
            <template slot="header">
              Create Users
            </template>
            <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
              ({{ dismissCountDown }}) {{ message }}
            </CAlert>
            <p>{{ $t("name") }}</p>
            <CInput
              type="text"
              :placeholder="$t('name') + '...'"
              v-model="name"
            ></CInput>
            <p>{{ $t("mobile") }}</p>

            <CInput
              type="text"
              :placeholder="$t('mobile') + '...'"
              v-model="mobile"
            ></CInput>
            <p>{{ $t("identity") }}</p>

            <CInput
              type="text"
              :placeholder="$t('identity') + '...'"
              v-model="identity"
            ></CInput>
            <p>{{ $t("password") }}</p>
            <CInput
              type="text"
              :placeholder="$t('password') + '...'"
              v-model="password"
            ></CInput>

            <CButton color="primary" @click="store()">{{ $t("save") }}</CButton>
            <CButton color="primary" @click="goBack">{{ $t("back") }}</CButton>
          </CForm>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from "axios";
export default {
  name: "CreatFleet",
  data: () => {
    return {
      name: "",
      mobile: "",
      identity: "",
      password: "",
      showMessage: false,
      message: "",
      alertColor: "",
      apiKey: "",
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    };
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
      alert(randomSerial);
    },
    goBack() {
      this.$router.go(-1);
      this.$router.replace({ path: "/fleets" });
    },
    store() {
      let self = this;
      axios
        .post("/api/fleets" + "?token=" + localStorage.getItem("api_token"), {
          name: self.name,
          mobile: self.mobile,
          identity: self.identity,
          password: self.password
        })
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully Created Fleet.";
          self.showAlert();
        })
        .catch(function(error) {
          console.log(error);
          self.alertColor = "danger";
          self.message = "unexpected error occurred in creating new fleet.";
          self.showAlert();
        });
    },

    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    }
  },
  mounted() {


  }
};
</script>
