<template>
  <div class="home">
    <van-nav-bar title="用餐人数统计" >
    </van-nav-bar>
    <div class="box">
      <div class="onul">
        <ul class="uls">
          <li class="lis" :class="{lis_id : index + 1 == num}"  v-for="(item,index) in list" @click="list_num(index + 1)">
            <!--<span>-->
            {{item}}
            <!--</span>-->
          </li>
        </ul>
        <div class="text">
          <div class="wu">
            <div>
              午餐 <span>{{lunch_number}}</span>人
            </div>
            <div>
							<span v-if="my_lunch == 1" class="span_d">
								[我已点餐]
							</span>
              <span v-else class="span_w">
								[我未点餐]
							</span>
            </div>
          </div>
          <div class="wan">
            <div>
              晚餐 <span>{{dinner_nubmer}}</span>人
            </div>
            <div>
							<span v-if="my_dinner == 1" class="span_d">
								[我已点餐]
							</span>
              <span v-else class="span_w">
								[我未点餐]
							</span>
            </div>
          </div>
        </div>
      </div>
      <!--喜欢菜式-->
      <div class="box_cai">
        <div class="box_cai_title">
          喜好菜式排名
        </div>
        <ul>
          <li class="box_cai_li" v-for="item in cai_list">
            <div class="box_cai_text">
              {{item.dish_name}}
            </div>
            <div class="box_cai_hua">
              <van-slider v-model="item.favorite" bar-height="0.05rem" disabled />
            </div>
            <div class="box_cai_text">
              {{item.favorite}}个人表示喜欢
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
  import utils from '@/utils/utils'
  export default {
    data() {
      return {
        list: ['周一', '周二', '周三', '周四', '周五', '周六', '周日'],
        num: new Date().getDay(),
        lunch_number:0,
        dinner_nubmer:0,
        my_lunch:false,
        my_dinner:false,
        cai_list:[]
      }
    },
    mounted() {
      this.list_num()
      this.food();

    },
    methods: {
      onClickLeft() {
        this.$router.push({
          path: '/dishes_memder'
        })
      },
      food(){
        this.$fetch('food').then(rs => {
          this.cai_list=rs.list
        })
      },
      list_num(index){
        const newNum =  new Date().getDay()
        index ? this.num = index : index = this.num
        const date = new Date().getTime() + (index - newNum) * 24 * 60 * 60 * 1000;
        let req = {};
        req.member_id = this.$store.state.user_id;
        req.date = utils.format(date);
        this.$fetch('order_count',this.$qs.stringify(req)).then(rs => {
          this.lunch_number = rs.lunch_number;
          this.dinner_nubmer = rs.dinner_nubmer;
          this.my_lunch = rs.my_lunch;
          this.my_dinner = rs.my_dinner;
        })
      },
    },
  }
</script>

<style scoped lang="less">
  .home {
    height: 100%;
    width: 100%;
    background: url("../../../static/images/home_bgi.jpg") no-repeat;
    background-size: 100% 100%;
    .box {
      padding: 0 0.12rem;
      margin-top: .1rem;
      .onul {
        margin-bottom: .1rem;
        .uls {
          display: flex;
          justify-content: space-between;
          .lis {
            height: .44rem;
            line-height: .44rem;
            margin-bottom: .1rem;
            text-align: center;
            font-size: .18rem;
          }
          .lis_id {
            color: #f00;
          }
        }
        .text{
          .wan , .wu{
            font-size: .16rem;
            height: .4rem;
            display: flex;
            align-items: center;
            justify-content:space-around ;
            .span_d{
              color:#f00
            }
            .span_w{
              color:#666
            }
          }
        }
      }
      .box_cai{
        position: absolute;
        top: 2.1rem;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 0 0.12rem;
        overflow: auto;
        .box_cai_title{
          padding-bottom: .1rem;
          margin-bottom: .1rem;
          border-bottom: .01rem solid #eee;
          font-size: .18rem;
        }
        .box_cai_li{
          display: flex;
          height: .44rem;
          line-height: .44rem;
          align-items: center;
          font-size: .12rem;
          justify-content: space-between;
          .box_cai_text{
            flex: 0 0 25%;
          }
          .box_cai_hua{
            margin-right: 1%;
            flex: 0 0 48%;
          }
        }
      }
    }

  }
</style>
<style type="text/css">

</style>
