<template>
    <div class="form" :class="formChange">
        <label for="cardNum">カード番号</label>
        <input type="text" name="" id="cardNum" placeholder="カード番号" v-mask="'#### #### #### ####'" v-model="cardNum" v-on:focus="onFocus" v-on:blur="onBlur">
        <div class="err_msg">{{ errors.cardNum }}</div>
    </div>
</template>

<script>
export default {
    props: {
    },
    data () {
        return {
        cardNum: '',
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
            if(this.errors.cardNum === undefined){
                this.colorChange('form_focus');
            }
        },
        onBlur: function(){
            var pattern = /^[\d]{4}[ ]{1}[\d]{4}[ ]{1}[\d]{4}[ ]{1}[\d]{4}/;
            if(this.cardNum.match(pattern)){
                this.colorChange('');
            } else {
                this.$set(this.errors, 'cardNum', 'カード番号を入力してください。');
                this.colorChange('form_err');
            }
        },
    },
    watch: {
        cardNum(cardNum) {
            var err = true;
            if(!cardNum) {
                this.$set(this.errors, 'cardNum', 'カード番号を入力してください。');
            } else {
                this.$delete(this.errors, 'cardNum');
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
