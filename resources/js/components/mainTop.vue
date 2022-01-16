<template>
    <div>
        <div class="maintop_wrap">
            <div id="map" ref="googleMap" />
            <div class="searchBox">
                <img :src="'/images/glass.png'" alt="glass" class="glass_img">
                <input
                    type="text"
                    class="locationName_box"
                    id="locationName"
                    placeholder="エリア・キーワード・駅名など"/>
            </div>
            <div class="returnBtn">
                <img :src="'/images/Group73.png'" alt="現在地ボタン" @click="backAddress"/>
            </div>
            <div class="whetherBox">
                <div class="whetherBox_title">
                    <p>週間天気</p>
                    <p>{{yourPinConfig.locationName}}</p>
                </div>
                <div class="whetherBox_border" @v-if="rendering"></div>
                <span v-html="whetherIcon"></span>
                <div class="nextBtn">
                    <a href="/Reserve">
                        <div　class="nextBtnBox">
                            <p>予約する</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import GoogleMapsApiLoader from "google-maps-api-loader";
import axios from "axios";
import whether from "../../../public/data/whether.json";

//コンポーネント
import Header from "./components/Header.vue"

//画像
import yourPin from "../../../public/assets/mypin.png"
import atherPin from "../../../public/assets/atherpin.png"


export default({
    components: {
        Header
    },
    data() {
        return{
            google:"",
            Map:"",
            marker:"",
            anyMapData:[],
            anyMapDatas:[],
            anyMapDatasrange:[],
            prefectures:"東京都",
            locationName:"HAL東京",
            mapConfig: {
                center: {
                    lat: 35.691655,
                    lng: 139.696937,
                },
                zoom: 15,
                mapTypeControl: false,
                fullscreenControl: false,
                streetViewControl: false,
                zoomControl: false,
            },
            yourPinConfig: {
                prefectures:"東京都",
                locationName:"HAL東京",
                marker:"",
                center: {
                    lat: 35.691655,
                    lng: 139.696937
                }
            },
            whetherIcon:"",
            rendering:true
        }
    },
    async mounted() {
        //初期マップ生成用
        this.google = await GoogleMapsApiLoader({
            apiKey: "AIzaSyCbr524Eht2tpaHaFLvBShbHBy1m1uqBy4",
        });
        this.Map = await new this.google.maps.Map(
            this.$refs.googleMap,
            this.mapConfig
        );

        //当日の予約ピン表示
        await axios.get("/api/reserve_page").then((response) => {
            this.anyMapData=response.data;
        });
        for (let i = 0; i < this.anyMapData.length; i++) {
            var map =  new this.google.maps.Marker({
                position: new this.google.maps.LatLng(this.anyMapData[i].latitude,this.anyMapData[i].longitude),
                map: this.Map,
                icon: atherPin,
            });
            this.anyMapDatas.push(map);

            var range = new this.google.maps.Circle({
                center: new this.google.maps.LatLng(this.anyMapData[i].latitude,this.anyMapData[i].longitude),
                map: this.Map,
                radius: Number(this.anyMapData[i].area),
                strokeColor: "#eaf07900",
                fillColor: "#A58888",
            });

            this.anyMapDatasrange.push(range)
            var pop = new this.google.maps.InfoWindow({
                content:  this.anyMapData[i].start_time.slice(0,-3)+" ~ "+this.anyMapData[i].end_time.slice(0,-3),
                disableAutoPan: true
            });
            pop.open(this.Map, this.anyMapDatas[i]);
            document.getElementById("locationName").value=this.yourPinConfig.locationName;
        }

        this.Map.addListener("click", (e) => {
            this.toClickPoint(e)
        })

        document.getElementById("locationName").addEventListener('keypress',()=>{
            this.searchLocationName()
        });

        this.createYourPin()
        this.searchWhether()
        this.localStorage()
    },
    methods: {
        createYourPin(){
            this.yourPinConfig.marker = new this.google.maps.Marker({
                position: new this.google.maps.LatLng(this.yourPinConfig.center),
                map: this.Map,
                icon: yourPin,
            });
            this.Map.panTo(
                new this.google.maps.LatLng(this.yourPinConfig.center)
            );
        },
        toClickPoint(e){
            var lat = e.latLng.lat();
            var lng = e.latLng.lng();
            var data = { lat, lng };
            this.yourPinConfig.center = data;
            this.yourPinConfig.marker.setMap(null);
            this.yourPinConfig.marker = new this.google.maps.Marker({
                position: new this.google.maps.LatLng(data),
                map: this.Map,
                icon: yourPin,
            });
            this.Map.panTo(new this.google.maps.LatLng(data));
            this.searchLocationNameLatlng(e)
        },
        async searchLocationName(){
            await new this.google.maps.Geocoder().geocode({
                address:document.getElementById("locationName").value
            },async (results)=>{
                this.yourPinConfig.marker.setMap(null)
                this.yourPinConfig.marker = new this.google.maps.Marker({
                    position: new this.google.maps.LatLng(results[0].geometry.location),
                    map: this.Map,
                    icon: yourPin,
                });
                this.yourPinConfig.center = results[0].geometry.location;
                this.Map.panTo(new this.google.maps.LatLng(results[0].geometry.location));
                document.getElementById("locationName").value=results[0].formatted_address;
                this.yourPinConfig.locationName = document.getElementById("locationName").value

                await axios.post("/api", results[0].geometry.location).then((response) => {
                    var sum = response.data.results.length
                    this.yourPinConfig.prefectures = response.data.results[sum - 2].formatted_address.substr( 3, 4 )
                    this.searchWhether()
                    this.localStorage()
                });
            })
        },
        async searchLocationNameLatlng(e){
            const data = {
                lat: Number(e.latLng.lat()),
                lng: Number(e.latLng.lng()),
            };
            await axios.post("/api", data).then((response) => {
                this.yourPinConfig.locationName = response.data.results[0].formatted_address;
                var sum = response.data.results.length
                this.yourPinConfig.prefectures = response.data.results[sum - 2].formatted_address.substr( 3, 4 )
            });
            document.getElementById("locationName").value = this.yourPinConfig.locationName;
            this.yourPinConfig.center = this.mapConfig.center
            this.searchWhether()
            this.localStorage()
        },
        backAddress(){
            this.yourPinConfig.marker.setMap(null)
            this.yourPinConfig.marker = new this.google.maps.Marker({
                position: new this.google.maps.LatLng(this.mapConfig.center),
                map: this.Map,
                icon: yourPin,
            });
            document.getElementById("locationName").value = this.locationName;
            this.yourPinConfig.locationName = this.locationName
            this.Map.panTo(new this.google.maps.LatLng(this.mapConfig.center));
            this.yourPinConfig.prefectures = this.prefectures
            this.searchWhether()
            this.localStorage()
        },

        async searchWhether(){
            var whetherHtml = ""
            var result = ""
            var data = ""
            await axios.get("/api/whetherCode").then((response) => {
                for (var key in response.data.offices) {
                    if(response.data.offices[key].name == this.yourPinConfig.prefectures){
                        result=response.data.offices[key];

                    }
                }
            });
            var whetherPoint = "";
            var num = {number:result.children[1].substr( 0, 2 )};
            await axios.post("/api/whether", num).then((data)=>{
                whetherPoint = data.data[1].timeSeries[0].areas[0].weatherCodes;
            })
            var data=whether
            whetherHtml += "<div class='weeklyWhether'>"
            for(var i=0;i<7;i++){
                var date = new Date();
                whetherHtml += "<div class='weeklyWhetherBox'><div class='weeklyWhether_Date'>"+('0' + (date.getMonth() + 1)).slice(-2)+"/"+('0' +( Number(date.getDate()) + i)).slice(-2)+"</div>"
                for (var key in data) {
                    if(key === whetherPoint[i]){
                        whetherHtml+="<img 'weeklyWhether_Icon' src='https://www.jma.go.jp/bosai/forecast/img/"+data[key][2]+".svg'>"
                        break;
                    }
                }
                whetherHtml += "</div>"
            }
            whetherHtml += "</div>"
            this.whetherIcon = whetherHtml

            this.rendering=false
            this.rendering=true
        },
        localStorage() {
            localStorage.setItem(
                "map",
                JSON.stringify({
                    locationName: this.yourPinConfig.locationName,
                    time:"00:00~00:30",
                    startTime: "00:00",
                    endTime:"00:30",
                    date: 2021/12/12,
                    startTimesum: 0,
                    endTimesum: 30,
                    range:150,
                    rebgeSum: 1,
                    latlng: this.yourPinConfig.center,
                    totalTime:0,
                    totalFee:0,
                    DBdate:"0000-00-00"
                })
            );
        },
    }
})
</script>

