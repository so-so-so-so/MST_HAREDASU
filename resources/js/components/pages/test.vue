<template>
    <div>
        <Header></Header>
        <h1 class="test">Yano home max</h1>
        <form>
            <PhoneForm form_title="電話番号" placeholder="08000000000" />
            <ZipForm form_title="郵便番号" placeholder="1234567" />
            <OrangeButton button_name="ボタンだよ"></OrangeButton>
        </form>
    </div>
</template>

<script>
    import Header from "../components/Header.vue"
    import OrangeButton from "../components/button.vue"
    import FormPc from "../components/Form_pc.vue"
    import PhoneForm from "../components/form_phone.vue"
    import ZipForm from "../components/form_zipcode.vue"
    export default{
        components:{
            Header,
            OrangeButton,
            FormPc,
            PhoneForm,
            ZipForm
        },
    }
</script>
