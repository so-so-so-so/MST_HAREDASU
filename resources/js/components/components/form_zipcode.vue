<template>
    <div class="form_wrap">
        <input class="form_pc" type="text" v-model="zipCode" v-on:blur="onBlur" :placeholder="placeholder">
        <label for="form_pc" class="form_title">{{form_title}}</label>
        <span class="form_error">{{errors.zipCode}}</span>
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
        zipCode: '',
        errors: {}
        }
    },
    computed: {
        isDisabled() {
            return Object.keys(this.errors).length > 0 ? true : false
        }
    },
    methods: {
        onBlur: function(){
            if (!this.zipCode) {
                this.$delete(this.errors, 'zipCode')
            }
        },
    },
    watch: {
        zipCode(zipCode) {
            // !!zipCode.match(/^\d{7}$/)
            if (!zipCode) {
                this.$set(this.errors, 'zipCode', '郵便番号を入力してください。')
            } else {
                this.$delete(this.errors, 'zipCode')
            }
        },
    }
}
</script>
