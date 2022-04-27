<template>
  <CRow>
    <CCol col="12" xl="12">
      <CRow>
        <CCol col="3">
          <CButton class="m-3 m-btn" color="primary" @click="createFleet()">
            {{ $t("create_fleet") }}
          </CButton>
          <CButton class="m-3 m-btn" color="primary" @click="bulkFleet()">
            {{ $t("bulk_fleet") }}
          </CButton>
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
          <CCardHeader>
            <span :style="(color = 'red')">{{ $t("applications") }}</span>
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
                <template #index="{index}">
                  <td>
                    <a href="#">{{  index+1}}</a>
                  </td>
                </template>
                <template #company="{item}">
                  <td>

                      <div class="bg-info"  v-if="item.user" style="padding: 2.5px ; border-radius: 10px ;text-align: center">
                      {{ item.user.company_name!=null? item.user.company_name :item.user.name }}
                    </div>
                  </td>
                </template>

                <template #code="{item}">
                  <td>
                    <a href="#">{{ item.code }}</a>
                  </td>
                </template>

                <template #name="{item}">
                  <td style="width: 270px;">
                    <a href="#" @click="showFleet(item.id)">{{ item.name }}</a>
                  </td>
                </template>

                <template #mobile="{item}">
                  <td>
                    <a href="#">{{ item.mobile }}</a>
                  </td>
                </template>

                <template #identity="{item}">
                  <td>
                    <a href="#">{{ item.identity }}</a>
                  </td>
                </template>

                <template v-if="role=='user,admin'" #status="{item}">
                  <td v-if="item.application_status">
                    <CDropdown
                      :color="item.application_status.class"
                      size="sm"
                      :offset="[0, 5]"
                      :toggler-text="item.application_status.name"
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

                  <template v-else #status="{item}">
                  <td v-if="item.application_status">
                    <CDropdown
                      :color="item.application_status.class"
                      size="sm"
                      :offset="[0, 5]"
                      :toggler-text="item.application_status.name"
                      class="m-2"
                    >
                      <CDropdownItem
                         v-if="status.id!=2 || status.id!=4 "
                        :key="status.id"
                        v-for="status in allStatus"
                        v-show="status !== item.status.name"
                        @click="handleChangeStatus(status.id, item.id)"
                        >{{ status.name }} </CDropdownItem
                      >
                    </CDropdown>
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

          <!--=========================== Start Translations Arabic ============================-->
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
                <template #رقم_التسلسل="{index}">
                  <td>
                    <a href="#">{{ index+1}}</a>
                  </td>
                </template>
                <template #الشركه="{item}">
                  <td>
                    <CBadge v-if="item.user" color="info">
                      {{ item.user.company_name }}
                    </CBadge>
                  </td>
                </template>

                <template #الكود="{item}">
                  <td>
                    <a href="#">{{ item.code }}</a>
                  </td>
                </template>

                <template #الأسم="{item}">
                  <td style="width: 270px;">
                    <a href="#" @click="showFleet(item.id)">{{ item.name }}</a>
                  </td>
                </template>

                <template #رقم_الموبايل="{item}">
                  <td>
                    <a href="#">{{ item.mobile }}</a>
                  </td>
                </template>

                <template #الرقم_التعريفى="{item}">
                  <td>
                    <a href="#">{{ item.identity }}</a>
                  </td>
                </template>

                <template #الحالة="{item}">
                  <td v-if="item.application_status">
                    <CDropdown
                      :color="item.application_status.class"
                      size="sm"
                      :offset="[0, 5]"
                      :toggler-text="item.application_status.name"
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
  name: "AppFleets",
  data: () => {
    return {
      items: [],
      fields: [
        "index",
        "company",
        "code",
        "name",
        "mobile",
        "identity",
        "status",
        "operation"
      ],
      fieldsAr: [
        "رقم_التسلسل",
        "الشركه",
        "الكود",
        "الأسم",
        "رقم_الموبايل",
        "الرقم_التعريفى",
        "الحالة",
        "التحكم"
      ],
      sorter: { column: "", asc: false },
      activePage: 1,
      maxPages: 1,
      message: "",
      alertColor: "",
      role:"",
      showMessage: false,
      dismissSecs: 3,
      dismissCountDown: 0,
      showDismissibleAlert: false,
      columnFilter: {},
      pageOfItems: [],
      loading: false,
      totalCount: 0,
      statuses: [],
      myLang: "",
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
    chatFleet(id) {
      const chatLink = this.chatLink(id);
      this.$router.push({ path: chatLink });
    },
    getLocale() {
      let locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
    },
    handleChangeStatus(statusId, driverId) {
      console.log("changed ....");
      let self = this;
      axios
        .post(
          "/api/change-status-app/" +
            driverId +
            "?token=" +
            localStorage.getItem("api_token"),
          {
            status_id: statusId
          }
        )
        .then(function(res) {
          self.alertColor = "success";
          self.message = "Successfully updated ";
          self.showAlert();
          self.getFleets();
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    changeItemsLimit(val) {
      this.itemsLimit = val;
      this.getFleets();
    },
    editLink(id) {
      return `driver-applications/${id.toString()}/edit`;
    },
    showLink(id) {
      return `driver-applications/${id.toString()}/show`;
    },
    chatLink(id) {
      return `fleets/${id.toString()}/chat`;
    },
    bulkFleet() {
      this.$router.push({ path: "driver-applications/bulk-driver" });
    },
    createFleet() {
      this.$router.push({ path: "driver-applications/create" });
    },
    editFleet(id) {
      const editLink = this.editLink(id);
      this.$router.push({ path: editLink });
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
              "/api/driver-applications/" +
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
          "/api/driver-applications?page=" +
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
          console.log(response.data.statuses);
          self.items = self.items.concat(response.data.fleets.data);
          self.maxPages = response.data.fleets.last_page;
          self.onlineCount = response.data.onlineCount;
          self.totalCount = response.data.fleets.total;
          self.allStatus = response.data.statuses;
          self.role = response.data.user.menuroles;
          self.loading = false;
        })
        .catch(function(error) {
          console.log(error);
          self.loading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in getting fleets.";
          self.showAlert();
        });
    },
    makeFilter() {
      this.getFleets();
    }
  },
  mounted: function() {
    this.getLocale();
    this.getFleets();
  }
};
</script>
