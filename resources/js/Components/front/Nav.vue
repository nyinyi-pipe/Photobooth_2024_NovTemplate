<template>
  <nav class="navbar navbar-expand-lg position-absolute end-0 top-0 me-3" style="z-index:40;">
    <i
      class="bi bi-list fs-3 text-muted"
      data-bs-target="#openMenu"
      data-bs-toggle="offcanvas"
      id="hamburger-menu"
    ></i>
  </nav>
  <NavOffcanvas></NavOffcanvas>
</template>

<script>
import NavOffcanvas from "./NavOffcanvas.vue";
export default {
  components: { NavOffcanvas },
};
</script>

<style>
</style>