<script setup>
  import PictureSvgComponent from './components/PictureSvgComponent.vue'
  import PictureComponent from './components/PictureComponent.vue'
</script>

<template>


  <h1>Cached image resizer</h1>
  <p>New image created with the given specification if, its been previously created and found in the cache folder "public/images/cache"</p>

  <h2>SVGs</h2>
  <p>Fallback image of specified extension created</p>
  <PictureSvgComponent
    alt="alt"
    :fallbackImageHeight="0"
    :fallbackImageWidth="400"
    fallbackImageExtension="webp"
    svg="laptop-400X266.svg"
loading=""
  />

  <h2>Resize</h2>
  <p>Resize the image to the exact dimensions given, unless 0 is given where that measurement is calculated to scale</p>
  <PictureComponent
      src="700x700.jpg"
      alt="alt text 1"
      :sizesAttribute="['200w', '400w', '600w']"
      :requiredWidthSizes="['200', '400', '600']"
      :requiredHeightSizes="['0', '0', '0']"
      loading=""
  />

    <h2>Resize and crop</h2>
    <p>Resize and crop to fit size given. If one size is 0 it uses the current size for that axis. If -1 is used for a crop coordinate then the image is cropped centrally</p>
    <PictureComponent
        :shouldCrop="true"
        src="700x700.jpg"
        alt="alt text 2"
        :sizesAttribute="['200w', '400w', '600w']"
        :requiredWidthSizes="['200', '400', '600']"
        :requiredHeightSizes="['0', '0', '0']"
        loading=""
    />

    <h2>Resize and reformat</h2>
    <p>Resize the image to the exact dimensions given, unless 0 is given where that measurement is calculated to scale. Then a different format image created e.g. use a jpeg image and save as a webp</p>
    <PictureComponent
        src="700x700.jpg"
        extension="webp"
        alt="alt text 3"
        :sizesAttribute="['200w', '400w', '600w']"
        :requiredWidthSizes="['200', '400', '600']"
        :requiredHeightSizes="['0', '0', '0']"
        loading=""
    />
    <h2>Resize, crop and reformat</h2>
    <p>Resize, crop to fit size given and reformat. If one size is 0 it uses the current size for that axis. If -1 is used for a crop coordinate then the image is cropped centrally. Then a different format image created e.g. use a jpeg image and save as a webp</p>
    <PictureComponent
        :shouldCrop="true"
        extension="webp"
        src="700x700.jpg"
        alt="alt text 4"
        :sizesAttribute="['200w', '400w', '600w']"
        :requiredWidthSizes="['200', '400', '600']"
        :requiredHeightSizes="['0', '0', '0']"
        loading=""
    />
</template>

<style scoped>
    img {
        max-width: 300px;
        max-height: 300px;
    }
</style>
