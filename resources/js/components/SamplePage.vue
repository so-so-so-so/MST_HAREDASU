<template>
    <div>
        <!-- <div class="form">
            <label for="sample">form title</label>
            <input type="text" name="" id="sample" placeholder="PCフォーム">
            <div class="err_msg">error</div>
        </div> -->

        <!-- <cardCVC></cardCVC> -->
        <!-- <cardExpDate></cardExpDate> -->
        <!-- <cardName></cardName> -->
        <!-- <cardNum></cardNum> -->
        <!-- <email></email> -->
        <!-- <pass></pass> -->
        <!-- <passCheck></passCheck> -->
        <!-- <tel></tel> -->
        <!-- <zip></zip> -->
        <userAddress></userAddress>
        <!-- <name></name> -->
        <nameKana></nameKana>
    </div>
</template>

<script>
//addressは予約語らしく使えない
    import name from './Forms/NameInput.vue'
    import nameKana from './Forms/NameKanaInput.vue'
    import email from './Forms/EmailInput.vue'
    import pass from './Forms/PasswordInput.vue'
    import passCheck from './Forms/PasswordCheckInput.vue'
    import tel from './Forms/TelInput.vue'
    import zip from './Forms/ZipInput.vue'
    import cardNum from './Forms/CardNumberInput.vue'
    import cardExpDate from './Forms/CardExpiryDateInput.vue'
    import cardCVC from './Forms/CardCVCInput.vue'
    import cardName from './Forms/CardNameInput.vue'
    import userAddress from './Forms/AddressInput.vue'
    export default {
        components:{
            name,
            nameKana,
            email,
            pass,
            passCheck,
            tel,
            zip,
            cardNum,
            cardExpDate,
            cardCVC,
            cardName,
            userAddress,
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
