<template>
    <div class="pages-wrap regist1-wrap">
        <div class="content-wrap">
            <div class="title-block">
                <p class="gray title">はじめまして！</p>
                <p class="gray introduction">
                    メールアドレスで登録して<br />晴れ予約を開始しましょう！
                </p>
            </div>
            <div class="form-block">
                <Email
                    :value="email"
                    @input="email = $event"
                    @err="emailErr = $event"
                />
                <SubmitButton
                    :isDisabled="isDisabled"
                    @clickBtn="submit()"
                    buttonName="確認メールを送信"
                ></SubmitButton>
                <div class="others-block">
                    <p class="black">または</p>
                    <a class="blue" href="/login">ログイン</a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Email from "../Forms/EmailInput.vue";
import SubmitButton from "../SubmitButton.vue";
export default {
    components: {
        Email,
        SubmitButton,
    },
    data() {
        return {
            email: "",
            emailErr: true,
            isDisabled: true,
        };
    },
    methods: {
        submit() {
            //url 書き換えてコントローラー指定
            var url = "/api/regist_mail";
            var params = {
                email: this.email,
            };
            axios.post(url, params).then((response) => {
                //処理
                console.log(response);
            });
        },
    },
    watch: {
        emailErr(emailErr) {
            if (!emailErr) {
                this.isDisabled = false;
            } else {
                this.isDisabled = true;
            }
        },
    },
};
</script>
