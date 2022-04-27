<template>
  <CRow class="m-orders">
    <CCol col="12" xl="12">
      <CCol col="3" class="my-3">
          <div class="popup-reason">
          <!-- Modal -->
          <div
            v-if="popupReasons"
            class="modal modal-reasons fade show d-block"
            id="exampleModal"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
          >
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">
                    Reasons Failed For Order Id : {{orderReasonId}}
                  </h5>
                  <button
                    type="button"
                    @click="popupReasons = false"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                  >
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div>
                    <div role="group" class="form-group">
                      <p>Order Level</p>
                      <select
                        type="text"
                        class=" form-control"
                        v-model="orderLevel"
                        @change="getReason"
                      >

                        <option value="0">
                          New Order
                        </option>
                        <option value="1">
                          Assign Order
                        </option>
                        <option value="2">
                          On the way to pickup
                        </option>
                        <option value="3">
                          Reach Pickup location (before bicked up)
                        </option>
                        <option value="4">
                          On the way to dropoff
                        </option>
                        <option value="5">
                          Reach dropoff location
                        </option>


                      </select>
                      <hr>
                      <div v-for="reason in allReason" :key="reason.id">
                        <input
                          type="radio"
                          :value="reason.id"
                          name="reason"
                          v-model="theReason"
                        />
                        <label>{{ reason.reason }} </label>
                      </div>
                    </div>
                    <!--                    <h4 class="text-danger">-->
                    <!--                      *Reach Pickup location (before picked up)-->
                    <!--                    </h4>-->
                    <!--                    <div v-for="(reason, index) in reasons" :key="index">-->
                    <!--                      <h4 v-if="index == 4" class="text-danger">-->
                    <!--                        * On the way to dropoff-->
                    <!--                      </h4>-->
                    <!--                      <h4 v-if="index == 8" class="text-danger">-->
                    <!--                        * Reach dropoff location-->
                    <!--                      </h4>-->
                    <!--                      <input-->
                    <!--                        type="radio"-->
                    <!--                        :value="index + 1"-->
                    <!--                        name="reason"-->
                    <!--                        v-model="theReason"-->
                    <!--                        :checked="theReason == index + 1"-->
                    <!--                      />-->
                    <!--                      <label>{{ reason }} </label>-->
                    <!--                    </div>-->
                  </div>
