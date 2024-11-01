<template>
  <nav class="navbar navbar-expand-lg pb-0 bg-body-tertiary">
    <div class="container-fluid justify-content-between main-navbar">
      <i class="bi bi-list sidebar-toggle fs-2" @click="sidebarOpen"></i>
      <div>
        <div class="navbar-brand">
          <div class="dropstart">
            <img
              @click="openDropdown"
              class="user-logo"
              :src="avatar"
              alt=""
              id="openDrop"
            />
            <ul class="dropdown-menu">
              <li>
                <Link
                  class="dropdown-item"
                  :href="route('logout')"
                  method="post"
                  >LogOut</Link
                >
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>
<script>
import bootstrapBundle from "bootstrap/dist/js/bootstrap.bundle";
import userAvatar from "@/composables/userAvatar";
import { ref, onMounted } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

export default {
  components: {
    Link,
  },
  setup() {
    let avatar = ref(null);
    let drop = ref(null);
    const sidebarOpen = () => {
      const mainSidebar = document.querySelector(".main-sidebar");
      mainSidebar.classList.add("sidebar-open");
    };

    onMounted(() => {
      drop.value = new bootstrapBundle.Dropdown("#openDrop");

      avatar.value = userAvatar(usePage().props.auth.user.avatar);
    });

    const openDropdown = () => {
      drop.value.toggle();
    };

    return {
      sidebarOpen,
      openDropdown,
      avatar,
    };
  },
};
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
