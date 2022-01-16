<template>
  <div class="form" :class="formChange">
    <label for="name">氏名</label>
    <input
      type="text"
      id="name"
      placeholder="晴れ出す太郎"
      v-model="name"
      v-on:focus="onFocus"
      v-on:blur="onBlur"
    />
    <div class="err_msg">{{ errors.name }}</div>
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
      name: "",
      formChange: "",
      errors: {},
      err: Boolean,
    };
  },
  watch: {
    name(name) {
      this.errCheck(name);
      this.$emit("err", this.err);
      this.$emit("input", name);
      if (this.err) {
        this.colorChange("form_err");
      } else {
        this.colorChange("form_focus");
      }
    },
  },
  mounted() {
    this.name = this.value;
  },
  methods: {
    errCheck(name) {
      var pattern =
        /^[A-Za-zＡ-Ｚａ-ｚ\u4E00-\u9FA0\u3005-\u3007\u3041-\u3094\u309D\u309E\u30A1-\u30F6\u30FB-\u30FE]+$/;
      if (!name) {
        this.$set(this.errors, "name", "氏名を入力してください。");
        this.err = true;
      } else if (!name.match(pattern)) {
        this.$set(
          this.errors,
          "name",
          "氏名に使用できない文字が含まれています。"
        );
        this.err = true;
      } else if (name.length > 50) {
        this.$set(this.errors, "name", "氏名が長すぎます。");
        this.err = true;
      } else {
        this.$delete(this.errors, "name");
        this.err = false;
      }
    },
    colorChange: function (color) {
      this.formChange = color;
    },
    onFocus: function () {
      this.$delete(this.errors, "name");
      this.colorChange("form_focus");
    },
    onBlur: function () {
      this.errCheck(this.name);
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
