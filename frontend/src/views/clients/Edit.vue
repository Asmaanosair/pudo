<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <template slot="header">
            Create Users
          </template>
          <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
            ({{ dismissCountDown }}) {{ message }}
          </CAlert>
          <div class="form-group">
            <p>{{ $t("company_name") }}</p>
            <input
              type="text"
              :placeholder="$t('company_name') + '...'"
              v-model.trim="$v.company_name.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.company_name.$error,
                'is-valid': !$v.company_name.$invalid
              }"
            />
            <div v-if="!$v.company_name.$error" class="valid-feedback">
              your first company name is valid !
            </div>

            <div v-if="$v.company_name.$error" class="invalid-feedback">
              <span v-if="!$v.company_name.required">
                Your company name is required .
              </span>

              <span v-if="!$v.company_name.minLength">
                Your company name must have at least
                {{ $v.company_name.$params.minLength.min }} letters
              </span>

              <span v-if="!$v.company_name.maxLength">
                Your company name must have at most
                {{ $v.company_name.$params.maxLength.max }} letters
              </span>
            </div>
          </div>
          <div class="form-group">
            <label>Name of the contact person.</label>
            <input
              type="text"
              :placeholder="$t('name') + '...'"
              v-model.trim="$v.name.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.name.$error,
                'is-valid': !$v.name.$invalid
              }"
            />
            <div v-if="!$v.name.$error" class="valid-feedback">
              your first name is valid !
            </div>

            <div v-if="$v.name.$error" class="invalid-feedback">
              <span v-if="!$v.name.required">
                Your name is required .
              </span>

              <span v-if="!$v.name.minLength">
                Your name must have at least
                {{ $v.name.$params.minLength.min }} letters
              </span>

              <span v-if="!$v.name.maxLength">
                Your name must have at most
                {{ $v.name.$params.maxLength.max }} letters
              </span>
            </div>
          </div>
          <div class="form-group">
            <label>Main phone number.</label>
            <input
              type="text"
              :placeholder="$t('mobile') + '...'"
              v-model.trim="$v.phone.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.phone.$error,
                'is-valid': !$v.phone.$invalid
              }"
            />

            <div v-if="!$v.phone.$error" class="valid-feedback">
              your first phone is valid !
            </div>

            <div v-if="$v.phone.$error" class="invalid-feedback">
              <span v-if="!$v.phone.required">
                Your phone is required .
              </span>
              <span v-if="!$v.phone.numeric">
                Your phone must be numbers
              </span>

              <span v-if="!$v.phone.minLength">
                Your phone must have at least
                {{ $v.phone.$params.minLength.min }} numbers
              </span>

              <span v-if="!$v.phone.maxLength">
                Your phone must have at most
                {{ $v.phone.$params.maxLength.max }} numbers
              </span>
            </div>
          </div>
          <div class="form-group">
            <p>Main Email.</p>
            <input
              type="email"
              :placeholder="$t('email') + '...'"
              v-model.trim="$v.email.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.email.$error,
                'is-valid': !$v.email.$invalid
              }"
            />

            <div v-if="!$v.email.$error" class="valid-feedback">
              your first email is valid !
            </div>

            <div v-if="$v.email.$error" class="invalid-feedback">
              <span v-if="!$v.email.required">
                Your email is required .
              </span>
              <span v-if="!$v.email.email">
                Your email should be valid email like(example@example.com) .
              </span>
            </div>
          </div>

          <div class="form-group">
            <p>{{ $t("address") }}</p>
            <input
              type="text"
              id="places"
              :placeholder="$t('address') + '...'"
              v-model.trim="$v.address.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.address.$error,
                'is-valid': !$v.address.$invalid
              }"
            />

            <div v-if="!$v.address.$error" class="valid-feedback">
              your address is valid !
            </div>

            <div v-if="$v.address.$error" class="invalid-feedback">
              <span v-if="!$v.address.required">
                Your address is required .
              </span>
              <span v-if="!$v.address.minLength">
                Your address must have at least
                {{ $v.address.$params.minLength.min }} letters
              </span>
            </div>
          </div>

          <div class="form-group">
            <p>{{ $t("city") }}</p>
            <input
              type="text"
              :placeholder="$t('city') + '...'"
              v-model.trim="$v.city.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.city.$error,
                'is-valid': !$v.city.$invalid
              }"
            />

            <div v-if="!$v.city.$error" class="valid-feedback">
              your city is valid !
            </div>

            <div v-if="$v.city.$error" class="invalid-feedback">
              <span v-if="!$v.city.required">
                Your city is required .
              </span>

              <span v-if="!$v.city.minLength">
                Your city name must have at least
                {{ $v.city.$params.minLength.min }} letters
              </span>
            </div>
          </div>
          <div role="group" class="form-group">
            <p>Delivery Fees</p>
            <select
              type="text"
              v-model.trim="$v.commission.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.commission.$error,
                'is-valid': !$v.commission.$invalid
              }"
            >
              <option
                v-for="(commission, index) in allCommissions"
                :value="commission.id"
                :key="index"
              >
                {{ commission.name }}
              </option>
            </select>

            <div class="valid-feedback">
              your status is valid !
            </div>

            <div class="invalid-feedback">
              <span v-if="!$v.status.required">
                Your status is required .
              </span>
            </div>
          </div>

          <div class="form-group">
            <p>{{ $t("password") }}</p>

            <input
              type="text"
              :placeholder="$t('password') + '...'"
              v-model="password"
              v-model.trim="$v.password.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.password.$error,
                'is-valid': !$v.password.$invalid
              }"
            />

            <div v-if="!$v.password.$error" class="valid-feedback">
              your password is valid !
            </div>

            <div v-if="$v.password.$error" class="invalid-feedback">
              <span v-if="!$v.password.required">
                Your password is required .
              </span>

              <span v-if="!$v.password.minLength">
                Your password must have at least
                {{ $v.password.$params.minLength.min }} numbers
              </span>
            </div>
          </div>





          <div role="group" class="form-group">
            <p>{{ $t("status") }}</p>
            <select
              type="text"
              v-model.trim="$v.status.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.status.$error,
                'is-valid': !$v.status.$invalid
              }"
            >
              <option
                v-for="(status, index) in allStatus"
                :value="status.name"
                :key="index"
              >
                {{ status.name }}
              </option>
            </select>

            <div class="valid-feedback">
              your first status is valid !
            </div>

            <div class="invalid-feedback">
              <span v-if="!$v.status.required">
                Your status is required .
              </span>
            </div>
          </div>

          <CButton color="primary" @click="update()">{{ $t("save") }}</CButton>
          <CButton color="primary" @click="goBack">{{ $t("back") }}</CButton>
        </CCardBody>
      </CCard>
    </CCol>

    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <CForm>
            <template slot="header">
              Set Images: {{ $route.params.id }}
            </template>
            <CAlert :show.sync="dismissCountDown" color="primary" fade>
              ({{ dismissCountDown }}) {{ message }}
            </CAlert>
            <CIcon :content="$options.plusIcon" />
            <CIcon :content="$options.fileIcon" />
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
            <CCol col="4" :key="file.id" v-for="file in files">
              <img
                class="image"
                :src="file.file_path"
                @click="imageClick(file.file_path)"
              />
              <CButton class="btn btn-danger" @click="deleteFile(file.id)"
                >delete</CButton
              >
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
import {
  required,
  minLength,
  maxLength,
  between,
  email,
  minValue,
  numeric
} from "vuelidate/lib/validators";
import axios from "axios";
import VueGallerySlideshow from "vue-gallery-slideshow";

