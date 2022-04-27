<template>
  <CRow>
    <CCol col="12" xl="12">
      <CButton class="m-3 m-btn" color="primary" @click="createFleet()">
    Create Client
      </CButton>

      <transition name="slide">
        <CCard>
          <CCardHeader>
            <span :style="(color = 'red')">Client of Branches </span>
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
                        color="info"
                        @click="showFleet(item.id)"
                        ><CIcon name="cil-list"></CIcon
                      ></CButton>
                      <CButton
                        size="sm"
                        color="warning"
                        @click="editFleet(item.id)"
                        ><CIcon name="cil-pencil"></CIcon
                      ></CButton>
                      <CButton
                        size="sm"
                        color="danger"
                        @click="deleteFleet(item.id)"
                        ><CIcon name="cil-trash"></CIcon
                      ></CButton>
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
                    {{item.company_name}}
                  </td>
                </template>

                <template #الحالة="{item}">
                  <td>
                    <CBadge :color="getBadge(item.status)">{{
                      item.status
                    }}</CBadge>
                  </td>
                </template>


                <template #التحكم="{item}">
                  <td>
                    <CButtonGroup>
                      <CButton
                        size="sm"
                        color="info"
                        @click="showFleet(item.id)"
                        ><CIcon name="cil-list"></CIcon
                      ></CButton>
                      <CButton
                        size="sm"
                        color="warning"
                        @click="editFleet(item.id)"
                        ><CIcon name="cil-pencil"></CIcon
                      ></CButton>
                      <CButton
                        size="sm"
                        color="danger"
                        @click="deleteFleet(item.id)"
                        ><CIcon name="cil-trash"></CIcon
                      ></CButton>
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
  name: "Client-branch",
  data: () => {
    return {
      items: [],
      fields: [
        "id",
        "name",
        "phone",
        "status",
        "operation"
      ],

      fieldsAr: [
        "رقم_التسلسل",
        "الأسم",
        "رقم_الموبايل",
        "اسم_الشركة",
        "الحالة",
        "السائقين",
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
      return `client-branch/${id.toString()}/edit`;
    },
    fleetLink(id) {
      return `client-branch/${id.toString()}/fleet`;
    },
    showLink(id) {
      return `client-branch/${id.toString()}/show`;
    },
    createFleet() {
      this.$router.push({ path: "client-branch/create" });



    },
    editFleet(id) {
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
              "/api/users/" + id + "?token=" + localStorage.getItem("api_token"),
              {
                _method: "DELETE"
              }
            )
            .then(function (response) {
              self.alertColor = "success";
              self.message = "Successfully deleted user.";
              self.showAlert();
              self.getFleets();
            })
            .catch(function (error) {
              console.log(error);
              self.alertColor = "danger";
              self.message = "unexpected error occurred in delete the fleet.";
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
          "/api/client-branch?page=" +
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
          self.message = "unexpected error occurred in getting client-branch.";
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
