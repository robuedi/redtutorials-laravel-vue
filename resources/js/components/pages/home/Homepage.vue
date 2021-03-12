<template>
    <section id="home_container">
        <section class="page-title">
            <h1 class="part-one">Step by step tutorials</h1>
            <h3 class="part-two"> <strong>Clear</strong> and <strong>easy</strong> to understand, <strong>track your progress</strong> through the courses </h3>
        </section>
        <section class="page-content" >
            <CourseItem v-for="course in courses" :key="course.id" :course="course"></CourseItem>
        </section>
    </section>
</template>

<script>
import CourseItem from "./CourseItem"

export default {
    name: "Homepage",
    data() {
        return {
            courses: [],
            apiLink: '/api/v1/courses?fields=id,name,slug,is_public,short_description&extra=progress'
        }
    },
    components: {
        CourseItem
    },
    created() {
        this.getCourses();
    },
    methods:{
        getCourses(){
            axios.get(this.apiLink).then((res) => {
                this.courses = res.data.data;
            }).catch((error) => {
                console.log(error)
            })
        }
    }
}
</script>

<style lang="scss" scoped>
@import "../../../../sass/base/index";

#home_container {
    box-sizing: border-box;
    min-height: $full-height-minus-header;
    width: 100%;
    position: relative;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    background-color: #fafafa;

    &:after {
        z-index: 0;
        position: absolute;
        top: -50px;
        bottom: 0;
        left: 0;
        right: 0;
        background-position: 30% 46px;
        background-image: url("/assets/img/cup-desk-drink-434337.jpg?w=1000&fit=contain");
        background-repeat: no-repeat;
        content: '';
        background-size: cover;

        @media(min-width: $screen-md) {
            background-position: top;
            top: -174px;
        }
    }

    .page-title {
        box-sizing: border-box;
        max-width: 100%;
        z-index: 2;
        padding: 70px 15px 30px;
        position: relative;

        @media (min-width: $screen-md) {
            background-color: rgba(255,255,255,0.8);
            padding-top: 100px;
            padding-bottom: 10px;
            padding-left: 75px;
        }


        .part-one {
            margin: 0;
            text-align: center;
            color: $brand-primary;
            display: block;
            font-size: 45px;
            font-weight: 400;

            @media (min-width: $screen-md) {
                font-size: 52px;
            }
        }

        .part-two {
            margin-top: 10px;
            margin-bottom: 0;
            font-weight: 100;
            font-size: 26px;
            text-align: center;
            display: block;

            @media (min-width: $screen-md) {
                font-size: 30px;
                padding-left: 150px;
            }
        }
    }

    .page-content {
        margin: 0 auto;
        padding: 50px 0;
        font-size: 18px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-evenly;
        width: 100%;
        box-sizing: border-box;
        position: relative;
        z-index: 2;
        min-height: auto;

        @media (min-width: $screen-md) {
            padding: 130px 75px 75px;
        }
    }
}
</style>
