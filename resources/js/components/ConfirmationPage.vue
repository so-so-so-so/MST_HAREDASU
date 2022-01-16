<template>
    <div class="confirmationPage_main">
        <div class="confirmationPage_main_location">
            <div class="confirmationPage_main_location_wrap">
                <img :src="'/images/signup.png'" alt="" />
                <p class="Inactive">予約入力</p>
            </div>
            <div class="confirmationPage_main_location_border"></div>
            <div class="confirmationPage_main_location_wrap">
                <img :src="'/images/confirmation_a.png'" alt="" />
                <p>予約確認</p>
            </div>
            <div class="confirmationPage_main_location_border"></div>
            <div class="confirmationPage_main_location_wrap">
                <img :src="'/images/completion.png'" alt="" />
                <p class="Inactive">予約完了</p>
            </div>
        </div>
        <div class="confirmationPage_main_wrap">
            <div class="confirmationPage_main_information">
                <p class="confirmationPage_main_information_title">予約情報</p>
                <div id="map" ref="googleMap" />
                <div class="confirmationPage_main_information_contents">
                    <p>場所</p>
                    <p class="font_size">{{ this.mapData.locationName }}</p>
                </div>
                <div class="confirmationPage_main_information_contents">
                    <p>日時</p>
                    <p class="font_size">{{ this.mapData.time }}</p>
                </div>
                <div class="confirmationPage_main_information_contents">
                    <p>範囲</p>
                    <p class="font_size">{{ this.mapData.range }}</p>
                </div>
                <div
                    class="confirmationPage_main_information_contents_border"
                ></div>
                <div class="confirmationPage_main_information_contents_alert">
                    <p>
                        予約日当日のキャンセルは受け付けておりませんのでご了承ください。
                    </p>
                    <div
                        class="confirmationPage_main_information_contents_alert_checkbox"
                    >
                        <label class="my-checkbox">
                            <input type="checkbox" id="checkbox" />
                            <span class="checkmark"></span>
                            <p>キャンセルポリシーに同意する</p>
                        </label>
                    </div>
                </div>
            </div>
            <div class="confirmationPage_main_others">
                <div class="confirmationPage_main_others_price">
                    <p class="confirmationPage_main_others_price_title">
                        料金詳細
                    </p>
                    <div class="confirmationPage_main_others_price_contents">
                        <p>基本料金</p>
                        <p><span class="font_size">300,000</span>円</p>
                    </div>
                    <!-- <div class="confirmationPage_main_others_price_contents">
                        <p>範囲料金</p>
                        <p><span class="font_size">{{}}</span>円</p>
                    </div> -->
                    <div class="confirmationPage_main_others_price_contents">
                        <p>時間</p>
                        <p>
                            <span class="font_size">{{ totalTime }}</span>
                        </p>
                    </div>
                    <div
                        class="confirmationPage_main_others_price_contents_border"
                    ></div>
                    <div class="confirmationPage_main_others_price_contents">
                        <p
                            class="confirmationPage_main_others_price_contents_total"
                        >
                            お支払い金額
                        </p>
                        <p>
                            <span class="font_size_totla">{{
                                this.mapData.totalFee
                            }}</span
                            >円
                        </p>
                    </div>
                </div>
                <div class="confirmationPage_main_others_payment">
                    <p>お支払い情報</p>
                    <p>{{ cardNumber }}</p>
                    <a href="#">変更</a>
                </div>
                <div class="confirmationPage_main_others_button">
                    <a href="#">
                        <div
                            id="next"
                            class="nextbtn"
                            v-bind:class="{
                                btnActive: btnActive,
                                btnnoActive: btnnoActive,
                            }"
                        >
                            <span>予約を確定する</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import GoogleMapsApiLoader from "google-maps-api-loader";
import mypin from "../../../public/assets/mypin.png";

