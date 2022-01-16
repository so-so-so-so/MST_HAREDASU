<template>
    <div>
        <div class="form" :class="formChange1">
            <label for="passCheck1">{{ form_label1 }}</label>
            <input
                type="text"
                id="passCheck1"
                :placeholder="placeholder1"
                v-model="passCheck1"
                v-on:focus="onFocus1"
                v-on:blur="onBlur1"
            />
            <div class="err_msg">{{ errors.passCheck1 }}</div>
        </div>
        <div class="form" :class="formChange2">
            <label for="passCheck2">{{ form_label2 }}</label>
            <input
                type="password"
                id="passCheck2"
                :placeholder="placeholder2"
                v-model="passCheck2"
                v-on:focus="onFocus2"
                v-on:blur="onBlur2"
            />
            <div class="err_msg">{{ errors.passCheck2 }}</div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        placeholder1: { type: String, required: true },
        form_label1: { type: String, required: true },
        value1: { type: String },
        placeholder2: { type: String, required: true },
        form_label2: { type: String, required: true },
        value2: { type: String },
    },
    data() {
        return {
            passCheck1: "",
            passCheck2: "",
            formChange1: "",
            formChange2: "",
            errors: {},
        };
    },
    watch: {
        passCheck1(passCheck1) {
            var pattern1 = /^[A-Za-z\d]*$/;
            var pattern2 = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{2,}$/;
            var err1 = true;
            var err2;
            if (!passCheck1) {
                this.$set(
                    this.errors,
                    "passCheck1",
                    "パスワードを入力してください。"
                );
            } else if (!passCheck1.match(pattern1)) {
                this.$set(
                    this.errors,
                    "passCheck1",
                    "パスワードには半角英数字しか利用できません。"
                );
            } else if (!passCheck1.match(pattern2)) {
                this.$set(
                    this.errors,
                    "passCheck1",
                    "パスワードは半角英字と、数字の両方を含めてください。"
                );
            } else {
                this.$delete(this.errors, "passCheck1");
                err1 = false;
                if (this.passCheck2 && passCheck1 !== this.passCheck2) {
                    this.$set(
                        this.errors,
                        "passCheck2",
                        "パスワードが一致していません"
                    );
                    this.colorChange2("form_err");
                    err2 = true;
                } else {
                    this.$delete(this.errors, "passCheck2");
                    this.colorChange2("");
                    err2 = false;
                }
            }

            if (err1) {
                this.colorChange1("form_err");
            } else {
                this.colorChange1("form_focus");
            }

            if (err2) {
                this.$emit("err2", err2);
            }
            this.$emit("err1", err1);
            this.$emit("input1", passCheck1);
        },
        passCheck2(passCheck2) {
            var err2 = true;
            if (!passCheck2) {
                this.$set(
                    this.errors,
                    "passCheck2",
                    "確認用のパスワードを入力してください。"
                );
            } else if (passCheck2 !== this.passCheck1) {
                this.$set(
                    this.errors,
                    "passCheck2",
                    "パスワードが一致していません"
                );
            } else {
                this.$delete(this.errors, "passCheck2");
                err2 = false;
            }

            if (err2) {
                this.colorChange2("form_err");
            } else {
                this.colorChange2("form_focus");
            }
            this.$emit("err2", err2);
            this.$emit("input2", passCheck2);
        },
    },
    mounted() {
        this.passCheck1 = this.value1;
        this.passCheck2 = this.value2;
    },
    methods: {
        colorChange1: function (color) {
            this.formChange1 = color;
        },
        colorChange2: function (color) {
            this.formChange2 = color;
        },
        onFocus1: function () {
            if (this.errors.passCheck1 === undefined) {
                this.colorChange1("form_focus");
            }
        },
        onFocus2: function () {
            if (this.errors.passCheck2 === undefined) {
                this.colorChange2("form_focus");
            }
        },
        onBlur1: function () {
            var pattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/;
            var err1 = true;
            if (this.passCheck1.match(pattern)) {
                this.colorChange1("");
                err1 = false;
            } else if (this.errors.passCheck1) {
                this.colorChange1("form_err");
            } else if (!this.passCheck1) {
                this.$set(
                    this.errors,
                    "passCheck1",
                    "パスワードを入力してください。"
                );
                this.colorChange1("form_err");
            } else {
                this.$set(
                    this.errors,
                    "passCheck1",
                    "パスワードは8字以上、20字以内で入力してください。"
                );
                this.colorChange1("form_err");
            }
            this.$emit("err1", err1);
        },
        onBlur2: function () {
            var err2 = true;
            if (this.errors.passCheck2) {
                this.colorChange2("form_err");
            } else if (!this.passCheck2) {
                this.$set(
                    this.errors,
                    "passCheck2",
                    "確認用のパスワードを入力してください。"
                );
                this.colorChange2("form_err");
            } else {
                this.colorChange2("");
                err2 = false;
            }
            this.$emit("err2", err2);
        },
    },
};
</script>