<!--                  <div>-->
<!--                    <h4 class="text-danger">-->
<!--                      *Reach Pickup location (before bicked up)-->
<!--                    </h4>-->
<!--                    <div v-for="(reason, index) in reasons" :key="index">-->
<!--                      <h4 v-if="index == 4" class="text-danger">-->
<!--                        * On the way to dropoff-->
<!--                      </h4>-->
<!--                      <h4 v-if="index == 8" class="text-danger">-->
<!--                        * Reach dropoff location-->
<!--                      </h4>-->
<!--                      <input-->
<!--                        type="radio"-->
<!--                        :value="index + 1"-->
<!--                        name="reason"-->
<!--                        v-model="theReason"-->
<!--                        :checked="theReason == index + 1"-->
<!--                      />-->
<!--                      <label>{{ reason }} </label>-->
<!--                    </div>-->
<!--                  </div>-->
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                    @click="popupReasons = false"
                  >
                    Close
                  </button>
                  <button
                    type="button"
                    class="btn btn-success"
                    @click="sendReason()"
                  >
                    Send Reason
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <a href="/#/new-orders/create"> create Order</a> -->

      </CCol>

      <CCard>
        <!--        <CCardHeader>-->
        <!--            Current Orders-->
        <!--        </CCardHeader>-->
        <CCardBody v-if="myLang == 'en'">
          <h6>
            {{ $t("Orders") }}

            <span>
           {{ $t("Issue") }}
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
              <template #reason-filter="{item}">

                <select
                  class="form-control" @change="reasonFilter()" v-model="currentOrdersColumnFilter.reason"
                >
                  <option v-for="(row,index) in failedReasons" :value="index+1" >{{ row }}</option>

                </select>


              </template>
              <template #index="{index}">
                <td>
                  {{ index + 1 }}
                </td>
              </template>
              <template #order_id="{item}">
                <td>
                  {{ item.id }}
                </td>
              </template>

              <template #company="{item}">
                <td>
                  <div class="bg-info" style="padding: 2.5px ; border-radius: 10px ;text-align: center">
                    {{ item.user.company_name }}

                  </div>
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

              <template #number_of_products="{item}">
                <td>
                  {{ item.number_of_products }}
                </td>
              </template>

              <template #delivery_time="{item}">
                <td>
                  {{ item.delivery_time }}
                </td>
              </template>

              <template #kilos_count="{item}">
                <td>
                  {{ item.kilos_count }}
                </td>
              </template>

              <template #total_price="{item}">
                <td>
                  {{ item.total_price }}
                </td>
              </template>

              <template #delivery_cost="{item}">
                <td>
                  {{ item.kilos_total_price }}
                </td>
              </template>

              <template #delivery_fees="{item}">
                <td>
                  {{ item.deliver_fees }}
                </td>
              </template>

              <!-- Start Drop Down Code -->
              <template v-if="role == 'user,admin'" #status="{item}">
                <td>
                  <CDropdown
                    size="sm"
                    :color="item.status.class"
                    :offset="[10, 5]"
                    :toggler-text="item.status.name"
                    class="m-2"
                  >
                    <CDropdownItem
                      :key="status.id"
                      v-for="status in allStatus"
                      v-show="status !== item.status.name"
                      @click="
                        handleChangeStatus(status.id, item.id, item.reason)
                      "

                    >{{ status.name }}</CDropdownItem
                    >
                  </CDropdown>
                </td>
              </template>

              <template v-else #status="{item}">
                <td>
                  <CDropdown
                    size="sm"
                    :color="item.status.class"
                    :offset="[10, 5]"
                    :toggler-text="item.status.name"
                    class="m-2"
                  >
                    <CDropdownItem
                      v-if="
                        status.id != 34 &&
                          status.id != 36 &&
                          status.id != 37 &&
                          status.id != 10 &&
                          status.id != 11
                      "
                      :key="status.id"
                      v-for="status in allStatus"
                      v-show="status !== item.status.name"
                      @click="
                        handleChangeStatus(status.id, item.id, item.reason)
                      "
                    >{{ status.name }}</CDropdownItem
                    >
                  </CDropdown>
                </td>
              </template>
              <!-- End Drop Down Code -->
              <template #reason="{item}">
                <td >

                  {{ failedReasons[item.reason - 1]}}

                </td>
              </template>
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

              <template #edit="{item}">
                <td>
                  <CButton class="my-btn" size="sm" @click="editOrder(item.id)">
                    <img
                      class="control-img"
                      src="https://www.pinclipart.com/picdir/big/164-1646319_ewsully-com-img-activities-icons-edit-icon-png.png"
                      alt=""
                    />
                  </CButton>
                </td>
              </template>

              <template #delete="{item}">
                <td>
                  <CButton
                    class="my-btn"
                    size="sm"
                    @click="deleteOrder(item.id)"
                  >
                    <img
                      class="control-img"
                      src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGp9jrAF7I5Wc0eAcIu6BS8_620EiL9Dd8Xg&usqp=CAU"
                      alt=""
                    />
                  </CButton>
                </td>
              </template>

              <template #assign_to_driver="{item}">
                <td>
                  <CButton
                    size="sm"
                    v-if="item.fleet_id === null"
                    color="primary"
                    @click="assignOrder(item.id,item.branch_id)"
                  >Assign</CButton
                  >
                  <CButton
                    size="sm"
                    v-else
                    color="warning"
                    @click="assignOrder(item.id,item.branch_id)"
                  >Reassign</CButton
                  >
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
            {{ $t("Orders") }}

            <span>
           {{ $t("Issue") }}
            </span>
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
              <template #رقم_الطلب="{item}">
                <td>
                  {{ item.id }}
                </td>
              </template>

              <template #اسم_الشركة="{item}">
                <td>
                  <div class="bg-info" style="padding: 2.5px ; border-radius: 10px ;text-align: center">
                    {{ item.user.company_name }}

                  </div>
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

              <template #عدد_المنتجات="{item}">
                <td>
                  {{ item.number_of_products }}
                </td>
              </template>

              <template #السعر_الإجمالى="{item}">
                <td>
                  {{ item.total_price }}
                </td>
              </template>

              <template #وقت_التوصيل="{item}">
                <td>
                  {{ item.delivery_time }}
                </td>
              </template>
              <template #المسافه_بالكيلو="{item}">
                <td>
                  {{ item.kilos_count }}
                </td>
              </template>
              <template #تكلفة_التوصيل="{item}">
                <td>
                  {{ item.kilos_total_price }}
                </td>
              </template>
              <template #رسوم_التوصيل="{item}">
                <td>
                  {{ item.deliver_fees }}
                </td>
              </template>

              <!-- Start Drop Down Code -->
              <template #الحالة="{item}">
                <td>
                  <CDropdown
                    size="sm"
                    :color="item.status.class"
                    :offset="[10, 5]"
                    :toggler-text="item.status.name"
                    class="m-2"
                  >
                    <CDropdownItem
                      :key="status.id"
                      v-for="status in allStatus"
                      v-show="status !== item.status.name"
                      @click="handleChangeStatus(status.id, item.id)"
                    >{{ status.name }}</CDropdownItem
                    >
                  </CDropdown>
                </td>
              </template>
              <!-- End Drop Down Code -->

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
              <template #تعيين_للسائق="{item}">
                <td>
                  <CButton
                    size="sm"
                    v-if="item.fleet_id === null"
                    color="primary"
                    @click="assignOrder(item.id,item.branch_id)"
                  >{{ $t("assign") }}</CButton
                  >
                  <CButton
                    size="sm"
                    v-else
                    color="warning"
                    @click="assignOrder(item.id,item.branch_id)"
                  >{{ $t("reassign") }}</CButton
                  >
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
    </CCol>
    <!--============================ Previous Orders  =======================-->

    <FleetsModal
      :showModal="showFleetModal"
      :closeModal="closeModal"
      :orderId="orderId"
      :branchId="branchId"
    >
    </FleetsModal>
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

