<template>
    <div class="form" :class="formChange" :value="value">
        <label for="password">{{ form_label }}</label>
        <input
            type="text"
            id="password"
            :placeholder="placeholder"
            v-model="password"
            v-on:focus="onFocus"
            v-on:blur="onBlur"
        />
        <div class="err_msg">{{ errors.password }}</div>
    </div>
</template>

<script>
export default {
    props: {
        form_label: {
            type: String,
            default: "パスワード",
        },
        placeholder: {
            type: String,
            default: "パスワード",
        },
        value: {
            type: String,
        },
    },
    data() {
        return {
            password: "",
            formChange: "",
            errors: {},
            err: Boolean,
        };
    },
    watch: {
        password(password) {
            this.errCheck(password);
            this.$emit("err", this.err);
            this.$emit("input", password);
            if (this.err) {
                this.colorChange("form_err");
            } else {
                this.colorChange("form_focus");
            }
        },
    },
    mounted() {
        this.password = this.value;
    },
    methods: {
        errCheck(password) {
            var pattern1 = /^[A-Za-z\d]*$/;
            var pattern2 = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{2,}$/;
            if (!password) {
                this.$set(
                    this.errors,
                    "password",
                    "パスワードを入力してください。"
                );
                this.err = true;
            } else if (!password.match(pattern1)) {
                this.$set(
                    this.errors,
                    "password",
                    "パスワードには半角英数字しか利用できません。"
                );
                this.err = true;
            } else if (!password.match(pattern2)) {
                this.$set(
                    this.errors,
                    "password",
                    "パスワードは半角英字と、数字の両方を含めてください。"
                );
                this.err = true;
            } else if (password.length < 8 || password.length > 20) {
                this.$set(
                    this.errors,
                    "password",
                    "パスワードは8字以上、20字以内で入力してください"
                );
                this.err = true;
            } else {
                this.$delete(this.errors, "password");
                this.err = false;
            }
        },
        colorChange: function (color) {
            this.formChange = color;
        },
        onFocus: function () {
            if (this.errors.password === undefined) {
                this.colorChange("form_focus");
            }
        },
        onBlur: function () {
            this.errCheck(this.password);
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
