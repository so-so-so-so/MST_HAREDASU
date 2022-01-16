<template>
    <div class="form_wrap">
        <!--<input type="text" placeholder={{form_placeholder}} class="form_black">-->
        <input class="form_pc" :type="type" :name="name" :value="value" :placeholder="placeholder" @input="updateValue" :v-model="form_v_model" />
        <label for="form_pc" class="form_title">{{form_title}}</label>
        <span class="form_error">{{error.phoneNumber}}</span>
    </div>
</template>

<script>
export default {
    props: {
    value: { type: String, required: true },
    type: { type: String, required: true },
    name: { type: String, required: true },
    placeholder: { type: String, required: false },
    form_title: { type:String },
    error_message: {type:String},
    form_v_model:{type:String},
  },
}
</script>
