<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header class="p-4">
        <h2 class="text-center">
          {{ $t("download_example") }}
          <div class="my-notes">
            <p>notes</p>
            <ul>
              <li>
                mobile should be unique
              </li>
              <li>
                identity should be unique
              </li>
              <li>
                identity should not be less than 10 numbers and greater than 15
              </li>
            </ul>
          </div>
        </h2>

             <a
          v-if="role == 'user,admin'"
          :href="file"
          download=""
          class="text-center"
        >
          <img
            class="excel-img"
            src="https://www.freeiconspng.com/thumbs/xls-icon/excel-icon-15.png"
            alt=""
          />
        </a>

        <a v-else :href="fileSupplier" download="" class="text-center">
          <img
            class="excel-img"
            src="https://www.freeiconspng.com/thumbs/xls-icon/excel-icon-15.png"
            alt=""
          />
        </a>





        <CCardBody class="text-center">
          <form
            action="/api/bulk-driver"
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
          <CButton class="mt-4" color="primary" @click="goBack">{{
              $t("back")
            }}</CButton>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from "axios";
import {asset} from "@codinglabs/laravel-asset";
export default {
  name: "Creat",
  data: () => {
    return {
      file:asset('/upload/Bulk_driver.xlsx'),
      fileSupplier:asset('/upload/Bulk_driver_supplier.xlsx'),
      apiToken: "",
      imageIndex: null,
      showMessage: false,
      number_of_products: 0,
      message: "",
      alertColor: "",
      role:"",
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    };
  },
  methods: {
    goBack() {
      this.$router.go(-1);
      this.$router.replace({ path: "/driver-applications" });
    },

    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
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

  created: function() {},

  mounted: function() {
    this.me();
    this.getToken();
  }
};
</script>
