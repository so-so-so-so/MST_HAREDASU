<template>
    <div>
        <h1>基本情報入力</h1>
        <p>快適な晴れ体験のために<br />あなたのことを教えてください。</p>
        <FormLastName placeholder="晴れ出す" form_title="姓"></FormLastName>
        <FormFirstName placeholder="晴れ太郎" form_title="名"></FormFirstName>
        <FormLastNameKana
            placeholder="ハレダス"
            form_title="セイ"
        ></FormLastNameKana>
        <!-- <FormLastNameKana placeholder="はれだす" form_title="せい"></FormLastNameKana> -->
        <FormFirstNameKana
            placeholder="ハレタロウ"
            form_title="メイ"
        ></FormFirstNameKana>
        <!-- <FormFirstNameKana placeholder="はれたろう" form_title="めい"></FormFirstNameKana> -->
        <FormPhone
            placeholder="070-0000-0000"
            form_title="電話番号"
        ></FormPhone>
        <FormPassCheck
            placeholder1="パスワード"
            form_title1="パスワード"
            placeholder2="パスワード確認"
            form_title2="パスワード確認"
        ></FormPassCheck>
        <FormZipCode placeholder="郵便番号" form_title="郵便番号"></FormZipCode>
        <FromAddress placeholder="住所" form_title="住所"></FromAddress>
        <OrangeButton button_name="登録"></OrangeButton>
    </div>
</template>

<script>
import Header from "../components/Header.vue";
import FormLastName from "../components/form_last_name.vue";
import FormFirstName from "../components/form_first_name.vue";
import FormLastNameKana from "../components/form_last_name_kana.vue";
import FormFirstNameKana from "../components/form_first_name_kana.vue";
import FormPhone from "../components/form_phone.vue";
import FormPassCheck from "../components/form_password_check.vue";
import FormZipCode from "../components/form_zipcode.vue";
import FromAddress from "../components/form_address.vue";
import OrangeButton from "../components/button.vue";
import FormPc from "../components/Form_pc.vue";
export default {
    components: {
        Header,
        FormLastName,
        FormFirstName,
        FormLastNameKana,
        FormFirstNameKana,
        FormPhone,
        FormPassCheck,
        FormZipCode,
        FromAddress,
        OrangeButton,
        FormPc,
    },
};
</script>
