<template>
    <div>
        <div class="reservePage_main">
            <div class="map">
                <div id="map" ref="googleMap" />
                <div class="mapimg">
                    <img
                        :src="'/images/Group73.png'"
                        alt="現在地ボタン"
                        @click="backAddress"
                    />
                </div>
            </div>
            <div class="reservePage_main_contents">
                <div class="reservePage_main_input">
                    <p class="reservePage_main_input_title">予約情報入力</p>
                    <div class="reservePage_main_input_form">
                        <input
                            type="text"
                            class="weight"
                            id="mapname"
                            placeholder="エリア・キーワード・駅名など"
                        />
                        <div class="reservePage_main_input_form_title">
                            <p>場所</p>
                        </div>
                    </div>
                    <div
                        class="reservePage_main_input_form"
                        @click="datePicker"
                    >
                        <input
                            type="text"
                            class="weight"
                            id="date"
                            placeholder="日付を選択"
                            readonly="readonly"
                        />
                        <div class="reservePage_main_input_form_title">
                            <p>日付</p>
                        </div>
                    </div>
                    <div
                        class="reservePage_main_input_form_calendar"
                        v-if="calendarPicker"
                        v-click-outside="hideMenu"
                    >
                        <v-date-picker
                            v-bind:class="{ calendarActive: calendarPicker }"
                            class="calendar"
                            :available-dates="dates"
                            :mode="mode"
                            v-model="picker"
                            @input="formatDate(picker)"
                        >
                        </v-date-picker>
                    </div>
                    <div class="reservePage_main_input_timeform">
                        <p class="reservePage_main_input_timeform_title">
                            利用時間
                        </p>
                        <div class="time_ipselect_wrap">
                            <input
                                type="text"
                                class="weight"
                                id="starttime"
                                value="00:00"
                                readonly="readonly"
                                @click="starttime_judg"
                            />
                            <div
                                class="time_ipselect_picker"
                                v-if="timePicker"
                                v-click-outside="hide_starttime"
                            >
                                <div class="touka"></div>
                                <div class="touka2"></div>
                                <div class="time_ipselect">
                                    <form
                                        name="timepicker"
                                        @change="updateTimePicker"
                                    >
                                        <span v-html="startTimePicker"></span>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <p>〜</p>

                        <div class="time_ipselect_wrap">
                            <input
                                type="text"
                                class="weight"
                                id="endtime"
                                value="00:30"
                                readonly="readonly"
                                @click="endtime_judg"
                            />
                            <div
                                class="time_ipselect_picker"
                                v-if="endtimePicker"
                                v-click-outside="hide_endtime"
                            >
                                <div class="touka"></div>
                                <div class="touka2"></div>
                                <div class="time_ipselect">
                                    <form
                                        name="timepicker"
                                        @change="updateendTimePicker"
                                    >
                                        <span v-html="endTimePicker"></span>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="reservePage_main_input_form_radius">
                        <p>範囲</p>
                        <form name="range" @change="changeRange">
                            <div
                                class="reservePage_main_input_form_radius_wrap weight"
                            >
                                <input
                                    type="radio"
                                    name="radius"
                                    value="150"
                                    id="150"
                                    checked="checked"
                                />
                                <label for="150">150m</label>
                                <input
                                    type="radio"
                                    name="radius"
                                    value="300"
                                    id="300"
                                />
                                <label for="300">300m</label>
                                <input
                                    type="radio"
                                    name="radius"
                                    value="500"
                                    id="500"
                                />
                                <label for="500">500m</label>
                                <input
                                    type="radio"
                                    name="radius"
                                    value="750"
                                    id="750"
                                />
                                <label for="750">750m</label>
                                <input
                                    type="radio"
                                    name="radius"
                                    value="1000"
                                    id="1000"
                                />
                                <label for="1000">1000m</label>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="reservePage_main_money">
                    <div class="reservePage_main_money_sum">
                        <p>見積もり金額</p>
                        <p id="val"><span class="enn">¥</span>{{ sumval }}</p>
                    </div>
                    <div class="reservePage_main_money_next">
                        <a href="/confirmation">
                            <div>
                                <p>次へ進む</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import GoogleMapsApiLoader from "google-maps-api-loader";
