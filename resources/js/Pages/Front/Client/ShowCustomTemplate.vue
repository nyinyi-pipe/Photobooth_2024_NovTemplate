<template>

    <Head title="Photo" />
    <div class="vh-100 d-flex justify-content-center align-items-center position-relative">
        <div v-if="template[0]?.template" class="photo-container">
            <a @click="download" download="photobooth.jpeg" id="download">
                <canvas class="canvas-background" style="cursor: pointer;" id="my-canvas" width="384" height="576">
                </canvas>
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
import { router } from '@inertiajs/vue3'

export default {
    components: {
        NoTemplateText,
    },
    props: {
        photos: Object,
        template: Array,
    },
    setup(props) {
        const logo = ref(null);

        const download = () => {
            window.onafterprint = () => {
                router.get("/photo/qrcode/" + props.photos.id);
            };
            window.print();
            const downloadLink = document.getElementById("download");
            const canvas = document.getElementById("canvas").toDataURL("image/jpeg", 1.0).replace("image/jpeg", "image/octet-stream");
            downloadLink.setAttribute("href", canvas);
        };

        const updateCanvas = () => {
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
                    const drawWidth = 384;
                    const drawHeight = 576;
                    const drawX = 0;
                    const drawY = 0;
                    ctx.drawImage(backgroundImage, drawX, drawY, drawWidth, drawHeight);
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
            renderImages("canvas", 4);
            renderImages("print-canvas", 4);

            const addText = (ctx) => {
                ctx.font = "13px ahronbd";
                ctx.fillStyle = "#000000";
                ctx.fillText("FOTOAUTOMAT", 46, 16);
                ctx.fillText("FOTOAUTOMAT", 243, 16);
            };

        };

        onMounted(() => {
            updateCanvas();
        });

        return {
            download,
            updateCanvas,
            logo,
        };
    },
};
</script>

<style scoped>
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