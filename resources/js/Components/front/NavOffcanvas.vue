<template>
  <div
    class="offcanvas offcanvas-end bg-dark"
    data-bs-scroll="true"
    data-bs-backdrop="false"
    id="openMenu"
  >
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Photo BUDDY</h5>
      <button
        type="button"
        class="btn-close"
        data-bs-dismiss="offcanvas"
      ></button>
    </div>
    <div class="offcanvas-body">
      <nav class="nav flex-column">
        <div v-if="role == 'admin'">
          <Link class="nav-link" :href="route('dashboard')">
            <h5 class="text-uppercase fw-semibold">Dashboard</h5>
          </Link>
        </div>
        <div v-else-if="role == 'moderator'">
          <Link class="nav-link" :href="route('ticket.index')">
            <h5 class="text-uppercase fw-semibold">Generate Ticket</h5>
          </Link>
        </div>
        <div v-else>
          <Link class="nav-link" href="/">
            <h5 class="text-uppercase fw-semibold">Home</h5>
          </Link>
        </div>
        <div>
          <Link class="nav-link" :href="route('ready.index')">
            <h5 class="text-uppercase fw-semibold">Ready</h5>
          </Link>
        </div>
        <a class="nav-link" href="#">
          <h5 class="text-uppercase fw-semibold">Our Clients</h5>
        </a>
        <Link class="nav-link" :href="route('contact.index')">
          <h5 class="text-uppercase fw-semibold">Contact Us</h5>
        </Link>
        <Link
          v-if="!$page.props.auth.user"
          class="nav-link"
          :href="route('login')"
        >
          <h5 class="text-uppercase fw-semibold">Login</h5>
        </Link>
        <Link v-else class="nav-link" :href="route('logout')" method="post">
          <h5 class="text-uppercase fw-semibold">Logout</h5>
        </Link>
      </nav>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, usePage } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
let role = ref(null);
onMounted(() => {
  role.value = usePage().props.role;
});
</script>

<style></style>
