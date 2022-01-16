<template>
    <div class="situation_wrap">
        <div class="situation_title">
            <p>Situation</p>
            <h2>こんなときに</h2>
        </div>
        <div class="situation_flex">
            <div class="flex_group1">
                <img :src="'/images/situation01.svg'" alt="" class="situation_image1">
                <div class="situation_group1">
                    <h3>楽しみたい日、大切な日</h3>
                    <p>デート、結婚式、おでかけ色々なシチュエーションで晴れを楽しみましょう。</p>
                    <p>直前の予約でも大丈夫、あなたに合わせて晴れをお届けします。</p>
                    <div class="situation_group1_1">
                        <p>デート</p>
                        <p>結婚式</p>
                        <p>レジャー</p>
                    </div>
                </div>
            </div>
            <div class="flex_group2">
                <div class="situation_group2">
                    <h3>イベント、行事</h3>
                    <p>野外イベント、催し物</p>
                    <p>ハレダスにあなたのイベントを成功させるお手伝いをさせてください。</p>
                    <p>事業者さま向けの<a href="#">プラン</a>もございます</p>
                    <div class="situation_group2_1">
                        <p>運動会</p>
                        <p>フェス</p>
                        <p>BBQ</p>
                    </div>
                </div>
                <img :src="'/images/situation02.svg'" alt="" class="situation_image2">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        setup() {

        },
    }
</script>
