<template>
  <div class="form" :class="formChange">
    <label for="email">メールアドレス</label>
    <input
      type="text"
      id="email"
      placeholder="haredas@gmail.com"
      v-model="email"
      v-on:focus="onFocus"
      v-on:blur="onBlur"
    />
    <div class="err_msg">{{ errors.email }}</div>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: String,
    },
  },
  data() {
    return {
      email: "",
      formChange: "",
      errors: {},
      err: Boolean,
    };
  },
  watch: {
    email(email) {
      this.errCheck(email);
      this.$emit("err", this.err);
      this.$emit("input", email);
      if (this.err) {
        this.colorChange("form_err");
      } else {
        this.colorChange("form_focus");
      }
    },
  },
  mounted() {
    this.email = this.value;
  },
  methods: {
    errCheck(email) {
      var pattern1 = /^[A-Za-z\d_.@\-]*$/;
      var pattern2 =
        /^[A-Za-z\d_.\-]{1,}@{1}[A-Za-z\d_\-]{1,}\.{1}[A-Za-z\d_.\-]{1,}$/;
      if (!email) {
        this.$set(this.errors, "email", "メールアドレスを入力してください。");
        this.err = true;
      } else if (!email.match(pattern1)) {
        this.$set(
          this.errors,
          "email",
          "メールアドレスに使用できない文字が含まれています。"
        );
        this.err = true;
      } else if (email.length > 50) {
        this.$set(this.errors, "email", "メールアドレスが長すぎます。");
        this.err = true;
      } else if (!email.match(pattern2)) {
        this.$set(
          this.errors,
          "email",
          "メールアドレスは「XX@XX.XX」の形式で入力してください。"
        );
        this.err = true;
      } else {
        this.$delete(this.errors, "email");
        this.err = false;
      }
    },
    colorChange: function (color) {
      this.formChange = color;
    },
    onFocus: function () {
      if (this.errors.email === undefined) {
        this.colorChange("form_focus");
      }
    },
    onBlur: function () {
      this.errCheck(this.email);
      this.$emit("err", this.err);
      if (this.err) {
        this.colorChange("form_err");
      } else {
        this.colorChange("");
      }
    },
  },
};
</script>
