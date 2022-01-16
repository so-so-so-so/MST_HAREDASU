<template>
    <div>
        <input class="form_pc" type="text" v-model="firstName" v-on:blur="onBlur" :placeholder="placeholder">
        <label for="form_pc" class="form_title">{{form_title}}</label>
        <span class="form_error">{{errors.firstName}}</span>
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
        firstName: '',
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
            if (!this.firstName) {
                this.$delete(this.errors, 'firstName')
            }
        },
    },
    watch: {
        firstName(firstName) {
            var pattern = /^[\u4E00-\u9FFF\u3005-\u3007\u3040-\u309F\u30A0-\u30FF]+$/;
            if(!firstName) {
                this.$set(this.errors, 'firstName', '名を入力してください')
            } else if(firstName.length > 100){
                this.$set(this.errors, 'firstName', '名は20字以内で入力してください。')
            } else if(!firstName.match(pattern)){
                this.$set(this.errors, 'firstName', '名は全角漢字、ひらがな、カタカナで入力してください。')
            } else {
                this.$delete(this.errors, 'firstName')
            }
        },
    }
}
</script>
