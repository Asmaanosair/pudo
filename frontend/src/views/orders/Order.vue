<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard>
        <CCardHeader> Order id: {{ $route.params.id }} </CCardHeader>
        <CCardBody>
          <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
            ({{ dismissCountDown }}) {{ message }}
          </CAlert>
          <CDataTable striped small fixed :items="order" :fields="fields">
          </CDataTable>
        </CCardBody>
        <CCardFooter>
          <CButton color="primary" @click="goBack">Back</CButton>
        </CCardFooter>
      </CCard>
      <CCard>
        <CCardHeader> Order Time Line Information </CCardHeader>
        <table class="table table-striped table-fixed">
          <tbody>
            <tr class="p-3">
              <td class="p-3 d-block">
                New Order ID : {{ myOrder.id }} created at
                {{ new Date(myOrder.created_at).toLocaleString("en") }}
              </td>
            </tr>
            <tr class="d-block" v-if="myOrder.last_driver_name">
              <td class="p-3 d-block">
                Order ID :
                {{ myOrder.id }} assigned to driver
                {{
                  myOrder.last_driver_name != null
                    ? myOrder.last_driver_name
                    : "....."
                }}
                at
                {{
                  myOrder.assign_order != null
                    ? new Date(myOrder.assign_order).toLocaleString("en")
                    : "....."
                }}
              </td>
            </tr>
            <tr class="d-block">
              <td class="p-3 d-block">
                Order ID : {{ myOrder.id }}
                <span v-if="myOrder.last_driver_name"> reassigned </span>
                <span v-else>assigned</span> to driver
                {{
                  myOrder.current_driver_name != null
                    ? myOrder.current_driver_name
                    : "....."
                }}
                at
                {{
                  myOrder.reassign_order != null
                    ? new Date(myOrder.reassign_order).toLocaleString("en")
                    : "....."
                }}
              </td>
            </tr>

            <tr class="d-block">
              <td class="p-3 d-block">
                Driver :
                {{
                  myOrder.current_driver_name != null
                    ? myOrder.current_driver_name
                    : "....."
                }}
                on the way to pick up at
                {{
                  myOrder.on_the_way_to_pickup != null
                    ? new Date(myOrder.on_the_way_to_pickup).toLocaleString(
                        "en"
                      )
                    : "....."
                }}
              </td>
            </tr>

            <tr class="d-block">
              <td class="p-3 d-block">
                Driver :
                {{
                  myOrder.current_driver_name != null
                    ? myOrder.current_driver_name
                    : "....."
                }}
                near pikup location at
                {{
                  myOrder.near_pikup_location != null
                    ? new Date(myOrder.near_pikup_location).toLocaleString("en")
                    : "....."
                }}
              </td>
            </tr>

            <tr class="d-block">
              <td class="p-3 d-block">
                Driver :
                {{
                  myOrder.current_driver_name != null
                    ? myOrder.current_driver_name
                    : "....."
                }}
                reach pickup location at
                {{
                  myOrder.reach_pickup_location != null
                    ? new Date(myOrder.reach_pickup_location).toLocaleString(
                        "en"
                      )
                    : "....."
                }}
              </td>
            </tr>
            <tr class="d-block">
              <td class="p-3 d-block">
                Driver :
                {{
                  myOrder.current_driver_name != null
                    ? myOrder.current_driver_name
                    : "....."
                }}
                picked up at
                {{
                  myOrder.picked_up_at != null
                    ? new Date(myOrder.picked_up_at).toLocaleString("en")
                    : "....."
                }}
              </td>
            </tr>

            <tr class="d-block">
              <td class="p-3 d-block">
                Driver :
                {{
                  myOrder.current_driver_name != null
                    ? myOrder.current_driver_name
                    : "....."
                }}
                on the way to dropoff at
                {{
                  myOrder.on_the_way_to_dropoff != null
                    ? new Date(myOrder.on_the_way_to_dropoff).toLocaleString(
                        "en"
                      )
                    : "....."
                }}
              </td>
            </tr>
            <tr class="d-block">
              <td class="p-3 d-block">
                Driver :
                {{
                  myOrder.current_driver_name != null
                    ? myOrder.current_driver_name
                    : "....."
                }}
                near dropoff location at
                {{
                  myOrder.near_dropoff_location != null
                    ? new Date(myOrder.near_dropoff_location).toLocaleString(
                        "en"
                      )
                    : "....."
                }}
              </td>
            </tr>

            <tr class="d-block">
              <td class="p-3 d-block">
                Driver :
                {{
                  myOrder.current_driver_name != null
                    ? myOrder.current_driver_name
                    : "....."
                }}
                reached customer {{ myOrder.customer_name }} at
                {{
                  myOrder.reach_customer != null
                    ? new Date(myOrder.reach_customer).toLocaleString("en")
                    : "....."
                }}
              </td>
            </tr>
            <tr class="d-block">
              <td class="p-3 d-block">
                Order Id :
                {{ myOrder.id }} is delivered at
                {{
                  myOrder.reach_customer != null
                    ? new Date(myOrder.delivered_at).toLocaleString("en")
                    : "....."
                }}
              </td>
            </tr>
          </tbody>
        </table>

        <CCardFooter> </CCardFooter>
      </CCard>
      <CCard>
        <CCardHeader> Invoice    </CCardHeader>

        <CCol col="4" :key="file.id" v-for="file in files">
          <img
            class="image"
            :src="file.file_path"
            @click="imageClick(file.file_path)"
            style="height: 200px"
          />
          <a  class=" btn btn-success" :href="file.file_path" download target="_blank">Show</a>
        </CCol>


      </CCard>
    </CCol>

    <CCol col="12" lg="6">
      <!--    map here-->
      <CCard>
        <CCardHeader> Maps </CCardHeader>
        <CCardBody>
          <div id="myMap2" class="my-4 mt-5" style="height: 500px; width: 100%"></div>
        </CCardBody>
      </CCard>

      <!--    status Info-->
      <CCard>
        <CCardHeader> Branch Information </CCardHeader>
        <CCardBody>
          <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
            ({{ dismissCountDown }}) {{ message }}
          </CAlert>

          <CDataTable striped small fixed :items="branch" :fields="fields">
          </CDataTable>
        </CCardBody>
        <CCardFooter> </CCardFooter>
      </CCard>

      <!--      Driver Information-->
      <CCard>
        <CCardHeader> Driver Information </CCardHeader>
        <CCardBody>
          <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
            ({{ dismissCountDown }}) {{ message }}
          </CAlert>
          <CDataTable striped small fixed :items="fleet" :fields="fields">
          </CDataTable>
        </CCardBody>
        <CCardFooter> </CCardFooter>
      </CCard>
    </CCol>


    <!--    products info-->
    <CCol col="12" lg="12">
      <CCard>
        <CCardHeader> Products Information </CCardHeader>
        <CCardBody>
          <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
            ({{ dismissCountDown }}) {{ message }}
          </CAlert>
          <CDataTable
            striped
            small
            fixed
            :items="products"
            :fields="productFields"
          >
          </CDataTable>
        </CCardBody>
        <CCardFooter>
          <CButton color="primary" @click="goBack">Back</CButton>
        </CCardFooter>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from "axios";
