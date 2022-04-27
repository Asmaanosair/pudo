<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <template slot="header">
            Create Orders
          </template>
          <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
            ({{ dismissCountDown }}) {{ message }}
          </CAlert>

          <p>{{ $t("customer_name") }}</p>
          <CInput
            type="text"
            :placeholder="$t('customer_name') + '...'"
            v-model="customer_name"
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
          <p>
            Payment Method
          </p>
          <select
            @change="choosePayFunc()"
            class="form-control"
            v-model="payment_method"
          >
            <option value="1">COD</option>
            <option value="2">Prepaid</option>

          </select>
          <p>
            Payment Type
          </p>
          <select
            class="form-control"
            v-model="payment_type"
            v-show="type1"
          >
            <option value="1" >Pay Cash</option>
            <option value="2">Pay by driver wallet</option>
            <option value="3"> Not Paying</option>
          </select>
          <select
            class="form-control"
            v-model="payment_type"
            v-show="type2"
          >
            <option value="3"> Not Paying</option>
            <option value="4">Paying on picked up</option>

          </select>

          <p>{{ $t("discount") }}</p>
          <CInput
            type="text"
            :placeholder="$t('discount') + '...'"
            v-model="discount"
          ></CInput>
          <p>{{ $t("deliver_fees") }}</p>
          <CInput
            type="text"
            :placeholder="$t('deliver_fees') + '...'"
            v-model="deliver_fees"
          ></CInput>
          <p>{{ $t("delivery_time") }} : {{ this.delivery_time_string }}</p>
          <CInput
            type="datetime-local"
            :placeholder="$t('delivery_time') + '...'"
            v-model="delivery_time"
          ></CInput>
        </CCardBody>
      </CCard>
      <CCol col="12" lg="12" >
        <CCard hidden no-header v-for="(product, index) in products" :key="index">
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
            <p>{{ $t("price") }}</p>
            <CInput
              type="text"
              :placeholder="$t('price') + '...'"
              v-model="product.one_piece_price"
            ></CInput>
            <p>{{ $t("notes") }}</p>
            <CInput
              type="text"
              :placeholder="$t('notes') + '...'"
              v-model="product.note"
            ></CInput>
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
        <CButton hidden class="mb-3" color="info" @click="addProduct()">{{
          $t("add_more_product")
        }}</CButton>
      </CCol>
    </CCol>

    <CCol col="12" lg="6">
      <div class="my-bg">
        <p>{{ $t("from") }}</p>
        <div id="myMap"></div>
        <p>{{ $t("pick_up_lng") }}</p>
        <CInput type="text" placeholder="0" v-model="pick_up_lng"></CInput>
        <p>{{ $t("pick_up_lat") }}</p>
        <CInput type="text" placeholder="0" v-model="pick_up_lat"></CInput>
      </div>

      <div class="my-bg">
        <p>{{ $t("to") }}</p>
        <div id="myMap2" class="my-4"></div>
        <p>{{ $t("delivery_lng") }}</p>
        <CInput type="text" placeholder="0" v-model="delivery_lng"></CInput>
        <p>{{ $t("delivery_lat") }}</p>
        <CInput type="text" placeholder="0" v-model="delivery_lat"></CInput>
      </div>
    </CCol>
  </CRow>
