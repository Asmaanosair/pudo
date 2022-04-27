<template>
  <CHeader with-subheader>
    <CToggler in-header class="ml-3 d-lg-none" @click="handleSideBar()" />

    <CToggler
      in-header
      class="ml-3 d-md-down-none"
      @click="$store.commit('toggleSidebarDesktop')"
    />
    <CHeaderBrand class="mx-auto d-lg-none" to="/">
      <CIcon name="logo" height="48" alt="Logo" />
    </CHeaderBrand>

    <CHeaderNav>
      <select
        class="custom-select"
        v-model="locale"
        @change="handleChange($event)"
      >
        <option value="en">English</option>
        <option value="ar">عربى</option>
      </select>

      <!-- <CHeaderNavItem class="px-3">
        <v-offline
          online-class="online"
          offline-class="offline"
          @detected-condition="amIOnline"
        >
          <template v-slot:[onlineSlot] :slot-name="onlineSlot">
            {{ onlineText }}
          </template>
          <template v-slot:[offlineSlot] :slot-name="offlineSlot">
            {{ onlineText }}
          </template>
        </v-offline>
      </CHeaderNavItem> -->
    </CHeaderNav>




    <div class="mr-auto text-center my-desc d-flex justify-content-center">
      <img hidden class="mylogo-bar" :src="logoImg" />
    </div>

    <CHeaderNav>
      <!--      <CHeaderNavItem class="px-3">-->
      <!--        <CSelect-->
      <!--          class="mt-3"-->
      <!--          :options="langs"-->
      <!--          :value="locale"-->
      <!--          @update:value="selectLocale"-->
      <!--        />-->
      <!--      </CHeaderNavItem>-->
      <CHeaderNavItem class="px-3">
        <button
          @click="() => $store.commit('toggle', 'darkMode')"
          class="c-header-nav-btn"
        >
          <CIcon v-if="$store.state.darkMode" name="cil-sun" />
          <CIcon v-else name="cil-moon" />
        </button>
      </CHeaderNavItem>
      <!--      <TheHeaderDropdownNotif/>-->
      <!--      <TheHeaderDropdownTasks/>-->
      <!--      <TheHeaderDropdownMssgs/>-->
      <TheHeaderDropdownAccnt />
      <!--      <CHeaderNavItem class="px-3">-->
      <!--        <button-->
      <!--          in-header-->
      <!--          class="c-header-nav-btn"-->
      <!--          @click="$store.commit('toggle', 'asideShow')"-->
      <!--        >-->
      <!--          <CIcon size="lg" name="cil-applications-settings" class="mr-2"/>-->
      <!--        </button>-->
      <!--      </CHeaderNavItem>-->
    </CHeaderNav>

    <!--    <CSubheader class="px-3">-->
    <!--      <CBreadcrumbRouter class="border-0 mb-0"/>-->
    <!--    </CSubheader>-->
  </CHeader>
</template>

<style>
.offline {
  background-color: #fc9842;
  background-image: linear-gradient(315deg, #fc9842 0%, #fe5f75 74%);
}
.online {
  background-color: #00b712;
  background-image: linear-gradient(315deg, #00b712 0%, #5aff15 74%);
}

.offline,
.online {
  padding: 10px;
  border-radius: 20px;
  color: white;
}
</style>

<script>
import TheHeaderDropdownAccnt from "./TheHeaderDropdownAccnt";

// import TheHeaderDropdownNotif from './TheHeaderDropdownNotif'
// import TheHeaderDropdownTasks from './TheHeaderDropdownTasks'
// import TheHeaderDropdownMssgs from './TheHeaderDropdownMssgs'
import VOffline from "v-offline";

import CMenu from "./Menu";
import axios from "axios";
import { asset } from "@codinglabs/laravel-asset";
export default {
  name: "TheHeader",
  components: {
    TheHeaderDropdownAccnt,
    // TheHeaderDropdownNotif,
    // TheHeaderDropdownTasks,
    // TheHeaderDropdownMssgs,
    CMenu,
    VOffline
  },
  data: function() {
    const locale = localStorage.getItem("locale") || "en";
    return {
      langs: [],
      locale: locale,
      onLine: null,
      onlineText: "",
      onlineSlot: "online",
      offlineSlot: "offline",
      logoImg: asset("/img/logo.jpg")
    };
  },
  methods: {
    handleChange(event) {
      localStorage.setItem("locale", event.target.value);
      window.location.reload();
    },
    selectLocale: function(option) {
      localStorage.setItem("locale", option);
      this.$i18n.set(option);
      //location.reload()
      this.$emit("change-locale", option);
    },
    amIOnline(e) {
      this.onLine = e;
      if (e === true) {
        if (this.myLang == "en") {
          this.onlineText = "OnLine";
        } else {
          this.onlineText = "متصل";
        }
      } else {
        if (this.myLang == "en") {
          this.onlineText = "OffLine";
        } else {
          this.onlineText = "خامل";
        }
      }
    },
    handleSideBar() {
      let sideBar = document.getElementById("my-sidebar");
      sideBar.classList.toggle("c-sidebar-show");
    },
    getLocale() {
      let locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
    }
  },
  mounted() {
    let self = this;
    if (typeof localStorage.locale !== "undefined") {
      this.locale = localStorage.getItem("locale");
    }
    axios
      .get("/api/langlist?token=" + localStorage.getItem("api_token"))
      .then(function(response) {
        console.log(response.data);
        self.langs = [];
        for (let i = 0; i < response.data.length; i++) {
          self.langs.push({
            value: response.data[i].short_name,
            label: response.data[i].name
          });
        }
      })
      .catch(function(error) {
        console.log(error);
        self.$router.push({ path: "/login" });
      });

    this.getLocale();
  },
  created() {
    let self = this;
    this.$pusher.connection.bind("unavailable", function() {
      console.log(self.onLine);
      // if (self.onLine === true || self.onLine === null) {
      //   window.open("https://soc.twistfleet.com:6001", "_blank");
      //   location.reload();
      // }

      setInterval(function() {}, 500);
    });
  }
};
</script>
