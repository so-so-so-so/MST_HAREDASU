<template>
    <div>
        <input class="form_pc" type="text" v-model="firstNameKana" v-on:blur="onBlur" :placeholder="placeholder">
        <label for="form_pc" class="form_title">{{form_title}}</label>
        <span class="form_error">{{errors.firstNameKana}}</span>
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
        firstNameKana: '',
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
            if (!this.firstNameKana) {
                this.$delete(this.errors, 'firstNameKana')
            }
        },
    },
    watch: {
        firstNameKana(firstNameKana) {
            var pattern = /^[\u30A0-\u30FF]+$/;
            if(!firstNameKana) {
                this.$set(this.errors, 'firstNameKana', 'メイを入力してください')
            } else if(firstNameKana.length > 100){
                this.$set(this.errors, 'firstNameKana', 'メイは20字以内で入力してください。')
            } else if(!firstNameKana.match(pattern)){
                this.$set(this.errors, 'firstNameKana', 'メイは全角カタカナで入力してください。')
            } else {
                this.$delete(this.errors, 'firstNameKana')
            }
        },
        // firstNameKana(firstNameKana) {
        //     var pattern = /^[\u3040-\u309F]+$/
        //     if(!firstNameKana) {
        //         this.$set(this.errors, 'firstNameKana', 'めいを入力してください')
        //     } else if(firstNameKana.length > 100){
        //         this.$set(this.errors, 'firstNameKana', 'めいは20字以内で入力してください。')
        //     } else if(!firstNameKana.match(pattern)){
        //         this.$set(this.errors, 'firstNameKana', 'めいは全角ひらがなで入力してください。')
        //     } else {
        //         this.$delete(this.errors, 'firstNameKana')
        //     }
        // },
    }
}
</script>
