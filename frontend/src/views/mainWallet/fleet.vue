<template>
  <CRow>
    <div class="move-top">
      <CCol col="12" xl="12">
        <CRow>
          <!--          <CCol col="3">-->
          <!--            <CButton-->
          <!--              class="m-3 my-create-fleet"-->
          <!--              color="primary"-->
          <!--              @click="createFleet()"-->
          <!--            >-->
          <!--              {{ $t("create_driver") }}-->
          <!--            </CButton>-->
          <!--          </CCol>-->
          <CCol col="3">
            <CCallout color="success">
              <small class="text-muted">{{ $t("online") }}</small
              ><br />
              <strong class="h4">{{ onlineCount }}</strong>
            </CCallout>
          </CCol>
          <CCol col="3">
            <CCallout color="danger">
              <small class="text-muted">{{ $t("offline") }}</small
              ><br />
              <strong class="h4">{{ totalCount - onlineCount }}</strong>
            </CCallout>
          </CCol>
          <CCol col="3">
            <CCallout color="info">
              <small class="text-muted">{{ $t("total") }}</small
              ><br />
              <strong class="h4">{{ totalCount }}</strong>
            </CCallout>
          </CCol>
        </CRow>
      </CCol>
      <CCol col="12" xl="12">
        <transition name="slide">
          <CCard>
            <CCardHeader>MAIN WALLET OF  {{ $t("drivers") }}</CCardHeader>
            <CCardBody>
              <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
                ({{ dismissCountDown }}) {{ message }}
              </CAlert>
              <CCol sm="12">
                <CDataTable
                  v-if="myLang == 'en'"
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
                      class="form-control"  @change="setDataFilter()" v-model="status"
                    >
                      <option value="online" >online</option>
                      <option value="offline" >offline</option>
                      <option value="free">free</option>
                      <option value="busy">busy</option>
                      <option value="suspended">suspended</option>
                    </select>


                  </template>
                  <template #index="{index}">
                    <td style="width: 270px;">
                      {{ index+1 }}
                    </td>
                  </template>
                  <template #Orders="{item}" >
                    <td style="width: 270px;">
                      <CButtonGroup>
                        <CButton

                          size="sm"
                          color="primary"
                          @click="SClient(item.id)"
                        ><CIcon name="cil-list"></CIcon>  Orders
                        </CButton>
                      </CButtonGroup>
                    </td>
                  </template>
                  <template #Requests="{item}" >
                    <td style="width: 270px;">
                      <CButtonGroup>
                        <CButton
                          class="text-dark"
                          size="sm"
                          color="default"
                          @click="SRequest(item.id)"
                        ><CIcon name="cil-list"></CIcon>  Requests
                        </CButton>
                      </CButtonGroup>
                    </td>
                  </template>
                  <template #code="{item}">
                    <td style="width: 270px;">
                      {{ item.code }}
                    </td>
                  </template>

                  <template #name="{item}">
                    <td style="width: 270px;">
                      <a href="#" @click="showFleet(item.id)">{{
                          item.name
                        }}</a>
                    </td>
                  </template>

                  <template #mobile="{item}">
                    <td style="width: 270px;">
                      {{ item.mobile }}
                    </td>
                  </template>

                  <template #identity="{item}">
                    <td style="width: 270px;">
                      {{ item.identity }}
                    </td>
                  </template>

                  <template #Wallet_balance="{item}">
                    <td>
                      <CBadge :color="getWalletBadge(item.fleet_balance)">{{
                          item.fleet_balance
                        }}</CBadge>
                    </td>
                  </template>



                  <template #status="{item}">
                    <td  style="width: 270px;">
                      <CBadge :color="getBadge(item.status)">{{
                          item.status
                        }}</CBadge>
                    </td>
                  </template>
                  <template #active="{item}">
                    <td>
                      <CBadge :color="getactive(item.block)" v-if="item.block==0" >
                        active
                      </CBadge>
                      <CBadge :color="getactive(item.block)" v-if="item.block==1">
                        blocked
                      </CBadge>
                    </td>
                  </template>

                  <template #operation="{item}">
                    <td>
                      <CButtonGroup>
                        <CButton
                          size="sm"
                          color="primary"
                          @click="goWallet(item.id)"
                        >{{ $t("wallet") }}</CButton
                        >

                      </CButtonGroup>
                    </td>
                  </template>
                  <!--          <template #delete="{item}">-->
                  <!--            <td>-->
                  <!--              <CButton  color="danger" @click="deleteFleet( item.id )">Delete</CButton>-->
                  <!--            </td>-->
                  <!--          </template>-->
                </CDataTable>
                <!--=============================== Start Translation Arabic ===============================-->
                <CDataTable
                  v-else
                  :items="items"
                  :fields="fieldsAr"
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
                  <template #رقم_التسلسل="{index}">
                    <td style="width: 270px;">
                      {{ index+1 }}
                    </td>
                  </template>

                  <template #رقم_الكود="{item}">
                    <td style="width: 270px;">
                      {{ item.code }}
                    </td>
                  </template>

                  <template #الأسم="{item}">
                    <td style="width: 270px;">
                      <a href="#" @click="showFleet(item.id)">{{
                          item.name
                        }}</a>
                    </td>
                  </template>

                  <template #الموبايل="{item}">
                    <td style="width: 270px;">
                      {{ item.mobile }}
                    </td>
                  </template>

                  <template #الرقم_التعريفى="{item}">
                    <td style="width: 270px;">
                      {{ item.identity }}
                    </td>
                  </template>

                  <template #رصيد_المحفظة="{item}">
                    <td>
                      <CBadge :color="getWalletBadge(item.fleet_balance)">{{
                          item.fleet_balance
                        }}</CBadge>
                    </td>
                  </template>

                  <template #أخر_تسجيل="{item}">
                    <td style="width: 270px;">
                      {{ item.Last_Login }}
                    </td>
                  </template>

                  <template #الحالة="{item}">
                    <td>
                      <CBadge :color="getBadge(item.status)">{{
                          item.status
                        }}</CBadge>
                    </td>
                  </template>
                  <template #الحالة2="{item}">
                    <td>
                      <CBadge :color="getactive(item.block)" v-if="item.block==1" >
                        محظور
                      </CBadge>
                      <CBadge :color="getactive(item.block)" v-if="item.block==0">
                        نشط
                      </CBadge>

                    </td>
                  </template>

                  <template #التحكم="{item}">
                    <td>
                      <CButtonGroup>
                        <CButton
                          size="sm"
                          color="primary"
                          @click="goWallet(item.id)"
                        >{{ $t("wallet") }}</CButton
                        >

                        <CButton
                          size="sm"
                          color="success"
                          @click="showFleet(item.id)"
                        >{{$t('show')}}</CButton
                        >
                        <CButton
                          size="sm"
                          color="warning"
                          @click="editFleet(item.id)"
                        >{{ $t("edit") }}</CButton
                        >

                        <CButton
                          size="sm"
                          color="danger"
                          @click="deleteFleet(item.id)"
                        >{{ $t("delete") }}</CButton
                        >
                      </CButtonGroup>
                    </td>
                  </template>
                  <!--          <template #delete="{item}">-->
                  <!--            <td>-->
                  <!--              <CButton  color="danger" @click="deleteFleet( item.id )">Delete</CButton>-->
                  <!--            </td>-->
                  <!--          </template>-->
                </CDataTable>

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
// import TwistPagination from '../twistPagination/Paginate.vue'

