<template>
  <div>
    <CRow>
      <CCol col="12" lg="6">
        <CCard>
          <CCardHeader> User id: {{ $route.params.id }} </CCardHeader>
          <CCardBody>

            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Key</th>
                  <th scope="col">Value</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Name</td>
                  <td>{{ fleet.name }}</td>
                </tr>
                <tr>
                  <td>Mobile</td>
                  <td>{{ fleet.phone }}</td>
                </tr>
                <tr>
                  <td>Email</td>
                  <td>{{ fleet.email }}</td>
                </tr>
                <tr>
                  <td>Company Name</td>
                  <td>{{ fleet.company_name }}</td>
                </tr>
                <tr>
                  <td>Address</td>
                  <td>{{ fleet.address }}</td>
                </tr>

                <tr>
                  <td>City</td>
                  <td>{{ fleet.city }}</td>
                </tr>

                <tr hidden>
                  <td>Kilo Price</td>
                  <td>{{ fleet.kilo_price }}</td>
                </tr>
                <tr>
                  <td>Status</td>
                  <td>{{ fleet.status }}</td>
                </tr>
                 <tr>
                  <td>Api Id</td>
                  <td>{{ fleet.api_id }}</td>
                </tr>
                <tr>

                  <td>EndPoint </td>

                  <td><form @submit.prevent="submitForm">
                    <div class="form-group" style="width: 70%; float:left;margin-right: 10px">
                      <input

                        type="text"
                        v-on:keyup="onlyText($event)"
                        :placeholder="'EndPoint' + '...'"
                        v-model="endpoint"

                        :class="{
                  'form-control': true,

                }"
                      />
                    </div>
                    <CButton color="success" @click="store(fleet.id)">Edit</CButton>
                  </form>
                  </td>

                </tr>
              </tbody>
            </table>
            <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
              ({{ dismissCountDown }}) {{ message }}
            </CAlert>
          </CCardBody>
          <CCardFooter>
            <CButton color="primary" @click="goBack">Back</CButton>
          </CCardFooter>
        </CCard>
      </CCol>
      <CCol col="12" lg="6">
        <CCard no-header>
          <CCardBody>
            <CRow>
              <CCol col="4" :key="file.id" v-for="file in files">
                <img
                  class="image"
                  :src="file.file_path"
                  @click="imageClick(file.file_path)"
                />
              </CCol>
            </CRow>
            <vue-gallery-slideshow
              :images="images"
              :index="imageIndex"
              @close="imageIndex = null"
            ></vue-gallery-slideshow>
          </CCardBody>
        </CCard>
      </CCol>
    </CRow>
  </div>
</template>
<style>
.image {
  width: 150px;
  height: 150px;
  background-size: cover;
  cursor: pointer;
  margin: 10px;
  border-radius: 3px;
}
</style>
<script>
import axios from "axios";
import VueGallerySlideshow from "vue-gallery-slideshow";

export default {
  name: "Fleet",
  components: {
    VueGallerySlideshow
  },
  data: () => {
    return {
      items: [],
      images: [],
      fleet: {},
      endpoint:'',
      showMessage: false,
      message: "",
      alertColor: "",
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false,

      imageIndex: null
    };
  },
  methods: {
    getFleetData(id) {
      let self = this;
      axios
        .get(
          "/api/client/" +
            self.$route.params.id +
            "?token=" +
            localStorage.getItem("api_token")
        )
        .then(function(response) {
          console.log(response);
          let fleetData = { ...response.data.fleet };
          let imagesData = [...response.data.fleet.files];
          self.files = response.data.fleet.files;
          self.fleet = response.data.fleet;
          self.endpoint=response.data.fleet.endpoint.endpoint
        })
        .catch(function(error) {
          console.log(error);
          // self.$router.push({ path: '/login' });
        });
    },
    goBack() {
      this.$router.go(-1);
    },
    imageClick(path) {
      let self = this;
      this.imageIndex = self.images.indexOf(path);
    },
    store($id) {
      let self = this;
      let formData = new FormData();
      formData.append("endpoint", self.endpoint);

      axios
        .post(
          "/api/endpoint/edit/" +
          $id +
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
  },
  mounted: function() {
    this.getFleetData();
  }
};
</script>
