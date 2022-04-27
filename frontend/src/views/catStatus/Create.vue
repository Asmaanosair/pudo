<template>
  <CRow>
    <CCol col="12" lg="6">

      <CCard no-header>
        <CCardBody>
          <template >
            <h6>
            Create   Category
            </h6>
          </template>
          <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
            ({{ dismissCountDown }}) {{ message }}
          </CAlert>

          <CInput
            type="text"
            label="Name"
            placeholder="Name"
            v-model="name"
          ></CInput>
          <CButton color="primary" @click="store()">Save</CButton>
        </CCardBody>
      </CCard>
    </CCol>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <template>
            <h6>
              Create   status
            </h6>
          </template>
          <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
            ({{ dismissCountDown }}) {{ message }}
          </CAlert>
          <CInput
            type="text"
            label="Name"
            placeholder="Name"
            v-model="name2"
          ></CInput>
          <label for="">Class </label>
          <select class="form-control" v-model="classn">
            <option value="success"> success </option>
            <option value="info "> info </option>
            <option value="primary">primary</option>
            <option value="warning "> warning </option>
            <option value="danger "> danger </option>
            <option value="secondary "> secondary </option>
          </select>
          <div role="group" class="form-group">
            <label class=""> Category  </label>
            <select
              type="text"
              v-model="catId"
              class="form-control"
            >
              <option
                v-for="(status, index) in allStatus"
                :value="status.id"
                :key="index"
              >
                {{ status.name }}
              </option>
            </select>
          </div>
          <CButton color="primary" @click="store2()">Save</CButton>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from "axios";
export default {
  name: "Creat",
  data: () => {
    return {

      allStatus: {},
      name: "",
      status: "status",
      cat: "cat",
      catId: "",
      name2: "",
      classn: "",
      imageIndex: null,
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
      this.$router.replace({ path: "/cat" });
    },
    store() {
      let self = this;
      let formData = new FormData();
      formData.append("name", this.name);
      formData.append("status", this.status);
      axios
        .post(
          "/api/cat" +
          "?token=" +
          localStorage.getItem("api_token"),
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        )
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully Created .";
          self.showAlert();
        })
        .catch(function(error) {
          console.log(error);
          self.alertColor = "danger";
          self.message = "unexpected error occurred in creating new .";
          self.showAlert();
        });
    },
    store2() {
      let self = this;
      let formData = new FormData();
      formData.append("name2", this.name2);
      formData.append("cat", this.cat);
      formData.append("catId", this.catId);
      formData.append("classn", this.classn);
      axios
        .post(
          "/api/cat" +
          "?token=" +
          localStorage.getItem("api_token"),
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        )
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully Created .";
          self.showAlert();
        })
        .catch(function(error) {
          console.log(error);
          self.alertColor = "danger";
          self.message = "unexpected error occurred in creating new .";
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
          "/api/cat" +
          "?token=" +
          localStorage.getItem("api_token")
        )
        .then(function(response) {
          console.log(response);
          self.allStatus = response.data.cat;
          console.log("res" + response);
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
    this.getFleets();
  }
};
</script>
