<template>
    <div class="form_wrap">
        <input class="form_pc" type="password" v-model="address" v-on:blur="onBlur" :placeholder="placeholder">
        <label for="form_pc" class="form_title">{{form_title}}</label>
        <span class="form_error">{{errors.address}}</span>
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
        address: '',
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
            if (!this.address) {
                this.$delete(this.errors, 'address')
            }
        },
    },
    watch: {
        address(address) {
            var pattern = /^[\u4E00-\u9FFF\u3005-\u3007\u3040-\u309F\u30A0-\u30FF]+$/;
            if(!address) {
                this.$set(this.errors, 'address', '住所を入力してください。')
            } else if(address.length > 100) {
                this.$set(this.errors, 'address', '住所は100字以内で入力してください。')
			} else if(!address.match(pattern)) {
                this.$set(this.errors, 'address', '住所は全角漢字、ひらがな、カタカナで入力してください。')
			} else {
                this.$delete(this.errors, 'address')
            }
        },
    },
}
</script>
