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

<style scoped>

</style>
