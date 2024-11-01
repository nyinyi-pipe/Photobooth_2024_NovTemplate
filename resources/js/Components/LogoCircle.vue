<template>
  <div class="logo-circles">
    <div class="position-relative" style="width: 100%; height: 100%">
      <div style="width: 100%; height: 100%; position: relative; z-index: 15">
        <div @click="openToggle" class="logo" id="openDrop"></div>
      </div>
      <div class="toggle">
        <Link :href="route('logout')" class="text-dark" method="post">
          <i class="bi bi-box-arrow-right"></i>
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";

const drop = ref(null);
const openToggle = () => {};
onMounted(() => {});
</script>
<style scoped>
.logo-circles {
  width: 85px;
  height: 85px;
  border-radius: 50%;
  position: absolute;
  bottom: 0;
  left: 0;
  display: flex;
}
.logo {
  width: 100%;
  height: 100%;
  object-fit: cover;
  background-color: white;
  border-radius: 50%;
}
.toggle {
  position: absolute;
  top: 30%;
  left: 22%;
  z-index: 10;
  font-size: 1.5rem;
  background-color: white;
  padding: 5px 10px;
  border-radius: 50%;
  transition: all 0.4s ease-in-out;
  box-shadow: 0px 0px 5px rgb(83, 83, 83);
  cursor: pointer;
}
.logo-circles:hover .toggle {
  transform: translate(35px, -140%);
}
</style>
