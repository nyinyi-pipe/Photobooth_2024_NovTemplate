<template>
  <div
    class="vh-100 position-relative w-100 bg-white d-flex flex-column justify-content-center align-items-center"
  >
    <h4 class="fw-bold">SCAN TO DOWNLOAD</h4>
    <QRCodeVue3
      class="my-4"
      :value="qrcode"
      :width="250"
      :height="250"
      :qrOptions="{ typeNumber: '0', mode: 'Byte', errorCorrectionLevel: 'Q' }"
      :imageOptions="{ hideBackgroundDots: true, imageSize: 0.4, margin: 0 }"
      :dotsOptions="{ type: 'square' }"
      :cornersSquareOptions="{ type: 'square' }"
    />
    <div
      class="bg-dark w-100 mt-3"
      style="cursor: pointer"
      @click="closeQrcode"
    >
      <h6 class="text-white text-center my-2 fw-bold">
        Close ({{ closeTime }}s)
      </h6>
    </div>
  </div>
</template>

<script >
import { Link, router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import QRCodeVue3 from "qrcode-vue3";

export default {
  props: {
    photo: Object,
  },
  components: {
    QRCodeVue3,
    Link,
  },
  setup({ photo }) {
    const qrcode = ref("");
    const closeTime = ref(30);
    let second = ref(null);
    const closeQrcode = () => {
      clearInterval(second.value);
      router.get("/ready");
    };
    onMounted(() => {
      qrcode.value = window.location.origin + "/photo/download/" + photo.id;
      second.value = setInterval(() => {
        closeTime.value -= 1;
        if (closeTime.value == 0) {
          clearInterval(second.value);
          closeQrcode();
        }
      }, 1000);
    });
    return {
      qrcode,
      closeTime,
      closeQrcode,
    };
  },
};
</script>
