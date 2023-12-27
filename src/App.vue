<script setup>
  import PictureSvgComponent from './components/PictureSvgComponent.vue'
  import PictureComponent from './components/PictureComponent.vue'
</script>

<template>
  <h2>SVG's</h2>
  <PictureSvgComponent alt="" svg="images/laptop-400X266.svg" loading=""/>
  <PictureSvgComponent alt="" svg="images/laptop-400X266.svg" img="images/laptop-400X266.jpg"/>
  <h2>Webp's</h2>
  <PictureComponent alt="" src="images/laptop-400X266.webp" loading=""/>
</template>

<style scoped>
</style>
