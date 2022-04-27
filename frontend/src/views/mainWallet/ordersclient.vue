<template>
  <CRow class="m-orders">
    <CCol col="12" xl="12">
      <CCol col="3" class="my-3">
      </CCol>
      <!--      <CTabs variant="pills" :active-tab="0" class="m-tab">-->
      <!--        <CTab title="All Orders" >-->
      <!--          <transition name="slide">-->
      <CCard>
        <!--        <CCardHeader>-->
        <!--            Current Orders-->
        <!--        </CCardHeader>-->
        <CCardBody v-if="myLang == 'en'">
          <h6>
            <span>
              {{ $t("Orders") }} of Client {{user.company_name}}
            </span>
          </h6>

          <CAlert :show.sync="showMessage" :color="alertColor" fade>
            ({{ dismissCountDown }}) {{ message }}
          </CAlert>

          <CCol sm="12">
            <CDataTable
              hover
              striped
              :items="currentOrdersItems"
              :fields="fieldsCurrent"
              table-column
              items-per-page-select
              :sorter="{ external: true, resetable: true }"
              :columnFilter="{ external: true, lazy: true }"
              @pagination-change="changeItemsLimitCurrentOrders"
              :sorter-value.sync="currentOrdersSorter"
              :column-filter-value.sync="currentOrdersColumnFilter"
              :loading="currentOrdersLoading"
            >
              <template #status-filter="{item}">

                <select
                  class="form-control" @change="setDataFilter()" v-model="currentOrdersColumnFilter.order_status_id"
                >
                  <option v-for="status in allStatus" :value="status.id" >{{ status.name }}</option>

                </select>


              </template>
              <template #fleet_name-filter="{item}" >

                <model-select :options="fleets "

                              placeholder="select driver" style="    width: 160px;"
                              @input="setFleetFilter()" v-model="currentOrdersColumnFilter.fleet_id"

                >
                </model-select>




              </template>
              <template #created_at-filter="{item}">

                <input type="date" v-model="currentOrdersColumnFilter.created_at" id="created_at" class="form-control" placeholder="To Date" @change="setDataFilter()" dataformatas="DD/MM/YYYY" />


              </template>

              <template #id="{item}">
                <td>
                  {{ item.id }}
                </td>
              </template>
              <template #created_at="{item}">
                <td >

                  {{ createdMoment(item.created_at) }}
                </td>
              </template>

              <template #customer_name="{item}">
                <td>
                  {{ item.customer_name }}
                </td>
              </template>

              <template #customer_mobile="{item}">
                <td>
                  {{ item.customer_mobile }}
                </td>
              </template>

              <template #fleet_name="{item}">
                <td>
                   <span v-if=" item.fleet!=null">
                      {{ item.fleet.name}}
                      </span>

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
              <template #order_price="{item}">
                <td>
                  {{ item.order_price }} <br>

                </td>
              </template>

              <!-- Start Drop Down Code -->


              <!-- End Drop Down Code -->

              <template #show="{item}">
                <td>
                  <CButton class="my-btn" size="sm" @click="showOrder(item.id)">
                    <img
                      class="control-img"
                      src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKcHbnEx0bIoJmfthMQ2Jnc97Uz-qjLGOjSg&usqp=CAU"
                      alt=""
                    />
                  </CButton>
                </td>
              </template>






            </CDataTable>

            <CPagination
              :pages="currentOrdersMaxPages"
              :active-page.sync="currentOrdersActivePage"
            />
          </CCol>
        </CCardBody>
        <!--============================ Start Translation Ar  ===============================-->
        <CCardBody v-else>
          <h6>
            {{ $t("orders") }}
            <span> </span>
          </h6>
          <!-- <CButton class="m-3" color="primary" @click="createFleet()">Create Driver</CButton> -->
          <CAlert :show.sync="showMessage" :color="alertColor" fade>
            ({{ dismissCountDown }}) {{ message }}
          </CAlert>
          <CCol sm="12">
            <CDataTable
              hover
              striped
              :items="currentOrdersItems"
              :fields="fieldsCurrentAr"
              table-column
              items-per-page-select
              :sorter="{ external: true, resetable: true }"
              :columnFilter="{ external: true, lazy: true }"
              @pagination-change="changeItemsLimitCurrentOrders"
              :sorter-value.sync="currentOrdersSorter"
              :column-filter-value.sync="currentOrdersColumnFilter"
              :loading="currentOrdersLoading"
            >
              <template #رقم_التسلسل="{index}">
                <td>
                  {{ index + 1 }}
                </td>
              </template>
              <template #رقم_الكود="{item}">
                <td>
                  {{ item.code }}
                </td>
              </template>

              <template #اسم_الشركة="{item}">
                <td>
                  <CBadge color="info">
                    {{ item.user.name }}
                  </CBadge>
                </td>
              </template>

              <template #اسم_صاحب_الطلب="{item}">
                <td>
                  {{ item.customer_name }}
                </td>
              </template>

              <template #موبايل_صاحب_الطلب="{item}">
                <td>
                  {{ item.customer_mobile }}
                </td>
              </template>



              <template #السعر_الإجمالى="{item}">
                <td>
                  {{ item.total_price }}
                </td>
              </template>



              <!-- Start Drop Down Code -->
              <template #عرض="{item}">
                <td>
                  <CButton class="my-btn" size="sm" @click="showOrder(item.id)">
                    <img
                      class="control-img"
                      src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKcHbnEx0bIoJmfthMQ2Jnc97Uz-qjLGOjSg&usqp=CAU"
                      alt=""
                    />
                  </CButton>
                </td>
              </template>

            </CDataTable>

            <CPagination
              :pages="currentOrdersMaxPages"
              :active-page.sync="currentOrdersActivePage"
            />
          </CCol>
        </CCardBody>
      </CCard>
      <CButton class="mb-3 col-1 ml-5" color="primary" @click="goBack">{{
          $t("back")
        }}</CButton>
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
import FleetsModal from "../fleets/fleetAssignModal";
import Pusher from "pusher-js";
import { ModelSelect } from 'vue-search-select'
import moment from "moment";

