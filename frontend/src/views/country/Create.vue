<template>
  <CRow>
    <CCol col="6" lg="6">
      <CCard no-header>
        <CCardBody>
          <h3 class="text-center">
            Create Country
          </h3>
          <CAlert :show.sync="dismissCountDown" color="primary" fade>
            ({{ dismissCountDown }}) {{ message }}
          </CAlert>

          <CInput
            label="Name"
            type="text"
            id="title"
            placeholder="Name..."
            v-model="name"
          ></CInput>

          <label>EWKT</label>
          <textarea
            rows="10"
            class="form-control"
            placeholder="EWKT.."
            v-model="geometry"
          ></textarea>
          <label for="">Status</label>
          <select class="form-control mb-2" v-model="active">
            <option value="1"> Active </option>
            <option value="0"> Not Active </option>
          </select>

          <CButton color="primary" @click="store()">Create</CButton>
          <CButton color="primary" @click="goBack">Back</CButton>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
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
      name: "",
      active: "",
      geometry: "",
      message: "",
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    };
  },
  methods: {
    goBack() {
      this.$router.go(-1);
      // this.$router.replace({path: '/users'})
    },
    store() {
      let self = this;
      let formData = new FormData();
      formData.append("name", this.name);
      formData.append("geometry", this.geometry);
      formData.append("active", this.active);

      axios
        .post(
          "/api/countries?token=" + localStorage.getItem("api_token"),
          formData
        )
        .then(function(response) {
          self.goBack();
          self.message = "Successfully created countries.";
          self.showAlert();
        })
        .catch(function(error) {
          self.message = "unexpected";

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

};
</script>
