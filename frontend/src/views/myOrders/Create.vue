<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <template slot="header"> Create Orders </template>
          <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
            <ul v-if="message instanceof Object">
              <li v-for="(item, index) in message" :key="index">
                ({{ dismissCountDown }}) {{ item[0] }}
              </li>
            </ul>
            <span
              v-if="
                alertColor == 'danger' && message instanceof Object == false
              "
            >
              ({{ dismissCountDown }}) unexpected error occurred in creating new
              order.
            </span>
            <span v-if="alertColor == 'success'">
              ({{ dismissCountDown }}){{ message }}
            </span>
          </CAlert>

          <p>{{ $t("customer_name") }} </p>
          <CInput
            type="text"
            :placeholder="$t('customer_name') + '...'"
            v-model="customer_name"
          ></CInput>
          <p>{{ $t("street_address") }} </p>
          <CInput
            type="text"
            :placeholder="$t('address') + '...'"
            v-model="address"
          ></CInput>

          <p>{{ $t("customer_mobile") }}</p>
          <CInput
            type="text"
            :placeholder="$t('customer_mobile') + '...'"
            v-model="customer_mobile"
          ></CInput>


          <p>Order Price</p>
          <CInput
            type="text"
            :placeholder="'Order Price...'"
            v-model="order_price"
          ></CInput>
          <p>{{ $t("discount") }}</p>
          <CInput
            type="text"
            :placeholder="$t('discount') + '...'"
            v-model="discount"
          ></CInput>
          <p>{{ $t("shipment_number") }}</p>
          <CInput
            type="text"
            :placeholder="$t('shipment_number') + '...'"
            v-model="code"
          ></CInput>
          <p>{{ $t("weight") }}</p>
          <CInput
            type="text"
            :placeholder="$t('weight') + '...'"
            v-model="shipment_weight"
          ></CInput>
          <p>Payment Method</p>
          <select
            @change="choosePayFunc()"
            class="form-control"
            v-model="payment_method"
          >
            <option value="1">COD</option>
            <option value="2">Prepaid</option>
          </select>
          <p>Payment Type</p>
          <select class="form-control" v-model="payment_type" v-show="type1">
            <option value="1">Pay Cash</option>
            <option value="2">Pay by driver wallet</option>
            <option value="3">Not Paying</option>
          </select>
          <select class="form-control" v-model="payment_type" v-show="type2">
            <option value="3">Not Paying</option>
            <option value="4">Paying on picked up</option>
          </select>
          <p>choose method deliver</p>
          <select
            @change="chooseFeesFunc()"
            class="form-control"
            v-model="chooseFees"
          >
            <option value="0">by fees</option>
            <option value="1">pay on pickup and collect</option>
          </select>
          <div class="mt-3" v-if="chooseFees == '0'">
            <p>{{ $t("deliver_fees") }}</p>
            <CInput
              type="text"
              :placeholder="$t('deliver_fees') + '...'"
              v-model="deliver_fees"
            ></CInput>
          </div>
          <div class="mt-3" v-else>
            <p>{{ $t("pay_on_pickup") }}</p>
            <CInput
              type="text"
              :placeholder="$t('pay_on_pickup') + '...'"
              v-model="pay_on_pickup"
            ></CInput>

            <p>{{ $t("collect_on_delivery") }}</p>
            <CInput
              type="text"
              :placeholder="$t('collect_on_delivery') + '...'"
              v-model="collect_on_delivery"
            ></CInput>
          </div>
          <p>{{ $t("delivery_time") }}</p>
          <CInput
            type="datetime-local"
            :placeholder="$t('delivery_time') + '...'"
            v-model="delivery_time"
            format="yyyy-MM-dd HH:mm:ss"
          ></CInput>


          <div
            class="form-group"
            v-if="role !== 'client' && role !== 'client-branch'"
          >
            <label for="">Client </label>

            <select
              v-model.trim="$v.client_id.$model"
              @change="getBranch()"
              :class="{
                'form-control': true,
                'is-invalid': $v.client_id.$error,
                'is-valid': !$v.client_id.$invalid,
              }"
            >
              <option
                v-for="(client, index) in clients"
                :selected="client.id == client_id"
                :value="client.id"
                :key="index"

              >
                {{ client.company_name }}
              </option>
            </select>

          </div>
          <div
            class="form-group"
            v-if="role !== 'client-branch'"
          >
            <label for="">Branch </label>

            <select
              v-model="branch_id"
              @change="getPickUP()"
              :class="{
                'form-control': true,

              }"
            >
              <option
                v-for="(branch, index) in branches"
                :selected="branch.id == branch_id"
                :value="branch.id"
                :key="index"
              >
                {{ branch.name }}
              </option>
            </select>

          </div>
        </CCardBody>
      </CCard>

    </CCol>

    <CCol col="12" lg="6">


      <div class="my-bg">
        <p>{{ $t("to") }}</p>

        <input
          @keyup="getLatLng2($event)"
          type="text"
          class="input-mao form-control"
          placeholder="https://www.google.com.eg/maps/@26.9060999,30.8768375,6z?hl=ar&shorturl=1"
        />

        <div id="myMap2" class="my-4 mt-5"></div>
        <p>{{ $t("delivery_lng") }}</p>
        <CInput type="text" placeholder="0" v-model="delivery_lng" @keyup="renderDeliverLng($event)"></CInput>
        <p>{{ $t("delivery_lat") }}</p>
        <CInput type="text" placeholder="0" v-model="delivery_lat" @keyup="renderDeliverLat($event)"></CInput>
      </div>
      <CCol col="12" lg="12">
        <CCard

          no-header
          v-for="(product, index) in products"
          :key="index"
        >
          <CCardBody>
            <p>{{ $t("product_name") }}</p>
            <CInput
              type="text"
              :placeholder="$t('product_name') + '...'"
              v-model="product.name"
            ></CInput>

            <p>{{ $t("quantity") }}</p>
            <CInput
              type="text"
              :placeholder="$t('quantity') + '...'"
              v-model="product.quantity"
            ></CInput>

            <p>{{ $t("notes") }}</p>
            <CTextarea
              type="text"
              :placeholder="$t('notes') + '...'"
              v-model="product.note"
            ></CTextarea>
            <CButton
              class="mb-3"
              color="danger"
              @click="deleteProduct(index)"
            >{{ $t("delete") }}</CButton
            >
          </CCardBody>
        </CCard>

        <CButton class="mb-3" color="success" @click="store()">{{
            $t("save")
          }}</CButton>
        <CButton class="mb-3" color="warning" @click="goBack">{{
            $t("back")
          }}</CButton>
        <CButton  class="mb-3" color="info" @click="addProduct()">{{
            $t("add_more_product")
          }}</CButton>
      </CCol>
    </CCol>
  </CRow>
