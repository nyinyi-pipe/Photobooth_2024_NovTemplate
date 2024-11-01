<template>
  <div id="app">
    <div class="web-camera-container">
      <div class="camera-button">
        <button
          type="button"
          class="button is-rounded"
          :class="{ 'is-primary': !isCameraOpen, 'is-danger': isCameraOpen }"
          @click="toggleCamera"
        >
          <span v-if="!isCameraOpen">Open Camera</span>
          <span v-else>Close Camera</span>
        </button>
      </div>

      <div v-show="isCameraOpen && isLoading" class="camera-loading">
        <ul class="loader-circle">
          <li></li>
          <li></li>
          <li></li>
        </ul>
      </div>

      <div
        v-if="isCameraOpen"
        v-show="!isLoading"
        class="camera-box"
        :class="{ flash: isShotPhoto }"
      >
        <div class="camera-shutter" :class="{ flash: isShotPhoto }"></div>

        <video
          v-show="!isPhotoTaken"
          ref="camera"
          :width="450"
          :height="337.5"
          webkit-playsinline
          playsinline
          autoplay
        ></video>

        <canvas
          v-show="isPhotoTaken"
          id="photoTaken"
          ref="canvas"
          :width="450"
          :height="337.5"
        ></canvas>
      </div>

      <div v-if="isCameraOpen && !isLoading" class="camera-shoot">
        <button type="button" class="button" @click="takePhoto">
          <img
            src="https://img.icons8.com/material-outlined/50/000000/camera--v2.png"
          />
        </button>
      </div>

      <div v-if="isPhotoTaken && isCameraOpen" class="camera-download">
        <a
          id="downloadPhoto"
          download="my-photo.jpg"
          class="button"
          role="button"
          @click="downloadImage"
        >
          Download
        </a>
      </div>
    </div>
     <div class="container">
        <h1 class="d-print-none">test</h1>
        <a
          id="downloadPhoto"
          download="my-photo.jpg"
          class="button"
          role="button"
          @click="downloadImage"
        >
          Download
        </a>
        <div
          ref="layoutContainer"
          id="layoutContainer"
          class="d-flex flex-wrap mx-auto"
        >
          <canvas id="my-canvas" width="576" height="384"></canvas>
        </div>
      </div>
  </div>
</template>

