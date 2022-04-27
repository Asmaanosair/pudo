<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header class="p-4">
        <h2 class="text-center">
          {{ $t("download_example") }}
        </h2>
         <div class="my-notes">
           <h2>Notes</h2>
            <p>Payment Method Should be numbers 1 or 2</p>
            <ul>
              <li>
                1=> for COD
              </li>
              <ul>
                Payment Type Should be numbers 1 or 2 or 3
                <li>  1 => Pay Cash</li>
                <li>   2 => Pay By Driver Wallet</li>
                <li>  3 => Not Paying</li>
              </ul>
              <li>
                2=> for Prepaid
              </li>
              <ul>
                Payment Type Should be numbers 3 or 4
                <li>  3 => Not Paying</li>
                <li>   4 =>  Paying on picked up</li>

              </ul>
            </ul>


          </div>


        <a v-if='role=="client"' :href="file2" download="" class="text-center">
          <img
            class="excel-img"
            src="https://www.freeiconspng.com/thumbs/xls-icon/excel-icon-15.png"
            alt=""
          />
        </a>
        <a v-else-if='role=="client-branch"' :href="file3" download="" class="text-center">
          <img
            class="excel-img"
            src="https://www.freeiconspng.com/thumbs/xls-icon/excel-icon-15.png"
            alt=""
          />
        </a>
        <a v-else :href="file" download="" class="text-center">
          <img
            class="excel-img"
            src="https://www.freeiconspng.com/thumbs/xls-icon/excel-icon-15.png"
            alt=""
          />
        </a>


        <CCardBody class="text-center">
          <form
            action="/api/import-excel"
            method="post"
            enctype="multipart/form-data"
          >
            <input type="hidden" name="token" :value="apiToken" />
            <input required type="file" name="file" />
            <input
              type="submit"
              class="btn btn-success"
              :value="$t('upload')"
            />

          </form>
          <CButton class="mb-3" color="primary" @click="goBack">{{
              $t("back")
            }}</CButton>
        </CCardBody>

      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import { asset } from "@codinglabs/laravel-asset";
import axios from "axios";
export default {
  name: "Creat",
  data: () => {
    return {
      apiToken: "",
      imageIndex: null,
      showMessage: false,
      number_of_products: 0,
      message: "",
      alertColor: "",
      dismissSecs: 7,
      role: "",
      dismissCountDown: 0,
      showDismissibleAlert: false,
      file: asset("/upload/pudoOrder.xlsx"),
      file2: asset("/upload/pudoOrderClient.xlsx"),
      file3: asset("/upload/pudoOrderManager.xlsx"),
    };
  },
  methods: {

    goBack() {
      this.$router.go(-1);
      this.$router.replace({ path: "/driver-applications" });
    },

    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    getToken() {
      this.apiToken = localStorage.getItem("api_token");
    },
    me() {
      let self = this;
      axios
        .post("/api/me?token=" + localStorage.getItem("api_token"))
        .then(function (response) {
          self.role = response.data.user.menuroles;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },

  created: function () {},

  mounted: function () {
    this.getToken();
    this.me();
  },
};
</script>
