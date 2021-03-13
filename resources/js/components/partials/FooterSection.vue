<template>
    <footer id="footer-container">
        <ul class="footer-links">
            <li v-for="page in pages" :key="page.slug">
                <a :href="'/info/'+page.slug" :class="{'active':(currentRelativeUrl === '/info/'+page.slug)}" >{{page.name}}</a>
            </li>
        </ul>
        <p class="copyright-container">
            Copyright &copy; 2021 RedTutorial.com
        </p>
    </footer>
</template>

<script>
export default {
    name: "FooterSection",
    data: function (){
        return {
            pages: [],
            apiLink: '/api/v1/static-pages?fields=slug,name'
        }
    },
    computed: {
        currentRelativeUrl() {
            return window.location.pathname;
        }
    },
    created() {
        this.getPages()
    },
    methods: {
        getPages(){
            axios.get(this.apiLink).then((res) => {
                this.pages = res.data.data;
            }).catch((error) => {
                console.log(error)
            })
        }
    }
}
</script>

<style lang="scss" scoped>
@import "../../../sass/base/index";

#footer-container{
    margin: 10px 15px;
    text-align: center;

    .copyright-container{
        box-sizing: border-box;
        text-align: center;
        margin: 0;
        line-height: 2;
    }

    .footer-links{
        margin: 0;
        box-sizing: border-box;
        vertical-align: middle;
        list-style: none;
        padding: 0;

        > li {
            display: inline-block;
            padding-left: 10px;

            a {
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                color: $text-color;
                text-decoration: none;
                transition: color .5s;
                font-size: 18px;
                letter-spacing: 1px;
                font-weight: 100;
                line-height: 2;
                display: inline-block;

                &.active, &:hover {
                    color: $brand-primary;
                }
            }

        }
    }
}
</style>
