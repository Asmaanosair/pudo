<template>
  <CRow>
    <CCol col="6" lg="6">
      <CCard no-header>
        <CCardBody>
          <h3 class="text-center">
            Create City
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
          <div class="form-group">
            <p>Country</p>
            <select
              type="text"
              v-model="countryId"
              :class="{
                'form-control': true
              }"
            >
              <option
                v-for="(country, index) in countries"
                :value="country.id"
                :key="index"
              >
                {{ country.name }}
              </option>
            </select>
          </div>
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
      countries: {},
      countryId: '',
      message: "",
      geometry: "",
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
      formData.append("countryId", this.countryId);
      formData.append("active", this.active);

      axios
        .post(
          "/api/create-city?token=" + localStorage.getItem("api_token"),
          formData
        )
        .then(function(response) {
          self.goBack();
          self.message = "Successfully created City.";
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
  mounted: function() {
    let self = this;
    axios
      .get("/api/cities?token=" + localStorage.getItem("api_token"))
      .then(function(response) {
        self.countries = response.data.countries;
      })
      .catch(function(error) {
        console.log(error);
        self.$router.push({ path: "login" });
      });
  }
};
</script>