</template>

<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAhcthMxe-_IQy1Jqa5KwcdO4kYNSQYcH8"></script>-->
<script>
import axios from "axios";
import moment from "moment";
import {
  required,
} from "vuelidate/lib/validators";
export default {
  name: "Creat",
  data: () => {
    return {
      products: [
        {
          name: "test",
          quantity: 1,
          weight: 10,
          note: "test",
        },
      ],
      customer_name: "test",
      clients: {},
      branches: {},
      code: "1",
      address: "",
      type1: true,
      type2: false,
      role: "",
      shipment_weight: "",
      client_id: "",
      branch_id: "",
      customer_mobile: "09022321223",
      total_price: 0,
      order_price: 100,
      discount: 0,
      chooseFees: 0,
      pay_on_pickup: 0,
      collect_on_delivery: 0,
      delivery_lng: 46.59552550127411,
      delivery_lat: 24.743909817158464,
      deliver_fees: 20,
      kilos_count: 0,
      payment_method: 1,
      payment_type: 3,
      pickerMove: false,
      delivery_time: "",
      timeNow: "",
      imageIndex: null,
      showMessage: false,
      flagOption: false,
      flagOption2: false,
      number_of_products: 0,
      message: "",
      alertColor: "",
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false,
    };
  },
  validations: {
    client_id: {
      required,
    },

  },

  methods: {

      renderDeliverLat(event) {
      let lat = event.target.value;
      this.delivery_lat =lat;
      this.mapPicker2();
    },
      renderDeliverLng(event) {
      let lng = event.target.value;
      this.delivery_lng =lng;
      this.mapPicker2();
    },

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

    getBranch() {
      this.loading = true;
      let self = this;
      this.items = [];
      axios
        .get(
          "/api/branches" + "?token=" + localStorage.getItem("api_token"),{
            params:{
              client_id:self.client_id
            }
          }
        )
        .then(function (response) {
          console.log(response);

          self.branches = response.data.branches;

          console.log(response);
        })
        .catch(function (error) {
          console.log(error);
          self.loading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in getting fleets.";
          self.showAlert();
        });
    },
    getFleets() {
      this.loading = true;
      let self = this;
      this.items = [];
      axios
        .get(
          "/api/orders/create" + "?token=" + localStorage.getItem("api_token")
        )
        .then(function (response) {
          console.log(response);

          self.clients = response.data.clients;
          self.role = response.data.user.menuroles;
          console.log(  self.role);
        })
        .catch(function (error) {
          console.log(error);
          self.loading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in getting fleets.";
          self.showAlert();
        });
    },
    getNow() {
      const today = new Date();
      this.timeNow = today;
    },
    deleteProduct(index) {
      this.products.splice(index, 1);
    },
    chooseFeesFunc() {
      if (this.chooseFees == 1) {
        this.deliver_fees = 0;
      } else {
        this.pay_on_pickup = 0;
        this.collect_on_delivery = 0;
      }
    },
    choosePayFunc() {
      if (this.payment_method == 1) {
        this.type1 = true;
        this.type2 = false;
        this.payment_type = 1;
      } else {
        this.type2 = true;
        this.type1 = false;
        this.payment_type = 3;
      }
    },
    mapPicker2() {
      var self = this;
      var map2;
      var marker2;
      var myLatlng2 = new google.maps.LatLng(
        self.delivery_lat,
        self.delivery_lng
      );
      var geocoder2 = new google.maps.Geocoder();
      var infowindow2 = new google.maps.InfoWindow();
      function initialize() {

         if (!self.flagOption2) {
          var mapOptions2 = {
            zoom: 18,
            center: myLatlng2,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
          };
        } else {
          var mapOptions2 = {
            zoom: 10,
            center: myLatlng2,
          };
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

        geocoder2.geocode(
          {
            latLng: myLatlng2,
          },
          function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              if (results[0]) {
                infowindow2.setContent(results[0].formatted_address);
                infowindow2.open(map2, marker2);
              }
            }
          }
        );

        google.maps.event.addListener(marker2, "dragend", function () {
          geocoder2.geocode(
            {
              latLng: marker2.getPosition(),
            },
            function (results, status) {
              self.delivery_lat = marker2.getPosition().lat();
              self.delivery_lng = marker2.getPosition().lng();
              self.pickerMove = true;
              self.kilos_count = self.calculateDistance();
              infowindow2.setContent(results[0].formatted_address);
              infowindow2.open(map2, marker2);
            }
          );
        });
      }
      initialize();
    },
    addProduct() {
      let product = {
        name: "product",
        quantity: 1,
        weight: 44,
        note: "Note",
      };

      this.products.push(product);
    },
    goBack() {
      this.$router.go(-1);
      this.$router.replace({ path: "/driver-applications" });
    },
    store() {
      let self = this;
      let formData = new FormData();
      let orderPrice = 0;
      this.number_of_products = this.products.length;
      this.total_price = parseInt(this.order_price) - parseInt(this.discount);
      formData.append("customer_name", this.customer_name);
      formData.append("customer_mobile", this.customer_mobile);
      formData.append("order_price", this.order_price);
      formData.append("address", this.address);
      formData.append("discount", this.discount);
      formData.append("deliver_fees", this.deliver_fees);
      formData.append("pay_on_pickup", this.pay_on_pickup);
      formData.append("collect_on_delivery", this.collect_on_delivery);
      formData.append("delivery_time",moment(String(this.delivery_time)).format("MM/DD/YYYY HH:mm"));
      formData.append("timeNow", moment(String(this.timeNow)).format("MM/DD/YYYY HH:mm"));
      formData.append("code", this.code);
      formData.append("client_id", this.client_id);
      formData.append("branch_id", this.branch_id);
      formData.append("number_of_products", this.number_of_products);
      formData.append("total_price", this.total_price);
      formData.append("shipment_weight", this.shipment_weight);
      formData.append("delivery_lng", this.delivery_lng);
      formData.append("delivery_lat", this.delivery_lat);
      formData.append("payment_type", this.payment_type);
      formData.append("payment_method", this.payment_method);
      formData.append("products", JSON.stringify(this.products));

      axios
        .post(
          "/api/create-order?token=" + localStorage.getItem("api_token"),
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        )
        .then(function (response) {
          self.alertColor = "success";
          self.message = "Successfully Created order.";
          self.showAlert();
        })
        .catch(function (error) {
          console.log(error.response);
          self.alertColor = "danger";
          self.message = error.response.data.message;

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

  created: function () {},

  mounted: function () {
    this.mapPicker2();
    this.getNow();
    this.getFleets();
    this.getBranch();
  },
};
</script>
