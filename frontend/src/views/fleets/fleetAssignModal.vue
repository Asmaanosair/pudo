<template>
  <div class="wrapper">
    <!-- Modal Component -->
    <CModal
      title="Modal title"
      size="lg"
      :show.sync="showModal"
      fade
      :closeOnBackdrop="false"
    >
      <template slot="header">
        <h5 class="modal-title"> Give the order to a driver </h5>

        <CButton  class="close"  @click="closeModal">
          ×
        </CButton>
      </template>

      <div slot="footer">
        <CButton class="float-right" color="danger" @click="closeModal">
          Close
        </CButton>
      </div>

      <CCol>
      <CAlert
        :show.sync="dismissCountDown"
        :color="alertColor"
        fade
      >
        ({{dismissCountDown}}) {{ message }}
      </CAlert>

      <CDataTable
        :items="items"
        :fields="fields"
        index-column
        hover
        table-column
        :sorter="{ external: true, resetable: true }"
        :columnFilter="{ external: true, lazy: true }"
        :sorter-value.sync="sorter"
        :column-filter-value.sync="columnFilter"
        :loading="loading"
      >
        <template #has_orders="{item}">
          <td>
            <CBadge color="info">{{item.orders_count}}</CBadge>
          </td>
        </template>
        <template #assign="{item}">
          <td>
            <CButton color="primary" @click="giveOrder(item.id)">give</CButton>
          </td>
        </template>
      </CDataTable>

      <CPagination
        :pages="maxPages"
        :active-page.sync="activePage"
      />
      </CCol>
    </CModal>
  </div>

</template>

<script>

  import axios from "axios";

  export default {
    name: 'FleetsModal',
    props: {
      showModal: {
        type: Boolean,
        default: false
      },
      closeModal:{
        type: Function,
      },
      orderId: null,
      branchId: null,
    },
    data () {
      return {
        items: [],
        fields: ['id', 'name','has_orders','assign'],
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
      }
    },
    methods:{
      getFleets(){
        this.loading = true;
        let self= this;
        this.items = [];

        axios.get('/api/fleetsInDuty/'+self.branchId+'?page=' + self.activePage + '&token='+localStorage.getItem("api_token"),{
          params: {
            sorter: self.sorter,
            columnFilter: self.columnFilter,
            itemsLimit: self.itemsLimit
          }
        })
          .then(function (response) {
            console.log(response.data)
            self.items = self.items.concat(response.data.fleets.data);
            self.maxPages = response.data.fleets.last_page;
            self.loading = false
          }).catch(function (error) {
          console.log(error)
          self.loading = false
          self.alertColor = 'danger';
          self.message = 'unexpected error occurred in gettin fleets.';
          self.showAlert();
        });

      },

      showAlert () {
        this.dismissCountDown = this.dismissSecs
      },

      giveOrder (id) {
        this.loading = true;
        let self= this;
        this.items = [];
        axios.post(  '/api/assignToDriver?token='+localStorage.getItem("api_token"),{

          order_id: self.orderId,
          fleet_id: id,

        })
          .then(function (response) {
            self.loading = false;
            self.closeModal();
            console.log(response.data)
          }).catch(function (error) {
          self.loading = false;
          console.log(error);
          self.alertColor = 'danger';
          self.message = 'unexpected error occurred in gettin fleets.';
          self.showAlert();
        });
      },
    },
    watch: {
      showModal:function(val) {
        if (val)
        this.getFleets();
      },
      activePage(){
        this.getFleets();
      },
      sorter: {
        handler(){
          this.getFleets();
        },
        deep: true
      },

      columnFilter(){
        this.getFleets();
      }

    }
  }
</script>
