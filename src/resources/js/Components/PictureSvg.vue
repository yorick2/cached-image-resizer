
<template>
    <div>
        <h1>testing testing testing</h1>
        <!-- resolution switching -->
        <img
            src="image-small.png"
            srcset="image-small.png 320w, image-medium.png 800w, image-large.png 1200w"
            sizes="${sizes}"
            alt="Image description"
        />

        <!-- art direction -->
        <!-- WebP formats???? -->

        <picture>
            <source
                    srcset="image-small.png 320w, image-medium.png 800w, image-large.png 1200w"
                    sizes="${sizes}"
            />
            <img src="image-small.png" alt="Image description" />
        </picture>


<!--        <picture>-->
<!--            <source media="(orientation: landscape) and (min-width: 1200px)" ... />-->
<!--            <source media="(orientation: landscape)" ... />-->
<!--        </picture>-->

<!--        <picture>-->
<!--            <source type="image/webp" srcset="illustration.webp">-->
<!--            <source type="image/svg+xml" srcset="illustration.svg">-->
<!--            <img src="illustration.png" alt="A hand-made illustration">-->
<!--        </picture>-->


    </div>
</template>

<script>
    export default {
        props: {
            "src": {
                description: "image file",
                type: string,
                required: true
            },
            "svg": {
                description: "image file svg alternative",
                type: string,
                required: false
            },
            "sizes": {
                description: "size of the slot for the image on the page",
                default: "(min-width: 60rem) 80vw, (min-width: 40rem) 90vw, 100vw", // % values no allowed
                type: string,
                required: false
            },
            "required-sizes": {
                description: "image file sizes",
                default: ["320w", "800w", "1200w"],
                type: array,
                required: false
            },
            "loading": {
                description: "Specifies whether a browser should load an image immediately or to defer loading of images until some conditions are met",
                default: "lazy",
                type: string,
                required: false
            },
            // "provide-webp-option": {
            //     description: "create webp files to offer the newer file type to the browser",
            //     default: true,
            //     type: Boolean,
            //     required: false
            // }

        },
    }
</script>