<script>
export default {
  name: "Camera",
  data() {
    return {
      photos: [],
      isCameraOpen: false,
      isPhotoTaken: false,
      isShotPhoto: false,
      isLoading: false,
      cameraType: "environment",
      link: "#",
      _selectedDeviceId: "",
      _facingMode: "user",
       sixToFour: false,
      twoToSix: false,
    };
  },

  methods: {
    c4_layout() {
      this.sixToFour = true;
      this.twoToSix = true;
      this.$refs.layoutContainer.style.backgroundColor = "black";
      this.$refs.layoutContainer.style.width = "576px";
      this.$refs.layoutContainer.style.height = "384px";

      const thank = document.createElement("div");
      thank.classList.add("text-info", "m-3");
      thank.innerText = "© 2023 , made with ❤️ by GENI";

      const layout = document.getElementById("layoutContainer");
      layout.innerHTML = "";
      this.photos.forEach((photo) => {
        const img = new Image();
        img.src = photo;
        img.classList.add("img-thumbnail");
        img.style.width = "288px";
        img.style.height = "192px";
        layout.append(img);
        layout.append(thank);
      });
    },
    c2_layout() {
      const getContext = () =>
        document.getElementById("my-canvas").getContext("2d");

      // It's better to use async image loading.
      const loadImage = (url) => {
        return new Promise((resolve, reject) => {
          const img = new Image();
          img.onload = () => resolve(img);
          img.onerror = () => reject(new Error(`load ${url} fail`));
          img.src = url;
        });
      };

      // Here, I created a function to draw image.
      const depict = (options) => {
        const ctx = getContext();
        // And this is the key to this solution
        // Always remember to make a copy of original object, then it just works :)
        const myOptions = Object.assign({}, options);
        return loadImage(myOptions.uri).then((img) => {
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
          uri: this.photos[0],
          x: 0,
          y: 0,
          sw: 286,
          sh: 190,
        },
        {
          uri: this.photos[1],
          x: 290,
          y: 0,
          sw: 286,
          sh: 190,
        },
        {
          uri: this.photos[2],
          x: 0,
          y: 194,
          sw: 286,
          sh: 190,
        },

        {
          uri: this.photos[3],
          x: 290,
          y: 194,
          sw: 288,
          sh: 190,
        },
      ];

      imgs.forEach(depict);
    },
    getMediaConstraints() {
      var videoConstraints = {};
      if (this._selectedDeviceId == "") {
        videoConstraints.facingMode = this._facingMode;
      } else {
        videoConstraints.deviceId = { exact: this._selectedDeviceId };
      }
      var constraints = {
        video: videoConstraints,
        audio: false,
      };
      return constraints;
    },
    toggleCamera() {
      if (this.isCameraOpen) {
        this.isCameraOpen = false;
        this.isPhotoTaken = false;
        this.isShotPhoto = false;
        this.stopCameraStream();
      } else {
        this.isCameraOpen = true;
        this.createCameraElement();
      }
    },

    createCameraElement() {
      this.isLoading = true;

      const constraints = (window.constraints = {
        audio: false,
        video: {
          facingMode: { exact: "environment" },
        },
      });

      navigator.mediaDevices
        .getUserMedia(this.getMediaConstraints())
        .then((stream) => {
          this.isLoading = false;
          this.$refs.camera.srcObject = stream;
        })
        .catch((error) => {
          this.isLoading = false;
          alert("May the browser didn't support or there is some errors.");
          console.log(error);
        });
    },

    stopCameraStream() {
      let tracks = this.$refs.camera.srcObject.getTracks();

      tracks.forEach((track) => {
        track.stop();
      });
    },

    takePhoto() {
      if (this.photos.length !== 4) {
        if (!this.isPhotoTaken) {
          this.isShotPhoto = true;

          const FLASH_TIMEOUT = 50;

          setTimeout(() => {
            this.isShotPhoto = false;
          }, FLASH_TIMEOUT);
        }

        this.isPhotoTaken = !this.isPhotoTaken;

        const context = this.$refs.canvas.getContext("2d");
        context.drawImage(this.$refs.camera, 0, 0, 450, 337.5);

        this.photos.push(this.$refs.canvas.toDataURL("image/jpeg"));

        if (this.sixToFour) {
          this.c4_layout();
        } else {
          this.c2_layout();
        }

      } else {
        alert("not");
      }
    },

      downloadImage() {
      const download = document.getElementById("downloadPhoto");
      const canvas = document
        .getElementById("my-canvas")
        .toDataURL("image/jpeg")
        .replace("image/jpeg", "image/octet-stream");
      download.setAttribute("href", canvas);
    },
  },
};
</script>

<style scoped>
.web-camera-container {
  margin-top: 2rem;
  margin-bottom: 2rem;
  padding: 2rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 500px;
}
.web-camera-container .camera-button {
  margin-bottom: 2rem;
}
.web-camera-container .camera-box .camera-shutter {
  opacity: 0;
  width: 450px;
  height: 337.5px;
  background-color: #fff;
  position: absolute;
}
.web-camera-container .camera-box .camera-shutter.flash {
  opacity: 1;
}
.web-camera-container .camera-shoot,
.web-camera-container .change-camera-type {
  margin: 1rem 0;
}
.web-camera-container .camera-shoot button,
.web-camera-container .change-camera-type button {
  height: 60px;
  width: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 100%;
}
.web-camera-container .camera-shoot button img,
.web-camera-container .change-camera-type button img {
  height: 35px;
  object-fit: cover;
}
.web-camera-container .camera-loading {
  overflow: hidden;
  height: 100%;
  position: absolute;
  width: 100%;
  min-height: 150px;
  margin: 3rem 0 0 -1.2rem;
}
.web-camera-container .camera-loading ul {
  height: 100%;
  position: absolute;
  width: 100%;
  z-index: 999999;
  margin: 0;
}
.web-camera-container .camera-loading .loader-circle {
  display: block;
  height: 14px;
  margin: 0 auto;
  top: 50%;
  left: 100%;
  transform: translateY(-50%);
  transform: translateX(-50%);
  position: absolute;
  width: 100%;
  padding: 0;
}
.web-camera-container .camera-loading .loader-circle li {
  display: block;
  float: left;
  width: 10px;
  height: 10px;
  line-height: 10px;
  padding: 0;
  position: relative;
  margin: 0 0 0 4px;
  background: #999;
  animation: preload 1s infinite;
  top: -50%;
  border-radius: 100%;
}
.web-camera-container .camera-loading .loader-circle li:nth-child(2) {
  animation-delay: 0.2s;
}
.web-camera-container .camera-loading .loader-circle li:nth-child(3) {
  animation-delay: 0.4s;
}
@keyframes preload {
  0% {
    opacity: 1;
  }
  50% {
    opacity: 0.4;
  }
  100% {
    opacity: 1;
  }
}
</style>