</template>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAhcthMxe-_IQy1Jqa5KwcdO4kYNSQYcH8"></script>
<script>
import axios from "axios";
export default {
  name: "Creat",
  data: () => {
    return {
      products: [],
      customer_name: "test",
      code: "1",
      type1: true,
      type2: false,
      customer_mobile: "",
      total_price: 0,
      order_price: 0,
      discount: 0,
      pick_up_lng: 0,
      pick_up_lat: 0,
      delivery_lng: 0,
      delivery_lat: 0,
      deliver_fees: 0,
      kilos_count: 0,
      payment_method: '',
      payment_type: '',
      delivery_time: "",
      delivery_time_string: "",
      imageIndex: null,
      showMessage: false,
      number_of_products: 0,
      message: "",
      alertColor: "",
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    };
  },
  methods: {
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
              self.delivery_lat = marker2.getPosition().lat();
              self.delivery_lng = marker2.getPosition().lng();
              self.kilos_count = self.calculateDistance();

              infowindow2.setContent(results[0].formatted_address);
              infowindow2.open(map2, marker2);
            }
          );
        });
      }
      initialize();
    },
    choosePayFunc() {
      if (this.payment_method == 1) {
        this.type1 = true;
        this.type2 = false;
        this.payment_type = 1;
      } else {
        this.type2 = true;
        this.type1= false;
        this.payment_type = 3;
      }
    },
    mapPicker() {
      var self = this;
      var map;
      var marker;
      var myLatlng = new google.maps.LatLng(self.pick_up_lat, self.pick_up_lng);
      var geocoder = new google.maps.Geocoder();
      var infowindow = new google.maps.InfoWindow();
      function initialize() {
        var mapOptions = {
          zoom: 18,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("myMap"), mapOptions);

        marker = new google.maps.Marker({
          map: map,
          position: myLatlng,
          draggable: true
        });

        geocoder.geocode(
          {
            latLng: myLatlng
          },
          function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              if (results[0]) {
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);
              }
            }
          }
        );

        google.maps.event.addListener(marker, "dragend", function() {
          geocoder.geocode(
            {
              latLng: marker.getPosition()
            },
            function(results, status) {
              self.pick_up_lat = marker.getPosition().lat();
              self.pick_up_lng = marker.getPosition().lng();
              self.kilos_count = self.calculateDistance();

              infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);
            }
          );
        });
      }
      initialize();
    },

    addProduct() {
      let product = {
        name: "",
        one_piece_price: 0,
        quantity: 1,
        total_price: 0,
        note: ""
      };

      this.products.push(product);
    },
    goBack() {
      this.$router.go(-1);
      this.$router.replace({ path: "/driver-applications" });
    },
    deleteProduct(index) {
      this.products.splice(index, 1);
    },

    getOrdrer() {
      let self = this;
      axios
        .post(
          "/api/edit-order/" +
            self.$route.params.id +
            "?token=" +
            localStorage.getItem("api_token")
        )
        .then(function(response) {
          console.log(response.data);

          self.customer_name = response.data.data.customer_name;
          self.customer_mobile = response.data.data.customer_mobile;
          self.deliver_fees = response.data.data.deliver_fees;
          self.discount = response.data.data.discount;
          self.delivery_lat = response.data.data.delivery_lat;
          self.delivery_lng = response.data.data.delivery_lng;
          self.pick_up_lat = response.data.data.pick_up_lat;
          self.pick_up_lng = response.data.data.pick_up_lng;
          self.kilos_count = response.data.data.kilos_count;
          self.payment_type = response.data.data.payment_type;
          self.payment_method = response.data.data.payment_method;
          self.code = response.data.data.code;
          self.order_price = response.data.data.order_price;
          self.delivery_time = response.data.data.delivery_time;
          self.delivery_time_string = new Date(
            response.data.data.delivery_time
          ).toLocaleString("en");

          self.products = response.data.data.products;
        })
        .catch(function(error) {
          console.log(error);
          self.alertColor = "danger";
          self.message = "unexpected error occurred in loading the order info.";
          self.showAlert();
        });
    },
    store() {
      let self = this;
      let formData = new FormData();
      let orderPrice = 0;
      this.number_of_products = this.products.length;

      // this.products.forEach(element => {
      //   orderPrice += element.quantity * element.one_piece_price;
      //   element.total_price = element.quantity * element.one_piece_price;
      // });

      // this.order_price = orderPrice;

      this.total_price =parseInt(this.order_price) - parseInt(this.discount);
      formData.append("customer_name", this.customer_name);
      formData.append("customer_mobile", this.customer_mobile);
      formData.append("order_price", this.order_price);
      formData.append("discount", this.discount);
      formData.append("deliver_fees", this.deliver_fees);
      formData.append("delivery_time", this.delivery_time);
      formData.append("code", this.code);
      formData.append("number_of_products", this.number_of_products);
      formData.append("total_price", this.total_price);
      formData.append("payment_type", this.payment_type);
      formData.append("payment_method", this.payment_method);
      formData.append("pick_up_lng", this.pick_up_lng);
      formData.append("pick_up_lat", this.pick_up_lat);
      formData.append("delivery_lng", this.delivery_lng);
      formData.append("delivery_lat", this.delivery_lat);
      formData.append("kilos_count", this.kilos_count);
      formData.append("products", JSON.stringify(this.products));

      axios
        .post(
          "/api/update-order/" +
            self.$route.params.id +
            "?token=" +
            localStorage.getItem("api_token"),
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        )
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully Updated Order.";
          self.showAlert();
        })
        .catch(function(error) {
          console.log(error);
          self.alertColor = "danger";
          self.message = "unexpected error occurred in creating new fleet.";
          self.showAlert();
        });
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },

    calculateDistance() {
      self = this;
      let gsp1 = new google.maps.LatLng(self.pick_up_lat, self.pick_up_lng);
      let gsp2 = new google.maps.LatLng(self.delivery_lat, self.delivery_lng);
      let distanceinMetere = google.maps.geometry.spherical.computeDistanceBetween(
        gsp1,
        gsp2
      );
      let kilos_count = distanceinMetere / 1000;
      return kilos_count.toFixed(2);
    }
  },

  created: function() {
    this.getOrdrer();
  },

  mounted: function() {
    setTimeout(() => {
      this.mapPicker2();
      this.mapPicker();
    }, 1000);
  }
};
</script>
