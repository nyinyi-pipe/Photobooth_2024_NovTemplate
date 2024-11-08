<template>

    <Head title="Photo" />
    <div class="vh-100 d-flex justify-content-center align-items-center position-relative">

        <div v-if="loading" class="loading-overlay">
            <div class="loading-spinner">
                <div class="hourglassBackground">
                    <div class="hourglassContainer">
                        <div class="hourglassCurves"></div>
                        <div class="hourglassCapTop"></div>
                        <div class="hourglassGlassTop"></div>
                        <div class="hourglassSand"></div>
                        <div class="hourglassSandStream"></div>
                        <div class="hourglassCapBottom"></div>
                        <div class="hourglassGlass"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Photo Container -->
        <div v-if="template[0]?.template" class="photo-container">
            <a @click="download" download="photobooth.jpeg" id="download">
                <canvas class="canvas-background" style="cursor: pointer;" id="my-canvas" width="384"
                    height="576"></canvas>
                <canvas class="canvas-hidden" style="cursor: pointer;" id="canvas" width="384" height="576"></canvas>
                <canvas class="canvas-hidden" style="cursor: pointer;" id="print-canvas" width="384"
                    height="576"></canvas>
            </a>
        </div>

        <NoTemplateText v-else />

        <div class="logo-circle"></div>
        <img src="/images/Rabit-removebg.svg" width="65" height="65" class="d-none" id="logo" alt="" />
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import NoTemplateText from "@/Components/NoTemplateText.vue";
import { router } from "@inertiajs/vue3";

