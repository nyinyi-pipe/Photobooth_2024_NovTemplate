<template>
  <div
    class="vh-100 d-flex justify-content-center align-items-center"
    v-if="!isCameraOpen"
  >
    <div class="mb-2">
      <button class="btn btn-sm btn-outline-warning" @click="toggleCamera">
        <span>Start</span>
      </button>
    </div>
  </div>
  <div v-if="isCameraOpen" class="vh-100 position-fixed start-0">
    <div class="counting" v-show="countText">
      <h1 class="text-white counting-text" ref="timeText"></h1>
    </div>

    <video src="" ref="camera" autoplay></video>
    <canvas
      v-show="isPhotoTaken"
      id="photoTaken"
      ref="canvas"
      :width="450"
      :height="337.5"
    ></canvas>

    <div class="p-3 camera-menu">
      <i
        class="bi bi-camera-fill text-white fs-2"
        ref="cameraIcon"
        @click="takePhoto"
      ></i>
    </div>
  </div>
</template>

<script>
import { router } from "@inertiajs/vue3";
export default {
  data() {
    return {
      photos: [],
      showfilter: false,
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
      time: 5,
      timefun: null,
      countText: false,
    };
  },
  methods: {
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
        console.log(this.photos);
        this.$refs.cameraIcon.style.opacity = "0";
        this.timefun = setInterval(this.setTime, 1000);

        setTimeout(() => {
          this.time = 5;
          this.$refs.timeText.innerText = null;
          this.createCameraElement();
          this.takePhoto();
          console.log(this.photos);
        }, 5000);
      } else {
        const form = {
          images: this.photos,
        };
        router.post("/camera", form);
      }
    },
    setTime() {
      this.time -= 1;
      if (this.time == 0) {
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
        this.isPhotoTaken = !this.isPhotoTaken;
        clearInterval(this.timefun);
      } else {
        this.$refs.timeText.innerText = this.time;
        this.countText = true;
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
    openFilter() {
      if (!this.showfilter) {
        this.$refs.showFilters.style.transform = "translate(0px)";
        this.showfilter = !this.showfilter;
      } else {
        this.showfilter = !this.showfilter;
        this.$refs.showFilters.style.transform = "translate(-1500px)";
      }
    },
    saturate() {
      this.$refs.camera.style.filter = "saturate(8)";
    },
    grayscale() {
      this.$refs.camera.style.filter = "grayscale(80%)";
    },
    huerotate() {
      this.$refs.camera.style.filter = "hue-rotate(90deg)";
    },
    contrast() {
      this.$refs.camera.style.filter = "contrast(200%)";
    },
    blur() {
      this.$refs.camera.style.filter = "blur(5px)";
    },
    invert() {
      this.$refs.camera.style.filter = "invert(100%)";
    },
    nolmal() {
      this.$refs.camera.style.filter = "none";
    },
  },
};
</script>

<style>
video {
  height: 100%;
  width: 100%;
  position: fixed;
}
.camera-menu {
  position: fixed;
  bottom: 0;
  width: 100%;
  z-index: 3;
  display: flex;
  justify-content: center;
}
.counting {
  display: flex;
  position: fixed;
  top: 0;
  margin-top: auto;
  z-index: 10;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
}
.counting-text {
  font-size: 8rem;
}
.shot-camera {
  display: flex;
  align-items: center;
}
.shot-camera i {
  cursor: pointer;
  user-select: none;
  color: white;
}
.shot-container i {
  cursor: pointer;
  user-select: none;
  color: white;
}
</style>
