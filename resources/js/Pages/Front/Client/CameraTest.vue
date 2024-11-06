<template>

  <Head title="Camera" />
  <div id="bgColor">
    <div class="container-fluid">
      <div class="vh-100 position-relative ">
        <div v-if="templateValid" class="camera-hero" ref="tap" @click="tapToStart">
          <h1 class="text-dark start">Tap To Start</h1>
        </div>
        <NoTemplateText v-else class="vh-100 d-flex justify-content-center align-items-center position-relative" />
        <div id="camera"
          class="vh-100 d-none overflow-hidden justify-content-center align-items-center position-relative"
          style="background-color: #000">
          <div class="d-flex overflow-auto align-items-center position-relative" style="width: 90%; height: 100%">
            <h1 id="textCount" class="text-white show-text" v-show="countText"></h1>
            <van-loading vertical text-color="#0094ff" color="#1989fa" class="display-1 position-absolute"
              style="top: 43%; left: 45%" v-show="loading">
              <template #icon>
                <van-icon name="star-o" size="50" />
              </template>
              Loading...
            </van-loading>

            <video src="" class="w-100" style="height: 90%" id="video" ref="camera" autoplay></video>
            <canvas v-show="isPhotoTaken" id="photoTaken" ref="canvas" :width="1600" :height="1800"></canvas>

          </div>
          <div style="width: 95%" class="row position-absolute bottom-0 justify-content-between m-auto">
            <div id="picone" class="col-3 p-5 d-flex justify-content-center align-items-center"
              style="width: 22%; background-color: #ffffff79">
              <h1 class="fw-bold mb-0 p-3" id="one">1</h1>
            </div>
            <div id="pictwo" class="col-3 p-5 d-flex justify-content-center align-items-center"
              style="width: 22%; background-color: #ffffff79">
              <h1 class="fw-bold mb-0 p-3">2</h1>
            </div>
            <div id="picthree" class="col-3 p-5 d-flex justify-content-center align-items-center"
              style="width: 22%; background-color: #ffffff79">
              <h1 class="fw-bold mb-0 p-3">3</h1>
            </div>
            <div id="picfour" class="col-3 p-5 d-flex justify-content-center align-items-center"
              style="width: 22%; background-color: #ffffff79">
              <h1 class="fw-bold mb-0 p-3">4</h1>
            </div>
          </div>
        </div>
        <div class="logo-circle"></div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { router, Head } from "@inertiajs/vue3";
import ClientLayout from "@/Components/client/Layout/ClientLayout.vue";
import NoTemplateText from "@/Components/NoTemplateText.vue";

