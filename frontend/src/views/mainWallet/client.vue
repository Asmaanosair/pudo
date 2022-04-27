<template>
  <CRow>
    <CCol col="12" xl="12">


      <transition name="slide">
        <CCard>
          <CCardHeader>
            <span :style="(color = 'red')">  Main Wallet Of  Clients</span>
          </CCardHeader>

          <CCardBody v-if="myLang == 'en'">
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


                <template #Orders="{item}" hidden>
                  <td>
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
                <template #Wallet_balance="{item}">
                  <td>
                    <CBadge :color="getWalletBadge(item.fleet_balance)">{{
                        item.fleet_balance
                      }}</CBadge>
                  </td>
                </template>
                <template #status="{item}">
                  <td>
                    <CBadge :color="getBadge(item.status)">{{
                        item.status
                      }}</CBadge>
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

              </CDataTable>

              <CPagination :pages="maxPages" :active-page.sync="activePage" />
            </CCol>
          </CCardBody>

          <!--==================== Start Translations Arabic ====================-->

          <CCardBody v-else>
            <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
              ({{ dismissCountDown }}) {{ message }}
            </CAlert>
            <CCol sm="12">
              <CDataTable
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
                <template #رقم_التسلسل="{item}">
                  <td>
                    {{ item.id }}
                  </td>
                </template>

                <template #الأسم="{item}">
                  <td>
                    {{ item.name }}
                  </td>
                </template>

                <template #رقم_الموبايل="{item}">
                  <td>
                    {{ item.phone }}
                  </td>
                </template>

                <template #اسم_الشركة="{item}">
                  <td>
                    {{ item.company_name }}
                  </td>
                </template>

                <template #الحالة="{item}">
                  <td>
                    <CBadge :color="getBadge(item.status)">{{
                        item.status
                      }}</CBadge>
                  </td>
                </template>




              </CDataTable>

              <CPagination :pages="maxPages" :active-page.sync="activePage" />
            </CCol>
          </CCardBody>
        </CCard>
      </transition>
    </CCol>
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
  name: "Client",
  data: () => {
    return {
      items: [],
      fields: [
        "id",
        "company_name",
        "phone",
        "Wallet_balance",
        "Orders",
        "status",
        "operation"

      ],

      fieldsAr: ["رقم_التسلسل", "الأسم", "رقم_الموبايل", "الحالة",],
      sorter: { column: "", asc: false },
      activePage: 1,
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
      totalCount: 0,
      myLang: "",
      statuses: [],
      allStatus: []
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
  },
  methods: {
    changeItemsLimit(val) {
      this.itemsLimit = val;
      this.getFleets();
    },



    clientLink(id) {
      return `clients/${id.toString()}/orders`;
    },




    SClient(id) {
      const clientLink = this.clientLink(id);
      this.$router.push({ path: clientLink });
    },

    getBadge(status) {
      return status === "Active"
        ? "success"
        : status === "Inactive"
          ? "secondary"
          : status === "Pending"
            ? "warning"
            : status === "Banned"
              ? "danger"
              : "primary";
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
          "/api/client?page=" +
          self.activePage +
          "&token=" +
          localStorage.getItem("api_token"),
          {
            params: {
              sorter: self.sorter,
              columnFilter: self.columnFilter,
              itemsLimit: self.itemsLimit
            }
          }
        )
        .then(function(response) {
          console.log(response);
          self.items = self.items.concat(response.data.fleets.data);
          self.maxPages = response.data.fleets.last_page;
          self.allStatus = response.data.statuses;

          self.loading = false;
        })
        .catch(function(error) {
          console.log(error);
          self.loading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in getting client.";
          self.showAlert();
        });
    },
    makeFilter() {
      this.getFleets();
    },
    getWalletBadge(balance) {
      return parseFloat(balance) <= 0 ? "danger" : "success";
    },
    walletLink(id) {
      return `/client/${id.toString()}/wallet`;
    },
    goWallet(id) {
      const walletLink = this.walletLink(id);
      this.$router.push({ path: walletLink });
    },
    getLocale() {
      let locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
    },

  },
  mounted: function() {
    this.getLocale();
    this.getFleets();
  }
};
</script>
