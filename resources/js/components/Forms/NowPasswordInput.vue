<template>
    <div class="form" :class="formChange">
        <label for="nowPass">現在のパスワード</label>
        <input
            type="text"
            name=""
            id="nowPass"
            placeholder="パスワード"
            v-model="nowPass"
            v-on:focus="onFocus"
            v-on:blur="onBlur"
        />
        <div class="err_msg">{{ errors.password }}</div>
    </div>
</template>

<script>
export default {
    props: {},
    data() {
        return {
            nowPass: "",
            formChange: "",
            errors: {},
        };
    },
    computed: {},
    methods: {
        colorChange: function (color) {
            this.formChange = color;
        },
        onFocus: function () {
            if (this.errors.nowPass === undefined) {
                this.colorChange("form_focus");
            }
        },
        onBlur: function () {
            var pattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/;
            if (this.nowPass.match(pattern)) {
                this.colorChange("");
            } else if (this.errors.nowPass) {
                this.colorChange("form_err");
            } else if (!this.nowPass) {
                this.$set(
                    this.errors,
                    "nowPass",
                    "パスワードを入力してください。"
                );
                this.colorChange("form_err");
            } else {
                this.$set(
                    this.errors,
                    "nowPass",
                    "パスワードは8字以上、20字以内で入力してください。"
                );
                this.colorChange("form_err");
            }
        },
    },
    watch: {
        nowPass(nowPass) {
            var pattern1 = /^[A-Za-z\d]*$/;
            var pattern2 = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{2,}$/;
            var err = true;
            if (!nowPass) {
                this.$set(
                    this.errors,
                    "nowPass",
                    "パスワードを入力してください。"
                );
            } else if (!nowPass.match(pattern1)) {
                this.$set(
                    this.errors,
                    "nowPass",
                    "パスワードには半角英数字しか利用できません。"
                );
            } else if (!nowPass.match(pattern2)) {
                this.$set(
                    this.errors,
                    "nowPass",
                    "パスワードは半角英字と、数字の両方を含めてください。"
                );
            } else {
                this.$delete(this.errors, "nowPass");
                err = false;
            }

            if (err) {
                this.colorChange("form_err");
            } else {
                this.colorChange("form_focus");
            }
        },
    },
};
</script>
