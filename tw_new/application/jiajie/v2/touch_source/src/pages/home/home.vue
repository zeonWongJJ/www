<template>
  <div class="home">
    <!--header-->
    <van-nav-bar title="首页" class="white" @click-right="onClickRight">
      <div slot="right"><i class="iconfont icon-saomiao"></i></div>
    </van-nav-bar>
    <div class="body">

      <!--十秒预约-->
      <div class="heder">
        <div class="heder_div" @click="$router.push({path:'/fastReservation'})">
          <div class="heder_div_img">
            <img src="../../assets/img/home/home_t1.png"/>
          </div>
          <div class="heder_div_text">
            10秒快速预约
          </div>
        </div>
        <div class="heder_div" @click="$router.push({path:'/releaseDemand'})">
          <div class="heder_div_img">
            <img src="../../assets/img/home/home_t2.png"/>
          </div>
          <div class="heder_div_text">
            发布需求
          </div>
        </div>
      </div>
      <!--轮播-->
      <div class="broadcast" @click="service_list(cate_list[0].id)">
        <img src="./assets/img/banner.png"/>
      </div>
      <!--中部-->
      <div class="box">
        <div class="centre" v-if="cate_list.length">
          <div class="centre_nai_li" @click="service_list(cate_list[5].id)">
            <div class="centre_div_le_text">
              <h4>{{cate_list[5].cat_name}}</h4>
              <span>{{cate_list[5].cate_remark}}</span>
            </div>
            <div class="centre_div_le_img imgs1">
              <img :src="cate_img_list[1]"/>
            </div>
          </div>
          <div class="centre_nai_li" @click="service_list(cate_list[2].id)">
            <div class="centre_div_le_text">
              <h4>{{cate_list[2].cat_name}}</h4>
              <span>{{cate_list[2].cate_remark}}</span>
            </div>
            <div class="centre_div_le_img imgs2">
              <img :src="cate_img_list[2]"/>
            </div>
          </div>
          <div class="centre_nai_li" style="margin-top:0.1rem;" @click="service_list(cate_list[1].id)">
            <div class="centre_div_le_text">
              <h4>{{cate_list[1].cat_name}}</h4>
              <span>{{cate_list[1].cate_remark}}</span>
            </div>
            <div class="centre_div_le_img imgs2">
              <img :src="cate_img_list[3]"/>
            </div>
          </div>
          <div class="centre_nai_li" style="margin-top: -0.5rem;" @click="service_list(cate_list[6].id)">

            <div class="centre_div_le_text">
              <h4>{{cate_list[6].cat_name}}</h4>
              <span>{{cate_list[6].cate_remark ? '' : cate_list[6].cat_name}}</span>
            </div>
            <div class="centre_div_le_img imgs1">
              <img :src="cate_img_list[4]"/>
            </div>
          </div>

          <!--<div class="centre_div_le" @click="service_list(cate_list[1].id)">
                        <div class="centre_div_le_text">
                            <h4>{{cate_list[1].cat_name}}</h4>
                            <span>{{cate_list[1].cate_remark}}</span>
                        </div>
                        <div class="centre_div_le_img">
                            <img :src="cate_img_list[0]" />
                        </div>
                    </div>
                    <div class="centre_div_ri" >
                        <div @click="service_list(cate_list[2].id)">
                            <div class="heder_div_img centre_div_ri_img">
                                <img :src="cate_img_list[1]" />
                            </div>
                            <div class="centre_div_ri_text">
                                <h4>{{cate_list[2].cat_name}}</h4>
                                <span>{{cate_list[2].cate_remark}}</span>
                            </div>
                        </div>
                        <div @click="service_list(cate_list[3].id)">
                            <div class="centre_div_ri_img2">
                                <img :src="cate_img_list[2]" />
                            </div>
                            <div class="centre_div_ri_text">
                                <h4>{{cate_list[3].cat_name}}</h4>
                                <span>{{cate_list[3].cate_remark}}</span>
                            </div>
                        </div>
                        </div>-->
        </div>
        <!--9宫各-->
        <div class="centre_nai">
          <ul>
            <li v-if="index>3" class="centre_nai_li flex" v-for="(item,index) in cate_list"
                @click="service_list(item.id)">
              <div class="centre_nai_li_img">
                <img :src="cate_img_list[index]"/>
              </div>
              <div class="centre_nai_li_text">
                <h4>{{item.cat_name}}</h4>
                <span>{{item.cate_remark || item.cat_name + item.cat_name}}</span>
              </div>
            </li>
            <li class="centre_nai_li" style="height: 1px;visibility: hidden;"></li>
            <li class="centre_nai_li" style="height: 1px;visibility: hidden;"></li>
            <li class="centre_nai_li" style="height: 1px;visibility: hidden;"></li>

          </ul>
        </div>
      </div>
    </div>
    <van-popup v-model="show_ewm_plus">
      <div class="showView" @click="show_ewm_plus = false">
        <div class="code" v-if=" $store.state.user_info">
          <img :src="uploadFileUrl + $store.state.user_info.user_qrcode"/>
        </div>
        <div class="bottom" style="text-align: center;padding: .2rem;">下单出示会员码，可积累积分</div>
      </div>
    </van-popup>
  </div>
