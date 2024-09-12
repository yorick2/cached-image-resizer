<template>
    <img :src="img"
         :srcset="'/images/'+svg"
         :alt="alt"
         :loading="loading">
</template>

<script setup>
    import { computed } from 'vue';

    const props = defineProps({
        "svg": {
            description: "svg file",
            type: String,
            required: true
        },
        "alt": {
            description: "alt text",
            type: String,
            required: true
        },
        "fallbackImageHeight": {
            description: "alt text",
            type: Number,
            required: true
        },
        "fallbackImageWidth": {
            description: "alt text",
            type: Number,
            required: true
        },
        "fallbackImageExtension": {
            description: "alt text",
            type: String,
            required: true
        },
        "loading": {
            description: "Specifies whether a browser should load an image immediately or to defer loading of images until some conditions are met",
            default: "lazy",
            type: String,
        },
    });
    const img = computed(() => {
        return '/pm-image-resizer/converted/w/'+props.fallbackImageWidth+'/h/'+props.fallbackImageWidth+'/'+props.svg+'.'+props.fallbackImageExtension;
    });
</script>
