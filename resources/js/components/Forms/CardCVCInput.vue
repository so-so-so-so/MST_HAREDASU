<template>
    <div class="form" :class="formChange">
        <label for="cardCVC">CVC番号</label>
        <input type="text" name="" id="cardCVC" placeholder="000" v-mask="'####'" v-model="cardCVC" v-on:focus="onFocus" v-on:blur="onBlur">
        <div class="err_msg">{{ errors.cardCVC }}</div>
    </div>
</template>

<script>
export default {
    props: {
    },
    data () {
        return {
        cardCVC: '',
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
            if(this.errors.cardCVC === undefined){
                this.colorChange('form_focus');
            }
        },
        onBlur: function(){
            var pattern1 = /^[\d]{3}/;
            var pattern2 = /^[\d]{4}/;
            if(this.cardCVC.match(pattern1) || this.cardCVC.match(pattern2)){
                this.colorChange('');
            } else {
                this.$set(this.errors, 'cardCVC', 'CVC番号を入力してください。');
                this.colorChange('form_err');
            }
        },
    },
    watch: {
        cardCVC(cardCVC) {
            var err = true;
            if(!cardCVC) {
                this.$set(this.errors, 'cardCVC', 'CVC番号を入力してください。');
            } else {
                this.$delete(this.errors, 'cardCVC');
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
