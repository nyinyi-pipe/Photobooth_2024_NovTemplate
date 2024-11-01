<template>
  <div class="container py-3">
    <div class="row g-3 justify-content-center">
      <div class="col-12 col-md-6">
        <div class="bg-white p-2 d-inline-block rounded-3">
          <canvas id="my-canvas" width="384" height="576"></canvas>
          <a
            download="photobooth.jpeg"
            id="download"
            @click="download"
            class="mt-3 d-block w-100 btn btn-sm btn-outline-primary"
          >
            Print
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props:{
    photos:Object
  },
  methods: {
    download() {
      const download = document.getElementById("download");
      const canvas = document
        .getElementById("my-canvas")
        .toDataURL("image/jpeg")
        .replace("image/jpeg", "image/octet-stream");
      download.setAttribute("href", canvas);
    },
  },
  mounted() {
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
       if(myOptions.color == 'baw'){
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
        uri:this.photos.image[0],
        x: 0,
        y: 0,
        sw: 191,
        sh: 143,
        color:this.photos.filter,
      },
      {
        uri:this.photos.image[0],
        x: 195,
        y: 0,
        sw: 191,
        sh: 143,
        color:this.photos.filter,
      },
      {
        uri:this.photos.image[1],
        x: 0,
        y: 145,
        sw: 191,
        sh: 143,
        color:this.photos.filter,
      },

      {
        uri:this.photos.image[1],
        x: 194,
        y: 145,
        sw: 191,
        sh: 143,
        color:this.photos.filter,
      },
      {
        uri:this.photos.image[2],
        x: 0,
        y: 290,
        sw: 191,
        sh: 143,
        color:this.photos.filter,
      },
      {
        uri:this.photos.image[2],
        x: 194,
        y: 290,
        sw: 191,
        sh: 143,
        color:this.photos.filter,
      },
      {
        uri:this.photos.image[3],
        x: 0,
        y: 435,
        sw: 191,
        sh: 143,
        color:this.photos.filter,
      },
      {
        uri:this.photos.image[3],
        x: 194,
        y: 435,
        sw: 191,
        sh: 143,
        color:this.photos.filter,
      },
    ];

    imgs.forEach(depict);
  },
};
</script>

<style>
</style>