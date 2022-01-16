<template>
    <div class="form" :class="formChange">
        <label for="cardName">名前</label>
        <input type="text" name="" id="cardName" placeholder="TARO HAREDASU" v-model="cardName" v-on:focus="onFocus" v-on:blur="onBlur">
        <div class="err_msg">{{ errors.cardName }}</div>
    </div>
</template>

<script>
export default {
    props: {
    },
    data () {
        return {
        cardName: '',
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
            if(this.errors.cardName === undefined){
                this.colorChange('form_focus');
            }
        },
        onBlur: function(){
            var pattern = /^[A-Z]{1,}[\s]{1}[A-Z]{1,}$/;
            if(this.cardName.match(pattern)){
                this.colorChange('');
            } else if(this.errors.cardName){
                this.colorChange('form_err');
            } else {
                this.$set(this.errors, 'cardName', '名前を入力してください。');
                this.colorChange('form_err');
            }
        },
    },
    watch: {
        cardName(cardName) {
            var pattern = /^[A-Z ]*$/;
            var err = true;
            if(!cardName) {
                this.$set(this.errors, 'cardName', '名前を入力してください。');
            } else if(!cardName.match(pattern)){
                this.$set(this.errors, 'cardName', '名前は半角大文字で入力してください。');
            } else {
                this.$delete(this.errors, 'cardName');
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
