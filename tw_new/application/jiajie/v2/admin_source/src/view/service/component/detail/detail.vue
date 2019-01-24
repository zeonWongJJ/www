<template>
  <div>
    <Card :title="isUpdate ? '修改服务' : '添加新服务'">
      <div slot="extra">
        <Button size="small" type="primary" @click="$router.push({name: 'servicesIndex'})">服务列表</Button>
        <Button size="small" type="primary" @click="onInsert" :loading="loading.insertBtn">提交</Button>
      </div>
      <Tabs value="generalTab">
        <TabPane label="通用信息" name="generalTab">
          <Form :model="formData" :label-width="100">
            <FormItem label="服务分类">
              <treeselect :multiple="false"
                          :searchable="false"
                          :options="categories"
                          placeholder="点击选择分类"
                          noChildrenText="该分类暂无下级"
                          ref="catSelect"/>
            </FormItem>
            <FormItem label="服务名称">
              <Input v-model="formData.service_name"></Input>
            </FormItem>
            <FormItem label="服务方式">
              <Select v-model="formData.order_charging" style="width: 150px; float: left;">
                <Option v-for="(charging, index) in meta.order_charging" :key="index" :value="charging.key">
                  {{charging.title}}
                </Option>
              </Select>
            </FormItem>
            <FormItem label="服务售价">
              <Input style="width: 150px; float: left;" v-model="formData.service_remuneration"
                     :disabled="formData.order_charging === 'NON_RESERVATION'"></Input>
            </FormItem>
            <FormItem label="计价单位">
              <Select @on-change="onChangeUnit" :label-in-value="true" v-model="formData.service_value_unit_id" style="width: 150px; float: left;"
                      :disabled="formData.order_charging === 'NON_RESERVATION'">
                <Option v-for="(unit, index) in meta.order_unit" :key="index" :value="unit.id">{{unit.title}}</Option>
              </Select>
            </FormItem>
          </Form>
        </TabPane>
        <TabPane label="位置信息" name="mixTab">
          <Form>
            <FormItem label="服务地址">
              <el-amap :plugin="amap.plugin" ref="map" :center="[113.33339,22.99457]" :zoom="amap.zoom"
                       :amap-manager="amap.amapManager" style="height: 300px;" class="amap-box">
                <el-amap-search-box class="search-box" :search-option="amap.searchOption"
                                    :on-search-result="onSearchResult"></el-amap-search-box>
                <el-amap-marker vid="component-marker" :position="[113.33339,22.99457]"></el-amap-marker>
              </el-amap>
            </FormItem>
          </Form>
        </TabPane>
        <!--服务项目选项卡 开始-->
        <TabPane label="服务项目" name="itemsTab">
          <service-item
            :init-service-item="formData.item_arr"
            :items="serviceItems"
            :selectedUnit="selectedUnit"
            :is-update="isUpdate"
            @on-add-item="onAddItemEmit"></service-item>
        </TabPane>
        <!--服务项目选项卡 结束-->
        <TabPane label="服务流程" name="ServiceFlow">
          <ServiceFlow
            :init-service-flows="formData.service_flow"
            @on-add-item="onAddFlowItemEmit"
            :is-update="isUpdate"></ServiceFlow>
        </TabPane>
        <TabPane label="专业设备" name="ProfessionalEquipment">
          <ProfessionalEquipment
            :is-update="isUpdate"
            @on-add-item="onAddEquipmentItemEmit"></ProfessionalEquipment>
        </TabPane>
        <TabPane label="服务标准" name="serviceStandards">
          <ServiceStandards
            :init-service-standards="formData.service_standards"
            :is-update="isUpdate"
            @on-add-item="onAddStandardsItemEmit"></ServiceStandards>
        </TabPane>
        <TabPane label="服务详情" name="detailTab">
        	<Row>
        		<Col span="18">
              <UE :defaultMsg="formData.service_info" :config="config" ref="ue"></UE>
        		</Col>
        		<Col span="6">
        			<!--预览-->
        		</Col>
        	</Row>
        </TabPane>
      </Tabs>
    </Card>
    <Card style="text-align: center; margin-bottom: 80px;">
      <Button type="primary" @click="onInsert">确定</Button>
      <Button type="default">重置</Button>
    </Card>
  </div>
</template>

