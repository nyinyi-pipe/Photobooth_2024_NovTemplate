<template>

  <Head title="Photo" />
  <div class="vh-100 d-flex justify-content-center align-items-center position-relative">
    <div v-if="isModalOpen" class="absolute top-0 bottom-44 modal-overlay">
      <div id="Container" class="vw-100 vh-100">
        <div id="rays">
          <svg fill="none" viewBox="0 0 299 152" height="9em" width="18em" xmlns="http://www.w3.org/2000/svg">
            <path fill="url(#paint0_linear_8_3)"
              d="M149.5 152H133.42L9.53674e-07 4.70132e-06H149.5L299 4.70132e-06L165.58 152H149.5Z"></path>
            <defs>
              <linearGradient gradientUnits="userSpaceOnUse" y2="12.1981" x2="150.12" y1="152" x1="149.5"
                id="paint0_linear_8_3">
                <stop stop-color="#00E0FF"></stop>
                <stop stop-opacity="0" stop-color="#65EDFF" offset="1"></stop>
              </linearGradient>
            </defs>
          </svg>
        </div>
        <div id="emiter">
          <svg fill="none" viewBox="0 0 160 61" height="61" width="160" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_di_1_38)">
              <path fill="#2B2B2B"
                d="M80 27.9997C121.974 27.9997 156 22.4032 156 15.4996L156 40.4998C156 47.4034 121.974 52.9998 80 52.9998C38.0265 52.9998 4.00028 47.4034 4 40.4998V40.4998V15.51C4.0342 22.4089 38.0474 27.9997 80 27.9997Z"
                clip-rule="evenodd" fill-rule="evenodd"></path>
            </g>
            <ellipse fill="url(#paint0_radial_1_38)" ry="4.80773" rx="28.3956" cy="17.4236" cx="80"></ellipse>
            <g filter="url(#filter1_i_1_38)">
              <path fill="#323232"
                d="M80 28.0002C121.974 28.0002 156 22.4037 156 15.5001C156 8.59648 121.974 3 80 3C38.0264 3 4 8.59648 4 15.5001C4 22.4037 38.0264 28.0002 80 28.0002ZM80.0001 20.308C96.1438 20.308 109.231 18.1555 109.231 15.5002C109.231 12.845 96.1438 10.6925 80.0001 10.6925C63.8564 10.6925 50.7693 12.845 50.7693 15.5002C50.7693 18.1555 63.8564 20.308 80.0001 20.308Z"
                clip-rule="evenodd" fill-rule="evenodd"></path>
            </g>
            <g filter="url(#filter2_di_1_38)">
              <path fill="#378BA6"
                d="M106.725 17.4505C108.336 16.8543 109.231 16.1943 109.231 15.4999C109.231 12.8446 96.1438 10.6921 80.0001 10.6921C63.8564 10.6921 50.7693 12.8446 50.7693 15.4999C50.7693 16.1943 51.6645 16.8543 53.2752 17.4504C53.275 17.4414 53.2748 17.4323 53.2748 17.4232C53.2748 14.768 65.2401 12.6155 80.0001 12.6155C94.7601 12.6155 106.725 14.768 106.725 17.4232C106.725 17.4323 106.725 17.4414 106.725 17.4505Z"
                clip-rule="evenodd" fill-rule="evenodd"></path>
            </g>
            <defs>
              <filter color-interpolation-filters="sRGB" filterUnits="userSpaceOnUse" height="45.5002" width="160"
                y="15.4996" x="0" id="filter0_di_1_38">
                <feFlood result="BackgroundImageFix" flood-opacity="0"></feFlood>
                <feColorMatrix result="hardAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" type="matrix"
                  in="SourceAlpha"></feColorMatrix>
                <feOffset dy="4"></feOffset>
                <feGaussianBlur stdDeviation="2"></feGaussianBlur>
                <feComposite operator="out" in2="hardAlpha"></feComposite>
                <feColorMatrix values="0 0 0 0 0.620833 0 0 0 0 0.620833 0 0 0 0 0.620833 0 0 0 0.25 0" type="matrix">
                </feColorMatrix>
                <feBlend result="effect1_dropShadow_1_38" in2="BackgroundImageFix" mode="normal"></feBlend>
                <feBlend result="shape" in2="effect1_dropShadow_1_38" in="SourceGraphic" mode="normal"></feBlend>
                <feColorMatrix result="hardAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" type="matrix"
                  in="SourceAlpha"></feColorMatrix>
                <feOffset></feOffset>
                <feGaussianBlur stdDeviation="8"></feGaussianBlur>
                <feComposite k3="1" k2="-1" operator="arithmetic" in2="hardAlpha"></feComposite>
                <feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 1 0" type="matrix"></feColorMatrix>
                <feBlend result="effect2_innerShadow_1_38" in2="shape" mode="normal"></feBlend>
              </filter>
              <filter color-interpolation-filters="sRGB" filterUnits="userSpaceOnUse" height="25.0002" width="152" y="3"
                x="4" id="filter1_i_1_38">
                <feFlood result="BackgroundImageFix" flood-opacity="0"></feFlood>
                <feBlend result="shape" in2="BackgroundImageFix" in="SourceGraphic" mode="normal"></feBlend>
                <feColorMatrix result="hardAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" type="matrix"
                  in="SourceAlpha"></feColorMatrix>
                <feMorphology result="effect1_innerShadow_1_38" in="SourceAlpha" operator="erode" radius="3">
                </feMorphology>
                <feOffset></feOffset>
                <feGaussianBlur stdDeviation="6.5"></feGaussianBlur>
                <feComposite k3="1" k2="-1" operator="arithmetic" in2="hardAlpha"></feComposite>
                <feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 1 0" type="matrix"></feColorMatrix>
                <feBlend result="effect1_innerShadow_1_38" in2="shape" mode="normal"></feBlend>
              </filter>
              <filter color-interpolation-filters="sRGB" filterUnits="userSpaceOnUse" height="26.7583" width="78.4615"
                y="0.692139" x="40.7693" id="filter2_di_1_38">
                <feFlood result="BackgroundImageFix" flood-opacity="0"></feFlood>
                <feColorMatrix result="hardAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" type="matrix"
                  in="SourceAlpha"></feColorMatrix>
                <feMorphology result="effect1_dropShadow_1_38" in="SourceAlpha" operator="dilate" radius="2">
                </feMorphology>
                <feOffset></feOffset>
                <feGaussianBlur stdDeviation="4"></feGaussianBlur>
                <feComposite operator="out" in2="hardAlpha"></feComposite>
                <feColorMatrix values="0 0 0 0 0 0 0 0 0 0.941176 0 0 0 0 1 0 0 0 1 0" type="matrix"></feColorMatrix>
                <feBlend result="effect1_dropShadow_1_38" in2="BackgroundImageFix" mode="color-dodge"></feBlend>
                <feBlend result="shape" in2="effect1_dropShadow_1_38" in="SourceGraphic" mode="normal"></feBlend>
                <feColorMatrix result="hardAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" type="matrix"
                  in="SourceAlpha"></feColorMatrix>
                <feMorphology result="effect2_innerShadow_1_38" in="SourceAlpha" operator="erode" radius="1">
                </feMorphology>
                <feOffset></feOffset>
                <feGaussianBlur stdDeviation="2"></feGaussianBlur>
                <feComposite k3="1" k2="-1" operator="arithmetic" in2="hardAlpha"></feComposite>
                <feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.52 0" type="matrix"></feColorMatrix>
                <feBlend result="effect2_innerShadow_1_38" in2="shape" mode="normal"></feBlend>
              </filter>
              <radialGradient gradientTransform="translate(80 17.4236) rotate(90) scale(6.25004 36.9143)"
                gradientUnits="userSpaceOnUse" r="1" cy="0" cx="0" id="paint0_radial_1_38">
                <stop stop-color="#00FFF0"></stop>
                <stop stop-color="#001AFF" offset="0.901042"></stop>
              </radialGradient>
            </defs>
          </svg>
        </div>
      </div>
    </div>

    <div v-if="template[0]?.template" class="photo-container">
      <div class="canvas-text">This is preview page</div>
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

    <NoTemplateText v-else/>

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
  components:{
    NoTemplateText
  },
  props: {
    template: Object,
    photos: Object,
  },
  data() {
    return {
      errors: {},
      isModalOpen: false,
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

.canvas-text {
  position: absolute;
  top: 10%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-family: Arial, sans-serif;
  font-size: 20px;
  font-weight: bold;
  color: #333;
}
</style>
