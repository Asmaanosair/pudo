<template>
  <CRow>
    <CCol col="12" xl="12">


      <transition name="slide">
        <CCard>
          <CCardHeader>
            <span :style="(color = 'red')">  Route Numbers</span>
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
                <template #assign_to_driver="{item}">
                  <td>
                    <CButton
                      size="sm"
                      v-if="item.fleet_id === null"
                      color="primary"
                      @click="assignOrder(item.id)"
                    >Assign</CButton
                    >
                    <CButton
                      size="sm"
                      v-else
                      color="warning"
                      @click="assignOrder(item.id)"
                    >Reassign</CButton
                    >
                  </td>
                </template>
                <template #Orders="{item}" >
                  <td style="width: 270px;">
                    <CButtonGroup>
                      <CButton
                        size="sm"
                        color="primary"
                        @click="orders(item.id)"
                      ><CIcon name="cil-list"></CIcon>  Orders
                      </CButton>
                    </CButtonGroup>
                  </td>
                </template>
                <template #status="{item}">
                  <td  style="width: 270px;">
                    <CBadge  style="width: 100px;" v-if="item.status==1" color="success">New </CBadge>
                    <CBadge  style="width: 100px;" v-else-if="item.status==2" color="primary">Accepted </CBadge>
                    <CBadge  style="width: 100px;" v-else-if="item.status==3" color="warning">NOT_ACCEPT </CBadge>
                    <CBadge  style="width: 100px;" v-else-if="item.status==4" color="default">COMPLETED </CBadge>
                    <CBadge  style="width: 100px;" v-else-if="item.status==5" color="danger">Failed </CBadge>
                    <CBadge  style="width: 100px;" v-else-if="item.status==6" color="primary">Assigned </CBadge>


                  </td>
                </template>
                <template #delete="{item}">
                  <td>
                    <CButton
                      class="my-btn"
                      size="sm"
                      @click="deleteBatch(item.id)"
                    >
                      <img
                        class="control-img"
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGp9jrAF7I5Wc0eAcIu6BS8_620EiL9Dd8Xg&usqp=CAU"
                        alt=""
                      />
                    </CButton>
                  </td>
                </template>
                <template #operation="{item}">
                  <td>
                    <CButton color="primary" class="btn-sm" @click="downloadFile(item.id)">Download</CButton>
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

              <CPagination :pages="maxPages" :active-page.sync="activePage" />
            </CCol>
          </CCardBody>
        </CCard>
      </transition>
    </CCol>
    <FleetsRouteNumberModal
      :showModal="showFleetModal"
      :closeModal="closeModal"
      :routeNumberId="routeNumberId"
      :branchId="branchId"
    >
    </FleetsRouteNumberModal>
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
import FleetsRouteNumberModal from "../routeNumber/fleetAssignModal";
import JSZip from "jszip";
import JSZipUtils from "jszip-utils";
import FileSaver from "file-saver";


export default {
  name: "RouteNumber",
  components: {
    // eslint-disable-next-line vue/no-unused-components
    FleetsRouteNumberModal
  },
  data: () => {
    return {
      showFleetModal: false,
      items: [],
      files: [],
      fields: [
        "id",
        "route_number",
        "status",
        "Orders",
        "operation",
        "assign_to_driver",
        "delete",
      ],

      patch_status:'',
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
      routeNumberId: null,
      branchId: null,
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
    deleteBatch(id) {
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
              "/api/remove-batch/" +
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
    assignOrder(id,branch_id) {

      this.showFleetModal = true;
      this.routeNumberId = id;
      this.branchId = branch_id;
    },
    closeModal() {
      this.showFleetModal = false;
    },
    orderLink(id) {
      return `route-numbers/${id.toString()}/orders`;
    },
    orders(id) {
      const orderLink = this.orderLink(id);
      this.$router.push({ path: orderLink });
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
          "/api/route-numbers?page=" +
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
          self.items = self.items.concat(response.data.orders.data);
          self.maxPages = response.data.orders.last_page;

          self.loading = false;
        })
        .catch(function(error) {
          console.log(error);
          self.loading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in getting data.";
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
    downloadFile(id) {
      axios.get('/api/zip-batch/'+id+"?&token=" +
      localStorage.getItem("api_token")).then(res => {
        this.files = res.data.pdf
        console.log(this.files)
        this.download()
      })
    },
    download(){
      let urls =this.files;
      let zip = new JSZip();
      let count = 0;
      let count2 = 0;
      let zipFilename = "ShipmentLabels.zip";
      let nameFromURL = [];

      let the_arr = "";
      for (let i = 0; i < urls.length; i++) {
        the_arr = urls[i]['pdf_url'].split('/');
        nameFromURL[i] = the_arr.pop();
      }

      urls.forEach(function (url) {
        let filename = nameFromURL[count2];
        count2++;

        JSZipUtils.getBinaryContent(url['pdf_url'],function (err, data) {
          console.log(url['pdf_url'])
          if (err) {
            throw err;
          }
          zip.file(filename, data, {binary: true});
          count++;
          if (count === urls.length) {
            zip.generateAsync({type: 'blob'}).then(function (content) {
              FileSaver.saveAs(content, zipFilename);
            });
          }
        });
      });
    },

  },
  mounted: function() {
    this.getLocale();
    this.getFleets();

  }

};
</script>
