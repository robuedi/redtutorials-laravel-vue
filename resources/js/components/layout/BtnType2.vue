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

<style lang="scss" scoped>
@import "../../../sass/base/index";

.start-course{
    z-index: 2;
    font-family: $font-family;
    letter-spacing: 1px;
    font-size: 20px;
    cursor: pointer;
    padding: 8px 20px;
    font-weight: 800;
    text-decoration: none;
    line-height: 25px;
    vertical-align: middle;
    position: absolute;
    right: 25px;
    bottom: 25px;
    background-color: $white-color;
    color: $brand-primary;
    border-radius: 8px;
    box-shadow: 0 0 4px 1px rgba(0,0,0,0.05);

    @media (min-width: $screen-sm) {
        transition: background-color 0.5s;
    }

    span{
        z-index: 2;
        position: relative;
        display: inline-block;
        padding-right: 5px;
    }

    i {
        line-height: 24px;
        vertical-align: middle;
        z-index: 2;
        font-size: 24px;
        color: #2d2d2d;
        height: 24px;
        width: 24px;
        position: relative;


        &:after{
            content: "";
            position: absolute;
            left: 1px;
            right: 1px;
            top: 1px;
            bottom: 1px;
            border-radius: 50%;
            z-index: 0;

        }
        &:before{
            position: relative;
            z-index: 1;
            color: $brand-primary ;

        }
    }

    &:hover, &:focus, &:active {
        background-color: $brand-primary;
        color: $white-color;

        i:before{
            color: $white-color ;

        }
    }
}
</style>
