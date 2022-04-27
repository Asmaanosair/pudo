<template>
  <CRow>
    <div class="move-top">
    <CCol col="12" xl="12">

      <CRow>

    <CCol  col="3" >
      <CCallout color="success">
        <small class="text-muted">Online</small><br>
        <strong class="h4">{{ onlineCount }}</strong>
      </CCallout>
    </CCol>
    <CCol  col="3">
      <CCallout color="danger">
        <small class="text-muted">Offline</small><br>
        <strong class="h4">{{ totalCount - onlineCount }}</strong>
      </CCallout>
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
            Dr<span>ivers</span>
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
              <a href="#" @click="showFleet( item.id )">{{ item.name }}</a>
            </td>
          </template>

          <template #Wallet_balance="{item}">
            <td>
              <CBadge :color="getWalletBadge(item.fleet_balance)">{{ item.fleet_balance }}</CBadge>
            </td>
          </template>

          <template #status="{item}">
            <td>
              <CBadge :color="getBadge(item.status)">{{ item.status }}</CBadge>
            </td>
          </template>

          <template #operation="{item}">
            <td>
              <CButtonGroup>
                <CButton size="sm" color="primary" @click="goWallet( item.id )">wallet</CButton>

<!--                <CButton size="sm" color="default" @click="showFleet( item.id )">Show</CButton>-->
<!--                <CButton size="sm" color="warning" @click="editFleet( item.id )">Edit</CButton>-->
                <CButton size="sm" color="danger" @click="deleteFleet( item.id )">Delete</CButton>
              </CButtonGroup>
            </td>
          </template>
<!--          <template #delete="{item}">-->
<!--            <td>-->
<!--              <CButton  color="danger" @click="deleteFleet( item.id )">Delete</CButton>-->
<!--            </td>-->
<!--          </template>-->
        </CDataTable>

          <CPagination
            :pages="maxPages"
            :active-page.sync="activePage"
          />

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
  .d-inline{
    font-size: 10px;
  }
  td{
    font-size: 12px;
  }
</style>

<script>
import axios from 'axios'
// import TwistPagination from '../twistPagination/Paginate.vue'

export default {
  name: 'Fleets',
  data: () => {
    return {
      items: [],
      fields: ['id','code', 'name','mobile','identity','Wallet_balance', 'last_login','status', 'operation'],
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
      onlineCount:0,
      offlineCount:0,
      totalCount:0,
    }
  },
  watch: {
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
  },
  methods: {
    changeItemsLimit( val ){
      this.itemsLimit = val;
      this.getFleets();
    },
    getBadge (status) {
      return status === 'online' ? 'success'
            : status === 'offline' ? 'danger' : 'primary'
    },
    getWalletBadge(balance){
      return parseFloat(balance) <= 0 ? 'danger': 'success';
    },
    walletLink (id) {
      return `/fleets/${id.toString()}/wallet`
    },
    editLink (id) {
      return `/fleets/${id.toString()}/edit`
    },
    showLink (id) {
      return `/fleets/${id.toString()}/show`
    },
    goWallet ( id ) {
      const walletLink = this.walletLink( id );
      this.$router.push({path: walletLink});
    },
      createFleet () {
      this.$router.push({path: 'fleets/create'});
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
      axios.post(  '/api/fleets/' + id + '?token=' + localStorage.getItem("api_token"), {
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
    getFleets (){
      this.loading = true;
      let self= this;
      this.items = [];
      axios.get(  '/api/sup_fleets/'+self.$route.params.id +'/data?page=' + self.activePage + '&token='+localStorage.getItem("api_token"),{
        params: {
          sorter: self.sorter,
          columnFilter: self.columnFilter,
          itemsLimit: self.itemsLimit
        }
      })
        .then(function (response) {
          console.log(response)
          self.items = self.items.concat(response.data.fleets.data);
          self.maxPages = response.data.fleets.last_page;

          self.onlineCount = response.data.onlineCount;
          self.totalCount = response.data.fleets.total;
          self.loading = false
        }).catch(function (error) {
        console.log(error);
        self.loading = false
        self.alertColor = 'danger';
        self.message = 'unexpected error occurred in gettin fleets.';
        self.showAlert();
      });

  },
    makeFilter(){
      this.getFleets();
    },
},
  mounted: function(){
    this.getFleets();
  },

}
</script>