export default {
  name: "Fleets",
  data: () => {
    return {

      items: [],
      fields: [
        "index",
        "code",
        "name",
        "mobile",
        "identity",
        "Wallet_balance",
        "Orders",
        "Requests",


        "status",

        "active",
        "operation"
      ],
      fieldsAr: [
        "رقم_التسلسل",
        "رقم_الكود",
        "الأسم",
        "الموبايل",
        "الرقم_التعريفى",
        "رصيد_المحفظة",
        "الحالة",
        "الحالة2",
        "التحكم"
      ],
      sorter: { column: "", asc: false },
      activePage: 1,
      myLang: "",
      maxPages: 1,
      message: "",
      alertColor: "",
      showMessage: false,
      dismissSecs: 3,
      dismissCountDown: 0,
      showDismissibleAlert: false,
      columnFilter: {},
      pageOfItems: [],

      loading: false,
      status: '',
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
    },

  },
  methods: {
    clientLink(id) {
      return `fleets/${id.toString()}/orders`;
    },
    requestLink(id) {
      return `/request-money/${id.toString()}`;
    },
    SClient(id) {
      const clientLink = this.clientLink(id);
      this.$router.push({ path: clientLink });
    },
    SRequest(id) {
      const requestLink = this.requestLink(id);
      this.$router.push({ path: requestLink });
    },
    setDataFilter() {

      this.getFleets();
    },
    changeItemsLimit(val) {
      this.itemsLimit = val;
      this.getFleets();
    },
    getBadge(status) {
      return status === "online"
        ? "success"
        : status === "offline"
          ? "danger"
          : status === "free"
            ? "dark"
            : status === "busy"
              ? "warning"
              : "primary";
    },
    getactive(status) {
      return status ===0
        ? "success"
        : status === 1
          ? "danger"
          : "primary";
    },
    getWalletBadge(balance) {
      return parseFloat(balance) <= 0 ? "danger" : "success";
    },
    walletLink(id) {
      return `/fleets/${id.toString()}/wallet`;
    },
    goWallet(id) {
      const walletLink = this.walletLink(id);
      this.$router.push({ path: walletLink });
    },
    editLink(id) {
      return `driver-applications/${id.toString()}/edit`;
    },
    chatLink(id) {
      return `fleets/${id.toString()}/chat`;
    },
    showLink(id) {
      return `fleets/${id.toString()}/show`;
    },

    createFleet() {
      this.$router.push({ path: "fleets/create" });
    },
    editFleet(id) {
      const editLink = this.editLink(id);
      this.$router.push({ path: editLink });
    },
    chatFleet(id) {
      const chatLink = this.chatLink(id);
      this.$router.push({ path: chatLink });
    },
    showFleet(id) {
      const editLink = this.showLink(id);
      this.$router.push({ path: editLink });
    },
    deleteFleet(id) {
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
              "/api/fleets/" + id + "?token=" + localStorage.getItem("api_token"),
              {
                _method: "DELETE"
              }
            )
            .then(function(response) {
              self.alertColor = "success";
              self.message = "Successfully deleted user.";
              self.showAlert();
              self.getFleets();
            })
            .catch(function(error) {
              console.log(error);
              self.alertColor = "danger";
              self.message = "unexpected error occurred in delete the fleet.";
              self.showAlert();
            });

        }
      });
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
          "/api/fleets?page=" +
          self.activePage +
          "&token=" +
          localStorage.getItem("api_token"),
          {
            params: {
              sorter: self.sorter,
              status: self.status,
              columnFilter: self.columnFilter,
              itemsLimit: self.itemsLimit
            }
          }
        )
        .then(function(response) {
          console.log(response);
          self.items = self.items.concat(response.data.fleets.data);
          self.maxPages = response.data.fleets.last_page;

          self.onlineCount = response.data.onlineCount;
          self.totalCount = response.data.fleets.total;
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
    }
  },
  mounted: function() {
    this.getFleets();
    this.getLocale();
  }
};
</script>
