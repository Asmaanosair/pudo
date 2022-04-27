<template>
  <CRow>



    <div class="move-top">
      <CCol col="12" xl="12">
        <CRow>

          <CCol col="12">


             <br />


          </CCol>

        </CRow>
      </CCol>
      <CCol col="12" xl="12">
        <transition name="slide">
          <CCard>
            <CCardHeader> Main Wallet</CCardHeader>
            <CCardBody>

              <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
                ({{ dismissCountDown }}) {{ message }}
              </CAlert>
              <CCol sm="12">
                <div class="row input-daterange">
                  <div class="col-md-4">
                    <input type="date" v-model="from_date" id="from_date" class="form-control" placeholder="From Date"  dataformatas="DD/MM/YYYY"  />
                  </div>
                  <div class="col-md-4">
                    <input type="date" v-model="to_date" id="to_date" class="form-control" placeholder="To Date"  dataformatas="DD/MM/YYYY"  />
                  </div>

                  <div class="col-md-4">
                    <button type="button" name="filter" id="filter" class="btn btn-primary" @click="getFleets">Filter</button>
                    <button type="button" name="refresh" id="refresh" class="btn btn-default" @click="refresh">Refresh</button>
                  </div>
                </div>

                <CDataTable
                  :items="items"
                  :fields="fields"
                  index-column
                  hover
                  table-column
                  items-per-page-select
                  :sorter="{ external: true, resetable: true }"
                  :columnFilter="{ external: true, lazy: true }"
                  @pagination-change="changeItemsLimit"
                  :sorter-value.sync="sorter"
                  :column-filter-value.sync="columnFilter"
                  :loading="loading"
                >
                  <template #fleet_name-filter="{item}" >
                    <model-select :options="fleets "

                                  placeholder="select driver" style="    width: 160px;"
                                  @input="setDataFilter()" v-model="columnFilter.fleet_id"

                    >

                    </model-select>
                  </template>
                  <template #status-filter="{item}">

                    <select
                      class="form-control" @change="setDataFilter()" v-model="columnFilter.order_status_id"
                    >
                      <option v-for="status in allStatus" :value="status.id" >{{ status.name }}</option>

                    </select>


                  </template>
                  <template #created_at-filter="{item}">

                    <input type="date" v-model="columnFilter.created_at" id="created_at" class="form-control" placeholder="To Date" @change="setDataFilter()" dataformatas="DD/MM/YYYY" />


                  </template>
                  <template #client_name-filter="{item}" >
                    <model-select :options="clients"

                                  placeholder="select Client" style="    width: 160px;"
                                  @input="setDataFilter()" v-model="columnFilter.user_id"

                    >
                    </model-select>
                  </template>
                  <template #id="{item}">
                    <td >
                      {{ item.id }}
                    </td>
                  </template>

                  <template #created_at="{item}">
                    <td >

                      {{ createdMoment(item.created_at) }}
                    </td>
                  </template>

                  <template #status="{item}">
                    <td>
                      <CButton  :color="item.status.class"   class="m-2">  {{ item.status.name}}</CButton>

                    </td>
                  </template>
                  <template #reason="{item}">
                    <td>

                      {{ reasons[item.reason - 1]}}

                    </td>
                  </template>
                  <template #delivery_commission="{item}">
                    <td>

                      {{ item.commission}}

                    </td>
                  </template>
                  <template #delivery_fees="{item}">
                    <td>

                      {{ item.deliver_fees}}

                    </td>
                  </template>
                  <template #delivery_cost="{item}">
                    <td>

                      {{ item.kilos_total_price}}

                    </td>
                  </template>
                  <template #fleet_name="{item}">
                    <td >
                       <span v-if=" item.fleet!=null">
                      {{ item.fleet.name}}
                      </span>
                    </td>
                  </template>
                  <template #client_name="{item}">
                    <td >
                      <span v-if=" item.user!=null">
                      {{ item.user.company_name }}
                          </span>
                    </td>
                  </template>

                  <template #fleet="{item}">
                    <td >
                     {{ item.balance_fleet }}

                    </td>
                  </template>

                  <template #client="{item}">
                    <td>
                      {{ item.balance_client }}
                    </td>
                  </template>
                  <template #price="{item}">
                    <td>
                     {{ item.order_price }} <br>

                    </td>
                  </template>




                </CDataTable>
                <!--=============================== Start Translation Arabic ===============================-->

                <CPagination :pages="maxPages" :active-page.sync="activePage" />

                <!--<TwistPagination  :pager = "pager"   />-->
              </CCol>
            </CCardBody>
          </CCard>
        </transition>
      </CCol>
    </div>

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
import { ModelSelect } from 'vue-search-select'
import moment from 'moment';
// import TwistPagination from '../twistPagination/Paginate.vue'

