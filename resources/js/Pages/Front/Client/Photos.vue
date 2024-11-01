<template>
  <Head title="Photo" />
  <div
    class="vh-100 d-flex justify-content-center align-items-center position-relative"
  >
    <div class="photo-container">
      <a
        @click="download"
        download="photobooth.jpeg"
        id="download"
        class="d-print-block"
      >
        <canvas
          style="cursor: pointer"
          id="my-canvas-white"
          width="384"
          height="576"
        ></canvas>
      </a>
      <a
        @click="download"
        download="photobooth.jpeg"
        id="downloadblack"
        class="d-print-none"
      >
        <canvas
          style="cursor: pointer"
          id="my-canvas-black"
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
      class="hidden d-none"
      id="logo"
      alt=""
    />
    <img
      src="/images/Rabit-removebg-white.svg"
      width="65"
      height="65"
      class="hidden d-none"
      id="logo-white"
      alt=""
    />
    <div class="logout-circle">
      <Link :href="route('logout')" class="text-dark" method="post">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          style="fill: rgba(0, 0, 0, 1); transform: ; msfilter: "
        >
          <path d="M16 13v-2H7V8l-5 4 5 4v-3z"></path>
          <path
            d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z"
          ></path>
        </svg>
      </Link>
    </div>
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
    download(e) {
      if (e.target.id == "my-canvas-white") {
        router.get("/photos/" + this.photos.id, { theme: "white" });
      } else {
        router.get("/photos/" + this.photos.id, { theme: "black" });
      }
    },
  },

  created() {
    document.querySelectorAll("#pics").forEach((pic) => {
      pic.remove();
    });
  },
  mounted() {
    const logo = document.getElementById("logo");
    const logoWh = document.getElementById("logo-white");

    const getContext = () =>
      document.getElementById("my-canvas-white").getContext("2d");

    const getContextBlack = () =>
      document.getElementById("my-canvas-black").getContext("2d");

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

    const depictblack = (options) => {
      const ctx = getContextBlack();
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
    imgs.forEach(depictblack);

    const showctx = document.getElementById("my-canvas-white").getContext("2d");
    const showctxbl = document
      .getElementById("my-canvas-black")
      .getContext("2d");

    showctx.font = "13px ahronbd";
    showctx.fillStyle = "#000000";
    showctx.fillText("FOTOAUTOMAT", 48, 16);
    showctx.fillText("FOTOAUTOMAT", 243, 16);

    showctxbl.font = "13px ahronbd";
    showctxbl.fillStyle = "#ffffff";
    showctxbl.fillText("FOTOAUTOMAT", 48, 16);
    showctxbl.fillText("FOTOAUTOMAT", 243, 16);

    showctx.font = "15px Dancing Script";
    showctx.fillStyle = "#000000";
    showctx.fillText("Aung", 52, 555);
    showctx.fillText("Aung", 245, 555);

    showctx.fillText("&", 87, 556);
    showctx.fillText("&", 281, 556);

    showctx.fillText("Theint", 100, 556);
    showctx.fillText("Theint", 294, 556);

    showctx.font = "11px Dancing Script";
    showctx.fillText("June 3,2024", 70, 570);
    showctx.fillText("June 3,2024", 264, 570);

    showctxbl.font = "15px Dancing Script";
    showctxbl.fillStyle = "#ffffff";
    showctxbl.fillText("Aung", 52, 555);
    showctxbl.fillText("Aung", 245, 555);

    showctxbl.fillText("&", 87, 555);
    showctxbl.fillText("&", 281, 555);

    showctxbl.fillText("Theint", 100, 555);
    showctxbl.fillText("Theint", 294, 555);

    showctxbl.font = "11px Dancing Script";
    showctxbl.fillText("June 3,2024", 70, 570);
    showctxbl.fillText("June 3,2024", 264, 570);
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
}

#my-canvas-black {
  background-color: black;
}
</style>
