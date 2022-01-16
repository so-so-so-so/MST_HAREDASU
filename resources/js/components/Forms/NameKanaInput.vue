<template>
  <div class="form" :class="formChange">
    <label for="nameKana">フリガナ</label>
    <input
      type="text"
      id="nameKana"
      placeholder="ハレダスタロウ"
      v-model="nameKana"
      v-on:focus="onFocus"
      v-on:blur="onBlur"
    />
    <div class="err_msg">{{ errors.nameKana }}</div>
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
      nameKana: "",
      formChange: "",
      errors: {},
      err: Boolean,
    };
  },
  watch: {
    nameKana(nameKana) {
      this.errCheck(nameKana);
      this.$emit("err", this.err);
      this.$emit("input", nameKana);
      if (this.err) {
        this.colorChange("form_err");
      } else {
        this.colorChange("form_focus");
      }
    },
  },
  mounted() {
    this.nameKana = this.value;
  },
  methods: {
    errCheck: function (nameKana) {
      var pattern = /^[\u30A1-\u30F6\u30FB-\u30FC]+$/;
      if (!nameKana) {
        this.$set(this.errors, "nameKana", "フリガナを入力してください。");
        this.err = true;
      } else if (!nameKana.match(pattern)) {
        this.$set(
          this.errors,
          "nameKana",
          "フリガナは全角カタカナで入力してください。"
        );
        this.err = true;
      } else if (nameKana.length > 50) {
        this.$set(this.errors, "nameKana", "フリガナが長すぎます。");
        this.err = true;
      } else {
        this.$delete(this.errors, "nameKana");
        this.err = false;
      }
    },
    colorChange: function (color) {
      this.formChange = color;
    },
    onFocus: function () {
      this.$delete(this.errors, "nameKana");
      this.colorChange("form_focus");
    },
    onBlur: function () {
      this.errCheck(this.nameKana);
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
