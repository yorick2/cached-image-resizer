<template>
    <img
            :srcset="getSrcset"
            :sizes="sizesAttribute"
            :alt="alt"
            :loading="loading"
            :src="'/images/'+src"
    />
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
            description: "fallback image file",
            type: String,
            required: true
        },
        "img": {
            description: "image file",
            type: String,
            required: true
        },
        "sizesAttribute": {
            description: "size of the slot for the image on the page e.g. (min-width: 60rem) 80vw, (min-width: 40rem) 90vw, 100vw",
            default: "320w, 800w, 1200w", // % values no allowed
            type: String,
            required: false
        },
        "requiredWidthSizes": {
            description: "image file width sizes",
            default() {
                return ["320", "800", "1200"]
            },
            type: Array,
            required: false
        },
        "requiredHeightSizes": {
            description: "image file height sizes",
            default() {
                return ["0", "0", "0"]
            },
            type: Array,
            required: false
        },
        "loading": {
            description: "[lazy|eager]Specifies whether a browser should load an image immediately or to defer loading of images until some conditions are met",
            default: "lazy",
            type: String,
            required: false
        },
    });
    // eg. image-small.png 320w, image-medium.png 800w, image-large.png 1200w
    // /pm-image-resizer/w/{width}/h/{height}/{img?}
    const getSrcset = computed(() => {
        let string = '';
        for (let i=0; i<props.requiredWidthSizes.length; i++){
            string += '/pm-image-resizer/w/'+props.requiredWidthSizes[i]+'/h/'+props.requiredHeightSizes[i]+'/'+props.img + ' ' + props.requiredWidthSizes[i]+"w ,";
        }
        return string;
    });
</script>