import { latLng } from "leaflet";
import {
  LMap,
  LTileLayer,
  LMarker,
  LPopup,
  LTooltip,
  LIconDefault,
} from "vue2-leaflet";
import { cifTj } from "@coreui/icons";

export default {
  name: "Order",
  data: () => {
    return {
      myOrder: {},
      message: "",
      showMessage: false,
      alertColor: "",
      dismissSecs: 3,
      dismissCountDown: 0,
      delivery_lng: '',
      delivery_lat: '',
      order: [],
      files: [],
      products: [],
      branch: [],
      fleet: [],
      paymentMethods: [
        "CASH_ON_DELIVERY",
        "Prepaid"
      ],
      paymentTypes: [
       "PAY_CASH" ,
       "PAY_BY_DRIVER_WALLET" ,
       "NOT_PAY",
       "PAY_ON_PICKUP"
      ],
      reasons: [
        "Client_Canceled_Before_Pickup ",
        "Store_Is_Closed",
        "Wrong_Pickup_Location",
        "App_Issues",
        "Client_Canceled_On_The_Way",
        "Driver_Refused_To_Deliver_Or_Late",
        "Car_Issues",
        "Abnormal_Weather",
        "Customer_Refused_To_Take_The_Order_Because_Of_Driver",
        "Customer_Refused_To_Take_The_Order_Because_Of_Client",
        //New Order
        "Customer_Canceled_New_Order",
        "Client_Canceled_New_Order",
        //Assign Order
        "Driver_Refused_To_Deliver_Assign_Order",
        "Driver_Canceled_Assign_Order",
        "Car_Issues_Assign_Order",
        "Abnormal_Weather_Assign_Order",
        "Order_Disappeared_From_The_Driver_App_Assign_Order",
        "Mistake_In_Dispatching_Logic_Assign_Order",
        "Driver_Is_Not_Responding_Assign_Order",
        //On_The_Way_To_Pickup
        "Customer_Canceled_On_The_Way_To_Pickup",
        "Client_Canceled_On_The_Way_To_Pickup",
        "Driver_Refused_To_Deliver_On_The_Way_To_Pickup",
        "Driver_Canceled_On_The_Way_To_Pickup",
        "Car_Issues_On_The_Way_To_Pickup",
        "Abnormal_Weather_On_The_Way_To_Pickup",
        "Mistake_In_Dispatching_Logic_On_The_Way_To_Pickup",
        "Missing_Order_Information_In_The_Driver_App_On_The_Way_To_Pickup",
        "Driver_Stopped_By_The_Police_On_The_Way_To_Pickup",
        "Traffic_On_The_Way_To_Pickup",
        "Order_Disappeared_From_The_Driver_App_On_The_Way_To_Pickup",
        //Reach_Pickup_location
      ],

      productFields: [
        "name",
        "quantity",
        "note",
      ],
      fields: [{ key: "key" }, { key: "value" }],
      zoomSnap: 0.5,
    };
  },
  methods: {
    getLatLng2(event) {
      let link = event.target.value;
      let linkSplit = link.split("@");
      let linkVal = linkSplit[1];
      let linkVal2 = linkVal.split(",");
      this.delivery_lat = linkVal2[0];
      this.delivery_lng = linkVal2[1];
      this.flagOption2 = true;
      this.mapPicker2();
    },
    mapPicker2() {
      var self = this;
      var map2;
      var marker2;
      var myLatlng2 = new google.maps.LatLng(
        self.delivery_lat,
        self.delivery_lng
      );
      function initialize() {
          var mapOptions2 = {
            zoom:17,
            center: myLatlng2,

        }
        map2 = new google.maps.Map(
          document.getElementById("myMap2"),
          mapOptions2
        );
        marker2 = new google.maps.Marker({
          map: map2,
          position: myLatlng2,
          draggable: true,
        });

      }
      initialize();
    },
    centerUpdate(center) {
      this.currentCenter = center;
    },
    innerClick() {
      alert("Click!");
    },

    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    getOrderDetails() {
      let self = this;
      axios
        .get(
          "/api/order/" +
            self.$route.params.id +
            "?token=" +
            localStorage.getItem("api_token")
        )
        .then(function (response) {
          let orderInfo = { ...response.data.order };
          self.myOrder = response.data.order;
          self.delivery_lat = response.data.order.delivery_lat;
          self.delivery_lng = response.data.order.delivery_lng;
          self.files = response.data.order.invoice;
          self.mapPicker2();
          console.log(self.myOrder);
          if (response.data.order.reason) {
            let reason_description = self.reasons[response.data.order.reason];
            orderInfo.reason_description = reason_description;
          }
          if (response.data.order.payment_method) {
            let payment_method = self.paymentMethods[response.data.order.payment_method-1];
            orderInfo.payment_method = payment_method;
          }
          if (response.data.order.payment_type) {
            let payment_type = self.paymentTypes[response.data.order.payment_type-1];
            orderInfo.payment_type = payment_type;
          }
          delete orderInfo.products;
          delete orderInfo.branch;
          delete orderInfo.fleet;
          delete orderInfo.deleted_at;
          delete orderInfo.pick_up_lng;
          delete orderInfo.pick_up_lat;
          delete orderInfo.delivery_lng;
          delete orderInfo.delivery_lat;
          const items = Object.entries(orderInfo);
          self.order = items.map(([key, value]) => {
            return { key: key, value: value };
          });

          //products
          if (response.data.order.products !== null)
            self.products = response.data.order.products;

          //branch
          if (response.data.order.branch !== null) {
            let branchInfo = { ...response.data.order.branch };
            delete branchInfo.user_id;
            delete branchInfo.manager_id;
            delete branchInfo.city_id;
            delete branchInfo.created_at;
            delete branchInfo.updated_at;
            const statusArr = Object.entries(branchInfo);
            self.branch = statusArr.map(([key, value]) => {
              return { key: key, value: value };
            });
          }

          //driver =
          if (response.data.order.fleet !== null) {
            let fleetInfo = { ...response.data.order.fleet };
            delete fleetInfo.user_id;
            delete fleetInfo.created_at;
            delete fleetInfo.updated_at;
            const fleetArr = Object.entries(fleetInfo);
            self.fleet = fleetArr.map(([key, value]) => {
              return { key: key, value: value };
            });
          }
        })
        .catch(function (error) {
          console.log(error);
          self.alertColor = "danger";
          self.message = "unexpected error occurred.";
          self.showAlert();
        });
    },
    goBack() {
      this.$router.go(-1);
    },
  },
  mounted: function () {

    this.getOrderDetails();
  },
};
</script>
