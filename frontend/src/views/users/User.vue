<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard>
        <CCardHeader> User id: {{ $route.params.id }} </CCardHeader>
        <CCardBody>
          <CDataTable striped small fixed :items="items" :fields="fields">
            <template slot="value" slot-scope="data">
              <td>{{ data.item.value }}</td>
            </template>
          </CDataTable>

          <!--================== Start Translation Arabic ==================-->
<!--
            <CDataTable striped small fixed :items="items" :fields="fields">
            <template slot="value" slot-scope="data">
              <strong>{{ data.item.value }}</strong>
            </template>
          </CDataTable> -->

        </CCardBody>
        <CCardFooter>
          <CButton color="primary" @click="goBack">Back</CButton>
        </CCardFooter>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from "axios";
export default {
  name: "User",
  data: () => {
    return {
      items: [],
      fields: [{ key: "key" }, { key: "value" }],
      fieldsAr: [
        "رقم_التسلسل",
        "الأسم",
        "تاريخ_التسجيل",
        "الصلاحيات",
        "الحالة",
      ]
    };
  },
  methods: {
    getUserData(id) {
      const user = usersData.find((user, index) => index + 1 == id);
      const userDetails = user ? Object.entries(user) : [["id", "Not found"]];
      return userDetails.map(([key, value]) => {
        return { key, value };
      });
    },
    goBack() {
      this.$router.go(-1);
    }
  },
  mounted: function() {
    let self = this;
    axios
      .get(
        "/api/users/" +
          self.$route.params.id +
          "?token=" +
          localStorage.getItem("api_token")
      )
      .then(function(response) {
        //const items = response.data.users;
        const items = Object.entries(response.data);
        self.items = items.map(([key, value]) => {
          return { key: key, value: value };
        });
        console.log(self.items)
        console.log(self.fields)

        console.log(items[0][1])
      })
      .catch(function(error) {
        console.log(error);
        self.$router.push({ path: "/login" });
      });
  }
};
</script>
