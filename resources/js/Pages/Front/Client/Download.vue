<template>
  <div class="container py-3 d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="bg-white p-2 rounded-3 text-center" v-if="template[0]?.template">
      <canvas class="canvas-background" style="cursor: pointer;" id="my-canvas" width="384" height="576"></canvas>

      <a download="photobooth.jpeg" id="download" @click="download"
        class="mt-3 btn btn-sm btn-outline-primary w-100 w-sm-auto">
        Print
      </a>
    </div>

    <NoTemplateText v-else />
  </div>
</template>



<script>
import NoTemplateText from '@/Components/NoTemplateText.vue';
import { template } from 'lodash';

export default {
  components: {
    NoTemplateText
  },
  props: {
    photos: Object,
    template: Array,
  },
  methods: {
    download() {
      const canvas = document.getElementById("my-canvas");
      const downloadLink = document.getElementById("download");
      const image = canvas.toDataURL("image/jpeg", 1.0);
      downloadLink.href = image;
    },
  },
  mounted() {
    console.log('====================================');
    console.log(this.template);
    console.log('====================================');
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
        img.onerror = () => reject(new Error(`Failed to load image: ${url}`));
        img.src = url;
      });
    };

    const depict = async (img, ctx) => {
      if (img.color === "baw") {
        ctx.filter = "grayscale(100%)";
      }
      const image = await loadImage(img.uri);
      ctx.drawImage(image, img.x, img.y, img.sw, img.sh);
      ctx.filter = "none";
    };

    let imgs = [
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

    const setBackgroundImage = async (canvasId) => {
      const canvas = document.getElementById(canvasId);
      const ctx = canvas.getContext("2d");
      const backgroundPath = `/storage/${this.template[0]?.template}`;

      
      if (this.template[0]?.template) {
        try {
          const backgroundImage = await loadImage(backgroundPath);

          const drawWidth = 384;
          const drawHeight = 576;
          const drawX = 0;
          const drawY = 0;
          ctx.drawImage(backgroundImage, drawX, drawY, drawWidth, drawHeight);
        } catch (error) {
          console.error('Error loading background image:', error);
         
          ctx.fillStyle = 'white';
          ctx.fillRect(0, 0, canvas.width, canvas.height);
        }
      } else {
        
        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
      }
    };


    const renderImages = async (canvasId, scale) => {
      const ctx = getContext(canvasId, scale);
      await setBackgroundImage(canvasId);
      for (const img of imgs) {
        await depict(img, ctx);
      }
      return ctx;
    };

    renderImages("my-canvas", 4);
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
</style>
