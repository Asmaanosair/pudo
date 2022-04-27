<template>
  <div class="messages">
    <div class="messages__left"></div>

    <div
      class="messages__right"
      style="padding: 20px 0 ;border: 1px solid #e2e2e2"
    >
      <div class="panel-block">
        <div class="chat" v-if="chats.length != 0">
          <div
            v-for="(chat, index) in chats"
            style="overflow:auto"
            :key="index"
          >
            <p class="message-rect-sender" v-if="chat.user_id == userid">
              {{ chat.chat }}
              <span class="time">{{
                chat.created_at == null
                  ? chat.curr
                  : new Date(chat.created_at).toLocaleString(myLang)
              }}</span>
            </p>
            <p class="message-rect-reciever" v-else>
              {{ chat.chat }}
              <span class="time">{{
                chat.created_at == null
                  ? chat.curr
                  : new Date(chat.created_at).toLocaleString(myLang)
              }}</span>
            </p>
          </div>
        </div>

        <div v-else class="no-message">
          {{
            myLang == "ar"
              ? "لا يوجد رسائل بينكم حتى الان"
              : "There are no messages untill now"
          }}
        </div>

        <chat-composer
          :userid="userid"
          :friendid="friendid"
          :chats="chats"
        ></chat-composer>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      chats: [],
      userid: "",
      friendid: "",
      myLang: "ar"
    };
  },
  mounted() {
    this.getLocale()
    this.getChat();
  },
  methods: {
    getLocale() {
      let locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
    },
    getChat() {
      let self = this;

      axios
        .post(
          "/api/chat/get_chat/" +
            self.$route.params.id +
            "?token=" +
            localStorage.getItem("api_token")
        )
        .then(function(response) {
          console.log(response.data);
          self.chats = response.data.data.chats;
          self.friendid = self.$route.params.id;
          self.userid = response.data.data.user.uuid;
        })
        .catch(function(error) {
          console.log(error);
          self.alertColor = "danger";
          self.message = "unexpected error occurred in loading the fleet info.";
          self.showAlert();
        });
    }
  }
};
</script>

<style scoped>
.container-fluid{
  padding: 0 !important;
}
</style>
