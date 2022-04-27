<template>
  <CRow>
    <CCol col="12" xl="12">
      <CRow>
        <CCol col="3">
          <CButton class="m-3" color="primary" @click="createFleet()">
        create
          </CButton>

        </CCol>
      </CRow>
    </CCol>
    <CCol col="12" xl="12">
      <transition name="slide">
        <CCard>
          <CCardHeader>
            <span :style="(color = 'red')">Status Category</span>
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

              >
                <template #id="{item}">
                  <td>
                    <a href="#">{{ item.id }}</a>
                  </td>
                </template>

                <template #code="{item}">
                  <td>
                    <a href="#">{{ item.name }}</a>
                  </td>
                </template>

              </CDataTable>

            </CCol>
          </CCardBody>

          <!--=========================== Start Translations Arabic ============================-->

        </CCard>
      </transition>
    </CCol>
    <CCol col="12" xl="12">
      <transition name="slide">
        <CCard>
          <CCardHeader>
            <span :style="(color = 'red')">Status </span>
          </CCardHeader>
          <CCardBody >
            <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
              ({{ dismissCountDown }}) {{ message }}
            </CAlert>
            <CCol sm="12">
              <CDataTable
                :items="items2"
                :fields="fields2"
                index-column
                hover
                table-column
                items-per-page-select

              >
                <template #id="{item}">
                  <td>
                    <a href="#">{{ item.id }}</a>
                  </td>
                </template>

                <template #name="{item}">
                  <td>
                    <a href="#">{{ item.name }}</a>
                  </td>
                </template>
                <template #color="{item}">
                  <td>
                    <a href="#">{{ item.color }}</a>
                  </td>
                </template>
                <template #class="{item}">
                  <td>
                    <a href="#">{{ item.class }}</a>
                  </td>
                </template>
                <template #cat_id="{item}">
                  <td>
                    <a href="#">{{ item.category_id }}</a>
                  </td>
                </template>
                <template #status="{item}">
                  <td>
                    <CButton
                      size="sm"
                      color="warning"
                      @click="editFleet(item.id)"
                    >{{ $t("edit") }}</CButton
                    >
                  </td>
                </template>
              </CDataTable>

            </CCol>
          </CCardBody>

          <!--=========================== Start Translations Arabic ============================-->

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
  name: "CatStatus",
  data: () => {
    return {
      items: [],
      items2: [],
      fields: [
        "id",
        "name",

      ],
      fields2: [
        "id",
        "name",
        "color",
        "class",
        "cat_id",
        "status",
      ],
      sorter: { column: "", asc: false },
      activePage: 1,
      maxPages: 1,
      maxPages2: 1,
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
      statuses: [],
      myLang: "",
      allStatus: []
    };
  },
  watch: {

    sorter: {
      handler() {
        this.getFleets();
      },
      deep: true
    },


  },
  methods: {

    editLink(id) {
      return `cat/${id.toString()}/edit`;
    },
    showLink(id) {
      return `cat/${id.toString()}/show`;
    },

    createFleet() {
      this.$router.push({ path: "cat/create" });
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
      axios
        .post(
          "/api/cat/" +
          id +
          "?token=" +
          localStorage.getItem("api_token"),
          {
            _method: "DELETE"
          }
        )
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully deleted user.";
          self.showAlert();
          self.getFleets();
        })
        .catch(function(error) {
          console.log(error);
          self.alertColor = "danger";
          self.message = "unexpected error occurred in delete the fleet.";
          self.showAlert();
        });
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
          "/api/cat?page=" +
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
         // console.log(response.data.status);
          self.items = self.items.concat(response.data.cat);
          self.items2 = self.items2.concat(response.data.status);
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

    this.getFleets();
  }
};
</script>
