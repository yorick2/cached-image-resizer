<script setup>
  import PictureSvgComponent from './components/PictureSvgComponent.vue'
  import PictureComponent from './components/PictureComponent.vue'
</script>

<template>
  <h2>SVGs</h2>
  <PictureSvgComponent
          alt="alt text"
          svg="images/laptop-400X266.svg"
          loading=""
  />
  <PictureSvgComponent
          alt="alt text 2"
          svg="images/laptop-400X266.svg"
          img="images/laptop-400X266.jpg"
  />
  <h2>Images</h2>
  <PictureComponent
          alt="alt text 3"
          img="laptop-400X266.webp"
          sizes="200w, 400w, 600w"
          :requiredWidthSizes="['200', '400', '600']"
          :requiredHeightSizes="['0', '0', '0']"
          loading=""
          src="700x700.jpg"
          style="max-width: 800px;"
  />
</template>

<style scoped>
</style>
