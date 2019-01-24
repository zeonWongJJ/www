<template>
  <div class="setLikes">
    <van-nav-bar
      title="设置菜式喜好"
      left-arrow
      @click-left="onClickLeft"/>
    <div class="body">
      <div class="checkAll" style="display: flex;">选择您喜欢的菜式：<van-checkbox v-model="checkAll" checked-color="#18b4ed">全选</van-checkbox></div>
      <div class="checkBoxGroup">
        <van-checkbox-group v-model="result">
          <van-checkbox
            v-for="(item, index) in foodList"
            :key="index"
            :name="item.food_id"
            checked-color="#18b4ed"
            style="margin: .1rem .1rem 0;display: inline-block;"
          >
            {{ item.dish_name }}
          </van-checkbox>
        </van-checkbox-group>
      </div>
      <van-button size="large" round style="background: #18b4ed;color:#fff;margin-top: .2rem" @click="finish">完成</van-button>
    </div>
  </div>
</template>

<script>
  export default {
    name: "setLikes",
    data () {
      return {
        foodList: [],
        result: [],
        checkAll:false,
      }
    },
    watch: {
      checkAll (val) {
        this.result = []
        if(val){
          this.foodList.forEach(item => {
            this.result.push(item.food_id)
          })
        }
      }
    },
    created () {
      this.$fetch('food').then(rs => {
        this.foodList = rs.list
      })
      this.$fetch('member',require('qs').stringify({member_id: this.$store.state.user_id})).then(rs => {
        if(rs.favorite){
          this.result = rs.favorite
        }
      })
    },
    methods:{
      onClickLeft () {
        this.$router.back(-1)
      },
      finish () {
        let req = {};
        req.member_id = this.$store.state.user_id;
        req.favorite = this.result;
        this.$fetch('member_favorite',require('qs').stringify(req)).then(rs => {
          this.$toast('设置成功')
          setTimeout(()=>{
            this.onClickLeft()
          },1500)
        })
      }
    }
  }
</script>

<style lang="less" scoped>
  .setLikes{
    .body{
      padding: .15rem;
    }
  }
</style>
