<template>
  <CRow>
    <CCol
      col="12"
      lg="6"
      :style="[
        myLang == 'ar' ? { direction: 'rtl', 'text-align': 'right' } : ''
      ]"
    >
      <CCard no-header>
        <CCardBody v-if="changePasswordShow == true">
          <h1 class="text-center">{{ $t("presonal_information") }}</h1>
          <template slot="header"> </template>
          <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
            ({{ dismissCountDown }}) {{ message }}
          </CAlert>
            <p>{{ $t("Name") }}</p>
          <CInput
            type="text"
            :placeholder="$t('name') + '...'"
            v-model="name"
          ></CInput>

          <p v-if="menuRoles == 'client'  ">{{ $t("company_name") }}</p>
          <CInput
            v-if="menuRoles == 'client'  "
            type="text"
            :placeholder="$t('company_name') + '...'"
            v-model="company_name"
          ></CInput>

          <p>{{ $t("mobile") }}</p>
          <CInput
            type="text"
            :placeholder="$t('company_mobile') + '...'"
            v-model="phone"
          ></CInput>

          <p>{{ $t("email") }}</p>
          <CInput
            type="text"
            :placeholder="$t('email') + '...'"
            v-model="email"
          ></CInput>
          <div v-if="menuRoles == 'client'  ">
            <p>{{ $t("Api Id") }}</p>

            <CInput
              type="text"
              :placeholder="$t('Api Id') + '...'"
              v-model="apiKey"
              readonly
            ></CInput>
          </div>
          <div v-if="menuRoles == 'client'  ">
            <p>{{ $t("Api Key") }}</p>

            <CInput
              type="text"
              :placeholder="$t('Api Key') + '...'"
              v-model="authKey"
              readonly
            ></CInput>
          </div>
          <div v-if="menuRoles == 'client'  ">
            <p>End Point</p>

            <CInput
              type="text"
              :placeholder="'EndPoint'+ '...'"
              v-model="endpoint"

            ></CInput>
          </div>

<!--          <div v-if="menuRoles == 'user,admin'" role="group" class="form-group">-->
<!--            <p>delivery fees</p>-->
<!--            <select-->
<!--              type="text"-->
<!--              v-model.trim="commission"-->
<!--              :class="{-->
<!--                'form-control': true-->
<!--              }"-->
<!--            >-->
<!--              <option-->
<!--                v-for="(commission, index) in allCommissions"-->
<!--                :value="commission.id"-->
<!--                :key="index"-->
<!--                :selected="commission == commission.id"-->
<!--              >-->
<!--                {{ commission.name }}-->
<!--              </option>-->
<!--            </select>-->
<!--          </div>-->
<!--          <div v-if="menuRoles == 'user,admin'" role="group" class="form-group">-->
<!--            <p>Commission</p>-->
<!--            <select-->
<!--              type="text"-->
<!--              v-model.trim="realCommission"-->
<!--              :class="{-->
<!--                'form-control': true-->
<!--              }"-->
<!--            >-->
<!--              <option-->
<!--                v-for="(realCommission, index) in allRealCommissions"-->
<!--                :value="realCommission.id"-->
<!--                :key="index"-->
<!--                :selected="realCommission == realCommission.id"-->
<!--              >-->
<!--                {{ realCommission.name }}-->
<!--              </option>-->
<!--            </select>-->
<!--          </div>-->


          <button
            v-if="menuRoles == 'client'  "
            class="btn btn-primary btn-sm"
            @click="generateApiKey()"
          >
            Update ApiId
          </button>
          <button
            v-if="menuRoles == 'client'  "
            class="btn btn-default btn-sm"
            @click="generateAuthKey()"
          >
            Update ApiKey
          </button>
          <button
            v-if="menuRoles == 'client'  "
            class="btn btn-warning btn-sm"
            @click="storeEndpoint(user_id)"
          >
           Update End Point
          </button>

          <CButton color="success" @click="store()" class="btn-sm">{{ $t("save") }}</CButton>

          <CButton color="info" class="btn-sm" @click="changePassword()">{{
            $t("change_password")
          }}</CButton>
          <CButton  color="warning" class="btn-sm" @click="goBack">{{
              $t("back")
            }}</CButton>
        </CCardBody>


        <CCardBody v-else>
          <h1 class="text-center">{{ $t("change_password") }}</h1>
          <template slot="header"> </template>
          <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
            ({{ dismissCountDown }}) {{ message }}
          </CAlert>
          <p>{{ $t("old_password") }}</p>
          <CInput
            type="text"
            :placeholder="$t('old_password') + '...'"
            v-model="oldPassword"
          ></CInput>

          <p>{{ $t("new_password") }}</p>
          <CInput
            type="text"
            :placeholder="$t('new_password') + '...'"
            v-model="newPassword"
          ></CInput>

          <CButton color="success" @click="storePassword()">{{
            $t("save")
          }}</CButton>

          <CButton color="info" @click="back()">{{ $t("back") }}</CButton>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from "axios";
