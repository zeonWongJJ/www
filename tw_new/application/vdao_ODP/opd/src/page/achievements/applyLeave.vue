<template>
	<div class="applyLeave">
		<div class="task_details_header">
			<div class="return_blue"></div>
			<div class="header_text">请假记录</div>
			<div class="return_blue"></div>
			<div class="header_text">{{id ? '编辑请假' : '申请请假'}}</div>
		</div>
		<div style="padding: 68px 76px;">
			<Form :model="formItem" :label-width="80" :rules="validate" ref="formItem">
				<FormItem label="审批人" prop="superior">
					<CheckboxGroup v-model="formItem.superior">
				        <Checkbox :label="item.member_id" v-for="(item,index) in persons" :key="index">
				            <span>{{ item.real_name }}</span>
				        </Checkbox>
				   </CheckboxGroup>
				</FormItem>
		        <FormItem label="请假类型" prop="status">
		            <RadioGroup v-model="formItem.status">
		                <Radio label="-2">病假</Radio>
		                <Radio label="-1">事假</Radio>
		                <Radio label="0">调休</Radio>
		                <Radio label="1">婚假</Radio>
		                <Radio label="2">产假</Radio>
		                <Radio label="3">年假</Radio>
		            </RadioGroup>
		        </FormItem>
		        <FormItem label="开始时间" prop="leaveStart">
		            <Row>
		                <Col span="10">
		                     <DatePicker type="date" :options="options1" placeholder="选择时间" v-model= "formItem.leaveStart"></DatePicker>
		                </Col>
		            </Row>
		        </FormItem>
		        <FormItem label="结束时间" prop="leaveEnd">
		            <Row>
		                <Col span="10">
		                     <DatePicker type="date" :options="options2" placeholder="选择时间" v-model= "formItem.leaveEnd"></DatePicker>
		                </Col>
		            </Row>
		        </FormItem>
		        <FormItem label="请假原因" prop="desc">
		            <Input v-model="formItem.desc" type="textarea" :autosize="{minRows: 4}" placeholder="请填写请假原因"></Input>
		        </FormItem>
		        <FormItem>
		        	<Button type="primary" @click="handleSubmit('formItem')" v-if="id">确认修改</Button>
		            <Button type="primary" @click="handleSubmit('formItem')" v-else>确认申请</Button>
		            <Button type="ghost" style="margin-left: 8px" @click="toLeaveRecord">取消</Button>
		        </FormItem>
		    </Form>
		</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	export default{
		data(){
            
			const validatePass = (rule, value, callback) => {
				if (!value) {
                    return callback(new Error('请选择请假开始时间'));
                }
                if (!new Date(value)) {
                    return callback(new Error('时间格式错误'));
                }else{
                    if(value.valueOf() < this.formItem.leaveStart.valueOf() + 86400000){
                    	return callback(new Error('请假时间需大于24小时'));
                    }else{
                    	callback();
                    }
                }
            };
			return{
				id:this.$route.query.id,
				persons:[],
				options1: {
                    disabledDate (date) {
                        return date && date.valueOf() < Date.now();
                    },
                },
                options2: {
                    disabledDate (date) {
//                  	if(this.formItem.leaveStart){
//                  		return date && date.valueOf() < this.formItem.leaveStart + 86400000;
//                  	}else{
//                      	return date && date.valueOf() < Date.now();	
//                  	}
                    	return date && date.valueOf() < Date.now();
                    },
                },
				formItem: {
	                status: '',
	                leaveStart:'',
	                leaveEnd:'',
	                superior:[],
	                desc: ''
	           },
	           validate:{
	           		status:[
                        { required: true, message: '请选择请假类型', trigger: 'change' }
                    ],
                    leaveStart: [
                        { required: true, type: 'date', message: '请选择请假开始时间', trigger: 'change' }
                    ],
//                  leaveEnd: [
//                      { required: true, type: 'date', message: '请选择请假开始时间', trigger: 'change' }
//                  ],
                    leaveEnd: [
                        { required: true, validator: validatePass, trigger: 'change' },
                    ],
                    desc: [
                        { required: true, message: '请填写请假原因', trigger: 'blur' },
                        { type: 'string', min: 10, message: '填写原因少于10个字符', trigger: 'blur' }
                    ],
                    superior:[
                    	{ required: true, type: 'array', min: 1, message: '最少选择一个审批人', trigger: 'change' }
                    ]
	           }
			}
		},
		mounted(){
			this.insert();
			if(this.id){
				this.getAbsence(this.id);
			}
		},
		methods:{
			toLeaveRecord(){
				this.$router.push({
					path: 'leaveRecord'
				})
			},
			handleSubmit (name) {//表单验证
                this.$refs[name].validate((valid) => {
                    if (valid) {
//                      this.$Message.success('Success!');
						this.absence_insert();
                    } else {
//                      this.$Message.error('Fail!');
                    }
                })
            },
            //确认申请
            absence_insert(){
				var that = this;
				var qs = require('qs');
				var url = api.absence_insert;
				let odata = {};
				odata.token = that.$store.state.token;
				odata.absence_status = that.formItem.status;
				odata.absence_start_time  = that.formItem.leaveStart.getTime()/1000;
				odata.absence_end_time  = that.formItem.leaveEnd.getTime()/1000;
				odata.absence_desc  = that.formItem.desc;
				odata.absence_approval_superior = that.formItem.superior;
				if(that.id){
					url = api.absence_update;
					odata.absence_id = that.id;
				}
				that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: url,
					data: qs.stringify(odata) //传参变量
				})
				.then(function(res) {
					if(!res.data.error){
						that.$Message.success(res.data.msg);
						setTimeout(function(){
							that.toLeaveRecord();
						},2000)
					}else{
						that.$Message.error(res.data.msg);
					}
				});
			},
			
			insert(){
				var that = this;
				var qs = require('qs');
				//获取审批人列表
				let data = {};
				data.token = that.$store.state.token
				that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.approval_member,
					data: qs.stringify(data) //传参变量
				})
				.then(function(res) {
					if(!res.data.error){
						var data = res.data.data;
						that.persons = data.list;
					}

				});
			},
			//获取编辑信息
			getAbsence(id){
				var that = this;
				var qs = require('qs');
				let data = {};
				data.token = that.$store.state.token;
				data.absence_id = id;
				that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.absence_edit,
					data: qs.stringify(data) //传参变量
				})
				.then(function(res) {
					if(!res.data.error){
						var data = res.data.data;
						that.formItem.status = data.list.absence_status;
						that.formItem.leaveStart = data.list.absence_start_time;
						that.formItem.leaveEnd = data.list.absence_end_time;
						that.formItem.desc = data.list.absence_desc;
						that.formItem.superior = data.list.absence_approval_superior.split(",");
					}else{
						that.$Message.error(res.data.msg);
					}

				});
			}
		},
	}
</script>

<style>
	.applyLeave{
		position: absolute;
		top:0px;
		width: 1090px;
		height: 100%;
		overflow: hidden;
		overflow-y: scroll;
		overflow-x: auto;
		background: #fff;
	}
	.applyLeave::-webkit-scrollbar-track {
		/*滚动条里面轨道*/
		/*-webkit-box-shadow: inset 0 0 5px #b0c0d0;*/
		border-radius: 10px;
		background: #fff;
	}
	/*头部*/
	.task_details_header {
		height: 44px;
		border-bottom: 1px solid rgba(186, 233, 249, .8);
		display: flex;
		align-items: center;
		color: #0ab3e9;
	}
	.return_blue {
		width: 8px;
		height: 12px;
		background: url(../../assets/img/return_bllue.png);
		margin: 0 7px 0 25px;
	}
</style>