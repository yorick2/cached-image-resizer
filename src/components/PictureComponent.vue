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
        "shouldCrop": {
            description: "crop image",
            default: true,
            type: Boolean,
            required: false
        },
        "extension": {
            description: "new image format",
            type: String,
            required: false
        },
        "src": {
            description: "fallback image file",
            type: String,
            required: true
        },
        "alt": {
            description: "alt text",
            type: String,
            required: false
        },
        "sizesAttribute": {
            description: "size of the slot for the image on the page e.g. (min-width: 60rem) 80vw, (min-width: 40rem) 90vw, 100vw",
            default() {
                return ["320w", "800w", "1200w"] // % values not allowed without units (e.g. rem,vw ...)
             },
            type: Array,
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
    const getSrcset = computed(() => {
        let string = '';
        if(props.shouldCrop && props.extension){
            for (let i=0; i<props.requiredWidthSizes.length; i++){
                string += '/pm-image-resizer/cropped/converted/w/'+props.requiredWidthSizes[i]+'/h/'+props.requiredHeightSizes[i]+'/'+props.src+'.'+props.extension + ' ' + props.sizesAttribute[i]+" ,";
            }
            return string;
        }
        if(props.extension){
            for (let i=0; i<props.requiredWidthSizes.length; i++){
                string += '/pm-image-resizer/converted/w/'+props.requiredWidthSizes[i]+'/h/'+props.requiredHeightSizes[i]+'/'+props.src+'.'+props.extension + ' ' + props.sizesAttribute[i]+" ,";
            }
            return string;
        }
        if(props.shouldCrop){
            for (let i=0; i<props.requiredWidthSizes.length; i++){
                string += '/pm-image-resizer/cropped/w/'+props.requiredWidthSizes[i]+'/h/'+props.requiredHeightSizes[i]+'/'+props.src + ' ' + props.sizesAttribute[i]+" ,";
            }
            return string;
        }
        for (let i=0; i<props.requiredWidthSizes.length; i++){
            string += '/pm-image-resizer/w/'+props.requiredWidthSizes[i]+'/h/'+props.requiredHeightSizes[i]+'/'+props.src + ' ' + props.sizesAttribute[i]+" ,";
        }
        return string;
    });
</script>

