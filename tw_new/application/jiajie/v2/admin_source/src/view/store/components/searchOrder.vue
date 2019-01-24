<template>
 <div>
    <Form :label-width="100" v-model="searchForm">
      <Row>
      	<Col span="6" style="margin-right:10px;">
          <FormItem label="搜索订单号">
            <Input v-model="searchForm.orderNum" placeholder="Enter something..."></Input>
          </FormItem>
        </Col>
        <Col span="6" style="margin-right:10px;">
          <FormItem label="搜索资金变动">
            <Input  v-model="searchForm.money" placeholder="Enter something..."></Input>
          </FormItem>
        </Col>
       	<Col span="4" style="margin-right:10px;">
        	<Button @click="sub()" type="primary" icon="ios-search">搜索</Button>
       	</Col>
      </Row>
    </Form>
  </div>
</template>

<script>
export default{
  data (){
    return {
      searchForm: {
        orderNum: '',
        money: '',
      }
    }
  },
  methods:{
    sub(){
    }
  }
}
</script>