export default {
  name: "EditUser",
  components: {
    VueGallerySlideshow
  },
  props: {
    caption: {
      type: String,
      default: "User id"
    }
  },
  data: () => {
    return {
      allStatus: {},
      name: "",
      phone: "",
      address: "",
      company_name: "",
      status: "",
      commission: "",
      allCommissions:[],
      kilo_price: "",
      uuid: "",
      city: "",
      password:"",
      email: "",
      showMessage: false,
      message: "",
      alertColor: "",
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false,
      images: [],
      files: "",
      fileId: "",
      imageIndex: null,
      progress: 0,
      deleteProgress: 0
    };
  },
  validations: {
    name: {
      required,
      minLength: minLength(6),
      maxLength: maxLength(40)
    },
    phone: {
      required,
      numeric,
      minLength: minLength(11),
      maxLength: maxLength(20)
    },
    age: {
      between: between(18, 100)
    },
    email: {
      required,
      email
    },
    password: {
      minLength: minLength(8)
    },
    kilo_price: {
      required,
      numeric,
      minValue: minValue(1)
    },
    company_name: {
      required,
      minLength: minLength(3),
      maxLength: maxLength(20)
    },
    status: {
      required
    },
    commission: {
      required
    },
    address: {
      required,
      minLength: minLength(5)
    },
      city: {
      required,
       minLength: minLength(2)
    }
  },
  methods: {
    goBack() {
      this.$router.go(-1);
      // this.$router.replace({path: '/users'})
    },
    fleetInfo() {
      let self = this;
      axios
        .get(
          "/api/client/" +
            self.$route.params.id +
            "/edit?token=" +
            localStorage.getItem("api_token")
        )
        .then(function(response) {
          console.log(response.data.fleet.files);
          (self.name = response.data.fleet.name),
            (self.phone = response.data.fleet.phone),
            (self.address = response.data.fleet.address),
            (self.company_name = response.data.fleet.company_name),
            (self.city = response.data.fleet.city),
            (self.status = response.data.fleet.status),
            (self.email = response.data.fleet.email),
            (self.kilo_price = response.data.fleet.kilo_price),
            (self.uuid = response.data.fleet.uuid),
            (self.commission = response.data.fleet.commission_id),
            (self.allStatus = response.data.statuses);
          self.allCommissions = response.data.commissions;
          self.files = response.data.fleet.files;

          self.images = [];
          response.data.fleet.files.map(file => {
            self.images.push(file.file_path);
          });
        })
        .catch(function(error) {
          console.log(error);
          self.alertColor = "danger";
          self.message =
            "unexpected error occurred in loading the Client info.";
          self.showAlert();
        });
    },
    update() {
      let self = this;
      let formData = new FormData();
      formData.append("name", this.name);
      formData.append("phone", this.phone);
      formData.append("address", this.address);
      formData.append("city", this.city);
      formData.append("company_name", this.company_name);
      formData.append("email", this.email);
      formData.append("uuid", this.uuid);
      formData.append("kilo_price", this.kilo_price);
      formData.append("status", this.status);
      formData.append("commission", this.commission);
      formData.append("_method", "PUT");
      axios
        .post(
          "/api/client/" +
            self.$route.params.id +
            "?token=" +
            localStorage.getItem("api_token"),
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        )
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully updated user.";
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
    deleteFile(id) {
      let self = this;
      axios
        .post(
          "/api/client/deleteFile/" +
            id +
            "?token=" +
            localStorage.getItem("api_token"),
          {},
          {
            onUploadProgress: function(progressEvent) {
              this.deleteProgress = parseInt(
                Math.round((progressEvent.loaded * 100) / progressEvent.total)
              );
            }.bind(this)
          }
        )
        .then(function() {
          self.fleetInfo();
          self.deleteProgress = 0;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    handleFileUpload(files, event) {
      let self = this;
      let formData = new FormData();
      formData.append("file", files[0]);

      axios
        .post(
          "/api/client/addFile/" +
            self.$route.params.id +
            "?token=" +
            localStorage.getItem("api_token"),
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data"
            },
            onUploadProgress: function(progressEvent) {
              this.progress = parseInt(
                Math.round((progressEvent.loaded * 100) / progressEvent.total)
              );
            }.bind(this)
          }
        )
        .then(function() {
          self.fleetInfo();
          self.progress = 0;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    imageClick(path) {
      let self = this;
      this.imageIndex = self.images.indexOf(path);
    },
    getCity() {
      self = this;
      var places = new google.maps.places.Autocomplete(
        document.getElementById("places")
      );

      google.maps.event.addListener(places, "place_changed", function() {
        var place = places.getPlace();
        self.address = place.formatted_address;
      });
    }
  },
  mounted: function() {
    this.getCity();
    this.fleetInfo();
  }
};
</script>
