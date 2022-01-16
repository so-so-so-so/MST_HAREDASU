<template>
    <div>
        <div v-if="list == true" class="reserve-list-wrap">
            <!-- 予約履歴一覧の表示 -->
            <!-- 予約履歴件数文v-forで回す -->
            <div v-if="reserves.length">
                <div
                    v-for="(reserve, index) in reserves"
                    :key="reserve.id"
                    class="reserve"
                >
                    <p>{{ reserve.address }}</p>
                    <p>
                        {{ reserve.date }} {{ reserve.start_time }}-{{
                            reserve.end_time
                        }}
                    </p>
                    <button class="button" @click="showDetail(index)">
                        詳細
                    </button>
                </div>
            </div>
            <div v-else>
                <p>予約情報はありません</p>
            </div>
        </div>
        <div v-else class="reserve-detail-wrap">
            <!-- 予約詳細 -->
            <div class="content-wrap">
                <div class="info-wrap">
                    <p class="info-title">予約情報</p>
                    <div id="map" ref="googleMap"></div>
                    <div class="info-contents">
                        <p>場所</p>
                        <p>{{ reserves[reserveId].address }}</p>
                    </div>
                    <div class="info-contents">
                        <p>日時</p>
                        <p>
                            {{ reserves[reserveId].date }}
                            {{ reserves[reserveId].start_time }}-{{
                                reserves[reserveId].end_time
                            }}
                        </p>
                    </div>
                    <div class="info-contents">
                        <p>範囲</p>
                        <p>{{ reserves[reserveId].area }}</p>
                    </div>
                </div>
                <div class="others-wrap">
                    <!-- 料金詳細、支払い情報(右側のblock)tate -->
                    <div class="cost-wrap">
                        <p class="cost-title">料金詳細</p>
                        <div class="cost-contents">
                            <p>基本料金</p>
                            <p>
                                {{ reserves[reserveId].cost }}
                            </p>
                        </div>
                        <div class="cost-contents">
                            <p>利用時間</p>
                            <p>{{ reserves[reserveId].total }}時間</p>
                        </div>
                        <div class="cost-border"></div>
                        <div class="cost-contents total">
                            <p>基本料金</p>
                            <p>
                                {{ reserves[reserveId].cost }}
                            </p>
                        </div>
                    </div>
                    <!-- <div class="card-wrap">
            <div class="card-contents">
              <p>お支払い情報</p>
              <p>{{ reserves[num].cardNum }}</p>
              <a href="#">変更</a>
            </div>
          </div> -->
                </div>
            </div>
            <div class="btn-wrap" :class="btnWrap">
                <button class="button submit-button" @click="list = true">
                    戻る
                </button>
                <button
                    class="button submit-button danger"
                    v-show="reserves[reserveId].cancel == true"
                    @click="openModal()"
                >
                    キャンセル
                </button>
            </div>
            <!-- キャンセルボタン押した時のモーダル -->
            <transition name="modal" appear v-if="modal">
                <div class="modal modal-overlay" @click="closeModal()">
                    <div class="modal-window">
                        <div class="modal-title-block">
                            <p class="title">予約キャンセル</p>
                            <p class="introduction">
                                下記の予約をキャンセルしますか？
                            </p>
                        </div>
                        <div class="modal-body">
                            <div class="info-wrap">
                                <!-- <div id="map" ref="googleMap"></div> -->
                                <div class="info-contents">
                                    <p>場所</p>
                                    <p>{{ reserves[reserveId].address }}</p>
                                </div>
                                <div class="info-contents">
                                    <p>日時</p>
                                    <p>
                                        {{ reserves[reserveId].date }}
                                        {{ reserves[reserveId].start_time }}-{{
                                            reserves[reserveId].end_time
                                        }}
                                    </p>
                                </div>
                                <div class="info-contents">
                                    <p>範囲</p>
                                    <p>{{ reserves[reserveId].area }}</p>
                                </div>
                                <div class="info-contents">
                                    <p>金額</p>
                                    <p>{{ reserves[reserveId].cost }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-btn">
                            <button
                                class="button submit-button"
                                @click="closeModal()"
                            >
                                戻る
                            </button>
                            <button
                                class="button submit-button danger"
                                @click="submit()"
                            >
                                キャンセル
                            </button>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>
<script>
import GoogleMapsApiLoader from "google-maps-api-loader";
import mypin from "../../../../../public/assets/mypin.png";

export default {
    components: {},
    data() {
        return {
            reserveId: Number,
            list: true,
            modal: false,
            btnWrap: "",

            google: null,
            Map: "",
            mapConfig: {
                center: {
                    lat: 0.0,
                    lng: 0.0,
                },
                zoom: 15,
                mapTypeControl: false,
                fullscreenControl: false,
                streetViewControl: false,
                zoomControl: false,
                disableDoubleClickZoom: true,
                scrollwheel: false,
                draggable: false,
                clickable: false,
            },
            reserves: [],
            counter: 0,
        };
    },
    computed: {},
    async mounted() {
        this.google = await GoogleMapsApiLoader({
            apiKey: "AIzaSyCbr524Eht2tpaHaFLvBShbHBy1m1uqBy4",
        });
        var url = "/api/user_reserves";
        axios.get(url).then((res) => {
            this.reserves = res.data;
            for(let i = 0; i < this.reserves.length; i++){
                //start_timeとend_timeをDate型で変数に格納
                const start = new Date(this.reserves[i].date + "T" + this.reserves[i].start_time);
                const end = new Date(this.reserves[i].date + "T" + this.reserves[i].end_time);

                //start_timeとend_timeの時差求めて変数に格納
                let total = start.getTime() - end.getTime();
                total = Math.abs(total) / (60*60* 1000);

                //this.reservesのdate,start_time,end_timeの表示形式変更
                this.reserves[i].date = this.reserves[i].date.replace(/-/g, "/");
                this.reserves[i].start_time = ('0' + start.getHours()).slice(-2) + ":" + ('0' + start.getMinutes()).slice(-2);
                this.reserves[i].end_time = ('0' + end.getHours()).slice(-2) + ":" + ('0' + end.getMinutes()).slice(-2);

                //詳細ボタン押した時に現在時刻と比較するためのstart_time作成
                this.reserves[i].start_time_calc = start;
                this.reserves[i].cancel = false;

                //this.reservesに、start_timeとend_timeの時差total追加
                this.reserves[i].total = total;
            }
        });
        console.log(this.reserves);
        console.log("aaa");
    },
    methods: {
        openModal() {
            this.modal = true;
        },
        closeModal() {
            this.modal = false;
        },
        showDetail(reserveId) {
            this.list = false;
            this.reserveId = reserveId;
            console.log(this.reserveId);

            ///////////////////////////
            //詳細ボタン押された時の時間取得、数値に変換
            let now = new Date();
            now = now.getFullYear() + "" +  (now.getMonth() + 1) + "" +  now.getDate();
            now = Number(now);

            //予約開始時刻を数値に変換
            let start = new Date(this.reserves[reserveId].start_time_calc);
            start = start.getFullYear() + "" +  (start.getMonth() + 1) + "" +  start.getDate();
            start = Number(start);

            //現在時刻と予約開始時刻比較
            const diff = start - now;
            if(diff >= 1){
                this.reserves[reserveId].cancel = true;
                this.btnWrap = "double";
            }else{
                this.reserves[reserveId].cancel = false;
                this.btnWrap = "single";
            }
            ///////////////////////////

            const lat = this.reserves[reserveId].latitude;
            const lng = this.reserves[reserveId].longitude;
            this.$nextTick(function () {
                this.Map = new this.google.maps.Map(
                    this.$refs.googleMap,
                    this.mapConfig
                );
                this.marker = new this.google.maps.Marker({
                    position: new this.google.maps.LatLng(lat, lng),
                    map: this.Map,
                    icon: mypin,
                });
                this.nowMappin = new this.google.maps.Circle({
                    center: new this.google.maps.LatLng(lat, lng),
                    map: this.Map,
                    radius: 150,
                    strokeColor: "#eaf07900",
                    fillColor: "#A58888",
                });
                this.Map.panTo(new this.google.maps.LatLng(lat, lng));
            });
        },
        submit() {
            //url 書き換えてコントローラー指定
            var url = "/api/reserve_delete";
            var params = {
                id: this.reserves[this.reserveId].id,
            };
            console.log(this.reserveId);
            console.log(this.reserves[this.reserveId].id);
            axios.post(url, params).then((response) => {
                //処理
                console.log(response.data);
                //予約(Reserve)削除
                if (response.data == true) {
                    window.location = "/user_page";
                }
            });
        },
    },
};
</script>
