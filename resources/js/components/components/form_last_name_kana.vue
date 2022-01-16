<template>
    <div>
        <input class="form_pc" type="text" v-model="lastNameKana" v-on:blur="onBlur" :placeholder="placeholder">
        <label for="form_pc" class="form_title">{{form_title}}</label>
        <span class="form_error">{{errors.lastNameKana}}</span>
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
        lastNameKana: '',
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
            if (!this.lastNameKana) {
                this.$delete(this.errors, 'lastNameKana')
            }
        },
    },
    watch: {
        lastNameKana(lastNameKana) {
            var pattern = /^[\u30A0-\u30FF]+$/;
            if(!lastNameKana) {
                this.$set(this.errors, 'lastNameKana', 'セイを入力してください。')
            } else if(lastNameKana.length > 20){
                this.$set(this.errors, 'lastNameKana', 'セイは20字以内で入力してください。')
            } else if(!lastNameKana.match(pattern)){
                this.$set(this.errors, 'lastNameKana', 'セイは全角カタカナで入力してください。')
            } else {
                this.$delete(this.errors, 'lastNameKana')
            }
        },
        // lastNameKana(lastNameKana) {
        //     var pattern = /^[\u3040-\u309F]+$/
        //     if(!lastNameKana) {
        //         this.$set(this.errors, 'lastNameKana', 'せいを入力してください。')
        //     } else if(lastNameKana.length > 20){
        //         this.$set(this.errors, 'lastNameKana', 'せいは20字以内で入力してください。')
        //     } else if(!lastNameKana.match(pattern)){
        //         this.$set(this.errors, 'lastNameKana', 'せいは全角ひらがなで入力してください。')
        //     } else {
        //         this.$delete(this.errors, 'lastNameKana')
        //     }
        // },
    }
}
</script>
