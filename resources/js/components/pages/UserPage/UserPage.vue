<template>
  <div class="user-page-wrap">
    <div class="content-wrap">
      <div class="title-block">
        <!-- tabsの選択に合わせて表示切替 -->
        <p v-if="screen == 1" class="title">ユーザー情報</p>
        <p v-else-if="screen == 2" class="title">パスワード</p>
        <p v-else-if="screen == 3" class="title">支払い情報</p>
        <p v-else class="title">予約履歴</p>
      </div>
      <div class="main-block">
        <div class="tabs">
          <!-- 選択時にクラス追加 -->
          <p class="tab" :class="selected1" @click="changeScreen(1)">
            ユーザー情報
          </p>
          <p class="tab" :class="selected2" @click="changeScreen(2)">
            パスワード
          </p>
          <p class="tab" :class="selected3" @click="changeScreen(3)">
            支払い情報
          </p>
          <p class="tab" :class="selected4" @click="changeScreen(4)">
            予約履歴
          </p>
          <button class="button logout-button" @click="logout()">
            ログアウト
          </button>
        </div>
        <div class="screen">
          <!-- pagecomponent切替 -->
          <UserInfo v-if="screen == 1" />
          <Password v-else-if="screen == 2" />
          <Payment v-else-if="screen == 3" />
          <RHistory v-else />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Header from "../../components/Header.vue";
import UserInfo from "./UserInfoPage.vue";
import Password from "./Password.vue";
import Payment from "./Payment.vue";
import RHistory from "./ReservationHistory.vue";
export default {
  data() {
    return {
      screen: 1,
      selected1: "selected",
      selected2: "",
      selected3: "",
      selected4: "",
    };
  },
  components: {
    Header,
    UserInfo,
    Password,
    Payment,
    RHistory,
  },
  methods: {
    changeScreen(num) {
      this.screen = num;
      this.selected1 = "";
      this.selected2 = "";
      this.selected3 = "";
      this.selected4 = "";
      if (num == 1) {
        this.selected1 = "selected";
      } else if (num == 2) {
        this.selected2 = "selected";
      } else if (num == 3) {
        this.selected3 = "selected";
      } else {
        this.selected4 = "selected";
      }
    },
    logout() {
      //console.log("submit success!");
      var url = "/api/logout";
      axios
        .post(url)
        .then(function (response) {
          console.log(response.data.result);
          //ログイン成功時
          console.log("seikou");
          if (response.data.result == true) {
            window.location = "/";
          }
        })
        .catch(function (error) {
          //ログイン失敗時
          console.log("seikoujanai");
          var responseErrors = error.response.data.errors;
          var errors = {};

          for (var key in responseErrors) {
            errors[key] = responseErrors[key][0];
          }

          self.errors = errors;
          console.log(this.errors);
        });
    },
  },
};
</script>