</template>
<script>
  import api from '@/api/api'
  import utils from '@/utils/utils'

  export default {
    data() {
      return {
        uploadFileUrl: api.uploadFileUrl + '/',
        cate_list: [],
        cate_img_list: [
          // require('./assets/img/banner.png'),
          require('./assets/img/hoem_s.png'),
          require('./assets/img/renovation_clean.png'),
          require('./assets/img/office_clean.png'),
          require('./assets/img/deep_clean.png'),
          require('./assets/img/electrical_appliances_clean.png'),
          require('./assets/img/conduit_clean.png'),
          require('./assets/img/lampblack_clean.png'),
          require('./assets/img/wall_clean.png'),
        ],
        show_ewm_plus: false,
      }
    },
    mounted() { //生命周期
      // this.category_list = this.$store.state.category_list;
      this.init()
      //扫码回调
      window['onScanResultSuccess'] = res => {
        if (res.scan_result) {
          let reg = /^http(.*)/;
          if (res.scan_result.match(reg)) {
            window.location.href = res.scan_result
          }
        }
      }
    },
    methods: { //方法
      onClickRight() { //扫码
        if (utils.is_android()) {
          android.callQRCodeScan();
        }
        if (utils.is_ios()) {
          window.webkit.messageHandlers.callQRCodeScan.postMessage({});
        }
      },
      service_list(index) {
        this.$router.push({
          path: '/service_list',
          query: {
            id: index
          }
        })
      },
      onShop() {
        this.$router.push({
          path: '/onshop'
        })
      },

      init() {
        let lists = {}
        lists.condition = {
          parent_id: 0,
          cate_is_show: 1
        };
        lists.sort = {
          cate_sort: 'desc',
          id: 'desc'
        }
        this.$fetch('category_list', lists).then(rs => {
          this.cate_list = rs
        })
      },
    },

  }
</script>
<style scoped>
  @import "./assets/icon/iconfont.css";

  h4 {
    margin: 0;
    padding: 0;
  }

  .home {
    height: 100%;
  }

  .home .body {
    height: calc(100% - .46rem);
    overflow-y: auto;
  }

  .box {
    padding: 0 0.12rem;
    overflow: hidden;
  }

  .heder {
    padding: 0.1rem 0.12rem;
    display: flex;
    justify-content: space-between;
  }

  .heder_div {
    width: 48%;
    height: 0.55rem;
    box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
    text-align: center;
    display: flex;
    align-items: center;
    border-radius: 0.05rem;
  }

  .heder_div_img img {
    width: 0.24rem;
    height: 0.24rem;
    margin: 0 .15rem;
  }

  .heder_div_text {
    font-size: .16rem;
    font-weight: 700;
  }

  .broadcast {
    height: 1.37rem;
    margin: 0 0 0.1rem 0;
  }

  .broadcast img {
    height: 1.37rem;
    width: 100%;
  }

  .centre {
    margin-bottom: .1rem;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
  }

  .centre > div {
    width: 48%;
    /*height: 1.95rem;*/
    text-align: center;
  }

  .centre_div_le_img {
    width: auto;
    height: .6rem;
  }

  .centre_div_le_img > img {
    width: auto;
    height: 100%;
  }

  .centre_div_le {
    box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
  }

  .centre_div_le_text {
    margin: 0.1rem 0 0.2rem 0;
  }

  .centre_div_le_text h4 {
    font-size: 0.16rem;
    color: #18b4ed;
    margin-bottom: 0.05rem;
  }

  .centre_div_le_text span {
    font-size: 0.14rem;
    color: #b2b2b2;
  }

  .centre_div_ri > div {
    margin-bottom: .1rem;
    height: .925rem;
    box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
    display: flex;
    align-items: center;
  }

  .centre_div_ri .centre_div_ri_img img {
    width: .54rem !important;
    height: .42rem !important;
  }

  .centre_div_ri .centre_div_ri_img2 {
    width: .54rem;
    height: .42rem;
    margin: 0 .15rem;
  }

  .centre_div_ri .centre_div_ri_img2 img {
    width: .4rem !important;
    height: .58rem !important;
  }

  .centre_div_ri .centre_div_ri_text {
    text-align: left;
  }

  .centre_div_ri .centre_div_ri_text h4 {
    font-size: .16rem;
    margin-bottom: 0.05rem;
  }

  .centre_div_ri .centre_div_ri_text span {
    font-size: 0.14rem;
    color: #b2b2b2;
  }

  .centre_nai ul {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
  }

  .centre_nai_li {
    width: 48%;
    height: 100%;
    box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
  }

  .centre_nai_li div {
    text-align: center;
  }

  .centre_nai_li_img img {
    margin: 0.2rem 0 0.12rem 0;
    width: 60%;
    /*height: .375rem;*/
  }

  .centre_nai_li_text h4 {
    font-size: .16rem;
    margin-bottom: 0.05rem;
  }

  .centre_nai_li_text span {
    font-size: 0.14rem;
    color: #b2b2b2;
  }

  .flex {
    display: flex;
    align-items: center;
  }

  .imgs1 {
    padding: 0 0 0.9rem 0;
  }

  .imgs1 img {
    width: 1.32rem;
    height: 1.25rem;
  }

  .imgs2 {
    padding: 0 0 0.3rem 0;
  }

  .imgs2 img {
    width: 0.68rem;
    height: 0.82rem;
  }
</style>
