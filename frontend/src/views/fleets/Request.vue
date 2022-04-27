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
            <CCardHeader> Requests of {{fleet}} </CCardHeader>
            <CCardBody>
              <h4>    {{$t("total_balance")}} <CBadge :color="getWalletBadge(balance)">{{balance}}</CBadge> </h4>

              <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
                ({{ dismissCountDown }}) {{ message }}
              </CAlert>
              <CCol sm="12">

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

                  <template #status-filter="{item}">

                    <select
                      class="form-control" @change="setDataFilter()" v-model="columnFilter.status"
                    >
                      <option v-for="(status,index) in allStatus" :value="index" >{{ status }}</option>

                    </select>


                  </template>
                  <template #created_at-filter="{item}">

                    <input type="date" v-model="columnFilter.created_at" id="created_at" class="form-control" placeholder="To Date" @change="setDataFilter()" dataformatas="DD/MM/YYYY" />


                  </template>

                  <template #id="{item}">
                    <td >
                      {{ item.id }}
                    </td>
                  </template>

                  <template #created_at="{item}">
                    <td>
                      {{ createdMoment(item.created_at) }}
                    </td>
                  </template>

                  <template #status="{item}">
                    <td  style="width: 270px;">
                      <CBadge :color="getBadge(item.status)">{{
                          allStatus[item.status]
                        }}</CBadge>
                    </td>
                  </template>
                  <template #options="{item}">
                    <td>


                      <CButton
                        size="sm"
                        color="success"
                        @click="openModal(item.id,item.status,item.note)"
                      ><CIcon name="cil-pencil"></CIcon
                      ></CButton>

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
                      {{ item.fleet.name }}
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
        <CButton class="mb-3 col-1 ml-5" color="primary" @click="goBack">{{
            $t("back")
          }}</CButton>
      </CCol>
    </div>
    <CModal
      :title="`withdraw `"
      :show.sync="depositModal"
    >

      <select
        class="form-control" v-model="status"
      >
        <option v-for="(status,index) in allStatus" :value="index" >{{ status }}</option>

      </select>
      <CTextarea type="text" label="Note" placeholder="Note" v-model="note"></CTextarea>
      <CInput type="text"  placeholder="Description" v-model="reqId" hidden></CInput>
      <div slot="footer">
        <CButton class="float-right" color="success" @click="withdraw()">
          save
        </CButton>
        <CButton class="" color="danger" @click="depositModal = false">
          Close
        </CButton>
      </div>
    </CModal>
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
  name: "Requests",
  components: {
    ModelSelect
  },
  data: () => {
    return {

      reqId:'',
      fleet:'',
      status:'',
      note:'',
      depositModal:false,
      allStatus:['new','accept','reject'],
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
        "created_at",
        "status",
        "note",
        "balance",
        "options",
      ],

      sorter: { column: "", asc: false },
      activePage: 1,
      myLang: "",
      from_date: "",
      to_date: "",
      maxPages: 1,
      message: "",
      balance: "",
      alertColor: "",
      showMessage: false,
      dismissSecs: 3,
      dismissCountDown: 0,
      showDismissibleAlert: false,
      columnFilter: {},
      pageOfItems: [],
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
    goBack() {
      this.$router.go(-1)
    },
    openModal(id,status,note) {
      this.reqId=id
      this.status=status
      this.note=note
      this.depositModal=true
    },
    createdMoment($created_at) {
      return moment(String($created_at)).format('DD/MM/YYYY ')
    },
    setDataFilter() {

      this.getFleets();
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
    getBadge(status) {
      return status == 1
        ? "success"
        : status == 0
          ? "warning"
          : "danger";
    },
    getFleets() {
      this.loading = true;
      let self = this;
      this.items = [];
      axios
        .get(
          "/api/request-money/"+this.$route.params.id+"/show?page=" +
          self.activePage +
          "&token=" +
          localStorage.getItem("api_token"),
          {
            params: {
              sorter: self.sorter,
              columnFilter: self.columnFilter,
              itemsLimit: self.itemsLimit,
            }
          }
        )
        .then(function(response) {
          console.log(self.reasons);
          self.items = self.items.concat(response.data.orders.data);
          self.balance = response.data.balance;
          self.fleet = response.data.fleet.name;
          self.maxPages = response.data.orders.last_page;


          self.loading = false;
        })
        .catch(function(error) {
          console.log(error);
          self.loading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in getting data .";
          self.showAlert();
        });
    },
    getWalletBadge(balance){
      return parseFloat(balance) <= 0 ? 'danger': 'success';
    },
    withdraw() {
      let self = this;
      this.items = [];
      axios
        .post(
          "/api/request-money/"+this.$route.params.id+"?page=" +
          "&token=" +
          localStorage.getItem("api_token"),
          {
            id: self.reqId,
            note: self.note,
            status: self.status,
          }
        )
        .then(function(response) {
          self.getFleets();
          self.depositModal=false
        })
        .catch(function(error) {
          self.depositModal=false
          self.alertColor = "danger";
          self.message = "unexpected error occurred or the amount of money not available on his Wallet .";
          self.getFleets();
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

  }
};
</script>
