<template>
    <picture>
<!--        <source-->
<!--                :srcset="getWebpSrcset()"-->
<!--                :sizes="sizesAttribute"-->
<!--                type="image/webp"-->
<!--        />-->
        <source
                :srcset="getSrcset"
                :sizes="sizesAttribute"
                :type="'image/'+type"
        />
        <img :src="src"  :alt="alt" :loading="loading" />
    </picture>
</template>

<script setup>
    import { computed } from 'vue';

    const props = defineProps({
        "alt": {
            description: "alt text",
            type: String,
            required: true
        },
        "src": {
            description: "image file",
            type: String,
            required: true
        },
        "type": {
            description: "required fallback type",
            type: String,
            required: false,
            default: 'jpg'
        },
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
    });
    // eg. image-small.png 320w, image-medium.png 800w, image-large.png 1200w
    // /pm-image-resizer/w/{width}/h/{height}/{img?}
    const getSrcset = computed(() => {
        let string = '/pm-image-resizer/w/'+props.requiredSizes[0]+'/h/0/'+props.src + ' ' + props.requiredSizes[0];
        for (let i=1; i<props.requiredSizes.length; i++){
            string += ', ' + props.src + ' ' + props.requiredSizes[i]
        }
        return string;
    });
</script>

