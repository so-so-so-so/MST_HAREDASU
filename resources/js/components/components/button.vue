<template>
    <button class="button_orange" type="submit" :disabled="isDisabled"><span class="button_chara">{{ button_name }}</span></button>
</template>

<script>
export default {
    name: "OrabgeButton",
    props: {
        button_name: { type: String },
    },
    /*computed: {
        isDisabled() {
            return Object.keys(this.errors).length > 0 ? true : false
        }
    },*/
}
</script>
