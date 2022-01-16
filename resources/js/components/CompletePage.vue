<template>
    <div class="completePage_main">
        <div class="confirmationPage_main_location">
            <div class="confirmationPage_main_location_wrap">
                <img :src="'/images/signup.png'" alt="" />
                <p class="Inactive">予約入力</p>
            </div>
            <div class="confirmationPage_main_location_border"></div>
            <div class="confirmationPage_main_location_wrap">
                <img :src="'/images/confirmation.png'" alt="" />
                <p class="Inactive">予約確認</p>
            </div>
            <div class="confirmationPage_main_location_border"></div>
            <div class="confirmationPage_main_location_wrap">
                <img :src="'/images/completion_a.png'" alt="" />
                <p>予約完了</p>
            </div>
        </div>
        <div class="completePage_main_contents">
            <p class="completePage_main_contents_title">予約完了</p>
            <div class="completePage_main_contents_border"></div>
            <p class="completePage_main_contents_subtitle">
                晴れ予約が完了しました。<br />当日は晴れをお楽しみください！
            </p>
            <div class="completePage_main_contents_contents">
                <div class="completePage_main_contents_contents_subwrap">
                    <p>予約情報</p>
                    <a href="#">詳細</a>
                </div>
                <div class="completePage_main_contents_contents_wrap">
                    <p>場所</p>
                    <p>{{ locationName }}</p>
                </div>
                <div class="completePage_main_contents_contents_wrap">
                    <p>日時</p>
                    <p>{{ time }}</p>
                </div>
                <div class="completePage_main_contents_contents_wrap">
                    <p>範囲</p>
                    <p>{{ range }}m</p>
                </div>
            </div>
            <div>
                <a href="/mainTop">
                    <div id="next" calss="nextbtn">
                        <span>トップに戻る</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            locationName: "",
            time: "",
            range: "",
        };
    },
    async mounted() {
        var data = JSON.parse(localStorage.getItem("map"));
        this.locationName = data.locationName;
        this.time = data.time;
        this.range = data.range;
        localStorage.removeItem("map");
    },
};
</script>

<style lang="scss">
.completePage_main {
    display: flex;
    align-items: center;
    flex-direction: column;
    height: calc(100vh - 80px - 64px);
    padding: 32px 0;
    width: auto;

    .confirmationPage_main_location {
        width: 280px;
        height: 68px;
        margin-bottom: 32px;
        display: flex;
        justify-content: center;
        align-items: center;

        .confirmationPage_main_location_wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #00473e;
            .Inactive {
                opacity: 0.5;
            }
        }
        .confirmationPage_main_location_border {
            height: 1px;
            width: 32px;
            margin-bottom: 18px;
            background: #00473e;
        }
    }
    .completePage_main_contents {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #00473e;
        margin-top: 5vh;

        .completePage_main_contents_title {
            font-size: 1.75rem;
            font-weight: 600;
        }
        .completePage_main_contents_border {
            background: #00473e;
            height: 1px;
            width: 80px;
            margin: 32px 0;
        }
        .completePage_main_contents_subtitle {
            text-align: center;
            font-size: 1.25rem;
        }
        .completePage_main_contents_contents {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            width: 300px;
            margin: 32px 0;

            .completePage_main_contents_contents_subwrap {
                padding: 8px 0;
                display: flex;
                align-items: flex-end;
                p:nth-child(1) {
                    font-size: 1.25rem;
                }
                a {
                    text-decoration: none;
                    color: #afc7ff;
                    margin-left: 16px;
                }
            }
            .completePage_main_contents_contents_wrap {
                padding: 8px 0;
                display: flex;
                align-items: center;

                p:nth-child(1) {
                    min-width: 45px;
                }
                p:nth-child(2) {
                    margin-left: 16px;
                }
            }
        }
    }
    a {
        div {
            background-color: #faae2b;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 8px;
            width: 400px;
            height: 64px;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
        }
    }
}
</style>
