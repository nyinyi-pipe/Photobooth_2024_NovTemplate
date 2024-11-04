<template>

    <Head title="Photo" />
    <div class="vh-100 d-flex justify-content-center align-items-center position-relative">
        <div class="photo-container">
            <a @click="download" download="photobooth.jpeg" id="download">
                <canvas class="canvas-background" style="cursor: pointer;" id="my-canvas" width="384" height="576">
                </canvas>
                <canvas class="canvas-hidden" style="cursor: pointer;" id="canvas" width="384" height="576"></canvas>
                <canvas class="canvas-hidden" style="cursor: pointer;" id="print-canvas" width="384"
                    height="576"></canvas>
            </a>
        </div>
        <div class="logo-circle"></div>
        <img src="/images/Rabit-removebg.svg" width="65" height="65" class="d-none" id="logo" alt="" />
    </div>
</template>

<script>
import { Link, router, Head } from "@inertiajs/vue3";

export default {
    props: {
        photos: Object,
        theme: String,
        template: Array,
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
                .toDataURL("image/jpeg", 1.0)
                .replace("image/jpeg", "image/octet-stream");
            download.setAttribute("href", canvas);
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
                    img.onerror = () => reject(new Error(`load ${url} failed`));
                    img.src = url;
                });
            };

            const depict = (options, ctx) => {
                const myOptions = Object.assign({}, options);
                return loadImage(myOptions.uri).then((img) => {
                    if (myOptions.color === "baw") {
                        ctx.filter = "grayscale(100%)";
                    }
                    ctx.drawImage(img, myOptions.x, myOptions.y, myOptions.sw, myOptions.sh);
                });
            };

            let imgs = [
                {
                        uri: this.photos.image[0],
                        x: 18,
                        y: 15,
                        sw: 165,
                        sh: 114,
                        color: this.photos.filter,
                    },
                    {
                        uri: this.photos.image[0],
                        x: 201,
                        y: 15,
                        sw: 165,
                        sh: 114,
                        color: this.photos.filter,
                    },
                    {
                        uri: this.photos.image[1],
                        x: 18,
                        y: 140,
                        sw: 165,
                        sh: 114,
                        color: this.photos.filter,
                    },
                    {
                        uri: this.photos.image[1],
                        x: 201,
                        y: 140,
                        sw: 165,
                        sh: 114,
                        color: this.photos.filter,
                    },
                    {
                        uri: this.photos.image[2],
                        x: 18,
                        y: 265,
                        sw: 165,
                        sh: 114,
                        color: this.photos.filter,
                    },
                    {
                        uri: this.photos.image[2],
                        x: 201,
                        y: 265,
                        sw: 165,
                        sh: 114,
                        color: this.photos.filter,
                    },
                    {
                        uri: this.photos.image[3],
                        x: 18,
                        y: 390,
                        sw: 165,
                        sh: 114,
                        color: this.photos.filter,
                    },
                    {
                        uri: this.photos.image[3],
                        x: 201,
                        y: 390,
                        sw: 165,
                        sh: 114,
                        color: this.photos.filter,
                    }
            ];

            const setBackgroundImage = async (canvasId) => {
                const canvas = document.getElementById(canvasId);
                const ctx = canvas.getContext("2d");
                const backgroundImagePath = `/storage/${this.template[0]?.template}`;
                const backgroundImg = await loadImage(backgroundImagePath);

                const drawWidth = 384;
                const drawHeight = 576;
                const drawX = 0;
                const drawY = 0;
                ctx.drawImage(backgroundImg, drawX, drawY, drawWidth, drawHeight);

            };

            const renderImages = async (canvasId, scale) => {
                const ctx = getContext(canvasId, scale);
                await setBackgroundImage(canvasId);
                for (const img of imgs) {
                    await depict(img, ctx);
                }
                return ctx;
            };

            const showctx = renderImages("my-canvas", 4);
            const ctx = renderImages("canvas", 4);
            const printctx = renderImages("print-canvas", 4);

            const addText = (ctx) => {
                ctx.font = "13px ahronbd";
                ctx.fillStyle = "#000000";
                ctx.fillText("FOTOAUTOMAT", 46, 16);
                ctx.fillText("FOTOAUTOMAT", 243, 16);
            };

            // showctx.then(addText);
            // ctx.then(addText);
            // printctx.then(addText);
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