export default {
    components: {
        NoTemplateText,
    },
    props: {
        photos: Object,
        template: Array,
        photoId : String,
    },
    setup(props) {
        const loading = ref(true);
        const logo = ref(null);
        const download = () => {
            window.onafterprint = () => {
                router.get("/photo/qrcode/" + props.photoId);
            };
            window.print();
            const downloadLink = document.getElementById("download");
            const canvas = document.getElementById("canvas").toDataURL("image/jpeg", 1.0).replace("image/jpeg", "image/octet-stream");
            downloadLink.setAttribute("href", canvas);
        };

        const updateCanvas = async () => {
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

            const depict = (options, ctx) => {
                const myOptions = { ...options };
                return loadImage(myOptions.uri).then((img) => {
                    if (myOptions.color === "baw") {
                        ctx.filter = "grayscale(100%)";
                    }
                    ctx.drawImage(img, myOptions.x, myOptions.y, myOptions.sw, myOptions.sh);
                });
            };

            const imgs = [
                { uri: props.photos.image[0], x: 12, y: 15, sw: 165, sh: 114, color: props.photos.filter },
                { uri: props.photos.image[0], x: 207, y: 15, sw: 165, sh: 114, color: props.photos.filter },
                { uri: props.photos.image[1], x: 12, y: 140, sw: 165, sh: 114, color: props.photos.filter },
                { uri: props.photos.image[1], x: 207, y: 140, sw: 165, sh: 114, color: props.photos.filter },
                { uri: props.photos.image[2], x: 12, y: 265, sw: 165, sh: 114, color: props.photos.filter },
                { uri: props.photos.image[2], x: 207, y: 265, sw: 165, sh: 114, color: props.photos.filter },
                { uri: props.photos.image[3], x: 12, y: 390, sw: 165, sh: 114, color: props.photos.filter },
                { uri: props.photos.image[3], x: 207, y: 390, sw: 165, sh: 114, color: props.photos.filter },
            ];

            const setBackgroundImage = async (canvasId) => {
                const canvas = document.getElementById(canvasId);
                const ctx = canvas.getContext("2d");
                const backgroundPath = `/storage/${props.template[0]?.template}`;

                if (props.template[0]?.template) {
                    const backgroundImage = await loadImage(backgroundPath);
                    ctx.drawImage(backgroundImage, 0, 0, 384, 576);
                } else {
                    ctx.fillStyle = "white";
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


            Promise.all([
                renderImages("my-canvas", 4),
                renderImages("canvas", 4),
                renderImages("print-canvas", 4),
            ]).then(() => {
                loading.value = false;
            });

        };

        onMounted(() => {
            updateCanvas();
        });

        return {
            download,
            updateCanvas,
            logo,
            loading,
        };
    },
};
</script>

<style scoped>
.loading-spinner {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 1.5rem;
}

.loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(128, 128, 128, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 50;
}

.canvas-background {
    cursor: pointer;
}

.canvas-hidden {
    cursor: pointer;
    display: none;
}

.photo-selection {
    position: absolute;
    top: 10px;
    display: flex;
    gap: 10px;
}

/* From Uiverse.io by SouravBandyopadhyay */
.hourglassBackground {
    position: relative;
    background-color: rgb(255, 255, 255);
    height: 130px;
    width: 130px;
    border-radius: 50%;
    margin: 30px auto;
}

.hourglassContainer {
    position: absolute;
    top: 30px;
    left: 40px;
    width: 50px;
    height: 70px;
    -webkit-animation: hourglassRotate 2s ease-in 0s infinite;
    animation: hourglassRotate 2s ease-in 0s infinite;
    transform-style: preserve-3d;
    perspective: 1000px;
}

.hourglassContainer div,
.hourglassContainer div:before,
.hourglassContainer div:after {
    transform-style: preserve-3d;
}

@-webkit-keyframes hourglassRotate {
    0% {
        transform: rotateX(0deg);
    }

    50% {
        transform: rotateX(180deg);
    }

    100% {
        transform: rotateX(180deg);
    }
}

@keyframes hourglassRotate {
    0% {
        transform: rotateX(0deg);
    }

    50% {
        transform: rotateX(180deg);
    }

    100% {
        transform: rotateX(180deg);
    }
}

.hourglassCapTop {
    top: 0;
}

.hourglassCapTop:before {
    top: -25px;
}

.hourglassCapTop:after {
    top: -20px;
}

.hourglassCapBottom {
    bottom: 0;
}

.hourglassCapBottom:before {
    bottom: -25px;
}

.hourglassCapBottom:after {
    bottom: -20px;
}

.hourglassGlassTop {
    transform: rotateX(90deg);
    position: absolute;
    top: -16px;
    left: 3px;
    border-radius: 50%;
    width: 44px;
    height: 44px;
    background-color: #999999;
}

.hourglassGlass {
    perspective: 100px;
    position: absolute;
    top: 32px;
    left: 20px;
    width: 10px;
    height: 6px;
    background-color: #999999;
    opacity: 0.5;
}

.hourglassGlass:before,
.hourglassGlass:after {
    content: '';
    display: block;
    position: absolute;
    background-color: #999999;
    left: -17px;
    width: 44px;
    height: 28px;
}

.hourglassGlass:before {
    top: -27px;
    border-radius: 0 0 25px 25px;
}

.hourglassGlass:after {
    bottom: -27px;
    border-radius: 25px 25px 0 0;
}

.hourglassCurves:before,
.hourglassCurves:after {
    content: '';
    display: block;
    position: absolute;
    top: 32px;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background-color: #333;
    animation: hideCurves 2s ease-in 0s infinite;
}

.hourglassCurves:before {
    left: 15px;
}

.hourglassCurves:after {
    left: 29px;
}

@-webkit-keyframes hideCurves {
    0% {
        opacity: 1;
    }

    25% {
        opacity: 0;
    }

    30% {
        opacity: 0;
    }

    40% {
        opacity: 1;
    }

    100% {
        opacity: 1;
    }
}

@keyframes hideCurves {
    0% {
        opacity: 1;
    }

    25% {
        opacity: 0;
    }

    30% {
        opacity: 0;
    }

    40% {
        opacity: 1;
    }

    100% {
        opacity: 1;
    }
}

.hourglassSandStream:before {
    content: '';
    display: block;
    position: absolute;
    left: 24px;
    width: 3px;
    background-color: white;
    -webkit-animation: sandStream1 2s ease-in 0s infinite;
    animation: sandStream1 2s ease-in 0s infinite;
}

.hourglassSandStream:after {
    content: '';
    display: block;
    position: absolute;
    top: 36px;
    left: 19px;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-bottom: 6px solid #fff;
    animation: sandStream2 2s ease-in 0s infinite;
}

@-webkit-keyframes sandStream1 {
    0% {
        height: 0;
        top: 35px;
    }

    50% {
        height: 0;
        top: 45px;
    }

    60% {
        height: 35px;
        top: 8px;
    }

    85% {
        height: 35px;
        top: 8px;
    }

    100% {
        height: 0;
        top: 8px;
    }
}

@keyframes sandStream1 {
    0% {
        height: 0;
        top: 35px;
    }

    50% {
        height: 0;
        top: 45px;
    }

    60% {
        height: 35px;
        top: 8px;
    }

    85% {
        height: 35px;
        top: 8px;
    }

    100% {
        height: 0;
        top: 8px;
    }
}

@-webkit-keyframes sandStream2 {
    0% {
        opacity: 0;
    }

    50% {
        opacity: 0;
    }

    51% {
        opacity: 1;
    }

    90% {
        opacity: 1;
    }

    91% {
        opacity: 0;
    }

    100% {
        opacity: 0;
    }
}

@keyframes sandStream2 {
    0% {
        opacity: 0;
    }

    50% {
        opacity: 0;
    }

    51% {
        opacity: 1;
    }

    90% {
        opacity: 1;
    }

    91% {
        opacity: 0;
    }

    100% {
        opacity: 0;
    }
}

.hourglassSand:before,
.hourglassSand:after {
    content: '';
    display: block;
    position: absolute;
    left: 6px;
    background-color: white;
    perspective: 500px;
}

.hourglassSand:before {
    top: 8px;
    width: 39px;
    border-radius: 3px 3px 30px 30px;
    animation: sandFillup 2s ease-in 0s infinite;
}

.hourglassSand:after {
    border-radius: 30px 30px 3px 3px;
    animation: sandDeplete 2s ease-in 0s infinite;
}

@-webkit-keyframes sandFillup {
    0% {
        opacity: 0;
        height: 0;
    }

    60% {
        opacity: 1;
        height: 0;
    }

    100% {
        opacity: 1;
        height: 17px;
    }
}

@keyframes sandFillup {
    0% {
        opacity: 0;
        height: 0;
    }

    60% {
        opacity: 1;
        height: 0;
    }

    100% {
        opacity: 1;
        height: 17px;
    }
}

@-webkit-keyframes sandDeplete {
    0% {
        opacity: 0;
        top: 45px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    1% {
        opacity: 1;
        top: 45px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    24% {
        opacity: 1;
        top: 45px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    25% {
        opacity: 1;
        top: 41px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    50% {
        opacity: 1;
        top: 41px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    90% {
        opacity: 1;
        top: 41px;
        height: 0;
        width: 10px;
        left: 20px;
    }
}

@keyframes sandDeplete {
    0% {
        opacity: 0;
        top: 45px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    1% {
        opacity: 1;
        top: 45px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    24% {
        opacity: 1;
        top: 45px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    25% {
        opacity: 1;
        top: 41px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    50% {
        opacity: 1;
        top: 41px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    90% {
        opacity: 1;
        top: 41px;
        height: 0;
        width: 10px;
        left: 20px;
    }
}


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
</style>