import Vue from "vue";
import mypin from "../../../public/assets/mypin.png";
import amagumo from "../../../public/images/amagumo.png";
import VCalendar from "v-calendar";
import axios from "axios";
import { compareAsc, format } from "date-fns";
import gsap from "gsap";
import Vuetify from "vuetify";
import ClickOutside from "vue-click-outside";
import atherpin from "../../../public/assets/atherpin.png";
import Header from "./components/Header.vue";

Vue.use(VCalendar);
Vue.use(Vuetify);

export default {
    components: {
        Header,
    },
    data() {
        return {
            dates: {
                start: new Date(),
            },
            mode: "single",
            selectedDate: new Date(),
            mapConfig: {
                center: {
                    lat: 35.68944,
                    lng: 139.69167,
                },
                zoom: 15,
                mapTypeControl: false,
                fullscreenControl: false,
                streetViewControl: false,
                zoomControl: false,
            },
            nowMappin: null,
            addressName: "",
            calendarPicker: false,
            Map: "",
            menu: "",
            text: "2021/11/31",
            picker: "",
            sumval: "",
            totalFee: {
                val: 0,
                latlng: { lat: 35.68944, lng: 139.69167 },
                radius: 150,
                radiusIndex: 1,
                address: "",
                sumDrone: 0,
            },
            startTimePicker: "",
            endTimePicker: "",
            timePicker: false,
            endtimePicker: false,
            startTimeSum: 0,
            endTimeSum: 30,
            oldMapname: "",
            anyMapData: "",
            anyMapDatas: [],
            anyMapDatasrange: [],
            amagumoRoop: 30,
            oldRoop: 0,
            DBdate: "",
        };
    },

    async mounted() {
        this.google = await GoogleMapsApiLoader({
            apiKey: "AIzaSyCbr524Eht2tpaHaFLvBShbHBy1m1uqBy4",
        });
        var local = JSON.parse(localStorage.getItem("map"));
        this.initializeMap(local);
        this.createTimePicker();
        this.getAnyPins();
        this.moveAmagumo();
    },

    methods: {
        async initializeMap(localStorage) {
            this.Map = await new this.google.maps.Map(
                this.$refs.googleMap,
                this.mapConfig
            );
            if (localStorage !== null) {
                //中心のピン詳細(localStorage有)
                this.marker = new this.google.maps.Marker({
                    position: new this.google.maps.LatLng(localStorage.latlng),
                    map: this.Map,
                    icon: mypin,
                });
                this.Map.panTo(
                    new this.google.maps.LatLng(localStorage.latlng)
                );

                //範囲の詳細(localStorage有)
                this.nowMappin = new this.google.maps.Circle({
                    center: new this.google.maps.LatLng(localStorage.latlng),
                    map: this.Map,
                    radius: localStorage.range,
                    strokeColor: "#eaf07900",
                    fillColor: "#A58888",
                });

                //初期住所の名前取得(localStorage有)
                document.getElementById("mapname").value =
                    localStorage.locationName;
                this.oldMapname = localStorage.locationName;

                this.totalFee.latlng = localStorage.latlng;

                document.getElementById("starttime").value =
                    localStorage.startTime;
                document.getElementById("endtime").value = localStorage.endTime;
                document.getElementById("date").value = localStorage.date;
                document.range.radius[localStorage.rebgeSum - 1].checked = true;
                this.startTimeSum = Number(localStorage.startTimesum);
                this.endTimeSum = Number(localStorage.endTimesum);
                this.sumval = localStorage.totalFee;
                this.totalFee.latlng = localStorage.latlng;
                this.totalFee.radiusIndex = localStorage.rebgeSum;
                this.amagumoRoop = localStorage.totalTime / 30;
            } else {
                //中心のピン詳細(localStorage無)
                this.marker = new this.google.maps.Marker({
                    position: new this.google.maps.LatLng(
                        this.mapConfig.latlng
                    ),
                    map: this.Map,
                    icon: mypin,
                });

                //範囲の詳細(localStorage無)
                this.nowMappin = new this.google.maps.Circle({
                    center: new this.google.maps.LatLng(this.mapConfig.center),
                    map: this.Map,
                    radius: 150,
                    strokeColor: "#eaf07900",
                    fillColor: "#A58888",
                });

                //初期住所の名前取得(localStorage無)
                axios.post("/api", this.mapConfig.center).then((response) => {
                    if (
                        response.data.results[0].formatted_address.substr(13)
                            .length >= 22
                    ) {
                        this.addressName =
                            response.data.results[0].formatted_address.substring(
                                12,
                                35
                            ) + "...";
                    } else {
                        this.addressName =
                            response.data.results[0].formatted_address.substr(
                                -13
                            );
                    }
                    document.getElementById("mapname").value = this.addressName;
                    this.oldMapname = this.addressName;
                    this.localStorage();
                });
            }

            const day = format(new Date(), "yyyy-MM-dd");
            var str = day;
            var result = day.replace("-", "/");
            while (result !== str) {
                str = str.replace("-", "/");
                result = result.replace("-", "/");
            }
            document.getElementById("date").value = result;
            this.localStorage();
            this.Calculation();

            //Mapがクリックされた時のハンドラ
            this.Map.addListener("click", (e) => {
                var lat = e.latLng.lat();
                var lng = e.latLng.lng();
                var data = { lat, lng };
                this.totalFee.latlng = data;
                this.nowMappin.setMap(null);
                this.nowMappin = new this.google.maps.Circle({
                    center: new this.google.maps.LatLng(data),
                    map: this.Map,
                    radius: Number(document.range.radius.value),
                    strokeColor: "#A5888800",
                    fillColor: "#A58888",
                });
                this.marker.setMap(null);
                this.marker = new this.google.maps.Marker({
                    position: new this.google.maps.LatLng(data),
                    map: this.Map,
                    icon: mypin,
                });
                this.Map.panTo(new this.google.maps.LatLng(data));
                this.getMap(e);
                this.localStorage();
            });

            //検索
            document
                .getElementById("mapname")
                .addEventListener("keypress", () => {
                    new this.google.maps.Geocoder().geocode(
                        {
                            address: document.getElementById("mapname").value,
                        },
                        (results) => {
                            this.marker.setMap(null);
                            this.nowMappin.setMap(null);
                            this.marker = new this.google.maps.Marker({
                                position: new this.google.maps.LatLng(
                                    results[0].geometry.location
                                ),
                                map: this.Map,
                                icon: mypin,
                            });
                            this.nowMappin = new this.google.maps.Circle({
                                center: new this.google.maps.LatLng(
                                    results[0].geometry.location
                                ),
                                map: this.Map,
                                radius: Number(document.range.radius.value),
                                strokeColor: "#A5888800",
                                fillColor: "#A58888",
                            });
                            this.totalFee.latlng = results[0].geometry.location;
                            this.Map.panTo(
                                new this.google.maps.LatLng(
                                    results[0].geometry.location
                                )
                            );
                            document.getElementById("mapname").value =
                                results[0].formatted_address;
                        }
                    );
                });
        },

        //Mapの住所名取得
        async getMap(e) {
            const data = {
                lat: Number(e.latLng.lat()),
                lng: Number(e.latLng.lng()),
            };
            await axios.post("/api", data).then((response) => {
                this.addressName = response.data.results[0].formatted_address;
            });
            document.getElementById("mapname").value = this.addressName;
            this.localStorage();
        },

        //カレンダーピッカーの表示切り替え
        datePicker() {
            this.calendarPicker = true;
        },

        //日付データのフォーマット
        async formatDate(date) {
            if (!date) return null;
            const day = format(date, "yyyy-MM-dd");
            var str = day;
            var result = day.replace("-", "/");
            while (result !== str) {
                str = str.replace("-", "/");
                result = result.replace("-", "/");
            }
            document.getElementById("date").value = result;
            this.text = result;
            this.calendarPicker = false;
            this.localStorage();
            const data = {
                day: day,
            };
            this.DBdate = format(date, "yyyy-MM-dd");
            await axios.post("/api/reserve_date", data).then((response) => {
                this.anyMapData = response.data;
            });
            for (var i = 0; i < this.anyMapDatas.length; i++) {
                this.anyMapDatas[i].setMap(null);
                this.anyMapDatasrange[i].setMap(null);
            }

            this.anyMapDatas = [];
            this.anyMapDatasrange = [];

            for (let i = 0; i < this.anyMapData.length; i++) {
                var map = new this.google.maps.Marker({
                    position: new this.google.maps.LatLng(
                        this.anyMapData[i].latitude,
                        this.anyMapData[i].longitude
                    ),
                    map: this.Map,
                    icon: atherpin,
                });
                this.anyMapDatas.push(map);

                var range = new this.google.maps.Circle({
                    center: new this.google.maps.LatLng(
                        this.anyMapData[i].latitude,
                        this.anyMapData[i].longitude
                    ),
                    map: this.Map,
                    radius: Number(this.anyMapData[i].area),
                    strokeColor: "#eaf07900",
                    fillColor: "#A58888",
                });

                this.anyMapDatasrange.push(range);

                var pop = new this.google.maps.InfoWindow({
                    content:
                        this.anyMapData[i].start_time.slice(0, -3) +
                        " ~ " +
                        this.anyMapData[i].end_time.slice(0, -3),
                    disableAutoPan: true,
                });
                pop.open(this.Map, this.anyMapDatas[i]); // 吹き出しの表示
            }
        },

        //範囲選択値の更新
        changeRange() {
            this.nowMappin.setMap(null);
            this.nowMappin = new this.google.maps.Circle({
                center: new this.google.maps.LatLng(this.totalFee.latlng),
                map: this.Map,
                radius: Number(document.range.radius.value),
                strokeColor: "#A5888800",
                fillColor: "#A58888",
            });
            var sum = "";
            for (var i = 0; i < 5; i++) {
                if (document.range.radius[i].checked) {
                    sum = i;
                    break;
                }
            }
            this.totalFee.radiusIndex = Number(sum + 1);
            this.Calculation();
            this.localStorage();
        },

        //合計金額計算
        Calculation() {
            var sum = Math.ceil((this.endTimeSum - this.startTimeSum) / 60 / 2);
            var str = String(100000 * sum * this.totalFee.radiusIndex);
            var num = [];
            for (let i = 0; i < str.length; i += 3) {
                num.unshift(str.substring(str.length - 3 - i, str.length - i));
            }
            this.sumval = num.join(",");

            gsap.to(document.getElementById("val"), {
                y: -250,
                opacity: 0,
            });
            gsap.to(document.getElementById("val"), {
                y: 0,
                opacity: 1,
                duration: 0.5,
                ease: "bounce",
            });
        },

        //現在地の戻るボタン
        backAddress() {
            this.nowMappin.setMap(null);
            this.nowMappin = new this.google.maps.Circle({
                center: new this.google.maps.LatLng(this.mapConfig.center),
                map: this.Map,
                radius: Number(document.range.radius.value),
                strokeColor: "#A5888800",
                fillColor: "#A58888",
            });
            this.marker.setMap(null);
            this.marker = new this.google.maps.Marker({
                position: new this.google.maps.LatLng(this.mapConfig.center),
                map: this.Map,
                icon: mypin,
            });
            this.Map.panTo(new this.google.maps.LatLng(this.mapConfig.center));
            document.getElementById("mapname").value = this.oldMapname;
        },

        hideMenu() {
            this.calendarPicker = false;
        },

        hide_starttime() {
            this.timePicker = false;
        },

        hide_endtime() {
            this.endtimePicker = false;
        },

        createTimePicker() {
            var index = "";
            var endindex = "";
            var hour = "";
            var minit = "";

            for (let i = 0; i < 1430; i += 30) {
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
                if (i == 0) {
                    index +=
                        " <input type='radio' name='start_titme' checked='checked' value=" +
                        i +
                        " id=" +
                        i +
                        "> <label for=" +
                        i +
                        ">" +
                        hour +
                        ":" +
                        minit +
                        "</label>";
                } else {
                    index +=
                        " <input type='radio' name='start_titme' value=" +
                        i +
                        " id=" +
                        i +
                        "> <label for=" +
                        i +
                        ">" +
                        hour +
                        ":" +
                        minit +
                        "</label>";
                }
            }

            for (let i = 30; i < 750; i += 30) {
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
                if (i == 30) {
                    endindex +=
                        " <input type='radio' name='end_titme' checked='checked' value=" +
                        i +
                        " id=" +
                        i +
                        "> <label for=" +
                        i +
                        ">" +
                        hour +
                        ":" +
                        minit +
                        "</label>";
                } else {
                    endindex +=
                        " <input type='radio' name='end_titme' value=" +
                        i +
                        " id=" +
                        i +
                        "> <label for=" +
                        i +
                        ">" +
                        hour +
                        ":" +
                        minit +
                        "</label>";
                }
            }
            this.startTimePicker = index;
            this.endTimePicker = endindex;
            this.localStorage();
        },

        updateTimePicker() {
            var index = "";
            var endindex = "";
            var sum = Number(document.timepicker.start_titme.value);
            var hour = "";
            var minit = "";

            if (sum / 60 < 10) {
                hour = "0" + Math.floor(sum / 60);
            } else {
                hour = Math.floor(sum / 60);
            }
            if (sum % 60 == 0) {
                minit = "0" + (sum % 60);
            } else {
                minit = sum % 60;
            }
            document.getElementById("starttime").value = hour + ":" + minit;

            this.startTimeSum = sum;
            if (
                this.endTimeSum < this.startTimeSum + 30 ||
                this.endTimeSum - this.startTimeSum > 720
            ) {
                if ((sum + 30) / 60 < 10) {
                    hour = "0" + Math.floor((sum + 30) / 60);
                } else {
                    hour = Math.floor((sum + 30) / 60);
                }
                if ((sum + 30) % 60 == 0) {
                    minit = "0" + ((sum + 30) % 60);
                } else {
                    minit = (sum + 30) % 60;
                }
                document.getElementById("endtime").value = hour + ":" + minit;
                this.endTimeSum = sum + 30;
            }

            this.timePicker = false;

            for (let i = 0; i < 1430; i += 30) {
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
                index +=
                    " <input type='radio' name='start_titme' value=" +
                    i +
                    " id=" +
                    i +
                    "> <label for=" +
                    i +
                    ">" +
                    hour +
                    ":" +
                    minit +
                    "</label>";
            }
            var maxleg = "";
            if (sum + 30 * 25 > 1470) {
                maxleg = 1470;
            } else {
                maxleg = sum + 30 * 25;
            }

            for (let i = sum + 30; i < maxleg; i += 30) {
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

                endindex +=
                    " <input type='radio' name='end_titme' value=" +
                    i +
                    " id=" +
                    i +
                    "> <label for=" +
                    i +
                    ">" +
                    hour +
                    ":" +
                    minit +
                    "</label>";
            }
            this.startTimePicker = index;
            this.endTimePicker = endindex;
            this.Calculation();
            this.localStorage();
        },

        updateendTimePicker() {
            var sum = Number(document.timepicker.end_titme.value);
            var hour = "";
            var minit = "";
            this.endTimeSum = sum;
            if (sum / 60 < 10) {
                hour = "0" + Math.floor(sum / 60);
            } else {
                hour = Math.floor(sum / 60);
            }
            if (sum % 60 == 0) {
                minit = "0" + (sum % 60);
            } else {
                minit = sum % 60;
            }
            document.getElementById("endtime").value = hour + ":" + minit;
            this.endtimePicker = false;
            this.Calculation();
            this.localStorage();
        },

        starttime_judg() {
            this.timePicker = true;
        },

        endtime_judg() {
            this.endtimePicker = true;
        },

        async getAnyPins() {
            await axios.get("/api/reserve_page").then((response) => {
                this.anyMapData = response.data;
            });

            for (let i = 0; i < this.anyMapData.length; i++) {
                var map = new this.google.maps.Marker({
                    position: new this.google.maps.LatLng(
                        this.anyMapData[i].latitude,
                        this.anyMapData[i].longitude
                    ),
                    map: this.Map,
                    icon: atherpin,
                });
                this.anyMapDatas.push(map);

                var range = new this.google.maps.Circle({
                    center: new this.google.maps.LatLng(
                        this.anyMapData[i].latitude,
                        this.anyMapData[i].longitude
                    ),
                    map: this.Map,
                    radius: Number(this.anyMapData[i].area),
                    strokeColor: "#eaf07900",
                    fillColor: "#A58888",
                });

                this.anyMapDatasrange.push(range);
                var pop = new this.google.maps.InfoWindow({
                    content:
                        this.anyMapData[i].start_time.slice(0, -3) +
                        " ~ " +
                        this.anyMapData[i].end_time.slice(0, -3),
                    disableAutoPan: true,
                });
                pop.open(this.Map, this.anyMapDatas[i]); // 吹き出しの表示
            }
        },

        localStorage() {
            localStorage.setItem(
                "map",
                JSON.stringify({
                    locationName: document.getElementById("mapname").value,
                    time:
                        document.getElementById("date").value +
                        " " +
                        document.getElementById("starttime").value +
                        " 〜 " +
                        document.getElementById("endtime").value,
                    startTime: document.getElementById("starttime").value,
                    endTime: document.getElementById("endtime").value,
                    date: document.getElementById("date").value,
                    startTimesum: this.startTimeSum,
                    endTimesum: this.endTimeSum,
                    range: Number(document.range.radius.value),
                    rebgeSum: this.totalFee.radiusIndex,
                    latlng: this.totalFee.latlng,
                    totalTime: this.endTimeSum - this.startTimeSum,
                    totalFee: this.sumval,
                    DBdate: this.DBdate,
                })
            );
        },
        moveAmagumo() {
            var startLat = 35.685577;
            var startLng = 139.694858;
            var endLat = 35.694838;
            var endLng = 139.707784;
            var resstartLat = 35.685577;
            var resstartLng = 139.694858;
            var num = 0;
            var roopamp = setInterval(() => {
                var roop = new this.google.maps.GroundOverlay(
                    amagumo,
                    new this.google.maps.LatLngBounds(
                        new this.google.maps.LatLng(startLat, startLng),
                        new this.google.maps.LatLng(endLat, endLng)
                    ),
                    {
                        map: this.Map,
                        opacity: 0.8,
                    }
                );
                startLat += 0.0009;
                startLng += 0.0015;
                endLat = Number(startLat) + 0.009261;
                endLng = Number(startLng) + 0.012926;
                setTimeout(() => {
                    roop.setMap(null);
                }, 1000);
                num++;
                if (num == this.amagumoRoop / 30 + 1) {
                    num = 0;
                    startLat = resstartLat;
                    startLng = resstartLng;
                    endLat = Number(startLat) + 0.009261;
                    endLng = Number(startLng) + 0.012926;
                }
                if (
                    JSON.parse(localStorage.getItem("map")).totalTime / 30 !=
                    this.amagumoRoop / 30
                ) {
                    this.amagumoRoop = Number(
                        JSON.parse(localStorage.getItem("map")).totalTime
                    );
                    clearInterval(roopamp);
                    this.moveAmagumo();
                }
            }, 1000);
        },
    },
};
</script>