export default {
    data() {
        return {
            google: null,
            Map: "",
            mapConfig: {
                center: {
                    lat: 35.68944,
                    lng: 139.69167,
                },
                zoom: 13,
                mapTypeControl: false,
                fullscreenControl: false,
                streetViewControl: false,
                zoomControl: false,
                disableDoubleClickZoom: true,
                scrollwheel: false,
                draggable: false,
                clickable: false,
            },
            cardNumber: "**** **** **** 0000",
            btnActive: false,
            btnnoActive: true,
            mapData: {
                locationName: JSON.parse(localStorage.getItem("map"))
                    .locationName,
                time: JSON.parse(localStorage.getItem("map")).time,
                range: JSON.parse(localStorage.getItem("map")).range + "m",
                totalFee: JSON.parse(localStorage.getItem("map")).totalFee,
            },
            totalTime: "",
        };
    },
    async mounted() {
        this.google = await GoogleMapsApiLoader({
            apiKey: "AIzaSyCbr524Eht2tpaHaFLvBShbHBy1m1uqBy4",
        });
        this.initializeMap();
        console.log(JSON.parse(localStorage.getItem("map")));
    },
    methods: {
        initializeMap() {
            this.Map = new this.google.maps.Map(
                this.$refs.googleMap,
                this.mapConfig
            );

            //中心のピン詳細(localStorage有)
            new this.google.maps.Marker({
                position: new this.google.maps.LatLng(
                    JSON.parse(localStorage.getItem("map")).latlng
                ),
                map: this.Map,
                icon: mypin,
            });

            this.Map.panTo(
                new this.google.maps.LatLng(
                    JSON.parse(localStorage.getItem("map")).latlng
                )
            );

            //範囲の詳細(localStorage有)
            new this.google.maps.Circle({
                center: new this.google.maps.LatLng(
                    JSON.parse(localStorage.getItem("map")).latlng
                ),
                map: this.Map,
                radius: JSON.parse(localStorage.getItem("map")).range,
                strokeColor: "#eaf07900",
                fillColor: "#A58888",
            });
            document.getElementById("next").disabled = true;

            //DB送るよう
            document
                .getElementById("next")
                .addEventListener("click", async () => {
                    await console.log(
                        document.getElementById("checkbox").checked
                    );
                    const data = {
                        DBdata: JSON.parse(localStorage.getItem("map")).DBdate,
                        end_time: JSON.parse(localStorage.getItem("map"))
                            .endTime,
                        start_time: JSON.parse(localStorage.getItem("map"))
                            .startTime,
                        area: JSON.parse(localStorage.getItem("map")).range,
                        address: JSON.parse(localStorage.getItem("map"))
                            .locationName,
                        cost: JSON.parse(localStorage.getItem("map")).totalFee,
                        latlng: JSON.parse(localStorage.getItem("map")).latlng,
                        date: JSON.parse(localStorage.getItem("map")).date,
                        totalFee: JSON.parse(localStorage.getItem("map"))
                            .totalFee,
                    };
                    await axios.post("/api/reserve", data).then((response) => {
                        console.log(response);
                        this.anyMapData = response.data;
                    });
                    window.location = "/complete";
                });
            document
                .getElementById("checkbox")
                .addEventListener("click", () => {
                    if (document.getElementById("checkbox").checked) {
                        this.btnActive = true;

                        this.btnnoActive = false;
                    } else {
                        this.btnActive = false;

                        this.btnnoActive = true;
                    }
                });
            console.log(localStorage.getItem("map").totalTime);

            for (
                let i = 0;
                i <= Number(JSON.parse(localStorage.getItem("map")).totalTime);
                i += 30
            ) {
                if (i / 60 < 10) {
                    var hour = "0" + Math.floor(i / 60);
                } else {
                    var hour = Math.floor(i / 60);
                }
                if (i % 60 == 0) {
                    var minit = "0" + (i % 60);
                } else {
                    var minit = i % 60;
                }
            }
            this.totalTime = hour + ":" + minit;
        },
    },
};
</script>

