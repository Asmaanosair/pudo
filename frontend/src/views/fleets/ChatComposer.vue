<template>
  <div class="pannel-block field d-flex">
    <input
      class="message-input"
      type="text"
      v-on:keyup.enter="sendChat"
      v-model="chat"
      :placeholder="myLang=='ar' ?'أكتب رسالة هنا ...' : 'Write Messages Here...'"
    />

    <button id="send" v-on:click="sendChat" class="message-sbt send-message">
      {{ myLang == "ar" ? " ارسال" : "Send" }}
    </button>
  </div>
</template>

<script>
import axios from "axios";
export default {
  props: ["chats", "userid", "friendid"],
  data() {
    return {
      chat: "",
      myLang: ""
    };
  },
  methods: {
    x: function() {
      alert("hi");
    },
    sendChat: function(e) {
      if (this.chat != "") {
        var data = {
          chat: this.chat,
          friend_id: this.friendid,
          user_id: this.userid,
          curr: new Date().toLocaleString(this.myLang)
        };

        this.chat = "";
        this.chats.push(data);

        let mySound = document.getElementById("chat-sound");
        mySound.play();
        mySound.currentTime = 0;

        axios
          .post(
            "/api/chat/send_chat" +
              "?token=" +
              localStorage.getItem("api_token"),
            data
          )
          .then(response => {});
      }
    },
    getLocale() {
      let locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
    }
  },

  mounted() {
    this.getLocale();
  }
};
</script>

<style></style>
