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

                <tr v-if="fleet.city_data!=null">
                  <td>City</td>
                  <td>{{  fleet.city_data.name}}</td>
                </tr>
                <tr v-else>
                  <td>City</td>
                  <td></td>
                </tr>
                <tr v-if="fleet.supplier_commission!=null">
                  <td>Commission</td>
                  <td>{{  fleet.supplier_commission.name  }}</td>
                </tr>
                <tr v-else>
                  <td>Commission</td>
                  <td></td>
                </tr>

                <tr>
                  <td>Status</td>
                  <td>{{ fleet.status }}</td>
                </tr>
              </tbody>
            </table>
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

      imageIndex: null
    };
  },
  methods: {
    getFleetData(id) {
      let self = this;
      axios
        .get(
          "/api/supplier/" +
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
    }
  },
  mounted: function() {
    this.getFleetData();
  }
};
</script>
