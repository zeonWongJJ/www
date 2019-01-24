<template>
  <div class="mingxi">
    <van-nav-bar title="禁用/启用" left-arrow @click-left="onClickLeft">
    </van-nav-bar>
    <div class="box">
      <div class="jin_b">
        <div class="jin_text">
          禁用或启用就餐
        </div>
        <div class="jin_bot">

          <van-switch
            :value="checked"
            size="36px"
            active-color="#4b0"
            inactive-color="#f44"
            @input="onInput"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { Switch } from 'vant';
  export default {
    data() {
      return {
        checked: true


      }
    },
    mounted() {

    },
    methods: {
      onClickLeft() {
        this.$router.push({
          path: '/dishes_memder'
        })
      },
      onInput(checked) {
        console.log(checked)
        if(checked == true){
          this.$dialog.confirm({
            title: '提醒',
            message: '是否启用就餐？'
          }).then(() => {
            this.checked = checked;
          });
        }else {
          this.$dialog.confirm({
            title: '提醒',
            message: '是否禁用就餐？'
          }).then(() => {
            this.checked = checked;
          });
        }


      }
    },
  }
</script>

<style scoped lang="less">
  .mingxi{
    .box{
      padding: 0 .12rem;
      .jin_b{
        margin-top: .2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        .jin_text{
          font-size: .18rem;
        }
      }
    }
  }
</style>
<style>
  .van-dialog__message--has-title {
    text-align: center;
  }
</style>

