<template>
    <div class="form_wrap">
        <div>
            <input class="form_pc" type="password" name="password" v-model="password" v-on:blur="onBlur" :placeholder="placeholder1">
            <label for="form_pc" class="form_title">{{form_title1}}</label>
            <span class="form_error">{{errors.password}}</span>
        </div>
        <div>
            <input class="form_pc" type="password" name="passwordCheck" v-model="passwordCheck" v-on:blur="onBlur" :placeholder="placeholder2">
            <label for="form_pc" class="form_title">{{form_title2}}</label>
            <span class="form_error">{{errors.passwordCheck}}</span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        placeholder1: { type: String, required: false },
        placeholder2: { type: String, required: false },
        form_title1: { type:String },
        form_title2: { type:String },
    },
    data () {
        return {
        password: '',
        passwordCheck: '',
        errors: {}
        }
    },
    computed: {
        isDisabled() {
            return Object.keys(this.errors).length > 0 ? true : false
        },

    },
    methods: {
        onBlur: function(){
            if (!this.password) {
                this.$delete(this.errors, 'password')
            }
            if(!this.passwordCheck) {
                this.$delete(this.errors, 'passwordCheck')
            }
        },
    },

    watch: {
        password(password) {
            var pattern1 = /^[A-Za-z\d]*$/;
            var pattern2 = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/;
            var pattern3 = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{2,}$/
            if(!password) {
                this.$set(this.errors, 'password', 'パスワードを入力してください。')
            } else if(!password.match(pattern1)) {
                this.$set(this.errors, 'password', 'パスワードには半角英数字しか利用できません。')
            } else if(!password.match(pattern2)) {
                var err1 = '', err2 = '';
                if(!password.match(pattern3)){
                    err1 = 'パスワードは半角英字と、数字の両方を含めてください。';
                }
                if (password.length < 8 || password.length > 20) {
                    err2 = 'パスワードは8字以上、20字以内で入力してください。';
                }
                this.$set(this.errors, 'password', err1 + err2)
            } else {
                this.$delete(this.errors, 'password')
                if(this.passwordCheck && password !== this.passwordCheck){
                    this.$set(this.errors, "passwordCheck", 'パスワードが一致していません')
                } else{
                    this.$delete(this.errors, 'passwordCheck')
                }
            }
        },
        passwordCheck(passwordCheck) {
            if (passwordCheck !== this.password) {
                this.$set(this.errors, "passwordCheck", 'パスワードが一致していません')
            } else {
                this.$delete(this.errors, 'passwordCheck')
            }
        },
    },
}
</script>
