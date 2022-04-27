<template>

  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <CForm>
            <template slot="header">
              Edit Fleet id:  {{ $route.params.id }}
            </template>
            <CAlert
              :show.sync="dismissCountDown"
              color="primary"
              fade
            >
              ({{dismissCountDown}}) {{ message }}
            </CAlert>
           <CInput type="text" label="Name" placeholder="Name" v-model="name"></CInput>
            <CInput type="text" label="Mobile" placeholder="Mobile" v-model="mobile"></CInput>
            <CInput type="text" label="Identity" placeholder="Identity" v-model="identity"></CInput>
            <CInput type="text" label="Password" placeholder="Password" v-model="password"></CInput>
            <CButton color="primary" @click="update()">Save</CButton>
            <CButton color="danger" @click="goBack">Back</CButton>
          </CForm>
        </CCardBody>
      </CCard>
    </CCol>

    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <CForm>
            <template slot="header">
              Set Images:  {{ $route.params.id }}
            </template>
            <CAlert
              :show.sync="dismissCountDown"
              color="primary"
              fade
            >
              ({{dismissCountDown}}) {{ message }}
            </CAlert>
            <CIcon :content="$options.plusIcon"/>
            <CIcon :content="$options.fileIcon"/>
            <CInputFile
              type="file"
              v-on:change="handleFileUpload"
              placeholder="New file"
            />
          </CForm>
          <CProgress
            :value="progress"
            color="success"
            striped
            :animated="true"
            class="mb-2"
          />
        </CCardBody>
      </CCard>


        <CCard no-header>
          <CCardBody>
            <CProgress
              :value="deleteProgress"
              color="warning"
              striped
              :animated="true"
              class="mb-2"
            />
            <CRow>
            <CCol col="4" :key="file.id" v-for="(file) in files">
            <img  class="image"  :src="file.file_path" @click="imageClick(file.file_path)">
              <CButton class="btn btn-danger" @click="deleteFile(file.id)">delete</CButton>
            </CCol>
            </CRow>
            <vue-gallery-slideshow :images="images" :index="imageIndex" @close="imageIndex = null"></vue-gallery-slideshow>
          </CCardBody>
        </CCard>

    </CCol>
  </CRow>



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
  import VueGallerySlideshow from 'vue-gallery-slideshow'


  export default {
  name: 'EditUser',
  components: {
    VueGallerySlideshow
  },
  props: {
    caption: {
      type: String,
      default: 'User id'
    },
  },
  data: () => {
    return {
        name: '',
        mobile: '',
        identity: '',
        password: '',
        showMessage: false,
        message: '',
        alertColor:'',
        dismissSecs: 7,
        dismissCountDown: 0,
        showDismissibleAlert: false,
        images: [],
        files: [],
        imageIndex: null,
        progress: 0,
      deleteProgress: 0,
    }
  },
  methods: {
    goBack() {
      this.$router.go(-1)
      // this.$router.replace({path: '/users'})
    },
    fleetInfo(){
      let self = this;
      axios.get(  '/api/fleets/' + self.$route.params.id + '/edit?token=' + localStorage.getItem("api_token"))
        .then(function (response) {
          console.log( response.data.fleet.files)
          self.name =response.data.fleet.name,
            self.mobile=response.data.fleet.mobile,
            self.identity=response.data.fleet.identity,
            self.password=response.data.fleet.password
          self.files = response.data.fleet.files;
           self.images = [];
          response.data.fleet.files.map((file)=> {
            self.images.push(file.file_path)
          })
        }).catch(function (error) {
        console.log(error);
        self.alertColor='danger';
        self.message = 'unexpected error occurred in loading the fleet info.';
        self.showAlert();
      });
    },
    update() {
        let self = this;
        axios.post(  '/api/fleets/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"),
        {
            _method: 'PUT',
            name: self.name,
            mobile: self.mobile,
            identity: self.identity,
            password: self.password
        })
        .then(function (response) {
          self.alertColor='success';
            self.message = 'Successfully updated user.';
            self.showAlert();
        }).catch(function (error) {
            console.log(error);
              self.alertColor='danger';
            self.message = 'unexpected error occurred in Editing the fleet.';
            self.showAlert();
        });
    },
    countDownChanged (dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs
    },
    deleteFile(id){
      let self = this;
      axios.post( '/api/fleets/deleteFile/'+ id+'?token=' + localStorage.getItem("api_token"), {} , {
        onUploadProgress:function (progressEvent) {
          this.deleteProgress = parseInt( Math.round( (progressEvent.loaded * 100)/progressEvent.total ) )
        }.bind(this)
        }
      ).then(function(){
        self.fleetInfo();
        self.deleteProgress = 0;
      })
        .catch(function(error){
          console.log(error)
        });
    },
    handleFileUpload(files, event){
      let self = this;
      let formData = new FormData();
      formData.append('file', files[0]);

      axios.post( '/api/fleets/addFile/'+ self.$route.params.id +'?token=' + localStorage.getItem("api_token"),
        formData,
        { headers: {
            'Content-Type': 'multipart/form-data'
          },
          onUploadProgress:function (progressEvent) {
            this.progress = parseInt( Math.round( (progressEvent.loaded * 100)/progressEvent.total ) )
          }.bind(this)
        }
      ).then(function(){
        self.fleetInfo();
        self.progress = 0;
      })
        .catch(function(error){
          console.log(error)
        });
    },
    imageClick(path) {
      let self = this;
      this.imageIndex = self.images.indexOf(path);
    }

  },
  mounted: function(){
    this.fleetInfo()
  },
}


</script>
