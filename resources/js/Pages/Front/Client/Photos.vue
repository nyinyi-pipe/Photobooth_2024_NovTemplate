<template>

  <Head title="Photo" />
  
  <div class="vh-100 d-flex justify-content-center align-items-center position-relative">
    <div class="" v-if="template[0]?.template">
      <div class="text-center fs-5 ">This is preview page.</div>
      <div class="pt-1">
        <a @click="download" download="photobooth.jpeg" id="download" class="d-print-block">
          <canvas style="cursor: pointer" id="my-canvas-white" width="384" height="576"></canvas>
        </a>
        <a v-if="template[0]?.template" @click="download" download="photobooth.jpeg" id="downloadcustom"
          class="d-print-none">
          <canvas
            :style="{ cursor: 'pointer', backgroundImage: 'url(' + 'storage/' + template[0]?.template + ')', backgroundSize: 'cover' }"
            id="my-canvas-custom" width="384" height="576">
          </canvas>
        </a>
        <a @click="download" download="photobooth.jpeg" id="downloadblack" class="d-print-none">
          <canvas style="cursor: pointer" id="my-canvas-black" width="384" height="576"></canvas>
        </a>
      </div>
      
    </div>


    <NoTemplateText v-else />

    <div class="logo-circle"></div>
    <img src="/images/Rabit-removebg.svg" width="65" height="65" class="hidden d-none" id="logo" alt="" />
    <img src="/images/Rabit-removebg-white.svg" width="65" height="65" class="hidden d-none" id="logo-white" alt="" />
    <div class="logout-circle">
      <Link :href="route('logout')" class="text-dark" method="post">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
        style="fill: rgba(0, 0, 0, 1); transform: msfilter">
        <path d="M16 13v-2H7V8l-5 4 5 4v-3z"></path>
        <path
          d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z">
        </path>
      </svg>
      </Link>
    </div>
  </div>
</template>

<script>
import Swal from 'sweetalert2'
import { Link, router, Head } from "@inertiajs/vue3";
import NoTemplateText from '@/Components/NoTemplateText.vue';

