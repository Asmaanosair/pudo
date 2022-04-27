<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <h1 class="text-center">
        Max Number of shipping labels
          </h1>
          <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
            {{ dismissCountDown }} {{ message }}
          </CAlert>
          <div class="form-group">
            <label>Max Number</label>
            <input
              type="text"
              :placeholder="'min' + '...'"
              v-model="max_number"
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


import axios from "axios";
export default {
  data: () => {
    return {
      max_number: "",

      showMessage: false,
      message: "",
      alertColor: "",
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    };
  },
  methods: {

    goBack() {
      this.$router.go(-1);
    },

    store() {
      let self = this;
      let formData = new FormData();
      formData.append("max_number", this.max_number);
      axios
        .post(
          "/api/shipping-labels" +
          "?token=" +
          localStorage.getItem("api_token"),
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        )
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully updated .";
          self.showAlert();
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
          "/api/shipping-labels" +
          "?token=" +
          localStorage.getItem("api_token")
        )
        .then(function(response) {

          self.max_number = response.data[0].role.max_number;

        })
        .catch(function(error) {
          console.log(error);

          self.loading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in getting data.";
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
    this.getFleets();
  }
};
</script>
