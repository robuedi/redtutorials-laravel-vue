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

<style scoped>

</style>
