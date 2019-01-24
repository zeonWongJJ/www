<template>
  <section>
    <section v-if="order_info.order_belong_store_id == 20">
      <div class="com_tit" v-if="order_info.order_pay_state_dsc == 'CLOSED'">
        {{is_store_page ? '交易关闭' : '已关闭'}}
      </div>
      <div class="com_tit" v-if="order_info.order_pay_state_dsc === 'PENDING_PAY'">待付款</div>
      <div class="com_tit" v-if="order_info.order_pay_state_dsc === 'PAYING'">交易处理中</div>
      <div class="com_tit" v-else-if="order_info.order_bis_state_dsc === 'PENDING_ORDER'">待接单</div>
      <div class="com_tit" v-else-if="order_info.order_bis_state_dsc === 'PENDING_ASSIGN'">待分配</div>
      <div class="com_tit" v-else-if="order_info.order_bis_state_dsc === 'PENDING_DOOR'">待上门</div>
      <div class="com_tit" v-else-if="order_info.order_bis_state_dsc === 'IN_SERVICE'">服务中</div>
      <div class="com_tit" v-else-if="order_info.order_bis_state_dsc === 'PENDING_EVALUATE'">待评价</div>
      <div class="com_tit" v-else-if="order_info.order_pay_state_dsc === 'REFUND_PROCESSING'">退款处理中</div>
      <div class="com_tit" v-else-if="order_info.order_pay_state_dsc === 'REFUNDED'">已退款</div>
      <div class="com_tit" v-else-if="order_info.order_bis_state_dsc === 'CLOSED'">已关闭</div>
      <div class="com_tit" v-else-if="order_info.order_bis_state_dsc === 'COMPLETED'">{{is_store_page ? '交易成功' : '已完成'}}</div>
    </section>
    <section v-else>
      <div class="com_tit" v-if="order_info.order_state == 4">
        {{is_store_page ? '交易关闭' : '已关闭'}}
      </div>
      <!--<div class="com_tit" v-else-if="order_info.order_is_peddling == 1">交易处理中</div>-->
      <div class="com_tit" v-else-if="order_info.order_state == 0">待付款</div>
      <div class="com_tit" v-if="order_info.order_belong_store_id == 0 && order_info.order_state == 1">待接单</div>
      <div class="com_tit" v-if="order_info.order_belong_store_id != 0 && order_info.order_state == 1 && !order_info.appointed_uid">待服务</div>
      <div class="com_tit" v-if="order_info.order_state == 2 && order_info.order_sm_at == 0">待上门</div>
      <div class="com_tit" v-if="order_info.order_state == 3 && order_info.order_rate == 0">服务中</div>

      <div class="com_tit" v-if="order_info.order_comment_id == 0 && order_info.order_rate == 1">待评价</div>
      <div class="com_tit"
           v-if="order_info.order_rate == 1 && order_info.order_comment_id != 0 && order_info.order_state == 5">
        {{is_store_page ? '交易成功' : '已完成'}}
      </div>
    </section>
    <div class="com_tit" v-else>交易成功</div>
  </section>
</template>

<script>
  export default {
    name: 'order_state',
    data() {
      return {}
    },
    props: ['order_info', 'is_store_page']
  }
</script>

<style scoped>
  .com_tit {
  	/*position: absolute;*/
  	z-index: 999;
    font-size: .12rem;
    color: red;
    margin: -0.05rem 0.14rem 0 0;
  }
</style>
