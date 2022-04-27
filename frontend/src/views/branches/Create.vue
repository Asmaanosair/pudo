<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
            ({{ dismissCountDown }}) {{ message }}
          </CAlert>
          <label for="">{{ $t("branch_name") }}</label>
          <input class="form-control mb-2" type="text" v-model="name" />

          <div class="form-group" v-show="showClient">
            <p>{{ $t("client") }}</p>
            <select
              type="text"
              v-model.trim="client"
              :class="{
                'form-control': true
              }"
              @change="getManager(client)"
            >
              <option
                v-for="(client, index) in allClients"
                :value="client.id"
                :key="index"

              >
                {{ client.company_name }}
              </option>
            </select>
          </div>
          <div class="form-group">
            <p>{{ $t("manager") }}</p>
            <select
              type="text"
              v-model.trim="manager"
              :class="{
                'form-control': true
              }"
            >
              <option
                v-for="(manager, index) in allManager"
                :value="manager.id"
                :key="index"
              >
                {{ manager.name }}
              </option>
            </select>
          </div>
          <label for="">{{ $t("street_address") }}</label>
          <input class="form-control mb-2" type="text" v-model="address" />

          <div class="my-bg">
            <p>Branch location</p>
            <div id="myMap2" class="my-4"></div>
            <p> Branch Longitude</p>
            <CInput type="text" placeholder="0" v-model="pickup_lng"></CInput>
            <p> Branch Latitude</p>
            <CInput type="text" placeholder="0" v-model="pickup_lat"></CInput>
          </div>
          <div role="group" class="form-group">
            <p>{{ $t("status") }}</p>
            <select
              type="text"
              v-model="status"
              :class="{
                'form-control': true,
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

          </div>
          <CButton class="mb-3" color="success" @click="store()">{{
            $t("save")
          }}</CButton>
          <CButton class="mb-3" color="warning" @click="goBack">{{
            $t("back")
          }}</CButton>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAhcthMxe-_IQy1Jqa5KwcdO4kYNSQYcH8"></script>
<script>
import axios from "axios";
import { cilThumbUp } from "@coreui/icons";
export default {
  name: "Creat",
  data: () => {
    return {
      allStatus: {},
      pickup_lng: 0,
      pickup_lat: 0,
      status: '',
      client: "",
      address: "",
      name: "",
      manager: "",
      allClients: [],
      allManager: [],
      pickerMove: false,
      showMessage: false,
      message: "",
      showClient: true,

      alertColor: "",
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    };
  },
  methods: {
    deleteProduct(index) {
      this.products.splice(index, 1);
    },
    mapPicker() {
      var self = this;
      var map2;
      var marker2;
      var myLatlng2 = new google.maps.LatLng(24.74674035785072, 46.601989625);
      var geocoder2 = new google.maps.Geocoder();
      var infowindow2 = new google.maps.InfoWindow();
      function initialize() {
        var mapOptions2 = {
          zoom: 18,
          center: myLatlng2,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map2 = new google.maps.Map(
          document.getElementById("myMap2"),
          mapOptions2
        );

        marker2 = new google.maps.Marker({
          map: map2,
          position: myLatlng2,
          draggable: true
        });

        geocoder2.geocode(
          {
            latLng: myLatlng2
          },
          function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              if (results[0]) {
                infowindow2.setContent(results[0].formatted_address);
                infowindow2.open(map2, marker2);
              }
            }
          }
        );

        google.maps.event.addListener(marker2, "dragend", function() {
          geocoder2.geocode(
            {
              latLng: marker2.getPosition()
            },
            function(results, status) {
              self.pickup_lat = marker2.getPosition().lat();
              self.pickup_lng = marker2.getPosition().lng();
              self.pickerMove = true;
              infowindow2.setContent(results[0].formatted_address);
              infowindow2.open(map2, marker2);
            }
          );
        });
      }
      initialize();
    },

    goBack() {
      this.$router.go(-1);
      this.$router.replace({ path: "/branch" });
    },
    getClients() {
      this.loading = true;
      let self = this;
      this.items = [];
      axios
        .get(
          "/api/branch/create" + "?token=" + localStorage.getItem("api_token")
        )
        .then(function(response) {
          self.allClients = response.data.clients;
          self.allStatus = response.data.statuses;
          self.showClient = response.data.show;

        })
        .catch(function(error) {
          console.log(error);

          self.loading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in getting fleets.";
          self.showAlert();
        });
    },
    getManager() {
      this.loading = true;
      let self = this;
      this.items = [];
      axios
        .get(
          "/api/manager/"+ "?token=" + localStorage.getItem("api_token"),
          {
            params: {
              client: self.client,

            }
          }
        )
        .then(function(response) {
          self.allManager = response.data.managers;
        })
        .catch(function(error) {
          console.log(error);

          self.loading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in getting fleets.";
          self.showAlert();
        });
    },
    store() {
      let self = this;
      let formData = new FormData();

      formData.append("name", this.name);
      formData.append("pickup_lng", this.pickup_lng);
      formData.append("pickup_lat", this.pickup_lat);
      formData.append("manager_id", this.manager);
      formData.append("user_id", this.client);
      formData.append("status", this.status);
      formData.append("address", this.address);
      axios
        .post(
          "/api/branch?token=" + localStorage.getItem("api_token"),
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        )
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully Created Branch.";
          self.showAlert();
          self.goBack();
        })
        .catch(function(error) {
          console.log(error);
          self.alertColor = "danger";
          self.message = "unexpected error occurred in creating new Branch.";
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

  created: function() {},

  mounted: function() {
    this.getClients();
    this.getManager();
    this.mapPicker();
  }
};
</script>
