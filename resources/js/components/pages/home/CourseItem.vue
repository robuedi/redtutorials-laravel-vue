<template>
    <div class="course-item"  >
        <div class="inner-container"  >
            <h2 >
                <a :href="'/'+course.slug">
                    <span class="course-name">{{course.name}}</span> <small>Tutorial</small>
                </a>
            </h2>
            <div class="txt-content" v-html="course.short_description"></div>
            <BtnType2 v-if="course.is_public" :link="'/'+course.slug" :title="btnTitle"></BtnType2>
        </div>
    </div>
</template>

<script>
import BtnType2 from "../../layout/BtnType2";

export default {
    name: "CourseItem",
    props: {
        course: Object,
        courseStarted: Boolean,
    },
    computed: {
        btnTitle: function (){
            if (this.course.progress > 0)
            {
                return 'Continue the course';
            }

            return 'Start now';
        }
    },
    components: {
        BtnType2
    }
}
</script>

<style lang="scss" scoped>
@import "../../../../sass/base/index";

.course-item {
    z-index: 1;
    color: $text-color;
    position: relative;
    overflow: auto;
    width: 35%;
    box-sizing: border-box;
    min-height: 200px;
    padding: 25px ;
    border-radius: 4px;

    @media (min-width: $screen-md) {
        margin: 0px 10px 50px;
        padding: 0px ;
    }

    @media (max-width: 1675px) {
        width: calc(33.33% - 20px);
    }

    @media (max-width: 1390px) {
        width: calc(50% - 20px);
    }

    @media (max-width: 800px) {
        width: 100%;
        padding: 15px;
    }

    .inner-container{
        height: 100%;
        text-align: left;
        box-sizing: border-box;
        padding: 25px 0 55px;
        position: relative;
        text-decoration: none;


        @media (min-width: $screen-sm) {
            border: none
        }

        @media (min-width: $screen-md) {
            padding: 25px 25px 55px;
        }

        h2 {
            margin: 10px 0 35px ;

            @media (min-width: $screen-md) {
                margin: 0 0 35px ;
            }

            @media (min-width: $screen-sm) {
                text-align: center;
            }

            a{
                text-decoration:none;
                display: inline-block;
                position: relative;
                z-index: 2;
                font-size: 50px;
                color: $text-color;
                font-weight: 700;

                small {
                    font-weight: 400;
                    background: none;
                    display: block;
                    font-size: 26px;
                    -webkit-background-clip: initial;
                    -webkit-text-fill-color: #000;
                }


            }
        }

        .txt-content{
            position: relative;
            z-index: 2;
            padding-bottom: 45px;
            line-height: 1.3;
            font-size: 20px;
            color: $text-color;

            @media (min-width: $screen-md) {
                padding-bottom: 60px;
            }

            p {
                margin: 0;
            }
        }
    }
}
</style>
