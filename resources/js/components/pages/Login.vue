<template>
    <div class="pages-wrap login-wrap">
        <div class="content-wrap">
            <div class="title-block">
                <p class="gray title">おかえりなさい！</p>
                <p class="gray introduction">
                    アカウントをお持ちですか？<br />ログインして晴れを予約しましょう！
                </p>
            </div>
            <div class="form-block">
                <Email
                    :value="email"
                    @input="email = $event"
                    @err="emailErr = $event"
                />
                <Pass
                    :value="password"
                    @input="password = $event"
                    @err="passErr = $event"
                />
                <div class="remember-block">
                    <div>
                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            v-model="remember"
                        />
                        <label class="black" for="remember"
                            >ログイン状態を保持する</label
                        >
                    </div>
                    <a class="blue" href="/change_pass">パスワードを忘れた？</a>
                </div>
                <SubmitButton
                    :isDisabled="isDisabled"
                    @clickBtn="submit()"
                    buttonName="ログイン"
                ></SubmitButton>
                <div class="others-block">
                    <p class="black">または</p>
                    <a class="blue" href="/user_regist1">アカウントを作成</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Email from "../Forms/EmailInput.vue";
import Pass from "../Forms/PasswordInput.vue";
import SubmitButton from "../SubmitButton.vue";
export default {
    components: {
        Email,
        Pass,
        SubmitButton,
    },
    data() {
        return {
            email: "",
            emailErr: true,
            password: "",
            passErr: true,
            isDisabled: true,
            remember: false,
        };
    },

    methods: {
        submit() {
            //console.log("submit success!");
            var url = "/api/login";
            var params = {
                email: this.email,
                password: this.password,
                remember: this.remember,
            };
            axios
                .post("/api/login", params)
                .then((response) => {
                    console.log(params);
                    console.log(response.data.result);
                    //ログイン成功時
                    console.log("seikou");
                    if (response.data.result == true) {
                        window.location = "/maintop";
                    }
                })
                .catch(function (error) {
                    //ログイン失敗時
                    console.log("seikoujanai");
                    var responseErrors = error.response.data.errors;
                    var errors = {};

                    for (var key in responseErrors) {
                        errors[key] = responseErrors[key][0];
                    }

                    self.errors = errors;
                    console.log(this.errors);
                });
        },
    },
    watch: {
        emailErr(emailErr) {
            if (!emailErr && !this.passErr) {
                this.isDisabled = false;
            } else {
                this.isDisabled = true;
            }
        },
        passErr(passErr) {
            if (!passErr && !this.emailErr) {
                this.isDisabled = false;
            } else {
                this.isDisabled = true;
            }
        },
    },
};
</script>