<style lang="scss">
    .maintop_wrap{
        position: relative;
        width: 100vw;
        height: calc(100vh - 80px);
        #map{
            width: 100%;
            height: 100%;
        }
        .searchBox{
            position: absolute;
            top: 0px;
            background: #fff;
            border-radius: 40px;
            box-shadow: 0 10px 25px 0 rgba(0, 0, 0, .5);
            margin: 16px;
            display: flex;
            align-items: center;
            padding: 16px 16px;
            .glass_img{
                width: 20px;
                padding: 0 8px;

            }
            .locationName_box{
                width: 350px;
                margin-left: 8px;
                color: #00473E;
                outline: 0;
            }
        }
        .returnBtn{
            position: absolute;
            bottom:8px;
            right: 8px;
        }
        .whetherBox{
            position: absolute;
            left: 0;
            right: 0;
            margin: auto;
            bottom: 0px;
            height:250px;
            width: 60vw;
            background: #fff;
            border-radius: 100px 100px 0  0;
            padding: 50px 50px 0 50px;
            .whetherBox_title{
                display: flex;
                align-items: flex-end;
                color: #00473E;
                p:nth-child(1) {
                    font-size: 24px;
                    font-weight: 700;
                }
                p:nth-child(2) {
                    font-size: 18px;
                    margin-left: 16px;
                }
            }
            .whetherBox_border{
                background-color: #00473E;
                height: 1px;
                width: 62px;
                margin: 16px 0 16px 16px;
            }
            .weeklyWhether{
                width: 100%;
                display: flex;
                .weeklyWhetherBox{
                    width: 80%;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: space-between;
                     .weeklyWhether_Date{

                    }

                    .weeklyWhether_Icon{

                    }
                }

            }
            .nextBtn{
                margin-top: 32px;
                display: flex;
                justify-content: center;
                .nextBtnBox{
                    width: 400px;
                    height: 54px;
                    background-color: #FAAE2B;
                    border-radius: 11px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    p{
                        color: #fff;
                        font-size: 18px;
                        font-weight: 700;
                    }
                }
            }
        }
    }
</style>
