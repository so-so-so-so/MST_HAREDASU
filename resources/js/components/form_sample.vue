<template>
  <div class="container">
    <div>
      <label for="name">名前</label>
      <input type="text" v-model="name">
      <span>{{errors.name}}</span>
    </div>
    <div>
      <label>名前（フリガナ）</label>
      <input type="text" v-model="nameKana">
      <span>{{errors.nameKana}}</span>
    </div>
    <div>
      <label>郵便番号</label>
      <input type="text" v-model="zipCode">
      <span>{{errors.zipCode}}</span>
    </div>
    <div>
      <label>電話番号</label>
      <input type="text" v-model="phoneNumber">
      <span>{{errors.phoneNumber}}</span>
    </div>
    <div class="register">
      <button type="button" :disabled="isDisabled">登録する</button>
    </div>
  </div>
</template>
<script>
export default {
  name: 'HelloWorld',
  data () {
    return {
      name: '',
      nameKana: '',
      zipCode: '',
      phoneNumber: '',
      errors: {}
    }
  },
  computed: {
    isDisabled() {
      return Object.keys(this.errors).length > 0 ? true : false
    }
  },
  watch: {
    nameKana(nameKana) {
      if (!nameKana || !!nameKana.match(/^[ァ-ヶー　]*$/)) {
        this.$delete(this.errors, 'nameKana')
      } else {
        this.$set(this.errors, "nameKana", '名前（フリガナ）は全角カタカナで入力してください')
      }
    },
    zipCode(zipCode) {
      if (!zipCode || !!zipCode.match(/^\d{7}$/)) {
        this.$delete(this.errors, 'zipCode')
      } else {
        this.$set(this.errors, "zipCode", '郵便番号は7桁の半角数字で入力してください。')
      }
    },
    phoneNumber(phoneNumber) {
      if (!phoneNumber || !!phoneNumber.match(/^[0-9\-]+$/)) {
        this.$delete(this.errors, 'phoneNumber')
      } else {
        this.$set(this.errors, "phoneNumber", '電話番号は半角数字、またはハイフンで入力してください。')
      }
    },
  }
}
</script>
