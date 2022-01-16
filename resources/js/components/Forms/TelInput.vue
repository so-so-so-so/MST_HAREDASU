<template>
  <div class="form" :class="formChange">
    <label for="tel">電話番号</label>
    <input
      type="text"
      id="tel"
      placeholder="000-0000-0000"
      v-mask="'###-####-####'"
      v-model="tel"
      v-on:focus="onFocus"
      v-on:blur="onBlur"
    />
    <div class="err_msg">{{ errors.tel }}</div>
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
      tel: "",
      formChange: "",
      errors: {},
    };
  },
  watch: {
    tel(tel) {
      var pattern1 = /^0[789]{1}0/;
      var pattern2 = /^0[789]{1}0[\-]{1}[\d]{4}[\-]{1}[\d]{4}/;
      var err = true;
      var errColor = true;
      if (!tel) {
        this.$set(this.errors, "tel", "電話番号を入力してください。");
      } else if (!tel.match(pattern1)) {
        this.$set(
          this.errors,
          "tel",
          "無効な電話番号です。正しい番号を入力してください。"
        );
      } else if (!tel.match(pattern2)) {
        this.$set(this.errors, "tel", "");
        errColor = false;
      } else {
        this.$delete(this.errors, "tel");
        err = false;
        errColor = false;
      }

      if (errColor) {
        this.colorChange("form_err");
      } else {
        this.colorChange("form_focus");
      }
      this.$emit("err", err);
      this.$emit("input", tel);
    },
  },
  mounted() {
    this.tel = this.value;
  },
  methods: {
    colorChange: function (color) {
      this.formChange = color;
    },
    onFocus: function () {
        this.$delete(this.errors, "tel");
        this.colorChange("form_focus");
    },
    onBlur: function () {
      var pattern = /^0[789]{1}0[\-]{1}[\d]{4}[\-]{1}[\d]{4}/;
      var err = true;
      if (this.tel.match(pattern)) {
        this.colorChange("");
        err = false;
      } else if (this.errors.tel) {
        this.colorChange("form_err");
      } else {
        this.$set(this.errors, "tel", "電話番号を入力してください。");
        this.colorChange("form_err");
      }
      this.$emit("err", err);
    },
  },
};
</script>
