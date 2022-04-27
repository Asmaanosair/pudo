<template>
  <CRow>
 <ChartOrder ></ChartOrder>


    <div class="move-top">
      <CCol col="12" xl="12">
        <CRow>

          <CCol col="3">


             <br />


          </CCol>

        </CRow>
      </CCol>
      <CCol col="12" xl="12">
        <transition name="slide">
          <CCard>
            <CCardHeader> Financial Reports</CCardHeader>
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

                  <template #code="{item}">
                    <td >
                      {{ item.code }}
                    </td>
                  </template>

                  <template #name="{item}">
                    <td >
                      <a href="#" @click="showFleet(item.id)">{{
                          item.name
                        }}</a>
                    </td>
                  </template>

                  <template #mobile="{item}">
                    <td>
                      {{ item.mobile }}
                    </td>
                  </template>

                  <template #Orders="{item}">
                    <td >
                     Total Count : {{ item.totalCount }} <br>
                      Total Price : {{ item.totalPrice }}
                    </td>
                  </template>

                  <template #Canceled_Orders="{item}">
                    <td>
                      Canceled Count : {{ item.totalCanceledCount }} <br>
                      Canceled  Price : {{ item.totalCanceledPrice }}
                    </td>
                  </template>
                  <template #Damaged_Orders="{item}">
                    <td>
                      Damaged Count : {{ item.totalDamageCount }} <br>
                      Damaged   Price : {{ item.totalDamagePrice }}
                    </td>
                  </template>
                  <template #Returned_Orders="{item}">
                    <td>
                      Returned Count : {{ item.totalReturnedCount }} <br>
                      Returned   Price : {{ item.totalReturnedPrice }}
                    </td>
                  </template>
                  <template #Failed_Returned_Orders="{item}">
                    <td>
                     Failed Return Count : {{ item.totalFReturnedCount }} <br>
                      Failed Return  Price : {{ item.totalFReturnedPrice }}
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

                  <template #رقم_الكود="{item}">
                    <td >
                      {{ item.code }}
                    </td>
                  </template>

                  <template #الأسم="{item}">
                    <td >
                      <a href="#" @click="showFleet(item.id)">{{
                          item.name
                        }}</a>
                    </td>
                  </template>

                  <template #الموبايل="{item}">
                    <td >
                      {{ item.mobile }}
                    </td>
                  </template>


                  <template #الطلبات="{item}">
                    <td >
                      Total Count : {{ item.totalCount }} <br>
                      Total Price : {{ item.totalPrice }}
                    </td>
                  </template>

                  <template #الطلبات_الملغيه="{item}">
                    <td>
                      Canceled Count : {{ item.totalCanceledCount }} <br>
                      Canceled  Price : {{ item.totalCanceledPrice }}
                    </td>
                  </template>
                  <template #الطلبات_التالفه="{item}">
                    <td>
                      Damaged Count : {{ item.totalDamageCount }} <br>
                      Damaged   Price : {{ item.totalDamagePrice }}
                    </td>
                  </template>
                  <template #المرتجع="{item}">
                    <td>
                      Returned Count : {{ item.totalReturnedCount }} <br>
                      Returned   Price : {{ item.totalReturnedPrice }}
                    </td>
                  </template>
                  <template #فشل_الارتجاع="{item}">
                    <td>
                      Failed Return Count : {{ item.totalFReturnedCount }} <br>
                      Failed Return  Price : {{ item.totalFReturnedPrice }}
                    </td>
                  </template>
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
        "code",
        "name",
        "mobile",
        "Orders",
        "Canceled_Orders",
        "Damaged_Orders",
        "Returned_Orders",
        "Failed_Returned_Orders",

      ],
      fieldsAr: [

        "رقم_الكود",
        "الأسم",
        "الموبايل",
        "الطلبات",
        "الطلبات_الملغيه",
        "الطلبات_التالفه",
        "المرتجع",
        "فشل_الارتجاع",

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
    }
  },
  methods: {
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
          "/api/financial?page=" +
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
  created(){
    this.getFleets();
  },
  mounted: function() {

    this.getLocale();
  }
};
</script>
