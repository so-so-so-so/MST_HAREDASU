<template>
    <div class="pages-wrap regist2-wrap">
        <div class="content-wrap">
            <div class="title-block">
                <p class="gray title">基本情報入力</p>
                <p class="gray introduction">
                    快適な晴れ体験のために<br />あなたのことを教えてください
                </p>
            </div>
            <div class="form-block">
                <Name
                    :value="name"
                    @input="name = $event"
                    @err="nameErr = $event"
                />
                <NameKana
                    :value="nameKana"
                    @input="nameKana = $event"
                    @err="nameKanaErr = $event"
                />
                <Tel
                    :value="tel"
                    @input="tel = $event"
                    @err="telErr = $event"
                />
                <PassCheck
                    :value1="passCheck1"
                    @input1="passCheck1 = $event"
                    @err1="passCheckErr1 = $event"
                    form_label1="パスワード"
                    placeholder1="パスワード"
                    :value2="passCheck2"
                    @input2="passCheck2 = $event"
                    @err2="passCheckErr2 = $event"
                    form_label2="確認用パスワード"
                    name2="pass_check"
                    placeholder2="確認用パスワード"
                />
                <Zip
                    :value="zip"
                    @input="zip = $event"
                    @err="zipErr = $event"
                />
                <Address
                    :value="address"
                    @input="address = $event"
                    @err="addressErr = $event"
                />
                <SubmitButton
                    :isDisabled="isDisabled"
                    @clickBtn="submit()"
                    buttonName="登録"
                />
            </div>
        </div>
    </div>
</template>
<script>
import Name from "../Forms/NameInput.vue";
import NameKana from "../Forms/NameKanaInput.vue";
import Tel from "../Forms/TelInput.vue";
import PassCheck from "../Forms/PasswordCheckInput.vue";
import Zip from "../Forms/ZipInput.vue";
import Address from "../Forms/AddressInput.vue";
import SubmitButton from "../SubmitButton.vue";
export default {
    components: {
        Name,
        NameKana,
        Tel,
        PassCheck,
        Zip,
        Address,
        SubmitButton,
    },
    data() {
        return {
            name: "",
            nameErr: true,
            nameKana: "",
            nameKanaErr: true,
            tel: "",
            telErr: true,
            passCheck1: "",
            passCheckErr1: true,
            passCheck2: "",
            passCheckErr2: true,
            zip: "",
            zipErr: true,
            address: "",
            addressErr: true,
            isDisabled: true,
        };
    },
    watch: {
        nameErr(nameErr) {
            if (
                !nameErr &&
                !this.nameKanaErr &&
                !this.telErr &&
                !this.passCheckErr1 &&
                !this.passCheckErr2 &&
                !this.addressErr &&
                !this.zipErr
            ) {
                this.isDisabled = false;
            } else {
                this.isDisabled = true;
            }
        },
        nameKanaErr(nameKanaErr) {
            if (
                !nameKanaErr &&
                !this.nameErr &&
                !this.telErr &&
                !this.passCheckErr1 &&
                !this.passCheckErr2 &&
                !this.addressErr &&
                !this.zipErr
            ) {
                this.isDisabled = false;
            } else {
                this.isDisabled = true;
            }
        },
        telErr(telErr) {
            if (
                !telErr &&
                !this.nameErr &&
                !this.nameKanaErr &&
                !this.passCheckErr1 &&
                !this.passCheckErr2 &&
                !this.addressErr &&
                !this.zipErr
            ) {
                this.isDisabled = false;
            } else {
                this.isDisabled = true;
            }
        },
        passCheckErr1(passCheckErr1) {
            if (
                !passCheckErr1 &&
                !this.nameErr &&
                !this.nameKanaErr &&
                !this.telErr &&
                !this.passCheckErr2 &&
                !this.addressErr &&
                !this.zipErr
            ) {
                this.isDisabled = false;
            } else {
                this.isDisabled = true;
            }
        },
        passCheckErr2(passCheckErr2) {
            if (
                !passCheckErr2 &&
                !this.nameErr &&
                !this.nameKanaErr &&
                !this.telErr &&
                !this.passCheckErr1 &&
                !this.addressErr &&
                !this.zipErr
            ) {
                this.isDisabled = false;
            } else {
                this.isDisabled = true;
            }
        },
        zipErr(zipErr) {
            if (
                !zipErr &&
                !this.nameErr &&
                !this.nameKanaErr &&
                !this.telErr &&
                !this.passCheckErr1 &&
                !this.passCheckErr2 &&
                !this.addressErr
            ) {
                this.isDisabled = false;
            } else {
                this.isDisabled = true;
            }
        },
        addressErr(addressErr) {
            if (
                !addressErr &&
                !this.nameErr &&
                !this.nameKanaErr &&
                !this.telErr &&
                !this.passCheckErr1 &&
                !this.passCheckErr2 &&
                !this.zipErr
            ) {
                this.isDisabled = false;
            } else {
                this.isDisabled = true;
            }
        },
    },
    methods: {
        submit() {
            //console.log("submit success!");
            var url = "/api/regist";
            var params = {
                name: this.name,
                nameKana: this.nameKana,
                tel: this.tel.replace(/-/g, ""),
                password: this.passCheck1,
                zip: this.zip.replace(/-/g, ""),
                address: this.address,
                email: this.$route.query.email,
            };
            axios.post(url, params).then((response) => {
                //処理
                console.log(response.data);
                console.log("seikou");
                if (response.data.result == true) {
                    window.location = "/login";
                }
            });
        },
    },
};
</script>