export default {
  name: "Creat",
  data: () => {
    return {
      myLang: "",
      company_name: "",
      email: "",
      apiKey: "",
      endpoint: "",
      phone: "",
      name:"",
      user_id:"",
      newPassword: "",
      oldPassword: "",
      menuRoles: "",
      allCommissions: [],
      allRealCommissions: [],
      commission: 0,
      realCommission: 0,
      changePasswordShow: true,
      password: "",
      authKey: "",
      imageIndex: null,
      showMessage: false,
      number_of_products: 0,
      message: "",
      alertColor: "",
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    };
  },
  methods: {
    generateApiKey() {
      let serialList =
        "123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
      let serialLength = 64;
      let randomSerial = "";

      for (let x = 0; x < serialLength; x++) {
        let randomNum = Math.floor(Math.random() * serialList.length);

        randomSerial += serialList.substring(randomNum, randomNum + 1);
      }
      this.apiKey = randomSerial;
    },
    generateAuthKey() {
      let serialList =
        "123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
      let serialLength = 64;
      let randomSerial = "";

      for (let x = 0; x < serialLength; x++) {
        let randomNum = Math.floor(Math.random() * serialList.length);

        randomSerial += serialList.substring(randomNum, randomNum + 1);
      }
      this.authKey = randomSerial;
    },
    changePassword() {
      this.changePasswordShow = false;
    },
    getProfile() {
      this.loading = true;
      let self = this;
      axios
        .post("/api/profile" + "?token=" + localStorage.getItem("api_token"))
        .then(function(response) {

          self.company_name = response.data.user.company_name;
          self.user_id = response.data.user.id;
          self.menuRoles = response.data.user.menuroles;
          self.allCommissions = response.data.commissions;
          self.allRealCommissions = response.data.realCommissions;
          self.phone = response.data.user.phone;
          self.name = response.data.user.name;
          self.email = response.data.user.email;
          self.commission = response.data.user.commission_id;
          self.realCommission = response.data.user.real_commission_id;
          self.apiKey = response.data.user.api_id;
          self.authKey = response.data.user.authKey.key;
          self.endpoint = response.data.endpoint[0].endpoint;
          console.log( self.endpoint);
        })
        .catch(function(error) {
          // console.log(error);
          // self.loading = false;
          // self.alertColor = "danger";
          // self.message = "unexpected error occurred in getting .";
          // self.showAlert();
        });
    },

    back() {
      this.changePasswordShow = true;
    },

    goBack() {
      this.$router.go(-1);
      this.$router.replace({ path: "/driver-applications" });
    },
    storePassword() {
      let self = this;
      let formData = new FormData();
      formData.append("old_password", self.oldPassword);
      formData.append("new_password", self.newPassword);

      axios
        .post(
          "/api/reset-password" + "?token=" + localStorage.getItem("api_token"),
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        )
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully Uptaded Password.";
          self.showAlert();
        })
        .catch(function(error) {
          console.log(error);
          self.alertColor = "danger";
          self.message = "your old Password is wrong.";
          self.showAlert();
        });
    },
    storeEndpoint($id) {
      let self = this;
      let formData = new FormData();
      formData.append("endpoint", self.endpoint);

      axios
        .post(
          "/api/endpoint/edit/" +
          $id +
          "?token=" +
          localStorage.getItem("api_token"),
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        )
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully updated .";
          self.showAlert();
        })
        .catch(function(error) {
          console.log(error);
          self.alertColor = "danger";
          self.message = "unexpected error occurred in Editing .";
          self.showAlert();
        });
    },
    store() {
      let self = this;
      let formData = new FormData();
      formData.append("company_name", self.company_name);
      formData.append("phone", self.phone);
      formData.append("email", self.email);
      formData.append("name", self.name);
      formData.append("commission", self.commission);
      formData.append("api_id", self.apiKey);
      formData.append("authKey", self.authKey);
      axios
        .post(
          "/api/edit-profile" + "?token=" + localStorage.getItem("api_token"),
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        )
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully Uptaded Company.";
          self.showAlert();
        })
        .catch(function(error) {
          console.log(error);
          self.alertColor = "danger";
          self.message = "unexpected error occurred in creating new fleet.";
          self.showAlert();
        });
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    getLocale() {
      let locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
    }
  },

  mounted: function() {
    this.getProfile();
    this.getLocale();
  }
};
</script>
