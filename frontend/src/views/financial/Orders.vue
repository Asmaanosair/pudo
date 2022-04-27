<template>
  <CRow class="m-orders">
    <CCol col="12" xl="12">

      <CCol col="3" class="my-3">
        <!-- <a href="/#/new-orders/create"> create Order</a> -->

      </CCol>

      <CCard>
                <CCardHeader>
                    Financial
                </CCardHeader>
        <CCardBody v-if="myLang == 'en'">
          <CCol sm="12">

            <table class="table table-striped">
              <thead>
              <tr>
                <th scope="col">#Status</th>
                <th scope="col">TotalOrders</th>
                <th scope="col">TotalPrice</th>

              </tr>
              </thead>
              <tbody>
              <tr>
                <th scope="row">All Orders</th>
                <td>{{ delivery.allcount }}</td>
                <td>{{ delivery.price }}</td>

              </tr>
              <tr>
                <th scope="row">Orders Canceled</th>
                <td>{{ delivery.canceled }}</td>
                <td>{{ delivery.cprice }}</td>

              </tr>
              <tr>
                <th scope="row">Orders Damaged</th>
                <td>{{ delivery.damageCount }}</td>
                <td>{{ delivery.damageSum }}</td>
              </tr>
              <tr>
                <th scope="row">Order Returned</th>
                <td>{{ delivery.recount }}</td>
                <td>{{ delivery.resum }}</td>
              </tr>
              <tr>
                <th scope="row">Order Failed To Returned</th>
                <td>{{ delivery.faildCount }}</td>
                <td>{{ delivery.faildSum }}</td>
              </tr>
              </tbody>
            </table>
          </CCol>

        </CCardBody>
        <!--============================ Start Translation Ar  ===============================-->
        <CCardBody v-else>


          <CCol sm="12">

            <table class="table table-striped">
              <thead>
              <tr>
                <th scope="col">#Status</th>
                <th scope="col">TotalOrders</th>
                <th scope="col">TotalPrice</th>

              </tr>
              </thead>
              <tbody>
              <tr>
                <th scope="row">All Orders</th>
                <td>Otto</td>
                <td>@mdo</td>
                <td>@fat</td>
              </tr>
              <tr>
                <th scope="row">Orders Canceled</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>

              </tr>
              <tr>
                <th scope="row">Orders Damaged</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
              </tr>
              <tr>
                <th scope="row">Order Returned</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
              </tr>
              <tr>
                <th scope="row">Order Failed To Returned</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
              </tr>
              </tbody>
            </table>
          </CCol>
        </CCardBody>
      </CCard>
    </CCol>
    <!--============================ Previous Orders  =======================-->


  </CRow>
</template>
<style>
.d-inline {
  font-size: 10px;
}
td {
  font-size: 12px;
}
</style>

<script>
import axios from "axios";



export default {
  name: "Orders",


  data: () => {
    return {

      delivery:{},
      myLang: "",


    };
  },


  methods: {

    getLocale() {
      let locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
    },


    getCurrentOrders() {
      this.currentOrdersLoading = true;
      let self = this;
      axios
        .get(
          "/api/financial?page=" +
          self.currentOrdersActivePage +
          "&token=" +
          localStorage.getItem("api_token"),
        )
        .then(function(response) {


          self.delivery=response.data
          console.log(response.data);
        })
        .catch(function(error) {
          console.log(error);
          self.currentOrdersLoading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in getting current orders.";
        });
    },


  },

  mounted: function() {
    this.getCurrentOrders();
    this.getLocale();

  }
};
</script>
