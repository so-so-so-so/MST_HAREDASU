<template>
    <div class="home_wrap">
        <div class="home_wrap">
            <Mainvisual></Mainvisual>
            <Situation></Situation>
            <Howto></Howto>
            <Sonohi></Sonohi>
            <Question></Question>
            <Business></Business>
        </div>
    </div>
</template>

<script>
    import Mainvisual from '../components/home_main.vue'
    import Situation from '../components/situation.vue'
    import Question from '../components/home_question.vue'
    import Howto from '../components/home_howto.vue'
    import Business from '../components/home_business.vue'
    import Sonohi from '../components/home_sonohi.vue'
    export default{
        components:{
            Situation,
            Question,
            Howto,
            Business,
            Mainvisual,
            Sonohi,
        },
        created() {
        //window変更を検知
        window.addEventListener('resize', this.setViewport)
        this.setViewport();
        },
        beforeDestroy() {
            window.removeEventListener('resize', this.setViewport)
        },
        methods: {
            setViewport: function() {
                let changeWindowSize = 375
                let viewportContent = "width=device-width,initial-scale=1.0"
                if (window.innerWidth < changeWindowSize) {
                    viewportContent = "width=375,user-scalable=no,viewport-fit=cover"
                }
                document.querySelector("meta[name='viewport']").setAttribute("content", viewportContent)
            }
        }
    }
</script>
