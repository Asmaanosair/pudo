<template>
  <CRow>
    <CCol col="12" xl="12">
      <CButton class="m-3 m-btn" color="primary" @click="createCity()">
        Create Country
      </CButton>

      <transition name="slide">
        <CCard>
          <CCardHeader>
            <span :style="(color = 'red')">{{ $t("Countries") }}</span>
          </CCardHeader>

          <CCardBody>
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
                    <select
                      :class="
                        item.active == 1 ? 'my-bg-success' : 'my-bg-danger'
                      "
                      @change="changActive(item.id, $event)"
                      class="my-form-control col-md-6"
                    >
                      <option
                        class="my-bg-success"
                        :selected="item.active == 1"
                        value="1"
                        >Active
                      </option>
                      <option
                        class="my-bg-danger"
                        :selected="item.active == 0"
                        value="0"
                        >Not Active
                      </option>
                    </select>
                  </td>
                </template>

                <template #operation="{item}">
                  <td>
                    <CButtonGroup>
                      <CButton
                        size="sm"
                        color="warning"
                        @click="editCity(item.id)"
                        >{{ $t("edit") }}</CButton
                      >

                      <CButton
                        size="sm"
                        color="danger"
                        @click="deleteCity(item.id)"
                        >{{ $t("delete") }}</CButton
                      >
                    </CButtonGroup>
                  </td>
                </template>
              </CDataTable>

              <CPagination :pages="maxPages" :active-page.sync="activePage" />
            </CCol>
          </CCardBody>

          <!--==================== Start Translations Arabic ====================-->
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
  name: "Supplier",
  data: () => {
    return {
      items: [],
      fields: ["id", "name", "status", "operation"],

      fieldsAr: ["رقم_التسلسل", "الأسم", "مفعل"],
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
      this.getCities();
    },
    sorter: {
      handler() {
        this.getCities();
      },
      deep: true
    },

    columnFilter() {
      this.getCities();
    }
  },
  methods: {
    changActive(id, event) {
      let self = this;
      if (event.target.value == 0) {
        event.target.classList.remove("my-bg-success");
        event.target.classList.add("my-bg-danger");
      } else {
        event.target.classList.remove("my-bg-danger");
        event.target.classList.add("my-bg-success");
      }

      let formData = new FormData();
      formData.append("active", event.target.value);

      axios
        .post(
          "/api/change-country/" +
            id +
            "?token=" +
            localStorage.getItem("api_token"),
          formData
        )
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully Changed Country Status.";
          self.showAlert();
        })
        .catch(function(error) {
          console.log(error);
          self.alertColor = "danger";
          self.message = "unexpected error occurred in delete the Country.";
          self.showAlert();
        });
    },
    deleteCity(id) {
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
              "/api/countries/" +
              id +
              "?token=" +
              localStorage.getItem("api_token"),
              {
                _method: "DELETE"
              }
            )
            .then(function (response) {
              self.alertColor = "success";
              self.message = "Successfully deleted Country.";
              self.showAlert();
              self.getCities();
            })
            .catch(function (error) {
              console.log(error);
              self.alertColor = "danger";
              self.message = "unexpected error occurred in delete the Country.";
              self.showAlert();
            });
        }
      });
    },
    changeItemsLimit(val) {
      this.itemsLimit = val;
      this.getFleets();
    },
    editLink(id) {
      return `countries/${id.toString()}/edit`;
    },
    editCity(id) {
      const editLink = this.editLink(id);
      this.$router.push({ path: editLink });
    },
    createCity() {
      this.$router.push({ path: "countries/create" });
    },
    getCities() {
      this.loading = true;
      let self = this;
      this.items = [];
      axios
        .get(
          "/api/countries?page=" +
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
          self.items = self.items.concat(response.data.cities.data);
          self.maxPages = response.data.cities.last_page;

          self.onlineCount = response.data.onlineCount;
          self.totalCount = response.data.cities.total;
          self.loading = false;
        })
        .catch(function(error) {
          console.log(error);
          self.loading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in gettin countries.";
          self.showAlert();
        });
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
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
    this.getCities();
  }
};
</script>
