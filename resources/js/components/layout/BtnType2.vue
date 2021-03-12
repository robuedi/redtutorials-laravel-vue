<template>
    <a class="start-course" :href="link">
        <span>{{title}}</span>
        <i class="fas fa-chevron-circle-right"></i>
    </a>
</template>

<script>
export default {
    name: "BtnType2",
    props: {
        title: String,
        link: String
    }
}
</script>

<style scoped>

</style>
