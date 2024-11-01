<template>
  <Head title="Photo" />
  <div
    class="vh-100 d-flex justify-content-center align-items-center position-relative"
  >
    <div class="photo-container">
      <a @click="download" download="photobooth.jpeg" id="download">
        <canvas
          style="cursor: pointer"
          id="my-canvas"
          width="384"
          height="576"
        ></canvas>
        <canvas
          style="cursor: pointer; display: none"
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
      src="/images/Rabit-removebg-white.svg"
      width="65"
      height="65"
      class="hidden d-none"
      id="logo-white"
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

  methods: {
    download() {
      window.onafterprint = () => {
        router.get("/photo/qrcode/" + this.photos.id);
      };
      window.print();
      const download = document.getElementById("download");
      const canvas = document
        .getElementById("canvas")
        .toDataURL("image/jpeg")
        .replace("image/jpeg", "image/octet-stream");
      download.setAttribute("href", canvas);
    },
  },

  created() {
    document.querySelectorAll("#pics").forEach((pic) => {
      pic.remove();
    });
  },
  mounted() {
    const logoWh = document.getElementById("logo-white");

    const getContext = () =>
      document.getElementById("my-canvas").getContext("2d");

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
      const myOptions = Object.assign({}, options);
      return loadImage(myOptions.uri).then((img) => {
        if (myOptions.color == "baw") {
          ctx.filter = "grayscale(100%)";
        }
        ctx.drawImage(
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

    imgs.forEach(depict);

    const showctx = document.getElementById("my-canvas").getContext("2d");

    showctx.font = "13px ahronbd";
    showctx.fillStyle = "#ffffff";
    showctx.fillText("FOTOAUTOMAT", 48, 16);
    showctx.fillText("FOTOAUTOMAT", 243, 16);

    showctx.font = "15px Dancing Script";
    showctx.fillStyle = "#ffffff";
    showctx.fillText("Aung", 52, 555);
    showctx.fillText("Aung", 245, 555);

    showctx.fillText("&", 87, 556);
    showctx.fillText("&", 281, 556);

    showctx.fillText("Theint", 100, 556);
    showctx.fillText("Theint", 294, 556);

    showctx.font = "11px Dancing Script";
    showctx.fillText("June 3,2024", 70, 570);
    showctx.fillText("June 3,2024", 264, 570);

    const ctx = document.getElementById("canvas").getContext("2d");

    const downdepict = (options) => {
      const myOptions = Object.assign({}, options);
      return loadImage(myOptions.uri).then((img) => {
        if (myOptions.color == "baw") {
          ctx.filter = "grayscale(100%)";
        }
        ctx.drawImage(
          img,
          myOptions.x,
          myOptions.y,
          myOptions.sw,
          myOptions.sh
        );
      });
    };

    imgs.forEach(downdepict);

    ctx.font = "13px ahronbd";
    ctx.fillStyle = "#ffffff";
    ctx.fillText("FOTOAUTOMAT", 48, 16);
    ctx.fillText("FOTOAUTOMAT", 243, 16);

    ctx.font = "15px Dancing Script";
    ctx.fillStyle = "#ffffff";
    ctx.fillText("Aung", 52, 555);
    ctx.fillText("Aung", 245, 555);

    ctx.fillText("&", 87, 556);
    ctx.fillText("&", 281, 556);

    ctx.fillText("Theint", 100, 556);
    ctx.fillText("Theint", 294, 556);

    ctx.font = "11px Dancing Script";
    ctx.fillText("June 3,2024", 70, 570);
    ctx.fillText("June 3,2024", 264, 570);

    const printctx = document.getElementById("print-canvas").getContext("2d");

    const printdepict = (options) => {
      const myOptions = Object.assign({}, options);
      return loadImage(myOptions.uri).then((img) => {
        if (myOptions.color == "baw") {
          printctx.filter = "grayscale(100%)";
        }
        printctx.drawImage(
          img,
          myOptions.x,
          myOptions.y,
          myOptions.sw,
          myOptions.sh
        );
      });
    };

    imgs.forEach(printdepict);
    printctx.fillStyle = "black";
    printctx.fillRect(0, 0, printctx.canvas.width, printctx.canvas.height);

    printctx.font = "13px ahronbd";
    printctx.fillStyle = "#ffffff";
    printctx.fillText("FOTOAUTOMAT", 48, 16);
    printctx.fillText("FOTOAUTOMAT", 243, 16);

    printctx.font = "15px Dancing Script";
    printctx.fillStyle = "#ffffff";
    printctx.fillText("Aung", 52, 555);
    printctx.fillText("Aung", 245, 555);

    printctx.fillText("&", 87, 556);
    printctx.fillText("&", 281, 556);

    printctx.fillText("Theint", 100, 556);
    printctx.fillText("Theint", 294, 556);

    printctx.font = "11px Dancing Script";
    printctx.fillText("June 3,2024", 70, 570);
    printctx.fillText("June 3,2024", 264, 570);
  },
};
</script>

      <style>
@media print {
  #my-canvas,
  .logo-circle {
    display: none;
  }

  #print-canvas {
    display: block !important;
  }
}

@page {
  size: portrait;
  margin: 0;
}

@page {
  size: 4in 6in;
}
canvas {
  background-color: black;
}
</style>
