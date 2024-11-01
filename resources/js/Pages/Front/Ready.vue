<template>
  <ClientLayout>
    <Head title="Ready" />
    <div class="vh-100 position-relative">
      <div class="ready-container" id="start">
        <Link :href="route('payment.method')" class="ready">
          <h1 class="ready-text1 mb-0">FOTO</h1>
          <div class="ready-img"></div>
          <h1 class="ready-text1 mb-0">AUTOMAT</h1>
        </Link>
      </div>
      <!-- <LogoCircle /> -->
      <div class="logout-circle">
        <form>
          <Link :href="route('logout')" class="text-dark" method="post">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              style="fill: rgba(0, 0, 0, 1); transform: ; msfilter: "
            >
              <path d="M16 13v-2H7V8l-5 4 5 4v-3z"></path>
              <path
                d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z"
              ></path>
            </svg>
          </Link>
        </form>
      </div>
    </div>
  </ClientLayout>
</template>
<script setup>
import { Link, Head } from "@inertiajs/vue3";
import ClientLayout from "@/Components/client/Layout/ClientLayout.vue";
import LogoCircle from "@/Components/LogoCircle.vue";
</script>
