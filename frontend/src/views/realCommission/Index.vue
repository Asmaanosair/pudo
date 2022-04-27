<template>
  <CRow>
    <CCol col="12" xl="12">
      <CButton class="m-3 m-btn" color="primary" @click="createFleet()">
        Create Delivery Commission
      </CButton>

      <transition name="slide">
        <CCard>
          <CCardHeader>
            <span :style="(color = 'red')">Delivery Commissions</span>
          </CCardHeader>

          <CCardBody >
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
                <template #type="{item}">
                  <td>
                    <CBadge :color="getBadge(item.type)">{{
                        item.type ==0 ?'Fixed' :'Dynamic'
                      }}</CBadge>
                  </td>
                </template>

                <template #operation="{item}">
                  <td>
                    <CButtonGroup>

                      <CButton
                        size="sm"
                        color="warning"
                        @click="editCommission(item.id)"
                      ><CIcon name="cil-pencil"></CIcon
                      ></CButton>
<!--                      <CButton-->
<!--                        size="sm"-->
<!--                        color="danger"-->
<!--                        @click="deleteCommission(item.id)"-->
<!--                      ><CIcon name="cil-trash"></CIcon-->
<!--                      ></CButton>-->
                    </CButtonGroup>
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
  name: "commission",
  data: () => {
    return {
      items: [],
      fields: [
        "id",
        "name",
        "distance",
        "default_price",
        "price_after",
        "type",
        "operation"
      ],

      fieldsAr: [
        "رقم_التسلسل",
        "الأسم",
        "السعر",
        "الحالة",
        "التحكم"
      ],
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
    editLink(id) {
      return `delivery-commission/${id.toString()}/edit`;
    },
    fleetLink(id) {
      return `delivery-commission/${id.toString()}/fleet`;
    },
    showLink(id) {
      return `delivery-commission/${id.toString()}/show`;
    },
    createFleet() {
      this.$router.push({ path: "delivery-commission/create" });



    },
    editCommission(id) {
      const editLink = this.editLink(id);
      this.$router.push({ path: editLink });
    },
    showFleet(id) {
      const editLink = this.showLink(id);
      this.$router.push({ path: editLink });
    },
    SFleet(id) {
      const fleetLink = this.fleetLink(id);
      this.$router.push({ path: fleetLink });
    },

    deleteCommission(id) {
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
              "/api/real-commission/" +
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
              self.getFleets();
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
          "/api/real-commission?page=" +
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
          self.items = self.items.concat(response.data.commissions.data);
          self.maxPages = response.data.commissions.last_page;

          self.loading = false;
        })
        .catch(function(error) {
          console.log(error);
          self.loading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in getting commission.";
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
    this.getLocale();
    this.getFleets();
  }
};
</script>
