<template>
  <div class="form" :class="formChange">
    <label for="address">住所</label>
    <input
      type="text"
      id="address"
      placeholder="住所"
      v-model="address"
      v-on:focus="onFocus"
      v-on:blur="onBlur"
    />
    <div class="err_msg">{{ errors.address }}</div>
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
      address: "",
      formChange: "",
      errors: {},
      err: Boolean,
    };
  },
  watch: {
    address(address) {
      this.errCheck(address);
      this.$emit("err", this.err);
      this.$emit("input", address);
      if (this.err) {
        this.colorChange("form_err");
      } else {
        this.colorChange("form_focus");
      }
    },
  },
    mounted() {
    this.address = this.value;
  },
  methods: {
    errCheck: function (address) {
      if (!address) {
        this.$set(this.errors, "address", "住所を入力してください。");
        this.err = true;
      } else if (address.length > 100) {
        this.$set(this.errors, "address", "住所が長すぎます。");
        this.err = true;
      } else {
        this.$delete(this.errors, "address");
        this.err = false;
      }
    },
    colorChange: function (color) {
      this.formChange = color;
    },
    onFocus: function () {
      this.$delete(this.errors, "address");
      this.colorChange("form_focus");
    },
    onBlur: function () {
      this.errCheck(this.address);
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
