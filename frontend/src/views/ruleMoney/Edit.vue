<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <h1 class="text-center">
          Rules Of Requests
          </h1>
          <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
            {{ dismissCountDown }} {{ message }}
          </CAlert>
          <div class="form-group">
            <label>Min Amount</label>
            <input
              type="text"
              :placeholder="'min' + '...'"
              v-model="max_money"
              :class="{
                'form-control': true
              }"
            />
          </div>

          <div class="form-group">
            <label>Number Of Weeks</label>
            <input
              type="number"
              v-model="week"
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
      max_money: "",
      week: "",
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
      formData.append("max_money", this.max_money);
      formData.append("week", this.week);


      axios
        .post(
          "/api/rules" +
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
          "/api/rules" +
          "?token=" +
          localStorage.getItem("api_token")
        )
        .then(function(response) {

          self.week = response.data[0].role.week;
          self.max_money = response.data[0].role.max_money;
          console.log(response.data[0].role);
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