export default {
  components: {
    NoTemplateText
  },
  props: {
    template: Object,
    photos: Object,
  },
  data() {
    return {
      errors: {},
      isCustomTemplate: false,
      photoCount: 3,
    };
  },
  components: {
    Link,
    Head,
  },
  methods: {
    download(e) {
      if (e.target.id == "my-canvas-white") {
        router.get("/photos/" + this.photos.id, { theme: "white", photoCount: this.photoCount });
      } else if (e.target.id == "my-canvas-custom") {
        router.get("/photos/" + this.photos.id, { theme: "custom", photoCount: this.photoCount });
      } else {
        router.get("/photos/" + this.photos.id, { theme: "black", photoCount: this.photoCount });
      }
    },
    updateCanvas() {
      const getContext = (canvasId) => {
        const canvas = document.getElementById(canvasId);
        const scale = 2;
        canvas.width = 384 * scale;
        canvas.height = 576 * scale;
        canvas.style.width = "384px";
        canvas.style.height = "576px";
        const ctx = canvas.getContext("2d");
        ctx.scale(scale, scale);
        return ctx;
      };

      const loadImage = (url) => {
        return new Promise((resolve, reject) => {
          const img = new Image();
          img.crossOrigin = "Anonymous";
          img.onload = () => resolve(img);
          img.onerror = () => reject(new Error(`Load ${url} failed`));
          img.src = url;
        });
      };

      const depict = (ctx, options) => {
        return loadImage(options.uri).then((img) => {
          if (options.color === "baw") {
            ctx.filter = "grayscale(100%)";
          }
          ctx.drawImage(
            img,
            options.x,
            options.y,
            options.sw,
            options.sh
          );
        });
      };

      // const imgs = [
      //   {
      //     uri: this.photos.image[0],
      //     x: 12,
      //     y: 22,
      //     sw: 165,
      //     sh: 114,
      //     color: this.photos.filter,
      //   },
      //   {
      //     uri: this.photos.image[0],
      //     x: 207,
      //     y: 22,
      //     sw: 165,
      //     sh: 114,
      //     color: this.photos.filter,
      //   },
      //   {
      //     uri: this.photos.image[1],
      //     x: 12,
      //     y: 155,
      //     sw: 165,
      //     sh: 114,
      //     color: this.photos.filter,
      //   },
      //   {
      //     uri: this.photos.image[1],
      //     x: 207,
      //     y: 155,
      //     sw: 165,
      //     sh: 114,
      //     color: this.photos.filter,
      //   },
      //   {
      //     uri: this.photos.image[2],
      //     x: 12,
      //     y: 290,
      //     sw: 165,
      //     sh: 114,
      //     color: this.photos.filter,
      //   },
      //   {
      //     uri: this.photos.image[2],
      //     x: 207,
      //     y: 290,
      //     sw: 165,
      //     sh: 114,
      //     color: this.photos.filter,
      //   },
      //   {
      //     uri: this.photos.image[3],
      //     x: 12,
      //     y: 425,
      //     sw: 165,
      //     sh: 114,
      //     color: this.photos.filter,
      //   },
      //   {
      //     uri: this.photos.image[3],
      //     x: 207,
      //     y: 425,
      //     sw: 165,
      //     sh: 114,
      //     color: this.photos.filter,
      //   }
      // ];

      const imgsCustom = [
        {
          uri: this.photos.image[0],
          x: 12,
          y: 15,
          sw: 165,
          sh: 114,
          color: this.photos.filter,
        },
        {
          uri: this.photos.image[0],
          x: 207,
          y: 15,
          sw: 165,
          sh: 114,
          color: this.photos.filter,
        },
        {
          uri: this.photos.image[1],
          x: 12,
          y: 140,
          sw: 165,
          sh: 114,
          color: this.photos.filter,
        },
        {
          uri: this.photos.image[1],
          x: 207,
          y: 140,
          sw: 165,
          sh: 114,
          color: this.photos.filter,
        },
        {
          uri: this.photos.image[2],
          x: 12,
          y: 265,
          sw: 165,
          sh: 114,
          color: this.photos.filter,
        },
        {
          uri: this.photos.image[2],
          x: 207,
          y: 265,
          sw: 165,
          sh: 114,
          color: this.photos.filter,
        },
        {
          uri: this.photos.image[3],
          x: 12,
          y: 390,
          sw: 165,
          sh: 114,
          color: this.photos.filter,
        },
        {
          uri: this.photos.image[3],
          x: 207,
          y: 390,
          sw: 165,
          sh: 114,
          color: this.photos.filter,
        }
      ];

      // const showctx = getContext("my-canvas-white");

      // const showctxbl = getContext("my-canvas-black");

      // imgs.forEach((img) => depict(showctx, img));
      // imgs.forEach((img) => depict(showctxbl, img));

      if (this.template[0]?.template) {
        const showctxcus = getContext("my-canvas-custom");
        imgsCustom.forEach((img) => depict(showctxcus, img));

      }


      // showctx.font = "13px ahronbd";
      // showctx.fillStyle = "#000000";
      // showctx.fillText("FOTOAUTOMAT", 48, 16);
      // showctx.fillText("FOTOAUTOMAT", 243, 16);

      // showctxbl.font = "13px ahronbd";
      // showctxbl.fillStyle = "#ffffff";
      // showctxbl.fillText("FOTOAUTOMAT", 48, 16);
      // showctxbl.fillText("FOTOAUTOMAT", 243, 16);

      // showctx.font = "15px Dancing Script";
      // showctx.fillStyle = "#000000";
      // showctx.fillText("Aung", 52, 555);
      // showctx.fillText("Aung", 245, 555);

      // showctx.fillText("&", 87, 556);
      // showctx.fillText("&", 281, 556);

      // showctx.fillText("Theint", 100, 556);
      // showctx.fillText("Theint", 294, 556);

      // showctx.font = "11px Dancing Script";
      // showctx.fillText("June 3,2024", 70, 570);
      // showctx.fillText("June 3,2024", 264, 570);

      // showctxbl.font = "15px Dancing Script";
      // showctxbl.fillStyle = "#ffffff";
      // showctxbl.fillText("Aung", 52, 555);
      // showctxbl.fillText("Aung", 245, 555);

      // showctxbl.fillText("&", 87, 555);
      // showctxbl.fillText("&", 281, 555);

      // showctxbl.fillText("Theint", 100, 555);
      // showctxbl.fillText("Theint", 294, 555);

      // showctxbl.font = "11px Dancing Script";
      // showctxbl.fillText("June 3,2024", 70, 570);
      // showctxbl.fillText("June 3,2024", 264, 570);
    },
  },
  mounted() {
    this.updateCanvas();



  },
  created() {

  },
};
</script>

<style>
@page {
  size: portrait;
  margin: 0;
}

@page {
  size: 4in 6in;
}

#my-canvas-white {
  background-color: white;
  display: none !important;
}

.photo-selection {
  position: absolute;
  top: 10px;
  display: flex;
  gap: 10px;
}


#my-canvas-black {
  background-color: black;
  display: none !important;
}
</style>
