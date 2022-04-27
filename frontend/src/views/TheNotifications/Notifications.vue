<template>
  <div class="my-dropdown">
    <a
      class="dropdown-toggle"
      data-toggle="dropdown"
      rple="button"
      aria-expanded="true"
      @click="showNotifyFun()"
    >
      <img
        class="notify-img"
        src="https://icons.iconarchive.com/icons/johanchalibert/mac-osx-yosemite/512/messages-icon.png"
        alt=""
      />
      {{ myLang == "ar" ? "الرسائل" : "Messages" }}
      <span class="badge badge-pill badge-info">
        {{ notifications.length }}
      </span>
      <span class="caret"></span>
    </a>
    <ul v-if="showNotify" class="notif-child" role="menu">
      <li
        class="notify-content"
        v-for="(notification, index) in notifications"
        :key="index"
      >
        <a @click="markAsRead(notification, index)">
          {{ JSON.parse(notification.data).fleet_name }}
          <span>
            {{
              myLang == "ar"
                ? JSON.parse(notification.data).description_ar
                : JSON.parse(notification.data).description_en
            }}
          </span>
        </a>
      </li>
      <li v-if="notifications.length == 0" class="notify-content">
        <a>
          {{ myLang == "ar" ? "لا توجد رسائل جديدة" : "no new messages" }}
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from "axios";
import Echo from 'laravel-echo';

window.Pusher = require("pusher-js");
export default {
  methods: {
    showNotifyFun: function() {
      this.showNotify = !this.showNotify;
    },
    getNotifications: function() {
      axios
        .post(
          "/api/notification/get" +
            "?token=" +
            localStorage.getItem("api_token")
        )
        .then(response => {
          this.notifications = response.data.data.notifications;
          this.userId = response.data.data.user.id;
        });
    },

    markAsRead: function(notification, index) {
      var data = {
        id: notification.id,
        created_at: notification.created_at
      };

      this.notifications.splice(index, 1);
      window.location = JSON.parse(notification.data).url;

      axios
        .post(
          "/api/notification/read" +
            "?token=" +
            localStorage.getItem("api_token"),
          data
        )
        .then(response => {});
    },
    getLocale() {
      let locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
    }
  },
  created() {
    this.getNotifications();
  },
  mounted() {
    this.getLocale();

    window.Echo = new Echo({
      authEndpoint : "/broadcasting/auth?token="+localStorage.getItem("api_token"),
      broadcaster: "pusher",
      key: process.env.MIX_PUSHER_APP_KEY,
      cluster: process.env.MIX_PUSHER_APP_CLUSTER,
      encrypted: true
    });

    window.Echo.private("user."+this.userId).notification(notification => {
      alert("connected")
      console.log("conected");
    });
  },
  data() {
    return {
      notifications: [],
      myLang: "",
      url: "",
      userId: "",
      showNotify: false
    };
  }
};
</script>

<style scoped></style>
