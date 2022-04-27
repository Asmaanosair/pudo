<template>
  <CRow>
    <CCol col="12" xl="12">

      <CRow>
    <CCol col="3">
      <CButton class="m-3" color="primary" @click="createOrder()">Create Order</CButton>
    </CCol>

        <CCol  col="3">
          <CCallout color="info">
            <small class="text-muted">total</small><br>
            <strong class="h4">{{ totalCount }}</strong>
          </CCallout>
        </CCol>
      </CRow>
    </CCol>
    <CCol col="12" xl="12">
      <transition name="slide">
      <CCard>
        <CCardHeader>
          <span :style="color='red'">Orders</span>
        </CCardHeader>
        <CCardBody>

          <CAlert
            :show.sync="dismissCountDown"
            :color="alertColor"
            fade
          >
            ({{dismissCountDown}}) {{ message }}
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

          <template #name="{item}">

            <td style="width: 270px;">
              <a href="#" @click="showFleet( item.id )">

                {{ item.name }}

                </a>
            </td>
          </template>



          <template #status="{item}">
            <td>
              <CDropdown
                size="sm"
                :color="item.application_status.class"
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

          <template #operation="{item}">
            <td>
              <CButtonGroup>


                <CButton size="sm" color="info" @click="showFleet( item.id )"><CIcon name="cil-list"></CIcon></CButton>
                <CButton size="sm" color="warning" @click="editFleet( item.id )"><CIcon name="cil-pencil"></CIcon></CButton>
                <CButton size="sm" color="danger" @click="deleteFleet( item.id )"><CIcon name="cil-trash"></CIcon></CButton>
              </CButtonGroup>
            </td>
          </template>

        </CDataTable>

          <CPagination
            :pages="maxPages"
            :active-page.sync="activePage"
          />





      </CCol>
        </CCardBody>
      </CCard>
      </transition>
    </CCol>

  </CRow>

</template>


<style>
  .d-inline{
    font-size: 10px;
  }
  td{
    font-size: 12px;
  }
</style>

<script>
import axios from 'axios'

export default {
  name: 'MyOrders',
  data: () => {
    return {
      items: [],
      fields: ['id','code', 'name','mobile','identity','status', 'operation'],
      sorter: {column: '', asc: false},
      activePage: 1,
      maxPages: 1,
      message: '',
      alertColor:'',
      showMessage: false,
      dismissSecs: 3,
      dismissCountDown: 0,
      showDismissibleAlert: false,
      columnFilter: {},
      pageOfItems: [],
      loading: false,
      totalCount:0,
      statuses: [],
      allStatus: [],
    }
  },
  watch: {
    activePage(){
      this.getOrders();
    },
    sorter: {
      handler(){
        this.getOrders();
      },
      deep: true
    },

    columnFilter(){
      this.getOrders();
    }
  },
  methods: {

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
          self.alertColor = 'success';
          self.message = 'Successfully updated ';
          self.showAlert();
          self.getFleets();
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    changeItemsLimit( val ){
      this.itemsLimit = val;
      this.getOrders();
    },
    editLink (id) {
      return `driver-applications/${id.toString()}/edit`
    },
    showLink (id) {
      return `driver-applications/${id.toString()}/show`
    },
      createOrder () {
      this.$router.push({path: 'new-orders/create'});
    },
    editFleet ( id ) {
      const editLink = this.editLink( id );
      this.$router.push({path: editLink});
    },
    showFleet ( id ) {
      const editLink = this.showLink( id );
      this.$router.push({path: editLink});
    },
    deleteFleet( id ) {
      let self = this;
      axios.post(  '/api/driver-applications/' + id + '?token=' + localStorage.getItem("api_token"), {
        _method: 'DELETE'
      })
      .then(function (response) {
         self.alertColor = 'success';
          self.message = 'Successfully deleted user.';
          self.showAlert();
          self.getFleets();
      }).catch(function (error) {
        console.log(error);
          self.alertColor = 'danger';
          self.message = 'unexpected error occurred in delete the fleet.';
           self.showAlert();
      });
    },
    countDownChanged (dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs
    },
    getOrders (){
      this.loading = true;
      let self= this;
      this.items = [];
      axios.get('/api/driver/new-orders?page=' + self.activePage + '&token='+localStorage.getItem("api_token"),{
        params: {
          sorter: self.sorter,
          columnFilter: self.columnFilter,
          itemsLimit: self.itemsLimit
        }
      })
        .then(function (response) {
          console.log(response)
          // self.items = self.items.concat(response.data.fleets.data);
          // self.maxPages = response.data.fleets.last_page;
          // self.onlineCount = response.data.onlineCount;
          // self.totalCount = response.data.fleets.total;
          // self.allStatus = response.data.statuses;
          self.loading = false
        }).catch(function (error) {
        console.log(error);
        self.loading = false
        self.alertColor = 'danger';
        self.message = 'unexpected error occurred in getting fleets.';
        self.showAlert();
      });

  },
    makeFilter(){
      this.getOrders();
    },
},
  mounted: function(){
    this.getOrders();

  },

}
</script>
