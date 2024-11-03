<template>
        <div class="col-md-2 main-sidebar border py-2 px-3">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">PhotoBooth</h2>
            <i class="bi bi-x-lg" style="cursor: pointer" id="close-toggle" @click="sidebarClose"></i>
          </div>
          <nav class="nav flex-column nav-pills">
            <Link v-if="role" class="nav-link " :class="{ 'active': $page.url === '/admin/dashboard' }" href="/admin/dashboard">Dashboard</Link>
            <Link v-if="role" class="nav-link" :class="{ 'active': $page.url === '/admin/staffs' }" href="/admin/staffs">Staff Approvement</Link>
            <Link class="nav-link " :class="{ 'active': $page.url === '/admin/ticket' }" href="/admin/ticket">Tickets</Link>
            <Link v-if="role" class="nav-link " :class="{ 'active': $page.url === '/admin/reports' }" href="/admin/reports">Reports</Link>
            <Link v-if="role" class="nav-link " :class="{ 'active': $page.url === '/admin/template' }" href="/admin/template">Template</Link>
          </nav>
        </div>
</template>
<script setup>
import { Link ,usePage} from '@inertiajs/vue3'
import {ref,onMounted} from "vue";

 const sidebarClose = () => {
  const mainSidebar = document.querySelector(".main-sidebar");
  mainSidebar.classList.remove("sidebar-open");
  };
  let role = ref(null)
  onMounted(() => {
    role.value =  usePage().props.auth.user.roles[0].name == 'admin';
  })
</script>

<style scoped>
 #close-toggle {
        display: none;
      }
      @media only screen and (max-width: 1115px) {
        #close-toggle {
          display: block;
        }
      }
</style>