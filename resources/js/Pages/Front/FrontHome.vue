<template>
  <div style="background-color: #b5b3b3" class="px-lg-3">
    <Head title="FOTOAUTOMAT" />
    <div class="container-fluid position-relative py-3 vh-100 home-container">
      <FontNav />
      <div v-for="image of images">
        <div>
          <h3 class="mb-0 img-text">photobooth</h3>
          <div class="img-container">
            <img
              class="home-img"
              src="https://i.pinimg.com/236x/f5/70/46/f57046f248a584eefb87a63235e0cae5.jpg"
              alt=""
            />
            <img
              class="home-img"
              src="https://i.pinimg.com/236x/9e/30/40/9e3040c29946239e2a8df6178f2457f7.jpg"
              alt=""
            />
          </div>
        </div>
      </div>
      <div class="home-title">
        <h1 class="text1 text-white">FOTO</h1>
        <!-- <img src="path/to/your/animated.gif" alt="Animated GIF" /> -->
        <img src="https://i.gifer.com/3vIF.mp4" alt="Bunny">
        <h1 class="text2" style="color: #000">AUTOMAT</h1>
      </div>
    </div>
    <footer>
      <p class="footer">
        © 2023
        <a class="footer-link" href="https://geni.technology" target="_blank">
          GENI
        </a>
      </p>
    </footer>
  </div>
</template>

<script>
import FontNav from "@/Components/front/Nav.vue";
import { Head } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
export default {
  components: {
    FontNav,
    Head,
  },
  setup() {
    let images = ref([]);
    onMounted(() => {
      images.value = Array(20).fill(0);
    });
    return {
      images,
    };
  },
};
</script>

<style scoped>
.home-title {
  position: absolute;
  top: 0;
  margin-top: 9%;
  display: flex;
}

.home-title .text1 {
  font-family: "Gill";
  font-size: 11rem;
}

.home-title .text2 {
  font-size: 11rem;
  font-family: "TheRumor";
  transform: translate(-45px) rotate(-14deg);
  display: block;
}

.home-container {
  display: flex;
  flex-wrap: wrap;
  gap: 40px;
  justify-content: center;
  overflow: hidden;
}

.img-text {
  font-family: "Gill";
  transform: translate(40px, 0px);
  color: #e1e1e1;
}

.img-container {
  display: flex;
  flex-wrap: wrap;
  gap: 40px;
  /* justify-content: center; */
  overflow: hidden;
}

.home-img {
  height: 110px;
  width: 73px;
  border: 4px solid black;
}

@media only screen and (max-width: 720px) {
  .home-title .text1 {
    font-size: 6rem;
  }

  .home-title .text2 {
    font-size: 6rem;
  }

  .home-title {
    margin-top: 15%;
  }
}

@media only screen and (min-width: 720px) and (max-width: 950px) {
  .home-title .text1 {
    font-size: 8rem;
  }

  .home-title .text2 {
    font-size: 8rem;
  }

  .home-title {
    margin-top: 10%;
  }
}

@media only screen and (min-width: 950px) and (max-width: 1115px) {
  .home-title .text1 {
    font-size: 9.5rem;
  }

  .home-title .text2 {
    font-size: 9.5rem;
  }

  .home-title {
    margin-top: 10%;
  }
}

.footer {
  font-size: 0.8rem;
  text-align: center;
  margin-bottom: 0;
}

.footer-link {
  color: #0c2242;
  font-weight: bold;
  text-decoration: none;
}
</style>
