<template>
  <CRow class="justify-content-center">
    <CCol col="12" xl="8">
      <CCol col="3">

        <CButton class="m-3 m-btn" color="primary" @click="create()">{{$t('create_member')}}</CButton>



      </CCol>
      <transition name="slide">
        <CCard v-if="myLang=='en'">
          <CCardHeader> {{ $t("users") }} </CCardHeader>
          <CCardBody>
            <CAlert :show.sync="dismissCountDown" color="primary" fade>
              ({{ dismissCountDown }}) {{ message }}
            </CAlert>
            <CDataTable
              :items="items"
              :fields="fields"
              :items-per-page="10"
              pagination
            >
              <template #id="{item}">
                <td>
                  {{ item.id }}
                </td>
              </template>
              <template #name="{item}">
                <td>
                  {{ item.name }}
                </td>
              </template>

              <template #registered="{item}">
                <td>
                  {{ item.registered }}
                </td>
              </template>

              <template #roles="{item}">
                <td>
                  {{ item.roles }}
                </td>
              </template>

              <template #status="{item}">
                <td>
                  <CBadge :color="getBadge(item.status)">{{
                    item.status
                  }}</CBadge>
                </td>
              </template>

              <template #show="{item}">
                <td>
                  <CButton class="my-btn" @click="showUser(item.id)">
                    <img
                      class="control-img"
                      src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKcHbnEx0bIoJmfthMQ2Jnc97Uz-qjLGOjSg&usqp=CAU"
                      alt=""
                    />
                  </CButton>
                </td>
              </template>

              <template #edit="{item}">
                <td>
                  <CButton class="my-btn" @click="editUser(item.id)">
                    <img
                      class="control-img"
                      src="https://www.pinclipart.com/picdir/big/164-1646319_ewsully-com-img-activities-icons-edit-icon-png.png"
                      alt=""
                    />
                  </CButton>
                </td>
              </template>

              <template #delete="{item}">
                <td>
                  <CButton
                    class="my-btn"
                    v-if="you != item.id"
                    @click="deleteUser(item.id)"
                  >
                    <img
                      class="control-img"
                      src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGp9jrAF7I5Wc0eAcIu6BS8_620EiL9Dd8Xg&usqp=CAU"
                      alt=""
                    />
                  </CButton>
                </td>
              </template>
            </CDataTable>
          </CCardBody>
        </CCard>

        <!--=================================== Start Translations Arabic ===================================-->
        <CCard v-else >
          <CCardHeader> {{ $t("users") }} </CCardHeader>
          <CCardBody>
            <CAlert :show.sync="dismissCountDown" color="primary" fade>
              ({{ dismissCountDown }}) {{ message }}
            </CAlert>
            <CDataTable
              :items="items"
              :fields="fieldsAr"
              :items-per-page="10"
              pagination
            >
              <template #رقم_التسلسل="{item}">
                <td>
                  {{ item.id }}
                </td>
              </template>
              <template #الأسم="{item}">
                <td>
                  {{ item.name }}
                </td>
              </template>

              <template #تاريخ_التسجيل="{item}">
                <td>
                  {{ item.registered }}
                </td>
              </template>

              <template #الصلاحيات="{item}">
                <td>
                  {{ item.roles }}
                </td>
              </template>

              <template #الحالة="{item}">
                <td>
                  <CBadge :color="getBadge(item.status)">{{
                    item.status
                  }}</CBadge>
                </td>
              </template>

              <template #عرض="{item}">
                <td>
                  <CButton class="my-btn" @click="showUser(item.id)">
                    <img
                      class="control-img"
                      src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKcHbnEx0bIoJmfthMQ2Jnc97Uz-qjLGOjSg&usqp=CAU"
                      alt=""
                    />
                  </CButton>
                </td>
              </template>

              <template #تعديل="{item}">
                <td>
                  <CButton class="my-btn" @click="editUser(item.id)">
                    <img
                      class="control-img"
                      src="https://www.pinclipart.com/picdir/big/164-1646319_ewsully-com-img-activities-icons-edit-icon-png.png"
                      alt=""
                    />
                  </CButton>
                </td>
              </template>

              <template #حذف="{item}">
                <td>
                  <CButton
                    class="my-btn"
                    v-if="you != item.id"
                    @click="deleteUser(item.id)"
                  >
                    <img
                      class="control-img"
                      src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGp9jrAF7I5Wc0eAcIu6BS8_620EiL9Dd8Xg&usqp=CAU"
                      alt=""
                    />
                  </CButton>
                </td>
              </template>
            </CDataTable>
          </CCardBody>
        </CCard>
      </transition>
    </CCol>
  </CRow>
</template>

<script>
import axios from "axios";

export default {
  name: "Users",
  data: () => {
    return {
      items: [],
      fields: [
        "id",
        "name",
        "registered",
        "roles",
        "status",
        "show",
        "edit",
        "delete"
      ],
      fieldsAr: [
        "رقم_التسلسل",
        "الأسم",
        "تاريخ_التسجيل",
        "الصلاحيات",
        "الحالة",
        "عرض",
        "تعديل",
        "حذف"
      ],
      myLang: "",
      currentPage: 1,
      perPage: 5,
      totalRows: 0,
      you: null,
      message: "",
      showMessage: false,
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    };
  },
  paginationProps: {
    align: "center",
    doubleArrows: false,
    previousButtonHtml: "prev",
    nextButtonHtml: "next"
  },
  methods: {
    create() {
      this.$router.push({path: 'users/create'});
    },
    getArray() {
      let locale;
      locale = localStorage.getItem("locale") || "en";
    },

    getBadge(status) {
      return status === "Active"
        ? "success"
        : status === "Inactive"
        ? "secondary"
        : status === "Pending"
        ? "warning"
        : status === "Banned"
        ? "danger"
        : "primary";
    },
    userLink(id) {
      return `users/${id.toString()}/show`;
    },
    editLink(id) {
      return `users/${id.toString()}/edit`;
    },
    showUser(id) {
      const userLink = this.userLink(id);
      this.$router.push({ path: userLink });
    },
    editUser(id) {
      const editLink = this.editLink(id);
      this.$router.push({ path: editLink });
    },
    deleteUser(id) {

      let userId = id;
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
          "/api/users/" + id + "?token=" + localStorage.getItem("api_token"),
          {
            _method: "DELETE"
          }
        )
        .then(function(response) {
          self.message = "Successfully deleted user.";
          self.showAlert();
          self.getUsers();
        })
        .catch(function(error) {
          console.log(error);
          self.$router.push({ path: "/login" });
        });
          }
      });
    },

    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    getUsers() {
      let self = this;
      axios
        .get("/api/users?token=" + localStorage.getItem("api_token"))
        .then(function(response) {
          self.items = response.data.users;
          console.log(response.data.users)
          self.you = response.data.you;
        })
        .catch(function(error) {
          console.log(error);
          self.$router.push({ path: "/login" });
        });
    },
    getLocale() {
      let locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
    }
  },

  mounted: function() {

    this.getUsers();
    this.getLocale();

  }
};
</script>