export default {
  components: {
    ClientLayout,
    Head,
    NoTemplateText
  },
  setup() {
    const tap = ref(null);
    const _selectedDeviceId = ref("");
    const _facingMode = ref("user");
    const isLoading = ref(false);
    const photos = ref([]);
    const timefun = ref(null);
    const time = ref(5);
    const isPhotoTaken = ref(false);
    const isShotPhoto = ref(false);
    const canvas = ref(null);
    const camera = ref(null);
    const countText = ref(false);
    const loading = ref(false);
    let textCount = null;
    const templateValid = ref(false);


    onMounted(() => {
      checkTemplateValidity();
    });


    const checkTemplateValidity = async () => {
      try {

        const response = await fetch("/camera/check-template");
        const data = await response.json();
        console.log(data);

        if (data.status) {
          templateValid.value = true;
        } else {
          templateValid.value = false;
        }
      } catch (error) {
        console.error("Error checking template:", error);
        templateValid.value = false;
      }
    };

    const tapToStart = () => {
      tap.value.style.display = "none";
      let cameraOpen = document.querySelector("#camera");
      let bgColor = document.querySelector("#bgColor");
      let logoCircle = document.querySelector(".logo-circle");
      logoCircle.style.display = "none";
      bgColor.style.backgroundColor = "#000";
      cameraOpen.classList.remove("d-none");
      cameraOpen.classList.add("d-flex");
      if (cameraOpen.classList.contains("d-flex")) {
        createCameraElement();
        takePhoto();
      }
    };

    const addPic = (src, pic) => {
      const video = document.querySelector("#video");
      const img = new Image();
      img.src = src;
      img.style.position = "fixed";
      img.style.transition = "0.4s";
      img.style.zIndex = 2000;
      img.style.width = video.getBoundingClientRect().width + "px";
      img.style.height = video.getBoundingClientRect().height + "px";
      img.style.left = video.getBoundingClientRect().left + "px";
      img.style.top = video.getBoundingClientRect().top + "px";
      img.setAttribute("id", "pics");

      document.body.append(img);

      setTimeout(() => {
        img.style.left = pic.getBoundingClientRect().left + "px";
        img.style.top = pic.getBoundingClientRect().top + "px";
        img.style.width = pic.getBoundingClientRect().width + "px";
        img.style.height = pic.getBoundingClientRect().height + "px";
      }, 100);
    };

    const picOne = (src) => {
      const picone = document.querySelector("#picone");
      addPic(src, picone);
    };

    const picTwo = (src) => {
      const pictwo = document.querySelector("#pictwo");
      addPic(src, pictwo);
    };

    const picThree = (src) => {
      const picthree = document.querySelector("#picthree");
      addPic(src, picthree);
    };

    const picFour = (src) => {
      const picfour = document.querySelector("#picfour");
      addPic(src, picfour);
    };

    const getMediaConstraints = () => {
      var videoConstraints = {};
      if (_selectedDeviceId.value == "") {
        videoConstraints.facingMode = _facingMode.value;
      } else {
        videoConstraints.deviceId = { exact: _selectedDeviceId.value };
      }
      var constraints = {
        video: videoConstraints,
        audio: false,
      };
      return constraints;
    };

    const createCameraElement = () => {
      isLoading.value = true;

      const constraints = (window.constraints = {
        audio: false,
        video: {
          facingMode: { exact: "environment" },
        },
      });

      const video = document.querySelector("#video");

      navigator.mediaDevices
        .getUserMedia(getMediaConstraints())
        .then((stream) => {
          isLoading.value = false;
          video.srcObject = stream;
        })
        .catch((error) => {
          isLoading.value = false;
          alert("May the browser didn't support or there is some errors.");
          console.log(error);
        });
    };

    const stopCameraStream = () => {
      const video = document.querySelector("#video");
      let tracks = video.srcObject.getTracks();
      tracks.forEach((track) => {
        track.stop();
      });
    };

    // const takePhoto = () => {
    //   if (photos.value.length !== 4) {
    //     timefun.value = window.setInterval(setTime, 1000);
    //     setTimeout(() => {
    //       time.value = 5;
    //       textCount = "";
    //       createCameraElement();
    //       takePhoto();
    //     }, 5000);
    //   } else {
    //     const form = {
    //       images: photos.value,
    //     };
    //     router.post("/camera", form, {
    //       onBefore: () => {
    //         stopCameraStream();
    //         window.clearInterval(timefun.value);
    //       },
    //       onStart: () => {
    //         loading.value = !loading.value;
    //       },
    //     });
    //   }
    // };

    // const setTime = () => {
    //   time.value -= 1;
    //   if (time.value == 0) {
    //     if (!isPhotoTaken.value) {
    //       isShotPhoto.value = true;
    //       const FLASH_TIMEOUT = 50;
    //       setTimeout(() => {
    //         isShotPhoto.value = false;
    //       }, FLASH_TIMEOUT);
    //     }
    //     countText.value = false;
    //     isPhotoTaken.value = !isPhotoTaken.value;
    //     const context = canvas.value.getContext("2d");
    //     context.drawImage(camera.value, 0, 0, 450, 337.5);
    //     photos.value.push(canvas.value.toDataURL("image/jpeg"));

    //     if (photos.value.length == 1) {
    //       picOne(canvas.value.toDataURL("image/jpeg"));
    //     } else if (photos.value.length == 2) {
    //       picTwo(canvas.value.toDataURL("image/jpeg"));
    //     } else if (photos.value.length == 3) {
    //       picThree(canvas.value.toDataURL("image/jpeg"));
    //     } else {
    //       picFour(canvas.value.toDataURL("image/jpeg"));
    //     }

    //     isPhotoTaken.value = !isPhotoTaken.value;
    //     window.clearInterval(timefun.value);

    //   } else {
    //     textCount = time.value;
    //     document.querySelector("#textCount").innerText = textCount;
    //     countText.value = true;
    //   }
    // };



    const takePhoto = () => {
      if (photos.value.length !== 4) {
        time.value = 5;
        countText.value = true;
        isPhotoTaken.value = false;

        const countdownInterval = setInterval(() => {
          time.value -= 1;

          if (time.value <= 0) {
            textCount = "";
            document.querySelector("#textCount").innerText = textCount;

            clearInterval(countdownInterval);
            countText.value = false;

            if (!isPhotoTaken.value) {
              isShotPhoto.value = true;
              const FLASH_TIMEOUT = 50;
              setTimeout(() => {
                isShotPhoto.value = false;
              }, FLASH_TIMEOUT);
            }

            isPhotoTaken.value = !isPhotoTaken.value;

            const context = canvas.value.getContext("2d");
            context.drawImage(camera.value, 0, 0, 1600, 1800);
            photos.value.push(canvas.value.toDataURL("image/jpeg"));

            switch (photos.value.length) {
              case 1:
                picOne(canvas.value.toDataURL("image/jpeg"));
                break;
              case 2:
                picTwo(canvas.value.toDataURL("image/jpeg"));
                break;
              case 3:
                picThree(canvas.value.toDataURL("image/jpeg"));
                break;
              default:
                picFour(canvas.value.toDataURL("image/jpeg"));
                break;
            }

            isPhotoTaken.value = !isPhotoTaken.value;
            takePhoto();
          } else {
            textCount = time.value;
            document.querySelector("#textCount").innerText = textCount;
          }
        }, 1000);
      } else {
        const form = {
          images: photos.value,
        };
        router.post("/camera", form, {
          onBefore: () => {
            stopCameraStream();
            clearInterval(timefun.value);
          },
          onStart: () => {
            loading.value = !loading.value;
          },
        });
      }
    };



    return {
      tapToStart,
      tap,
      createCameraElement,
      takePhoto,
      countText,
      camera,
      canvas,
      isPhotoTaken,
      loading,
      templateValid
    };
  },
};
</script>
