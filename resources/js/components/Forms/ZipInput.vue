<template>
  <div class="form" :class="formChange">
    <label for="zip">郵便番号</label>
    <input
      type="text"
      id="zip"
      placeholder="000-0000"
      v-mask="'###-####'"
      v-model="zip"
      v-on:focus="onFocus"
      v-on:blur="onBlur"
    />
    <div class="err_msg">{{ errors.zip }}</div>
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
      zip: "",
      formChange: "",
      errors: {},
    };
  },
  watch: {
    zip(zip) {
      var pattern = /^[\d]{3}[\-]{1}[\d]{4}/;
      var err = true;
      var errColor = true;
      if (!zip) {
        this.$set(this.errors, "zip", "郵便番号を入力してください。");
      } else if (!zip.match(pattern)) {
        this.$set(this.errors, "zip", "");
        errColor = false;
      } else {
        this.$delete(this.errors, "zip");
        err = false;
        errColor = false;
      }
      
      if (errColor) {
        this.colorChange("form_err");
      } else {
        this.colorChange("form_focus");
      }
      this.$emit("err", err);
      this.$emit("input", zip);
    },
  },
  mounted() {
    this.zip = this.value;
  },
  methods: {
    colorChange: function (color) {
      this.formChange = color;
    },
    onFocus: function () {
      this.$delete(this.errors, "zip");
      this.colorChange("form_focus");
    },
    onBlur: function () {
      var pattern = /^[\d]{3}[\-]{1}[\d]{4}/;
      var err = true;
      if (this.zip.match(pattern)) {
        this.colorChange("");
        err = false;
      } else {
        this.$set(this.errors, "zip", "郵便番号を入力してください。");
        this.colorChange("form_err");
      }
      this.$emit("err", err);
    },
  },
};
</script>
