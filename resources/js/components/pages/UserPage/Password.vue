<template>
  <div class="password-wrap">
    <Password
      :value="password"
      @input="password = $event"
      @err="passErr = $event"
      form_label="現在のパスワード"
      name="old_pass"
      placeholder="現在のパスワード"
    />
    <PassCheck
      :value1="passCheck1"
      @input1="passCheck1 = $event"
      @err1="passCheckErr1 = $event"
      form_label1="新しいパスワード"
      placeholder1="新しいパスワード"
      :value2="passCheck2"
      @input2="passCheck2 = $event"
      @err2="passCheckErr2 = $event"
      form_label2="新しいパスワード(確認用)"
      placeholder2="新しいパスワード(確認用)"
    />
    <SubmitButton
      :isDisabled="isDisabled"
      @clickBtn="submit()"
      buttonName="変更"
    />
  </div>
</template>
<script>
import Password from "../../Forms/PasswordInput.vue";
import PassCheck from "../../Forms/PasswordCheckInput.vue";
import SubmitButton from "../../SubmitButton.vue";
export default {
  components: {
    Password,
    PassCheck,
    SubmitButton,
  },
  data() {
    return {
      password: "",
      passErr: true,
      passCheck1: "",
      passCheckErr1: true,
      passCheck2: "",
      passCheckErr2: true,
      isDisabled: true,
    };
  },
  watch: {
    passErr(passErr) {
      if (!passErr && !this.passCheckErr1 && !this.passCheckErr2) {
        this.isDisabled = false;
      } else {
        this.isDisabled = true;
      }
    },
    passCheckErr1(passCheckErr1) {
      if (!passCheckErr1 && !this.passErr && !this.passCheckErr2) {
        this.isDisabled = false;
      } else {
        this.isDisabled = true;
      }
    },
    passCheckErr2(passCheckErr2) {
      if (!passCheckErr2 && !this.passErr && !this.passCheckErr1) {
        this.isDisabled = false;
      } else {
        this.isDisabled = true;
      }
    },
  },
  methods: {
    submit() {
      //url 書き換えてコントローラー指定
      var url = "/";
      var params = {
        password: this.password,
        newPassword: this.passCheck1,
      };
      axios.post(url, params).then((response) => {
        //処理
        //passwordが現在のパスワードと合ってるか
        //合ってるならnewPasswordに変更？
        //ただし不一致エラーを表示するスペースはない
      });
    },
  },
};
</script>
