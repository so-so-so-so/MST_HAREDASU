<template>
  <div class="user-info-wrap">
    <Tel :value="tel" @input="tel = $event" @err="telErr = $event" />
    <Email :value="email" @input="email = $event" @err="emailErr = $event" />
    <Zip :value="zip" @input="zip = $event" @err="zipErr = $event" />
    <Address
      :value="address"
      @input="address = $event"
      @err="addressErr = $event"
    />
    <SubmitButton
      :isDisabled="isDisabled"
      @clickBtn="submit()"
      buttonName="変更"
    />
  </div>
</template>
<script>
import Tel from "../../Forms/TelInput.vue";
import Email from "../../Forms/EmailInput.vue";
import Zip from "../../Forms/ZipInput.vue";
import Address from "../../Forms/AddressInput.vue";
import SubmitButton from "../../SubmitButton.vue";
export default {
  components: {
    Tel,
    Email,
    Zip,
    Address,
    SubmitButton,
  },
  props: {
  },
  data() {
    return {
      tel: "",
      telErr: true,
      email: "",
      emailErr: true,
      zip: "",
      zipErr: true,
      address: "",
      addressErr: true,
      isDisabled: true,
    };
  },
  watch: {
    telErr(telErr) {
      if (!telErr && !this.emailErr && !this.zipErr && !this.addressErr) {
        this.isDisabled = false;
      } else {
        this.isDisabled = true;
      }
    },
    emailErr(emailErr) {
      if (!emailErr && !this.telErr && !this.zipErr && !this.addressErr) {
        this.isDisabled = false;
      } else {
        this.isDisabled = true;
      }
    },
    zipErr(zipErr) {
      if (!zipErr && !this.telErr && !this.emailErr && !this.addressErr) {
        this.isDisabled = false;
      } else {
        this.isDisabled = true;
      }
    },
    addressErr(addressErr) {
      if (!addressErr && !this.telErr && !this.emailErr && !this.zipErr) {
        this.isDisabled = false;
      } else {
        this.isDisabled = true;
      }
    },
  },
  methods: {
    submit() {
      //url 書き換えてコントローラー指定
      var url = "/";
      var params = {
        tel: this.tel.replace(/-/g, ""),
        email: this.email,
        zip: this.zip.replace(/-/g, ""),
        address: this.address,
      };
      axios.post(url, params).then((response) => {
        //処理
        //予約(Reserve)削除
      });
    },
  },
};
</script>
