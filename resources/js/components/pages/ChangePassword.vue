<template>
    <div>
        <Header></Header>
        <div class="form-page-wrap">
            <div class="title">パスワード変更</div>
            <div class="introduction">パスワードは半角英数含め、<br>8字以上で入力してください。</div>
            <form>
                <PassCheck
                    form_label1="パスワード"
                    name1="new_pass"
                    placeholder1="パスワード"
                    form_label2="確認用パスワード"
                    name2="new_pass_check"
                    placeholder2="確認用パスワード"
                ></PassCheck>
                <SubmitButton buttonName="変更"></SubmitButton>
            </form>
        </div>
    </div>
</template>

<script>
    import Header from '../components/Header.vue'
    import PassCheck from '../Forms/PasswordCheckInput.vue'
    import SubmitButton from '../SubmitButton.vue'
    export default{
        components:{
            Header,
            PassCheck,
            SubmitButton,
        },
    }
</script>