// import Pusher from "pusher-js";

export default {
  name: "Orders",
  components: {
    FleetsModal
  },

  data: () => {
    return {
      orderId: null,
      branchId: null,
      showFleetModal: false,
      currentOrdersItems: [],
      failedReasons:[
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
      fieldsCurrent: [
        "index",
        "order_id",
        "company",
        "customer_name",
        "customer_mobile",

        "total_price",
        "delivery_time",
        "delivery_fees",
        "delivery_cost",
        "kilos_count",
        "status",
        "reason",
        "show",
        "edit",
        "delete",
        "assign_to_driver"
      ],

      fieldsCurrentAr: [
        "رقم_التسلسل",
        "رقم_الطلب",
        "اسم_الشركة",
        "اسم_صاحب_الطلب",
        "موبايل_صاحب_الطلب",

        "السعر_الإجمالى",
        "وقت_التوصيل",
        "المسافه_بالكيلو",
        "تكلفة_التوصيل",
        "رسوم_التوصيل",
        "الحالة",
        "عرض",
        "تعيين_للسائق"
      ],

      currentOrdersActivePage: 1,
      currentOrdersMaxPages: 1,

      currentOrdersSorter: { column: "", asc: false },

      currentOrdersColumnFilter: {},

      message: "",
      showMessage: false,
      alertColor: "",
      dismissSecs: 3,
      dismissCountDown: 7,
      role: "",
      showDismissibleAlert: false,
      pager: {},
      pageOfItems: [],

      currentOrdersLoading: false,
      connection: null,
      online: null,
      statuses: [],
      allStatus: [],
      newStatus: "",
      myLang: "",
      popupReasons: false,
      allReason:[],
      orderLevel:'',
      reasons: [
        { 'data':[
            { 'id':11,'reason':"Customer_Canceled"},
            { 'id':12,'reason':"Client_Canceled"},

          ]
        },
        { 'data':[
            { 'id':13,'reason':"Driver_Refused_To_Deliver"},
            { 'id':14,'reason':"Driver_Canceled"},
            { 'id':15,'reason':"Car_Issues"},
            { 'id':16,'reason':"Abnormal_Weather"},
            { 'id':17,'reason':"Order_Disappeared_From_The_Driver's_App"},
            { 'id':18,'reason':"Mistake_In_Dispatching_Logic"},
            { 'id':19,'reason':"Driver_Is_Not_Responding"},
          ]
        },
        { 'data':[
            { 'id':20,'reason':"Customer_Canceled"},
            { 'id':21,'reason':"Client_Canceled"},
            { 'id':22,'reason':"Driver_Refused_To_Deliver"},
            { 'id':23,'reason':"Driver_Canceled"},
            { 'id':24,'reason':"Car_Issues"},
            { 'id':25,'reason':"Abnormal_Weather"},
            { 'id':26,'reason':"Order_Disappeared_From_The_Driver's_App"},
            { 'id':27,'reason':"Mistake In Dispatching Logic (Pick Up Location Is Far From The Driver)"},
            { 'id':28,'reason':"Missing Order Information In The Driver's App"},
            { 'id':29,'reason':"Driver Stopped By The Police"},
            { 'id':30,'reason':"Traffic"},
          ]
        },
        { 'data':[
            { 'id':1,'reason':"Client_Canceled"},
            { 'id':2,'reason':"Store_Is_Closed"},
            { 'id':3,'reason':"Wrong_Pickup_Location"},
            { 'id':4,'reason':"App_Issues"},

          ]
        },
        { 'data':[

            { 'id':5,'reason':"Clients_Canceled"},
            { 'id':6,'reason':"Driver_Refused_To_Deliever_Or_Late"},
            { 'id':7,'reason':"Car_Issues"},
            { 'id':8,'reason':"Abnormal_Weather"},

          ]
        },
        { 'data':[

            { 'id':9,'reason':"Customer_Refused_To_Take_The_Order_Because_Of_Driver"},
            { 'id':10,'reason':"Customer_Refused_To_Take_The_Order_Because_Of_Client"},


          ]
        }
      ],
      // reasons: [
      //   "Client_Canceled",
      //   "Store_Is_Closed",
      //   "Wrong_Pickup_Location",
      //   "App_Issues",
      //   "Clients_Canceled",
      //   "Driver_Refused_To_Deliever_Or_Late",
      //   "Car_Issues",
      //   "Abnormal_Weather",
      //   "Customer_Refused_To_Take_The_Order_Because_Of_Driver",
      //   "Customer_Refused_To_Take_The_Order_Because_Of_Client"
      // ],
      theReason: 0,
      orderReasonId: 0
      // ['ASSIGN_TO_DRIVER','DELIVERED','FAILED_TO_RETURN']
    };
  },
  watch: {
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
    }
    //Issue
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
    reasonFilter() {

      this.getCurrentOrders();
    },
    getReason(){
      this.allReason=this.reasons[this.orderLevel].data
      console.log(this.allReason)

    },

    setDataFilter() {
      this.getCurrentOrders();
    },
    sendReason() {
      let self = this;

      axios
        .post(
          "/api/send-reason/" +
            self.orderReasonId +
            "?token=" +
            localStorage.getItem("api_token"),
          {
            reason: self.theReason
          }
        )
        .then(function(res) {
          self.popupReasons = false;
          self.getCurrentOrders();
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    deleteOrder(id) {
      let self = this;
      self.$swal({
        text: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        confirmButtonColor: '#4bb543',
        cancelButtonColor: '#d33',
      }).then((result) => {
        if (result.value) {
          axios
            .post(
              "/api/remove-order/" +
              id +
              "?token=" +
              localStorage.getItem("api_token"),
              {
                _method: "DELETE"
              }
            )
            .then(function(response) {
              self.alertColor = "success";
              self.message = "Successfully deleted .";
              self.showAlert();
              self.getCurrentOrders();
            })
            .catch(function(error) {
              console.log(error);
              self.alertColor = "danger";
              self.message = "unexpected error occurred in delete .";
              self.showAlert();
            });
        }
      });

    },
    editLink(id) {
      return `orders/${id.toString()}/edit-order`;
    },
    editOrder(id) {
      const editOrder = this.editLink(id);
      this.$router.push({ path: editOrder });
    },
    bulkOrder() {
      this.$router.push({ path: "new-orders/bulk-order" });
    },
    createOrder2() {
      this.$router.push({ path: "new-orders/create" });
    },
    createOrder() {
      this.$router.push({ path: "new-orders/create" });
    },

    changeItemsLimitCurrentOrders(val) {
      this.currentOrdersItemsLimit = val;
      this.getCurrentOrders();
    },
    getBadge(status) {
      return status.class;
    },
    orderLink(id) {
      return `orders/${id.toString()}`;
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

    assignOrder(id,branch) {
      this.showFleetModal = true;
      this.orderId = id;
      this.branchId = branch;
    },
    closeModal() {
      this.showFleetModal = false;
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    getCurrentOrders() {
      this.currentOrdersLoading = true;
      let self = this;
      axios
        .get(
          "/api/issueOrder?page=" +
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
          console.log(response);
          self.currentOrdersItems = response.data.issueOrders.data;
          self.currentOrdersMaxPages = response.data.issueOrders.last_page;
          self.currentOrdersLoading = false;
        })
        .catch(function(error) {
          console.log(error);
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
          console.log(error);
        });
    },
    handleChangeStatus(statusId, orderId, reason) {
      if (statusId == "68") {
        this.popupReasons = true;
        this.orderReasonId = orderId;
        this.theReason = reason;
      }
      let self = this;
      axios
        .post(
          "/api/change-status/" +
            orderId +
            "?token=" +
            localStorage.getItem("api_token"),
          {
            status_id: statusId
          }
        )
        .then(function(res) {
          self.getCurrentOrders();
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },

  mounted: function() {
    this.getCurrentOrders();

    this.getAllStatus();
    this.getLocale();
    Pusher.logToConsole = true;
  }
};
</script>
