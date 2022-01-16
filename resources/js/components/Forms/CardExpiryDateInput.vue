<template>
    <div class="form" :class="formChange">
        <label for="cardExpDate">有効期限</label>
        <input type="text" name="" id="cardExpDate" placeholder="MM/YY" v-mask="'##/##'" v-model="cardExpDate" v-on:focus="onFocus" v-on:blur="onBlur">
        <div class="err_msg">{{ errors.cardExpDate }}</div>
    </div>
</template>

<script>
export default {
    props: {
    },
    data () {
        return {
        cardExpDate: '',
        formChange: '',
        errors: {}
        }
    },
    computed: {
    },
    methods: {
        colorChange: function (color){
            this.formChange = color;
        },
        onFocus: function(){
            if(this.errors.cardExpDate === undefined){
                this.colorChange('form_focus');
            }
        },
        onBlur: function(){
            var pattern = /^[\d]{2}[/]{1}[\d]{2}/;
            if(this.cardExpDate.match(pattern)){
                this.colorChange('');
            } else if(this.errors.cardExpDate){
                this.colorChange('form_err');
            } else {
                this.$set(this.errors, 'cardExpDate', 'カードの有効期限を入力してください。');
                this.colorChange('form_err');
            }
        },
    },
    watch: {
        cardExpDate(cardExpDate) {
            this.$delete(this.errors, 'cardExpDate');
            var pattern1 = /^[0]{1}/
            var pattern2 = /^[1]{1}/
            var pattern3 = /^.[1-9]{1}/
            var pattern4 = /^.[0-2]{1}/
            var err = true;
            if(!cardExpDate) {
                this.$set(this.errors, 'cardExpDate', 'カードの有効期限を入力してください。');
            } else if(!cardExpDate.match(pattern1) && !cardExpDate.match(pattern2)){
                this.$set(this.errors, 'cardExpDate', '月は01~12の範囲で入力してください。');
            } else if(cardExpDate.match(pattern1) && !cardExpDate.match(pattern3) || cardExpDate.match(pattern2) && !cardExpDate.match(pattern4)) {
                if(cardExpDate.length >= 2){
                    this.$set(this.errors, 'cardExpDate', '月は01~12の範囲で入力してください。');
                }else {
                    err = false;
                }
            }else {
                this.$delete(this.errors, 'cardExpDate');
                err = false;
            }

            if(err) {
                this.colorChange('form_err');
            }else {
                this.colorChange('form_focus');
            }
        },
    }
}
</script>
