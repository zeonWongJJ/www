<template>
	<div class="system">
		<div class="setContainer">
      <van-nav-bar
        title="用餐情况"/>
			<div class="setMenu">
        <div class="form">
          <div class="checkbox_group">
            <van-checkbox-group  style="display: flex; align-content: center; font-size:0.16rem" v-model="week.result"  v-for="(week,length) in weekList" :key="length">
              <div style="margin-right: .2rem">{{week.name}}</div>
              <van-checkbox
                v-for="(item,index) in meal"
                :key="index"
                :name="index+1"
                checked-color="#18b4ed"
              >
                {{item}}
              </van-checkbox>
            </van-checkbox-group>
          </div>
          <van-checkbox v-model="weekRadio" style="margin-left: .1rem" checked-color="#18b4ed">其他天相同</van-checkbox>
        </div>
        <van-button size="large" round style="background: #18b4ed;color:#fff;margin-top: .2rem" @click="nextPage">下一步设置菜式喜好</van-button>
      </div>
		</div>

    <!--弹框设置用户名-->
    <van-popup v-model="showName" position="top" :close-on-click-overlay="false">
      <van-cell-group>
        <van-field
          v-model="realName"
          center
          clearable
          label="姓名"
          placeholder="请输入真实姓名"
        >
          <van-button slot="button" @click="setNameFinish" size="small" type="primary">下一步</van-button>
        </van-field>
      </van-cell-group>
    </van-popup>
	</div>
</template>

<script>
export default{
	data(){
		return{
			showName: true,
			realName: '',//真实姓名
      weekRadio: false,
      weekList: [
        {
          name: '周日',
          result:[]
        },
        {
          name: '周一',
          result:[]
        },
        {
          name: '周二',
          result:[]
        },
        {
          name: '周三',
          result:[]
        },
        {
          name: '周四',
          result:[]
        },
        {
          name: '周五',
          result:[]
        },
        {
          name: '周六',
          result:[]
        },

      ],
      meal: ['午餐','晚餐'],
		}
	},
  watch:{
    weekRadio(val){
      if(val){
        this.weekList.forEach(item => {
          item.result = this.weekList[0].result
        })
      }else{
        this.weekList.forEach((item,index) => {
          if(index > 0){
            item.result = []
          }
        })
      }
    }
  },
	methods:{
		setNameFinish(){
			if( this.realName != '' ){
				this.showName=false;
			}
		},
    nextPage(){
      let data = [];
      Object.keys(this.weekList).forEach(key => {
        data[key] = [];
        if(this.weekList[key].result.indexOf(1) != -1){//午餐
          data[key].lunch = 1
        }else{
          data[key].lunch = 0
        }
        if(this.weekList[key].result.indexOf(2) != -1){//晚餐
          data[key].dinner = 1
        }else{
          data[key].dinner = 0
        }
      })
      let req = {}
      req.member_id = this.$store.state.user_id;
      req.fullname = this.realName;
      req.meals = data;
      var qs = require('qs');
      this.$fetch('member_firstsetup',qs.stringify(req)).then(rs =>{
        this.$store.commit('username',this.realName);
        this.$router.replace('/');
      })
    }
	}
}
</script>

<style scoped>
  .setMenu{
    padding: .15rem;
  }
	.setMenu .van-popup--right{
		width:100%;
		height:100%;
		background:white;
	}
	.van-checkbox{
    margin-left: .1rem;
		display: inline-block;
	}
  .setMenu .form{
    display: flex;
  }
</style>
