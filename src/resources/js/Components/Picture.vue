
<template>
    <div>
        <h1>testing testing testing juisadhgf</h1>
        <!-- resolution switching -->
        <img
            :src="src"
            :srcset="srcset"
            :sizes="sizesAttribute"
            :alt="alt"
            :loading="loading"
        />

        <!-- art direction -->
        <!-- WebP formats???? -->

<!--        <picture>-->
<!--            <source-->
<!--                :srcset="srcset"-->
<!--                :sizes="sizesAttribute"-->
<!--            />-->
<!--            <img :src="src" :alt="alt" :loading="loading"/>-->
<!--        </picture>-->
    </div>
</template>

<script>
    export default {
        props: {
            "alt": {
                description: "alt text, mainly for screen readers",
                type: String,
                required: true
            },
            "src": {
                description: "image file",
                type: String,
                required: true
            },
            // "svg": {
            //     description: "image file svg alternative",
            //     type: String,
            //     required: false
            // },
            "requiredSizes": {
                description: "image file sizes",
                default() {
                    return ["320w", "800w", "1200w"]
                },
                type: Array,
                required: false
            },
            "sizesAttribute": {
                description: "size of the slot for the image on the page",
                default: "(min-width: 60rem) 80vw, (min-width: 40rem) 90vw, 100vw", // % values no allowed
                type: String,
                required: false
            },
            "loading": {
                description: "Specifies whether a browser should load an image immediately or to defer loading of images until some conditions are met",
                default: "lazy",
                type: String,
                required: false
            },
            // "provide-webp-option": {
            //     description: "create webp files to offer the newer file type to the browser",
            //     default: true,
            //     type: Boolean,
            //     required: false
            // }
        },
        computed: {
            srcset: function () {
                let string = this.src + ' ' + this.requiredSizes[0];
                for (let i=1; i<this.requiredSizes.length; i++){
                    string += ', ' + this.src + ' ' + this.requiredSizes[i]
                }
                return string;
            }
        }
    }
</script>
