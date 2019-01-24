<template>
  <div class="periodicReservation">
    <Modal v-model="show" class="periodicReservation" :footer-hide="true" :closable="false" :mask-closable="false" :scrollable="true">
      <div class="center" style="font-size: 14px;">
        <div class="setLong">
          <div class="label">服务时长</div>
          <div class="btn">
            <div class="left" @click="setLong(0)">-</div>
            <div class="middle">{{defaultLong}}小时</div>
            <div class="right" @click="setLong(1)">+</div>
          </div>
        </div>
        <div class="time">
          <div class="title">请选择每周服务时间段</div>
          <div class="label">
            <div class="li" :class="{checked : defaultWeek == item.type}" v-for="item in week" @click="selectWeek(item.type)">{{item.name}}</div>
          </div>
          <div class="arr">
            <div class="li"
                 :class="[{checked : checked && periodicData[defaultWeek] && periodicData[defaultWeek].order.indexOf(item.start_at) >= 0},
							{nochecked : getGray(index) || !item.can_order}]"
                 v-for="(item,index) in arr" @click="selectTime(item,index)">{{item.display_text}}</div>
            <!--为了最后一行能左对齐-->
            <div class="li" style="height: 0px;visibility: hidden;"></div>
            <div class="li" style="height: 0px;visibility: hidden;"></div>
            <div class="li" style="height: 0px;visibility: hidden;"></div>
            <div class="li" style="height: 0px;visibility: hidden;"></div>
            <!--为了最后一行能左对齐-->
          </div>
        </div>
        <div class="cycle">
          <div class="title">服务周期</div>
          <div class="label">
            <span :class="{check:cycleLong == 5}" @click="cycleLong = 5">1个月</span>
            <span :class="{check:cycleLong == 13}" @click="cycleLong = 13">3个月</span>
            <span :class="{check:cycleLong == 26}" @click="cycleLong = 26">半年</span>
            <span :class="{check:cycleLong == 52}" @click="cycleLong = 52">1年</span>
            <div class="btn">
              <div class="left" @click="setCycle(0)">-</div>
              <div class="middle">{{cycleLong}}星期</div>
              <div class="right" @click="setCycle(1)">+</div>
            </div>
          </div>
        </div>
        <div class="tip">
          <div v-if="periodicData[1]">
            <div class="li" v-for="item in periodicData[1].order">每周一 {{getH(item)}}~{{getH(item + periodicData[1].long * 3600)}}</div>
          </div>
          <div v-if="periodicData[2]">
            <div class="li" v-for="item in periodicData[2].order">每周二 {{getH(item)}}~{{getH(item + periodicData[2].long * 3600)}}</div>
          </div>
          <div v-if="periodicData[3]">
            <div class="li" v-for="item in periodicData[3].order">每周三 {{getH(item)}}~{{getH(item + periodicData[3].long * 3600)}}</div>
          </div>
          <div v-if="periodicData[4]">
            <div class="li" v-for="item in periodicData[4].order">每周四 {{getH(item)}}~{{getH(item + periodicData[4].long * 3600)}}</div>
          </div>
          <div v-if="periodicData[5]">
            <div class="li" v-for="item in periodicData[5].order">每周五 {{getH(item)}}~{{getH(item + periodicData[5].long * 3600)}}</div>
          </div>
          <div v-if="periodicData[6]">
            <div class="li" v-for="item in periodicData[6].order">每周六 {{getH(item)}}~{{getH(item + periodicData[6].long * 3600)}}</div>
          </div>
          <div v-if="periodicData[0]">
            <div class="li" v-for="item in periodicData[0].order">每周日 {{getH(item)}}~{{getH(item + periodicData[0].long * 3600)}}</div>
          </div>
        </div>
        <div class="startTime" @click="selectStart = true">
          <div class="left" v-if="!startTime">请选择开始时间</div>
          <div class="left" v-else>开始时间{{formatTime(startTime)}}</div>
          <div class="right"></div>
        </div>
      </div>
      <Button long type="primary" @click="finish">确认选择</Button>
    </Modal>
    <Modal class="selectStart" v-model="selectStart" title="首次服务时间">
      <div class="ul">
        <div class="li" v-for="item in allStartTime" @click="selectStart = false;startTime = item">
          <div class="left">{{formatTime(item)}}({{getDay(item)}})</div>
          <i class="iconfont" :class="[startTime == item ? 'icon-checkoutline02' : 'icon-check02']"></i>
        </div>
      </div>
    </Modal>
  </div>
