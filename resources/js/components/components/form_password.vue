<template>
    <div class="form_wrap">
        <input class="form_pc" type="password" v-model="password" v-on:blur="onBlur" :placeholder="placeholder">
        <label for="form_pc" class="form_title">{{form_title}}</label>
        <span class="form_error">{{errors.password}}</span>
    </div>
</template>

<script>
export default {
    props: {
        placeholder: { type: String, required: false },
        form_title: { type:String },
    },
    data () {
        return {
        password: '',
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
            }
        },
    },
}
</script>
