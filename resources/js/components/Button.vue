<template>
    <button class="button" @click="$emit('show-detail')">{{ buttonName }}</button>
</template>
<script>
export default {
    props: {
        buttonName: { type: String },
    },
}
</script>
