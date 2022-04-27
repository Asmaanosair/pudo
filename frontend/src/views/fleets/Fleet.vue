<template>
  <div>

    <CRow>
      <CCol :key="i" v-for="(item,i) in statistics" col="12" sm="6" lg="3">
        <CWidgetIcon
          :header="`${item.value} orders`"
          :text="item.key"
          :color="item.color"
        >
          <CIcon name="cil-check" width="24"/>
        </CWidgetIcon>
      </CCol>

    </CRow>

  <CRow>
    <CCol col="12" lg="6">
      <CCard>
        <CCardHeader>
          User id:  {{ $route.params.id }}
        </CCardHeader>
        <CCardBody>
          <CDataTable
            striped
            small
            fixed
            :items="items"
            :fields="fields"
          >
            <template slot="value" slot-scope="data">
              <td>{{data.item.value}}</td>
            </template>
          </CDataTable>
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
      files: [],
      statistics: [],
      fields: [
        {key: 'key'},
        {key: 'value'},
      ],
      imageIndex:null,
    }
  },
  methods: {
    getFleetData (id) {
      let self = this;
      axios.get(  '/api/fleets/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"))
        .then(function (response) {
          let fleetData = {...response.data.fleet};
          let imagesData = [...response.data.fleet.files];
          self.files = response.data.fleet.files;
          self.statistics = response.data.statistics;

          console.log( self.statistics)
          delete fleetData.files;
          delete fleetData.image;
          const items = Object.entries(fleetData);
          self.items = items.map(([key, value]) => {return {key: key, value: value}});

          self.images = [];
          imagesData.map((file)=> {
            self.images.push(file.file_path)
          });

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
