<template>
    <div>
        <button class="button submit-button" :class="{ 'disabled': isDisabled, 'hover': isHover }" :disabled="isDisabled" @mouseover="mouseoverAction()" @mouseleave="mouseleaveAction()" @click="$emit('clickBtn')">{{ buttonName }}</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isHover: false
        }
    },
    props: {
        buttonName: { type: String },
        isDisabled: { type: Boolean },
    },
    methods: {
        mouseoverAction() {
            this.isHover = true;
        },
        mouseleaveAction() {
            this.isHover = false;
        }
    },
}
</script>
