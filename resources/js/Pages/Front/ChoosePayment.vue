<template>
  <ClientLayout>
    <div
      class="row vh-100 justify-content-center align-items-center position-reactive"
    >
      <div class="d-flex flex-column align-items-center gap-3">
        <p
          style="cursor: pointer; user-select: none;width:235px;"
          class="py-2 px-5 bg-dark mb-0 fs-1 fw-bold text-white payment-text rounded"
          @click="cash"
        >
          Cash
        </p>
        <p
          style="cursor: pointer; user-select: none;width:235px;"
          class="py-2 px-5 bg-dark mb-0 fs-1 fw-bold text-white payment-text rounded"
          @click="ticket"
        >
          Ticket
        </p>
      </div>
      <div class="logo-circle" @click="back">
      </div>
    </div>
  </ClientLayout>
</template>

<script>
import { router, Link } from "@inertiajs/vue3";
import ClientLayout from "@/Components/client/Layout/ClientLayout.vue";

export default {
  components: {
    ClientLayout,
  },
  setup() {
    const cash = () => {
      router.get(route("payment.method"));
    };

    const ticket = () => {
      router.get(route("payment.method"));
    };

    const back = () => {
      router.get(route("ready.index"));
    }

    return {
      ticket,
      cash,
      back
    };
  },
};
</script>

<style>
</style>
