<template>
  <div class="container-fluid">
    <div class="row justify-content-center vh-100 position-relative">
      <AdminSidebar />
      <div class="col-md-10 col-main-12 border px-2">
        <AdminNav />
        <div class="container-fluid">
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import AdminSidebar from "@/Components/admin/AdminSidebar.vue";
import AdminNav from "@/Components/admin/AdminNav.vue";
</script>

<style scoped>
.user-logo {
  width: 40px;
  height: 40px;
  object-fit: cover;
  border-radius: 50%;
  border: 2px solid #000;
}

.sidebar-toggle {
  display: none;
}

@media screen and (max-width: 450px) {
  .main-sidebar {
    width: 60% !important;
  }
}
@media screen and (max-width: 1024px) and (min-width: 450px) {
  .main-sidebar {
    width: 33% !important;
  }
}
@media only screen and (max-width: 1115px) {
  .col-main-12 {
    width: 100%;
  }
  .main-navbar {
    display: flex !important;
    justify-content: space-between !important;
  }
  .main-sidebar {
    width: 20%;
    transform: translateX(-500px);
    position: absolute;
    left: 0;
    top: 0;
    transition: all 0.4s;
    background-color: #f3f4f4;
    height: 100%;
    z-index: 3;
  }
  .sidebar-toggle {
    display: block;
    cursor: pointer;
  }
  .sidebar-open {
    transform: translateX(0px);
  }
}
</style>