<script>
import ServiceItem from '../ServiceItem'
import ProfessionalEquipment from '../ProfessionalEquipment'
import ServiceFlow from '../ServiceFlow'
import ServiceStandards from '../serviceStandards'
import Treeselect from '@riophae/vue-treeselect'
import UE from '@/components/ueditor'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
import VueAMap from 'vue-amap'
let amapManager = new VueAMap.AMapManager()
export default {
  name: 'serviceInsert',
  props: {
    isUpdate: {
      type: Boolean,
      required: true
    },
    serviceId: {
      type: Number,
      default () {
        return 0
      }
    }
  },
  components: {
    UE,
    Treeselect,
    ServiceItem,
    ServiceFlow,
    ServiceStandards,
    ProfessionalEquipment
  },
  mounted () {
    if (this.isUpdate && this.serviceId) {
      this.$http(`service.get-${this.serviceId}`).then(rs => {
        Object.keys(this.formData).forEach(key => {
          this.formData[key] = rs.data[key] || ''
        })
        this.formData.service_cate_id = parseInt(rs.data.service_level_1)
        this.formData.service_value_unit_id = parseInt(this.formData.service_value_unit_id)
        // 服务项目
        this.formData.item_arr = rs.data['service_item'] || []
        // 服务标准
        this.formData.service_standards = rs.data['service_standards'] || []
        // 服务流程
        this.formData.service_flow = rs.data['flow_item'] || []
      })
    }
    this.$http('category.list', {
      'data-set': 'tree',
      'field': 'cat_name as label, cate_is_show, cate_icon'
    }).then(rs => {
      this.categories = rs.data
      this.formData.service_cate_id = rs.data.shift().id
    })
  },
  data () {
    return {
      config: {
        initialFrameWidth: null,
        initialFrameHeight: 350
      },
      selectedUnit: '元/次',
      loading: {
        insertBtn: false
      },
      serviceItems: [],
      categories: [],
      detailTab: {
        ueditor: {
          defaultMsg: '',
          config: {}
        }
      },
      amap: {
        amapManager,
        zoom: 12,
        plugin: [{
          pName: 'ToolBar'
        }],
        searchOption: {
          pageSize: 5, // 单页显示结果条数
          pageIndex: 1, // 页码
          city: '010', // 兴趣点城市
          citylimit: true  //是否强制限制在设置的城市内搜索
        }
      },
      meta: {
        disabled: {
          order_charging: false
        },
        order_charging: [
          {
            key: 'FIXED_PRICE',
            title: '一口价'
          },
          {
            key: 'HAS_RESERVATION',
            title: '预约金'
          },
          {
            key: 'NON_RESERVATION',
            title: '免费预约'
          }
        ],
        order_unit: [
          {
            id: 1,
            title: '元/次'
          },
          {
            id: 2,
            title: '元/小时'
          },
          {
            id: 3,
            title: '元/个'
          },
          {
            id: 4,
            title: '元/平米'
          },
          {
            id: 5,
            title: '元/间'
          }
        ]
      },
      formData: {
        store_id: 0,
        service_cate_id: 0,
        service_name: '',
        service_uuid: '',
        order_charging: 'FIXED_PRICE',
        service_remuneration: 0,
        service_value_unit_id: 1,
        service_info: '',
        service_lal: '113.33339,22.99457',
        service_address_name: '广东省广州市番禺区钟村街道长华创意谷',
        item_arr: [],
        service_equipment: [],
        service_flow: [],
        service_standards: []
      }
    }
  },
  methods: {
    onAddItemEmit (item) {
      this.formData.item_arr = item
    },
    onAddEquipmentItemEmit (item) {
      this.formData.service_equipment = item
    },
    onAddFlowItemEmit (item) {
      this.formData.service_flow = item
    },
    onAddStandardsItemEmit (item) {
      this.formData.service_standards = item
      console.log(this.formData.service_standards)
    },
    onChangeUnit (e) {
      this.selectedUnit = e.label
    },
    onInsert () {
      this.loading.insertBtn = true
      this.formData.service_cate_id = parseInt(this.$refs['catSelect'].getValue())
      this.formData.service_info = this.$refs['ue'].getUEContent()
      const url = this.isUpdate ? `service.update-${this.serviceId}` : 'service.add'
      if (this.isUpdate) {
        delete this.formData.item_arr
        delete this.formData.service_equipment
        delete this.formData.service_flow
        delete this.formData.service_standards
      }
      this.$http(url, this.formData).then(() => {
        this.loading.insertBtn = false
        this.$Message.success(this.isUpdate? '添加成功' : '修改成功')
        this.$router.push({path: '/services/index'})
      }).catch(err => {
        err.forEach(e => {
          this.loading.insertBtn = false
          this.$Message.warning(e)
        })
      })
    },
    onSearchResult(pois) {
      let latSum = 0;
      let lngSum = 0;
      if (pois.length > 0) {
        pois.forEach(poi => {
          let {lng, lat} = poi;
          lngSum += lng;
          latSum += lat;
          this.markers.push([poi.lng, poi.lat]);
        })
      }
    }
  }
}
</script>

<style scoped>
.amap-wrapper {
  width: 500px;
  height: 500px;
}

.search-box {
  position: absolute;
  top: 25px;
  left: 100px;
}

.amap-page-container {
  position: relative;
}
</style>
