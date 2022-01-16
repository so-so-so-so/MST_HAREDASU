<template>
    <div>
        <input class="form_pc" type="text" v-model="lastName" v-on:blur="onBlur" :placeholder="placeholder">
        <label for="form_pc" class="form_title">{{form_title}}</label>
        <span class="form_error">{{errors.lastName}}</span>
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
        lastName: '',
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
            if (!this.lastName) {
                this.$delete(this.errors, 'lastName')
            }
        },
    },
    watch: {
        lastName(lastName) {
            var pattern = /^[\u4E00-\u9FFF\u3005-\u3007\u3040-\u309F\u30A0-\u30FF]+$/;
            if(!lastName) {
                this.$set(this.errors, 'lastName', '姓を入力してください。')
            } else if(lastName.length > 20){
                this.$set(this.errors, 'lastName', '姓は20字以内で入力してください。')
            } else if(!lastName.match(pattern)){
                this.$set(this.errors, 'lastName', '姓は全角漢字、ひらがな、カタカナで入力してください。')
            } else {
                this.$delete(this.errors, 'lastName')
            }
        },
    }
}
</script>