<style lang="scss">
.reservePage_main {
    display: flex;
    height: calc(100vh - 80px);
    color: #00473e;

    .map {
        position: relative;
        width: 70%;
        height: 100%;

        #map {
            width: 100%;
            height: 100%;
        }
        .mapimg {
            position: absolute;
            right: 0px;
            bottom: 0px;
        }
        .trigger {
            position: absolute;
            bottom: calc(50% - 50px);
            right: calc(50% - 26px);
            font-size: 5em;
            opacity: 0.5;
            font-weight: 100;
            user-select: none;
        }
    }
    .reservePage_main_contents {
        position: relative;
        width: 480px;
        height: 100%;

        .reservePage_main_input {
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: flex-start;
            width: 480px;
            .reservePage_main_input_title {
                font-weight: 700;
                font-size: 24px;
                padding: 16px 0;
            }
            .reservePage_main_input_form {
                position: relative;
                z-index: 1;
                width: 400px;
                padding: 16px 0;

                input {
                    width: 360px;
                    padding: 20px;
                    border-radius: 7px;
                    border: solid #00473e;
                    font-size: 16px;
                    color: #00473e;
                }
                input[type="text"]:focus {
                    outline: none;
                    border: solid #faae2b;
                }
                input[type="text"]:focus + .reservePage_main_input_form_title {
                    color: #faae2b;
                }
                .reservePage_main_input_form_title {
                    position: absolute;
                    background: #fff;
                    top: 5px;
                    left: 10px;
                    padding: 0 3px;
                    input[type="radio"] {
                        display: none;
                    }
                    label {
                        display: block;
                        padding: 15px 12.9px;
                        border-right: solid 3px #00473e;
                        color: #00473e;
                    }
                    input[type="radio"]:checked + label {
                        background: #00473e;
                        color: #ffffff;
                    }
                }
            }
            .reservePage_main_input_form_calendar {
                position: absolute;
                z-index: 100;
                width: 300px;
                display: flex;
                align-items: center;
                flex-direction: column;
                margin-left: 3px;
                margin-top: 239px;
                border-radius: 10px;
                padding: 16px 0;
                background: #fff;
                box-shadow: 0 10px 25px 0 rgba(0, 0, 0, 0.5);
            }
            .reservePage_main_input_timeform {
                position: relative;
                display: flex;
                align-items: center;
                width: 400px;
                margin: 20px 0px;
                .reservePage_main_input_timeform_title {
                    margin-right: 20px;
                    width: 100px;
                }

                .time_ipselect_wrap {
                    margin: 0 30px;
                }

                input[type="text"] {
                    border: solid #00473e 3px;
                    border-radius: 8px;
                    padding: 10px 15px;
                    width: 50px;
                    text-align: center;
                    font-size: 16px;
                    color: #00473e;
                }
                input[type="text"]:focus {
                    outline: none;
                    border: solid #faae2b;
                    color: #faae2b;
                }

                .touka {
                    z-index: 3;
                    position: absolute;
                    background: linear-gradient(
                        rgba(255, 255, 255, 0) 0,
                        #fff 80%
                    ); /* 徐々に透明にする */
                    height: 25px;
                    width: 85px;
                    border-radius: 7px;
                    transform: rotate(180deg);
                }
                .touka2 {
                    z-index: 3;
                    position: absolute;
                    background: linear-gradient(
                        rgba(255, 255, 255, 0) 0,
                        #fff 80%
                    ); /* 徐々に透明にする */
                    height: 25px;
                    width: 85px;
                    bottom: -230px;
                    border-radius: 7px;
                }

                .time_ipselect {
                    position: absolute;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    max-height: 190px;
                    overflow: scroll;
                    background: #fff;
                    border-radius: 7px;
                    padding: 20px 0;
                    box-shadow: 0 10px 25px 0 rgba(0, 0, 0, 0.5);
                    input[type="radio"] {
                        display: none;
                    }
                    label {
                        display: block;
                        padding: 6px 20px;
                        color: #00473e;
                    }
                }
                .time_ipselect::-webkit-scrollbar {
                    /* Chrome, Safari 対応 */
                    display: none;
                }
            }

            .reservePage_main_input_form_radius {
                display: flex;
                align-items: center;
                flex-direction: column;
                justify-content: center;

                .reservePage_main_input_form_radius_wrap {
                    margin-left: 5px;
                    width: 400px;
                    height: 54px;
                    border: #00473e solid 3px;
                    border-radius: 7px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    overflow: hidden;
                    margin-top: 8px;

                    input[type="radio"] {
                        display: none;
                    }
                    label {
                        display: block;
                        padding: 20px 16.9px;
                        border-right: solid 3px #00473e;
                        color: #00473e;
                    }
                    input[type="radio"]:checked + label {
                        background: #00473e;
                        color: #ffffff;
                    }
                }
            }
        }
        .reservePage_main_money {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            position: absolute;
            bottom: 0px;
            width: 480px;
            .reservePage_main_money_sum {
                display: flex;
                align-items: flex-end;
                justify-content: space-between;
                margin: 0 48px;
                p:nth-child(1) {
                    font-size: 18px;
                }
                p:nth-child(2) {
                    font-size: 36px;
                    font-weight: 700;
                }
                .enn {
                    font-size: 24px;
                }
            }
            .reservePage_main_money_next {
                width: 480px;
                a {
                    text-decoration: none;
                    // pointer-events: none;
                    div {
                        width: 448px;
                        height: 64px;
                        margin: 16px;
                        background: #faae2b;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 3px;
                        pointer-events: none;
                        p {
                            font-weight: 800;
                            font-size: 24px;
                            color: #fff;
                        }
                    }
                }
            }
        }
    }
}

.weight {
    font-weight: 800;
    user-select: none;
    color: #333;
}
.vc-container {
    border: none;
}

* {
    box-sizing: content-box;
}
</style>
