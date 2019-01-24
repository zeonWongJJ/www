<template>
  <Card title="收费策略设置">
    <div slot="extra">
      <Button size="small" type="primary" @click="$router.push({name: 'servicesIndex'})">返回服务列表</Button>
    </div>
    <Tabs value="periodicity" id="chargeStrategyTabs">
      <TabPane label="周期性弹性价格" name="periodicity">
        <Form v-model="elasticForm" :label-width="80">
          <FormItem label="选择周期：" prop="choose_date" style="float: left; width: 300px;">
            <Select v-model="elasticForm.choose_date" style="width: 160px;">
              <Option v-for="(day, index) in daysItems" :key="index" :value="day.key">{{day.title}}</Option>
            </Select>
          </FormItem>
          <FormItem label="开始时间：" prop="user" style="float: left; width: 250px;">
            <TimePicker :value="customForm.time_interval"
                        @on-change="handleElasticFormChange"
                        format="HH:mm"
                        type="timerange"
                        placement="bottom-end"
                        placeholder="点击选择"></TimePicker>
          </FormItem>
          <div style="clear: both"></div>
          <FormItem label="改动：" prop="user" style="float: left; width: 250px;">
            <Select v-model="customForm.diff_type" style="width: 160px;">
              <Option v-for="(type, index) in chargeType"
                      :key="index"
                      :value="type.type">{{type.title}}</Option>
            </Select>
          </FormItem>
          <FormItem label="价格：" prop="price_change" style="float: left; width: 250px;">
            <Input v-model="elasticForm.price_change" placeholder="输入变动价格多少"></Input>
          </FormItem>
          <Button style="margin-left: 30px;" type="primary"
                  shape="circle" icon="md-add"
                  @click="addRuleItem('elasticForm')"></Button>
        </Form>
        <div style="clear: both"></div>
        <Table :columns="customColumns" :data="elasticData"></Table>
      </TabPane>
      <TabPane label="自定义弹性价格" name="custom">
        <Form v-model="customForm" :label-width="80">
          <FormItem label="选择日期：" prop="choose_date"
                    style="float: left; width: 300px;">
            <DatePicker :value="customForm.choose_date"
                        @on-change="handleCustomDateChange"
                        type="date" placeholder="选择日期"
                        style="width: 200px"></DatePicker>
          </FormItem>
          <FormItem label="开始时间：" prop="time_interval"
                    style="float: left; width: 250px;">
            <TimePicker :value="customForm.time_interval"
                        format="HH:mm"
                        type="timerange"
                        @on-change="handleCustomFormChange"
                        placement="bottom-end"
                        placeholder="点击选择"></TimePicker>
          </FormItem>
          <div style="clear: both"></div>
          <FormItem label="改动：" prop="diff_type" style="float: left; width: 250px;">
            <Select v-model="customForm.diff_type" style="width: 160px;">
              <Option v-for="(type, index) in chargeType"
                      :key="index"
                      :value="type.type">{{type.title}}</Option>
            </Select>
          </FormItem>
          <FormItem label="价格：" prop="price_change" style="float: left; width: 250px;">
            <Input v-model="customForm.price_change"
                   placeholder="输入变动价格多少"></Input>
          </FormItem>
          <Button style="margin-left: 30px;" type="primary"
                  shape="circle" icon="md-add"
                  @click="addRuleItem('customForm')"></Button>
        </Form>
        <div style="clear: both"></div>
        <Table :columns="customColumns" :data="customData"></Table>
      </TabPane>
    </Tabs>
  </Card>
</template>

<script>
const daysItems = [
  {
    key: 1,
    title: '星期一'
  },
  {
    key: 2,
    title: '星期二'
  },
  {
    key: 3,
    title: '星期三'
  },
  {
    key: 4,
    title: '星期四'
  },
  {
    key: 5,
    title: '星期五'
  },
  {
    key: 6,
    title: '星期六'
  },
  {
    key: 7,
    title: '星期日'
  }
]
export default {
  name: 'chargeStrategy',
  data () {
    return {
      customColumns: [
        {
          title: '日期',
          key: 'choose_date',
          render: (h, param) => {
            let day_name = ''
            if (param.row.change_type == 1) {
              daysItems.forEach(item => {
                if (item.key == param.row.choose_date) {
                  day_name = item.title
                }
              })
              return h('span', `每逢${day_name}`)
            }
            return h('span', param.row.choose_date)
          }
        },
        {
          title: '改动时间',
          render: (h, params) => {
            return h('span', `${params.row.begin_at}-${params.row.end_at}`)
          }
        },
        {
          title: '价格变动',
          key: 'price_change',
          render: (h, param) => {
            return h('span', (param.row['diff_type'] == 'INCR' ? '+' : '-') + param.row['price_change'])
          }
        },
        {
          title: '操作',
          key: '_action',
          render: (h, params) => {
            return h('div', [
              h('Button', {
                props: {
                  type: 'warning',
                  size: 'small'
                },
                style: {
                  marginRight: '5px'
                },
                on: {
                  click: () => {
                    this.handleRemoveItem(params.row.id, params.index, params.row.change_type)
                  }
                }
              }, '删除')
            ])
          }
        }
      ],
      serviceId: parseInt(this.$route.query.id || 0),
      chargeType: [
        {
          type: 'INCR',
          title: '提升'
        },
        {
          type: 'REDU',
          title: '下降'
        }
      ],
      daysItems,
      elasticForm: {
        change_type: 1,
        choose_date: 1,
        time_interval: ['00:00', '23:00'],
        price_change: 0,
        diff_type: 'INCR'
      },
      customForm: {
        change_type: 2,
        choose_date: '',
        time_interval: ['00:00', '23:00'],
        price_change: 0,
        diff_type: 'INCR'
      },
      customData: [],
      elasticData: []
    }
  },
  mounted () {
    ([1, 2]).forEach(changeType => {
      this.getRulesList(1, changeType)
    })
    const date = new Date(),
      year = date.getFullYear(),
      month = date.getMonth() + 1,
      day = date.getDate()
    this.customForm.choose_date = `${year}-${month}-${day}`
  },
  methods: {
    addRuleItem (modal) {
      const postData = this[modal] || {}
      if (postData.time_interval) {
        postData['begin_at'] = postData.time_interval[0]
        postData['end_at'] = postData.time_interval[1]
        delete postData.time_interval
      }
      console.log(postData)
      this.$http(`service.pricerule.add-${this.serviceId}`, postData).then(rs => {
        const _modal = modal.replace(/Form$/, '') + 'Data'
        if (this[_modal]) {
          postData.id = rs.data.id
          this[_modal].push(postData)
        }
      })
    },
    handleCustomFormChange (date) {
      this.customForm.time_interval = date
    },
    handleElasticFormChange (date) {
      this.elasticForm.time_interval = date
    },
    handleCustomDateChange (date) {
      this.customForm.choose_date = date
    },
    getRulesList (page = 1, changeType = 1) {
      this.$http('service.pricerule.list', {
        condition: {
          service_id: this.service_id,
          change_type: changeType
        },
        page,
        rows: 30
      }).then(rs => {
        if (changeType == 1) {
          this.elasticData = rs.data
        } else {
          this.customData = rs.data
        }
      })
    },
    handleRemoveItem (id, index, changeType) {
      this.$http(`service.pricerule.delete-${id}`).then(rs => {
        if (changeType == 1) {
          this.elasticData.splice(index, 1)
        } else {
          this.customData.splice(index, 1)
        }
      })
    }
  }
}
</script>

<style scoped>
#chargeStrategyTabs {
  min-height: 400px !important;
}
</style>
