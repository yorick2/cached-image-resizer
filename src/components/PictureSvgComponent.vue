<template>
    <img v-if="img" :src="img" :srcset="svg" :alt="alt" :loading="loading">
    <img v-else :src="svg" :alt="alt" :loading="loading">
</template>

<script setup>
    defineProps({
        "alt": {
            description: "alt text",
            type: String,
            required: true
        },
        "svg": {
            description: "svg file",
            type: String,
            required: true
        },
        "img": {
            description: "image file alternative",
            type: String,
        },
        "loading": {
            description: "Specifies whether a browser should load an image immediately or to defer loading of images until some conditions are met",
            default: "lazy",
            type: String,
        },
    });
</script>