<style lang="scss">
.font_size {
    font-size: 1.25rem;
}
.font_size_totla {
    font-size: 1.35rem;
}
.confirmationPage_main {
    display: flex;
    align-items: center;
    flex-direction: column;
    height: auto;
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
    .confirmationPage_main_wrap {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;

        .confirmationPage_main_information {
            height: auto;
            width: 646px;
            margin-right: 16px;
            border-radius: 8px;
            border: solid 1px #d2d2d2;
            padding: 16px 32px;

            .confirmationPage_main_information_title {
                color: #00473e;
                font-size: 1.45rem;
                font-weight: 600;
                padding: 16px 0;
            }
            #map {
                width: 100%;
                height: 280px;
                margin: 16px 0;
                pointer-events: none;
            }
            .confirmationPage_main_information_contents {
                display: flex;
                align-items: flex-end;
                margin: 16px 0;
                color: #00473e;
                font-weight: 500;

                p:nth-child(2) {
                    margin-left: 32px;
                    font-size: 1rem;
                }
            }
            .confirmationPage_main_information_contents_border {
                background: #a7a7a7;
                height: 1px;
                width: 100%;
            }
            .confirmationPage_main_information_contents_alert {
                color: #00473e;
                padding: 16px 0;
                font-size: 1.15rem;

                .confirmationPage_main_information_contents_alert_checkbox {
                    display: flex;
                    align-items: center;
                    justify-content: center;

                    .my-checkbox {
                        display: block;
                        position: relative;
                        margin: 1em 0;
                        padding-left: 28px;
                        cursor: pointer;
                        user-select: none;

                        p {
                            margin-top: 3px;
                            font-size: 0.9rem;
                        }
                    }
                    .my-checkbox input {
                        display: none;
                    }

                    .checkmark {
                        position: absolute;
                        top: 1px;
                        left: 0;
                        height: 22px;
                        width: 22px;
                        border: solid 2px #d4dae2;
                        border-radius: 4px;
                        box-sizing: border-box;
                    }
                    .checkmark:after {
                        content: "";
                        position: absolute;
                        left: 6px;
                        top: 3px;
                        width: 6px;
                        height: 10px;
                        border: solid #fff;
                        border-width: 0 2px 2px 0;
                        transform: rotate(45deg);
                        opacity: 0;
                    }

                    .my-checkbox input:checked + .checkmark {
                        background: #fa5246;
                        border-color: #fa5246;
                    }

                    .my-checkbox input:checked + .checkmark:after {
                        opacity: 1;
                    }
                }
            }
        }
        .confirmationPage_main_others {
            height: 60vh;
            width: 400px;
            margin-left: 16px;

            .confirmationPage_main_others_price {
                color: #00473e;
                width: calc(100% - 36px);
                height: auto;
                border-radius: 8px;
                border: solid 1px #d2d2d2;
                padding: 16px;

                .confirmationPage_main_others_price_title {
                    color: #00473e;
                    font-size: 1.45rem;
                    font-weight: 600;
                    padding: 16px 0;
                }
                .confirmationPage_main_others_price_contents {
                    display: flex;
                    align-items: flex-end;
                    justify-content: space-between;
                    padding: 8px 0;
                    text-align: bottom;

                    .confirmationPage_main_others_price_contents_total {
                        font-size: 1.15rem;
                        font-weight: 600;
                    }
                }
                .confirmationPage_main_others_price_contents_border {
                    margin-top: 100px;
                    background: #a7a7a7;
                    height: 1px;
                    margin-bottom: 16px;
                    width: 100%;
                }
            }
            .confirmationPage_main_others_payment {
                color: #00473e;
                width: calc(100% - 36px);
                height: auto;
                border-radius: 8px;
                border: solid 1px #d2d2d2;
                padding: 16px;
                margin: 32px 0;
                display: flex;
                justify-content: space-between;
                a {
                    text-decoration: none;
                    color: #afc7ff;
                }
            }
            .confirmationPage_main_others_button {
                a {
                    pointer-events: none;
                    .nextbtn {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border: none;
                        border-radius: 8px;
                        width: 100%;
                        height: 64px;
                        color: #fff;
                        font-size: 1.1rem;
                        font-weight: 600;
                    }
                }
            }
        }
    }
}
.btnActive {
    background-color: #faae2b;
    opacity: 1;
    pointer-events: auto;
}

.btnnoActive {
    background-color: #faae2b;
    opacity: 0.3;
    pointer-events: none;
}
</style>
