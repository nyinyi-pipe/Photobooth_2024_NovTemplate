<template>
  <Head title="Photo" />
  <ClientLayout>
    <div
      class="py-2 vh-100 bg-white position-relative d-flex justify-content-center gap-5 align-items-center"
    >
      <div>
        <div class="bg-dark p-2 d-flex flex-column">
          <canvas
            @click="filter('normal')"
            id="normal"
            width="192"
            height="576"
          ></canvas>
        </div>
        <div>
          <h1 class="mb-0 text-center fw-bold">COLOR</h1>
        </div>
      </div>
      <div>
        <div class="bg-dark p-2 d-flex flex-column">
          <canvas
            @click="filter('baw')"
            id="BAW"
            width="192"
            height="576"
          ></canvas>
        </div>
        <div>
          <h1 class="mb-0 text-center fw-bold">B&W</h1>
        </div>
      </div>
      <div class="logo-circle"></div>
    </div>
  </ClientLayout>
</template>

<script>
import { onMounted, onBeforeMount } from "vue";
import { router } from "@inertiajs/vue3";
import ClientLayout from "@/Components/client/Layout/ClientLayout.vue";

export default {
  props: {
    photos: Object,
  },
  components: {
    ClientLayout,
  },
  setup({ photos }) {
    const filter = (color) => {
      router.patch("/photo/filter", { id: photos.id, filter: color });
    };
    onBeforeMount(() => {
      document.querySelectorAll("#pics").forEach((pic) => {
        pic.remove();
      });
    });
    onMounted(() => {
      const getContext = () =>
        document.getElementById("normal").getContext("2d");
      const getBAW = () => document.getElementById("BAW").getContext("2d");

      const loadImage = (url) => {
        return new Promise((resolve, reject) => {
          const img = new Image();
          img.crossOrigin = "Anonymous";
          img.onload = () => resolve(img);
          img.onerror = () => reject(new Error(`load ${url} fail`));
          img.src = url;
        });
      };

      const depict = (options) => {
        const ctx = getContext();
        const baw = getBAW();
        const myOptions = Object.assign({}, options);
        return loadImage(myOptions.uri).then((img) => {
          ctx.drawImage(
            img,
            myOptions.x,
            myOptions.y,
            myOptions.sw,
            myOptions.sh
          );

          baw.filter = "grayscale(100%) ";
          baw.drawImage(
            img,
            myOptions.x,
            myOptions.y,
            myOptions.sw,
            myOptions.sh
          );
        });
      };

      const imgs = [
        {
          uri: photos.image[0],
          x: 0,
          y: 0,
          sw: 192,
          sh: 142,
        },

        {
          uri: photos.image[1],
          x: 0,
          y: 145,
          sw: 192,
          sh: 142,
        },

        {
          uri: photos.image[2],
          x: 0,
          y: 290,
          sw: 192,
          sh: 142,
        },

        {
          uri: photos.image[3],
          x: 0,
          y: 435,
          sw: 192,
          sh: 142,
        },
      ];

      imgs.forEach(depict);
    });

    return {
      filter,
    };
  },
};
</script>

<style scoped>
canvas {
  cursor: pointer;
}
</style>