</template>

<script>
export default{
  props: {
    value: {
      type: Boolean,
      default: false
    },
    service_id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      defaultLong: 2,
      cycleLong: 1,
      show: false,
      arr: [],
      week: [
        {
          type: '1',
          name: '周一'
        },
        {
          type: '2',
          name: '周二'
        },
        {
          type: '3',
          name: '周三'
        },
        {
          type: '4',
          name: '周四'
        },
        {
          type: '5',
          name: '周五'
        },
        {
          type: '6',
          name: '周六'
        },
        {
          type: '0',
          name: '周日'
        },
      ],
      defaultWeek: '1',
      periodicData: {},
      checked: 0, // 无意义，用来刷新dom
      startDay: '',
      allStartTime: [],
      allOrder: {},
      startTime: '',
      selectStart: false
    }
  },
  watch: {
    value (val) {
      this.show = val
      if (val) {
        this.setArr()
      }
    },
    startTime (val) {
      if (val) {
        this.getOrder()
      }
    },
    cycleLong (val) {
      this.getOrder()
    }
  },
  methods: {
    getGray (index) {
      let gray = false
      if (this.periodicData[this.defaultWeek]) {
        let arr = this.periodicData[this.defaultWeek].order
        let defaultAt = this.defaultLong * 3600
        let indexAt = this.arr[index].start_at
        arr.forEach(item => {
          if ((indexAt > item && indexAt < item + defaultAt) || (indexAt < item && indexAt > item - defaultAt)) {
            gray = true
          }
        })
      }
      return gray
    },
    setArr () {
      let req = {}
      req.service_id = this.service_id
      req.service_week = this.defaultWeek
      req.service_length = this.defaultLong
      this.$http('service.get.ordercycle', req).then(rs => {
        this.arr = rs.data
      })
    },
    getH (str) {
      let newDate = new Date(str * 1000)
      if (newDate) {
        let h = newDate.getHours()
        let m = newDate.getMinutes()
        return this.add0(h) + ':' + this.add0(m)
      } else {
        return ''
      }
    },
    getDay (time) {
      let data = new Date(time)
      if (data) {
        let day = data.getDay()
        let cnDay = ''
        switch (day) {
          case 0 :
            cnDay = '周日'
            break
          case 1 :
            cnDay = '周一'
            break
          case 2 :
            cnDay = '周二'
            break
          case 3 :
            cnDay = '周三'
            break
          case 4 :
            cnDay = '周四'
            break
          case 5:
            cnDay = '周五'
            break
          case 6 :
            cnDay = '周六'
            break
        }
        return cnDay
      } else {
        console.log('时间格式有误：' + time)
        return ''
      }
    },
    // 转换时间
    formatTime (time) {
      let data = new Date(time)
      if (data) {
        let year = data.getFullYear();
        let month = this.add0(data.getMonth() + 1)
        let day = this.add0(data.getDate())
        let hour = this.add0(data.getHours())
        let minute = this.add0(data.getMinutes())
        return year + '-' + month + '-' + day + ' ' + hour + ':' + minute
      } else {
        console.log('时间格式有误：' + time)
        return ''
      }
    },
    add0 (time) {
      time = Number(time)
      if (time < 10) {
        time = '0' + time
      }
      return time
    },
    setLong (type) { // 设置服务时长
      if (this.periodicData[this.defaultWeek]) {
        this.$Modal.confirm({
          content: '服务时长已选择' + this.defaultLong + '小时，是否重新选择',
          onOk: () => {
            this.checked = 1
            delete this.periodicData[this.defaultWeek]
          }
        })
      } else {
        if (type) {
          this.defaultLong += 0.5
        } else {
          this.defaultLong -= 0.5
        }
        if (this.defaultLong < 2) {
          this.defaultLong = 2
          return
        }
        if (this.defaultLong > 6) {
          this.defaultLong = 6
          return
        }
        this.setArr()
      }
    },
    setCycle (type) { // 设置服务周期
      if (type) {
        this.cycleLong++
      } else {
        this.cycleLong--
      }
      if (this.cycleLong < 1) {
        this.cycleLong = 1
      }
    },
    close () { // 关闭组件
      this.$emit('input',false)
    },
    selectWeek (type) {
      this.defaultWeek = type
      if (this.periodicData[type]) {
        this.defaultLong = this.periodicData[type].long
      }
      this.setArr()
    },
    selectTime (time, index) { // 添加服务时间
      if (time.can_order && !this.getGray(index)) {
        if (this.startTime) {
          this.$dialog.confirm({
            message: '已选择首次服务时间，是否要重新选择'
          }).then(() => {
            this.startTime = ''
          }).catch(() => {

          })
        } else {
          // 没啥意义，为了刷新dom
          this.checked++

          if (this.periodicData[this.defaultWeek] && (this.defaultLong == this.periodicData[this.defaultWeek].long)) {
            let had = false
            let arr = this.periodicData[this.defaultWeek].order
            arr.forEach(item => {
              if (item == time.start_at) {
                had = true
              }
            })
            if (had) { // 以选择，删除
              let index = arr.indexOf(time.start_at)
              arr.splice(index, 1)
              if (arr.length == 0) {
                delete this.periodicData[this.defaultWeek]
              }
            } else { // 添加
              arr.push(time.start_at)
            }
          } else { // 啥都没，直接添加
            this.periodicData[this.defaultWeek] = {}
            this.periodicData[this.defaultWeek].long = this.defaultLong
            this.periodicData[this.defaultWeek].order = []
            this.periodicData[this.defaultWeek].order.push(time.start_at)
          }

          // 每次添加服务时间都添加首次服务时间
          this.addStartTime()
        }
      }
    },
    addStartTime () {
      this.allStartTime = []
      Object.keys(this.periodicData).forEach(key => {
        this.periodicData[key].order.forEach(item => {
          this.allStartTime.push(item * 1000)
        })
      })
    },
    getOrder () {
      if (this.startTime) {
        let allOrder = []
        let reqOrder = {}
        let cycleLong = this.cycleLong
        for (var i = 0; i < cycleLong; i++) {
          Object.keys(this.periodicData).forEach(key => {
            let order = this.periodicData[key].order.sort(sortNumber)
            order.forEach(item => {
              let time = this.formatTime(item * 1000 + i * 24 * 3600 * 1000 * 7)
              allOrder.push({time: time, long: this.periodicData[key].long})
              if (!reqOrder[key]) {
                reqOrder[key] = {}
                reqOrder[key].order = []
              } else if (!reqOrder[key].order) {
                reqOrder[key].order = []
              }
              reqOrder[key].order.push(time)
            })
          })
        }
        Object.keys(this.periodicData).forEach(key => {
          reqOrder[key].long = this.periodicData[key].long
        })
        this.allOrder.resOrder = allOrder
        this.allOrder.order = reqOrder
        this.allOrder.cycleLong = this.cycleLong
        this.allOrder.startTime = this.formatTime(this.startTime)
      }
    },
    finish () {
      if (Object.keys(this.allStartTime).length && !this.startTime) {
        this.selectStart = true
        return false
      } else {
        this.$emit('input', false)
        this.$emit('finish', this.allOrder)
      }
    }
  }
}
function sortNumber (a,b) {
  return a - b
}
</script>

<style lang="less" scoped>
  @import "./periodcReservation.less";
</style>