// import Pusher from "pusher-js";

export default {
  name: "Orders",
  components: {
    ModelSelect
  },

  data: () => {
    return {
      fleets:[],
      fleet_id: {
        value: '',
        text: ''
      },


      orderId: null,
      showFleetModal: false,
      currentOrdersItems: [],
      progressOrdersItems: [],
      issueOrdersItems: [],
      previousOrdersItems: [],
      fieldsCurrent: [

        "id",
        "created_at",
        "status",
        "fleet_name",
        "order_price",
        "delivery_cost",
        "delivery_commission",
        "delivery_fees",
        'reason',
        "fleet",
        "client",
        "show",

      ],

      fieldsCurrentAr: [
        "رقم_التسلسل",
        "رقم_الكود",
        "اسم_صاحب_الطلب",
        "موبايل_صاحب_الطلب",
        "الحالة",
        "عرض",

      ],

      previousOrdersActivePage: 1,
      progressOrdersActivePage: 1,
      previousOrdersMaxPages: 1,
      progressOrdersMaxPages: 1,
      issueOrdersActivePage: 1,
      issueOrdersMaxPages: 1,
      currentOrdersActivePage: 1,
      currentOrdersMaxPages: 1,
      previousOrdersSorter: { column: "", asc: false },
      currentOrdersSorter: { column: "", asc: false },
      issueOrdersSorter: { column: "", asc: false },
      progressOrdersSorter: { column: "", asc: false },
      previousOrdersColumnFilter: {},
      progressOrdersColumnFilter: {},
      currentOrdersColumnFilter: {},
      issueOrdersColumnFilter: {},
      message: "",
      showMessage: false,
      alertColor: "",
      dismissSecs: 3,
      dismissCountDown: 7,
      role: "",
      user: "",
      showDismissibleAlert: false,
      pager: {},
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
      pageOfItems: [],
      previousOrdersLoading: false,
      progressOrdersLoading: false,
      issueOrdersLoading: false,
      currentOrdersLoading: false,
      connection: null,
      online: null,
      statuses: [],
      allStatus: [],
      newStatus: "",
      myLang: "",
      popupReasons: false,

      theReason: 0,
      orderReasonId: 0

      // ['ASSIGN_TO_DRIVER','DELIVERED','FAILED_TO_RETURN']
    };
  },
  watch: {
    previousOrdersActivePage() {
      this.getPreviousOrders();
    },

    previousOrdersSorter: {
      handler() {
        this.getPreviousOrders();
      },
      deep: true
    },

    previousOrdersColumnFilter() {
      this.getPreviousOrders();
    },

    //current
    currentOrdersActivePage() {
      this.getCurrentOrders();
    },
    currentOrdersSorter: {
      handler() {
        this.getCurrentOrders();
      },
      deep: true
    },

    currentOrdersColumnFilter() {
      this.getCurrentOrders();
    },
    //Issue
    issueOrdersActivePage() {
      this.getCurrentOrders();
    },
    issueOrdersSorter: {
      handler() {
        this.getCurrentOrders();
      },
      deep: true
    },

    issueOrdersColumnFilter() {
      this.getCurrentOrders();
    },
    //Progress
    progressOrdersActivePage() {
      this.getCurrentOrders();
    },
    progressOrdersSorter: {
      handler() {
        this.getCurrentOrders();
      },
      deep: true
    },

    progressOrdersColumnFilter() {
      this.getCurrentOrders();
    }
  },
  created() {
    let self = this;

    this.$pusher.subscribe("twistOrderOperation");
    this.$pusher.bind("App\\Events\\OrderOperation", data => {
      console.log("the error is here");
      console.log(data);
      let order = self.currentOrdersItems.find(
        order => order.id === data.order.id
      );
      let index = self.currentOrdersItems.indexOf(order);

      let previosStatuses = [8, 9, 10, 11];
      if (order && !previosStatuses.includes(data.order.status.id)) {
        let keys = Object.keys(order);
        keys.map(key => {
          self.currentOrdersItems[index][key] = data.order[key];
        });
      } else if (order && previosStatuses.includes(data.order.status.id)) {
        self.currentOrdersItems.splice(index, 1);
        self.previousOrdersItems.push(data.order);
      } else {
        self.currentOrdersItems.push(data.order);
      }
    });
  },
  methods: {
    goBack() {
      this.$router.go(-1)
    },
    createdMoment($created_at) {
      return moment(String($created_at)).format('DD/MM/YYYY ')
    },
    reset () {
      this.fleet_id = {}
    },
    selectFromParentComponent1 () {
      // select option from parent component
      this.fleet_id = this.fleets[0]
    },

    setDataFilter() {

      this.getCurrentOrders();
    },

    setFleetFilter() {

      this.getCurrentOrders();
    },


    changeItemsLimitPreviousOrders(val) {
      this.previousOrdersitemsLimit = val;
      this.getPreviousOrders();
    },
    changeItemsLimitIssueOrders(val) {
      this.issueOrdersitemsLimit = val;
      this.getIssueOrders();
    },
    changeItemsLimitProgressOrders(val) {
      this.progressOrdersitemsLimit = val;
      this.getProgressOrders();
    },
    changeItemsLimitCurrentOrders(val) {
      this.currentOrdersItemsLimit = val;
      this.getCurrentOrders();
    },
    getBadge(status) {
      return status.class;
    },
    orderLink(id) {
      return `/orders/${id.toString()}`;
    },
    showOrder(id) {
      const orderLink = this.orderLink(id);
      this.$router.push({ path: orderLink });
    },
    getLocale() {
      let locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
    },


    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    getCurrentOrders() {
      this.currentOrdersLoading = true;
      let self = this;
      axios
        .get(
          "/api/main-client/"+self.$route.params.id+"?page=" +
          self.currentOrdersActivePage +
          "&token=" +
          localStorage.getItem("api_token"),
          {
            params: {
              sorter: self.currentOrdersSorter,
              columnFilter: self.currentOrdersColumnFilter,
              itemsLimit: self.currentOrdersItemsLimit
            }
          }
        )
        .then(function(response) {

          self.currentOrdersItems = response.data.orders.data;
          self.user = response.data.user;
          self.currentOrdersMaxPages = response.data.orders.last_page;
          self.currentOrdersLoading = false;
          console.log( self.currentOrdersItems);
        })
        .catch(function(error) {

          self.currentOrdersLoading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in getting current orders.";
        });
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
    getAllFleet() {
      let self = this;
      axios
        .get("/api/all_fleet_client?token=" + localStorage.getItem("api_token"))
        .then(function(res) {
          self.fleets = res.data.fleet;


        })
        .catch(function(error) {

        });
    },

  },

  mounted: function() {
    this.getCurrentOrders();

    this.getAllStatus();
    this.getAllFleet();
    this.getLocale();
    Pusher.logToConsole = true;
  }
};
</script>
