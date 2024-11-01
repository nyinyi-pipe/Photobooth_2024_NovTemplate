<template>
  <Head title="Photo" />
  <div class="vh-100 d-flex justify-content-center align-items-center position-relative">
    <div class="photo-container">
      <a @click="download" download="photobooth.jpeg" id="download">
        <canvas
          style="cursor: pointer; background-color: white !important"
          id="my-canvas"
          width="384"
          height="576"
        ></canvas>
        <canvas
          style="cursor: pointer; display: none; background-color: white !important"
          id="canvas"
          width="384"
          height="576"
        ></canvas>
        <canvas
          style="cursor: pointer; display: none"
          id="print-canvas"
          width="384"
          height="576"
        ></canvas>
      </a>
    </div>
    <div class="logo-circle"></div>
    <img
      src="/images/Rabit-removebg.svg"
      width="65"
      height="65"
      class="d-none"
      id="logo"
      alt=""
    />
  </div>
</template>

<script>
import { Link, router, Head } from "@inertiajs/vue3";

export default {
  props: {
    photos: Object,
  },
  components: {
    Link,
    Head,
  },
  data() {
    return {
      
    };
  },

  methods: {
    download() {
      const canvas = document.getElementById("canvas");
      const dataURL = canvas
        .toDataURL("image/jpeg", 1.0)
        .replace("image/jpeg", "image/octet-stream");
      const downloadLink = document.getElementById("download");
      downloadLink.setAttribute("href", dataURL);

      window.onafterprint = () => {
        router.get("/photo/qrcode/" + this.photos.id);
      };
      window.print();
    },
    updateCanvas() {
      const logo = document.getElementById("logo");

      const getContext = (canvasId, scale) => {
        const canvas = document.getElementById(canvasId);
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
          img.onerror = () => reject(new Error(`load ${url} fail`));
          img.src = url;
        });
      };

      const depict = (options, ctx) => {
        const myOptions = Object.assign({}, options);
        return loadImage(myOptions.uri).then((img) => {
          ctx.fillStyle = "white"; 
          ctx.fillRect(0, 0, ctx.canvas.width / ctx.scale, ctx.canvas.height / ctx.scale);
          if (myOptions.color == "baw") {
            ctx.filter = "grayscale(100%)";
          }
          ctx.drawImage(img, myOptions.x, myOptions.y, myOptions.sw, myOptions.sh);
        });
      };

      const imgs = [
      {
        uri: this.photos.image[0],
        x: 12,
        y: 22,
        sw: 165,
        sh: 114,
        color: this.photos.filter,
      },
      {
        uri: this.photos.image[0],
        x: 207,
        y: 22,
        sw: 165,
        sh: 114,
        color: this.photos.filter,
      },
      {
        uri: this.photos.image[1],
        x: 12,
        y: 155,
        sw: 165,
        sh: 114,
        color: this.photos.filter,
      },
      {
        uri: this.photos.image[1],
        x: 207,
        y: 155,
        sw: 165,
        sh: 114,
        color: this.photos.filter,
      },

      {
        uri: this.photos.image[2],
        x: 12,
        y: 290,
        sw: 165,
        sh: 114,
        color: this.photos.filter,
      },
      {
        uri: this.photos.image[2],
        x: 207,
        y: 290,
        sw: 165,
        sh: 114,
        color: this.photos.filter,
      },
      {
        uri: this.photos.image[3],
        x: 12,
        y: 425,
        sw: 165,
        sh: 114,
        color: this.photos.filter,
      },
      {
        uri: this.photos.image[3],
        x: 207,
        y: 425,
        sw: 165,
        sh: 114,
        color: this.photos.filter,
      },
    ];

      const renderImages = (canvasId, scale) => {
        const ctx = getContext(canvasId, scale);
        ctx.fillStyle = "white";
        ctx.fillRect(0, 0, 384 * scale, 576 * scale);
        imgs.forEach((img) => depict(img, ctx));
        return ctx;
      };

      const showctx = renderImages("my-canvas", 2);
      const ctx = renderImages("canvas", 4);
      const printctx = renderImages("print-canvas", 4);

      const addText = (ctx) => {
        ctx.font = "13px ahronbd";
        ctx.fillStyle = "#000000";
        ctx.fillText("FOTOAUTOMAT", 48, 16);
        ctx.fillText("FOTOAUTOMAT", 243, 16);

        ctx.font = "15px Dancing Script";
        ctx.fillStyle = "#000000";
        ctx.fillText("Aung", 52, 555);
        ctx.fillText("Aung", 245, 555);

        ctx.fillText("&", 87, 556);
        ctx.fillText("&", 281, 556);

        ctx.fillText("Theint", 100, 556);
        ctx.fillText("Theint", 294, 556);

        ctx.font = "11px Dancing Script";
        ctx.fillText("June 3,2024", 70, 570);
        ctx.fillText("June 3,2024", 264, 570);
      };

      addText(showctx);
      addText(ctx);
      addText(printctx);
    },
  },

  created() {
    document.querySelectorAll("#pics").forEach((pic) => {
      pic.remove();
    });
  },

  mounted() {
    this.updateCanvas();
  },
};
</script>

<style>
@media print {
  #my-canvas,
  .logo-circle {
    display: none;
    background-color: white !important;
  }

  #canvas {
    background-color: white !important;
  }

  #print-canvas {
    display: block !important;
    background-color: white !important;
  }
}

@page {
  size: portrait;
  margin: 0;
}

@page {
  size: 4in 6in;
}
</style>
