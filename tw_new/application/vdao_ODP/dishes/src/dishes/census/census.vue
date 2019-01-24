<template>
  <div class="census">
    <div>
      <van-nav-bar
        title="用餐人员统计"
      />
      <div class="mouth">
          <van-tabbar v-model="active" :fixed="false">
            <van-tabbar-item v-for="item in monthList" @click="onSelect(item)" :key="item.name">{{item.name}}</van-tabbar-item>
            <van-tabbar-item @click="moreMon">更多</van-tabbar-item>
          </van-tabbar>
      </div>
      <div class="order">
        <van-cell
          @click="detail(item)"
          v-for="item in haveEat"
          is-link
          value="用餐明细"
          :label="monthValue == monthList[0].month ? '预计' + item.meal_times + '次' : item.meal_times + '次'"
          :title="item.fullname"
          :key="item.fullname"
          arrow-direction="right" />
        <div v-if="haveEat.length == 0" style="margin-top: 1rem;text-align: center;">暂无数据</div>
      </div>

    </div>
    <van-actionsheet
      v-model="showMon"
      :actions="monthList"
      @select="onSelect"
    />
  </div>
</template>

<script>
  export default{
    data(){
      return{
        active: 1,
        showMon:false,
        monthList:[],
        haveEat:[],
        monthValue:0,
      }
    },
    mounted() {
      this.setMonthList();
      this.onSelect(this.monthList[0]);
    },
    methods:{
      moreMon(){
        this.showMon=true;
      },
      detail(item){
        this.$router.push({
          path: '/censusDetails',
          query:{
           data:item
          }
        })
      },
      setMonthList () {
        let newYear = new Date().getFullYear();
        let newMonth = new Date().getMonth() + 2;
        for(var i=0;i<4;i++){
          let json = {};
          newMonth--
          if(newMonth == 0){
            newMonth = 12
            newYear--
          }
          json.month = newMonth;
          json.date = newYear + '-' + this.add0(newMonth);
          json.name = newMonth + '月'
          this.monthList.push(json)
        }
        this.monthValue = this.monthList[0].month;
      },
      add0 (num) {
        return num > 9 ? num : '0' + num
      },
      onSelect (data) {
        this.monthValue = data.month;
        this.$fetch('order_meal_list',
          this.$qs.stringify({
            date: data.date
          })
        ).then(rs => {
          if(rs.list){
            this.haveEat = rs.list
          }else{
            this.haveEat = []
          }
        })
        this.showMon = false;
      },
    }
  }
</script>

<style scoped>
  .mouth{
    display: flex;
  }
  .van-tag{
    color:green;
    background:none;
  }

</style>
<style>
  .census .van-tabbar-item__text{
    font-size:0.14rem !important;
  }
</style>
