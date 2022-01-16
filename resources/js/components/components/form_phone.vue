<template>
    <div class="form_wrap">
        <input class="form_pc" type="text" v-model="phoneNumber" v-on:blur="onBlur" :placeholder="placeholder">
        <label for="form_pc" class="form_title">{{form_title}}</label>
        <span class="form_error">{{errors.phoneNumber}}</span>
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
        phoneNumber: '',
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
            if (!this.phoneNumber) {
                this.$delete(this.errors, 'phoneNumber')
            }
        },
    },
    watch: {
        phoneNumber(phoneNumber) {
            // !!phoneNumber.match(/^[0-9\-]+$/)
            if (!phoneNumber) {
                this.$delete(this.errors, 'phoneNumber','電話番号を入力してください。')
            } else {
                this.$delete(this.errors, 'phoneNumber')
            }
        },
    }
}
</script>