export default {
  name: "Fleets",
  components: {
    ModelSelect
  },
  data: () => {
    return {
      fleets:[],
      allStatus:[],
      clients:[],
      created_at:'',
      fleet_id: {
        value: '',
        text: ''
      },
      user_id: {
        value: '',
        text: ''
      },
      items: [],
      fields: [
        "id",
        "created_at",
        "status",
        "reason",
        "delivery_commission",
        "delivery_fees",
        "delivery_cost",
        "fleet_name",
        "client_name",
        "fleet",
        "client",
        "price",
      ],

      sorter: { column: "", asc: false },
      activePage: 1,
      myLang: "",
      from_date: "",
      to_date: "",
      maxPages: 1,
      message: "",
      alertColor: "",
      showMessage: false,
      dismissSecs: 3,
      dismissCountDown: 0,
      showDismissibleAlert: false,
      columnFilter: {},
      pageOfItems: [],
      reasons:[
             'Client_Canceled_Before_Pickup ',
             'Store_Is_Closed' ,
             'Wrong_Pickup_Location' ,
             'App_Issues',
              'Client_Canceled_On_The_Way' ,
              'Driver_Refused_To_Deliver_Or_Late' ,
               'Car_Issues' ,
               'Abnormal_Weather' ,
              'Customer_Refused_To_Take_The_Order_Because_Of_Driver' ,
              'Customer_Refused_To_Take_The_Order_Because_Of_Client',
                //New Order
              'Customer_Canceled_New_Order',
              'Client_Canceled_New_Order',
              //Assign Order
              'Driver_Refused_To_Deliver_Assign_Order',
              'Driver_Canceled_Assign_Order',
              'Car_Issues_Assign_Order',
              'Abnormal_Weather_Assign_Order',
               'Order_Disappeared_From_The_Driver_App_Assign_Order',
               'Mistake_In_Dispatching_Logic_Assign_Order',
               'Driver_Is_Not_Responding_Assign_Order',
              //On_The_Way_To_Pickup
                'Customer_Canceled_On_The_Way_To_Pickup',
                'Client_Canceled_On_The_Way_To_Pickup',
                'Driver_Refused_To_Deliver_On_The_Way_To_Pickup',
                'Driver_Canceled_On_The_Way_To_Pickup',
                'Car_Issues_On_The_Way_To_Pickup',
               'Abnormal_Weather_On_The_Way_To_Pickup',
               'Mistake_In_Dispatching_Logic_On_The_Way_To_Pickup',
               'Missing_Order_Information_In_The_Driver_App_On_The_Way_To_Pickup',
               'Driver_Stopped_By_The_Police_On_The_Way_To_Pickup',
               'Traffic_On_The_Way_To_Pickup',
               'Order_Disappeared_From_The_Driver_App_On_The_Way_To_Pickup',
      //Reach_Pickup_location
      ],

      loading: false,
      onlineCount: 0,
      offlineCount: 0,
      totalCount: 0
    };
  },
  watch: {
    activePage() {
      this.getFleets();
    },
    sorter: {
      handler() {
        this.getFleets();
      },
      deep: true
    },

    columnFilter() {
      this.getFleets();
    }
    ,

  },
  methods: {
    createdMoment($created_at) {
      return moment(String($created_at)).format('DD/MM/YYYY ')
    },
    getAllStatus() {
      let self = this;
      axios
        .get("/api/all-statuses?token=" + localStorage.getItem("api_token"))
        .then(function(res) {
          self.allStatus = res.data.statuses;
          self.role = res.data.user.menuroles;

        })
        .catch(function(error) {

        });
    },
    setDataFilter() {

      this.getFleets();
    },
    getAllFleet() {
      let self = this;
      axios
        .get("/api/all_fleet_client?token=" + localStorage.getItem("api_token"))
        .then(function(res) {
          self.fleets = res.data.fleet;
          self.clients = res.data.client;


        })
        .catch(function(error) {

        });
    },
    changeItemsLimit(val) {
      this.itemsLimit = val;
      this.getFleets();
    },

    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    getFleets() {
      this.loading = true;
      let self = this;
      this.items = [];
      axios
        .get(
          "/api/main?page=" +
          self.activePage +
          "&token=" +
          localStorage.getItem("api_token"),
          {
            params: {
              sorter: self.sorter,
              columnFilter: self.columnFilter,
              itemsLimit: self.itemsLimit,
              from_date:self.from_date,
              to_date:self.to_date,
            }
          }
        )
        .then(function(response) {
          console.log(self.reasons);
          self.items = self.items.concat(response.data.orders.data);
          self.maxPages = response.data.orders.last_page;


          self.loading = false;
        })
        .catch(function(error) {
          console.log(error);
          self.loading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in gettin fleets.";
          self.showAlert();
        });
    },
    makeFilter() {
      this.getFleets();
    },
    getLocale() {
      let locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
    },
    refresh(){
      let self = this;
      self.from_date=''
      self.to_date=''
      this.getFleets();
    },
  },
  created(){
    this.getFleets();
  },
  mounted: function() {

    this.getLocale();
    this.getAllFleet();
    this.getAllStatus();
  }
};
</script>
