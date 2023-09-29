
<template>
    <div>
        <h1>testing testing testing</h1>
        <picture>
            <source media="(min-width: 650px)" srcset="img_food.jpg">
            <source media="(min-width: 465px)" srcset="img_car.jpg">
            <img src="img_girl.jpg">
        </picture>
    </div>
</template>

<script>
    export default {
        props: [
        ],
    }
</script>
