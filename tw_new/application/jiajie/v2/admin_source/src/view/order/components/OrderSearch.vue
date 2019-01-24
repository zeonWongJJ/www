<template>
  <div>
    <Form :label-width="60">
      <Row>
        <Col span="5">
          <ButtonGroup style="width: 100%;">
            <Button style="width: 33%;" type="default">今天</Button>
            <Button style="width: 33%;"  type="default">昨天</Button>
            <Button style="width: 33%;"  type="default">最近7天</Button>
          </ButtonGroup>
        </Col>
        <Col span="6">
          <Select style="width: 34%; float: left; margin-right: 1%;">
            <Option value="beijing">创建时间</Option>
            <Option value="shanghai">支付时间</Option>
          </Select>
          <DatePicker style="width: 30%; float: left; margin-right: 1%;" type="date" placeholder="开始日期"></DatePicker>
          <DatePicker style="width: 30%; float: left;" type="date" placeholder="结束日期"></DatePicker>
        </Col>
        <Col span="4">
          <FormItem label="交易状态">
            <Select>
              <Option v-for="(state, key) in orderPayStateMap" :value="key">{{state}}</Option>
            </Select>
          </FormItem>
        </Col>
        <Col span="4">
          <FormItem label="业务状态">
            <Select>
              <Option v-for="(state, key) in orderBisStateMap" :value="key">{{state}}</Option>
            </Select>
          </FormItem>
        </Col>
        <Col span="4">
          <FormItem label="交易性质">
            <Select>
              <Option v-for="(type, index) in orderTypeMap" :value="index">{{type}}</Option>
            </Select>
          </FormItem>
        </Col>
      </Row>
      <Row>
        <Col span="4">
          <FormItem label="交易方式">
            <Select>
              <Option v-for="(way, index) in payWayMap" :value="index">{{way}}</Option>
            </Select>
          </FormItem>
        </Col>
        <Col span="4">
          <FormItem label="下单手机">
            <Input placeholder="Enter something..."></Input>
          </FormItem>
        </Col>
        <Col span="4">
          <FormItem label="快速查询">
          <Select>
            <Option value="1">急需跟进</Option>
            <Option value="0">进行中</Option>
          </Select>
          </FormItem>
        </Col>
        <Col span="6">
          <FormItem label="流向">
            <RadioGroup>
              <Radio label="male">流出</Radio>
              <Radio label="female">流入</Radio>
              <Radio label="female">所有</Radio>
            </RadioGroup>
          </FormItem>
        </Col>
      </Row>
    </Form>
    <Button type="primary" icon="ios-search">搜索</Button>
  </div>
</template>

<script>
export default {
  name: 'OrderSearch',
  props: {
    orderTypeMap: {
      type: Object,
      default () {
        return {}
      }
    },
    payWayMap: {
      type: Object,
      default () {
        return {}
      }
    },
    orderBisStateMap: {
      type: Object,
      default () {
        return {
          SET_UP: '已下单',
          LOCKING: '已锁定',
          PENDING_ORDER: '待接单',
          PENDING_ASSIGN: '待分配',
          PENDING_DOOR: '待上门',
          IN_SERVICE: '服务中',
          PENDING_EVALUATE: '待评价',
          CLOSED: '已关闭',
          COMPLETED: '已完成'
        }
      }
    },
    orderPayStateMap: {
      type: Object,
      default () {
        return {
          PENDING_PAY: '待支付',
          PAYING: '支付中',
          PAY_SUCCESS: '付款成功',
          REFUND_PROCESSING: '退款中',
          REFUNDED: '已退款'
        }
      }
    }
  },
  data () {
    return {}
  }
}
</script>

<style lang="less" scoped>
.ivu-col {
  padding: 0 5px;
}
</style>
