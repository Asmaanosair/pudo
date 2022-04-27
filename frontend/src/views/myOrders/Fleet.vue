<template>
  <div>
  <CRow>
    <CCol col="12" lg="6">
      <CCard>
        <CCardHeader>
          User id:  {{ $route.params.id }}
        </CCardHeader>
        <CCardBody>
          <table class="table table-striped">
            <thead>
            <tr>
              <th scope="col">Key </th>
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
              <td>{{ fleet.mobile }}</td>

            </tr>
            <tr>
              <td>Identity</td>
              <td>{{ fleet.identity }}</td>

            </tr>
            <tr>
              <td>age</td>
              <td>{{ fleet.age }}</td>

            </tr>
            <tr>
              <td>bank_name</td>
              <td>{{ fleet.bank_name }}</td>

            </tr>
            <tr>
              <td>vehicle_type</td>
              <td>{{ fleet.vehicle_type }}</td>

            </tr>
            <tr>
              <td>nationalityId</td>
              <td>{{ fleet.nationalityId }}</td>

            </tr>
            <tr>
              <td>nationality</td>
              <td>{{ fleet.nationality }}</td>

            </tr>
            <tr>
              <td>contract</td>
              <td>{{ fleet.contract_type }}</td>

            </tr>
            <tr>
              <td>bank_iban</td>
              <td>{{ fleet.bank_iban }}</td>

            </tr>
            <tr>
              <td>bank_name</td>
              <td>{{ fleet.bank_name }}</td>

            </tr>
            <tr>
              <td>Status</td>
              <td>{{ fleet.application_status.name }}</td>

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
            <CCol col="4" :key="file.id" v-for="(file) in files">
              <img  class="image"  :src="file.file_path" @click="imageClick(file.file_path)">
            </CCol>
          </CRow>
          <vue-gallery-slideshow :images="images" :index="imageIndex" @close="imageIndex = null"></vue-gallery-slideshow>
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
import axios from 'axios'
import VueGallerySlideshow from 'vue-gallery-slideshow';

export default {
  name: 'Fleet',
  components: {
    VueGallerySlideshow
  },
  data: () => {
    return {
      items: [],
      images:[],
      fleet: {},

      imageIndex:null,
    }
  },
  methods: {
    getFleetData (id) {
      let self = this;
      axios.get(  '/api/driver-applications/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"))
        .then(function (response) {
          console.log(response)
          let fleetData = {...response.data.fleet};
          let imagesData = [...response.data.fleet.files];
          self.files = response.data.fleet.files;
          self.fleet = response.data.fleet;

        }).catch(function (error) {
        console.log(error);
        // self.$router.push({ path: '/login' });
      });
    },
    goBack() {
      this.$router.go(-1)
    },
    imageClick(path) {
      let self = this;
      this.imageIndex = self.images.indexOf(path);
    }
  },
  mounted: function(){
    this.getFleetData();
  }
}
</script>
