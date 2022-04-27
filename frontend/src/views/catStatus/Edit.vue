<template>
  <CRow
    :style="[myLang == 'ar' ? { direction: 'rtl', 'text-align': 'right' } : '']"
  >
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <template>
            <h6>
              Create   status
            </h6>
          </template>
          <CAlert :show.sync="dismissCountDown"  fade>
            ({{ dismissCountDown }}) {{ message }}
          </CAlert>
          <CInput
            type="text"
            label="Name"
            placeholder="Name"
            v-model="name2"
          ></CInput>
          <label for="">Class </label>
          <select class="form-control" v-model="classn">
            <option value="success"> success </option>
            <option value="info "> info </option>
            <option value="primary">primary</option>
            <option value="warning "> warning </option>
            <option value="danger "> danger </option>
            <option value="secondary "> secondary </option>
          </select>
          <div role="group" class="form-group">
            <label class=""> Category  </label>
            <select
              type="text"
              v-model="catId"
              class="form-control"
            >
              <option
                v-for="(status, index) in allStatus"
                :value="status.id"
                :key="index"
              >
                {{ status.name }}
              </option>
            </select>
          </div>
          <CButton color="primary" @click="update()">Save</CButton>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from "axios";
export default {
  name: "EditCatStatus",
  props: {
    caption: {
      type: String,

    }
  },
  data: () => {
    return {
      name2: "",
      classn: "",
      catId: "",
      allStatus: {},
      phone: "",
      myLang: "",

      showMessage: false,
      message: "",
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    };
  },
  methods: {
    goBack() {
      this.$router.go(-1);
      // this.$router.replace({path: '/users'})
    },
    getFleets() {
      this.loading = true;
      let self = this;
      this.items = [];
      axios
        .get(
          "/api/cat" +
          "?token=" +
          localStorage.getItem("api_token")
        )
        .then(function(response) {
          console.log(response);
          self.allStatus = response.data.cat;
          console.log("res" + response);
        })
        .catch(function(error) {
          console.log(error);
          self.loading = false;

          self.message = "unexpected error occurred in getting .";
          self.showAlert();
        });
    },
    update() {
      let self = this;
      axios
        .post(
          "/api/cat/" +
            self.$route.params.id +
            "?token=" +
            localStorage.getItem("api_token"),
          {
            _method: "PUT",
            name2: self.name2,
            catId: self.catId,
            classn: self.classn,
          }
        )
        .then(function(response) {
          self.message = "Successfully updated user.";
          self.showAlert();
        })
        .catch(function(error) {
          console.log(error);
          self.$router.push({ path: "/login" });
        });
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },

  },
  mounted: function() {

    this.getFleets();
    let self = this;

    axios
      .get(
        "/api/cat/" +
          self.$route.params.id +
          "/edit?token=" +
          localStorage.getItem("api_token")
      )
      .then(function(response) {
        self.name2 = response.data.name;
        self.catId = response.data.category_id;
        self.classn = response.data.class;
        console.log(response.data.class)
      })
      .catch(function(error) {
        console.log(error);
        self.$router.push({ path: "/login" });
      });
  }
};
</script>
