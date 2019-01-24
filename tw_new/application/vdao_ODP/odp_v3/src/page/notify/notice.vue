<template>
	<div class="approvalDetails">
		<div class="task_details_header">
			<div class="return_blue"></div>
			<div class="header_text">公告详情</div>
		</div>
		<div class="details">
			<div class="label">
				<Row>
			        <Col class="title" span="4">公告主题</Col>
			        <Col span="20">{{details.bulletin_title}}</Col>
			    </Row>
			</div>
			
			<div class="label">
			    <Row>
			        <Col class="title" span="4">创建时间</Col>
			        <Col span="20">{{getTime(details.bulletin_post_at)}}</Col>
			    </Row>
		    </div>
		    <div class="label">
			    <Row>
			        <Col class="title" span="4">描述</Col>
			        <Col span="20"><pre>{{details.bulletin_content}}</pre></Col>
			    </Row>
		    </div>
		    <div class="label">
			    <Row>
			        <Col class="title" span="4">图片</Col>
			        <Col span="20">
			        	<div class="imgs">
			        		<div class="img" v-for="item in details.images" @click="handleView(oUrl+item.path)">
								<img :src="oUrl+item.path">
							</div>
			        	</div>
			        </Col>
			    </Row>
	        	<Modal title="View Image" v-model="visible">
					<img :src="this.indexs" alt="" v-if="visible" style="width: 100%" />
				</Modal>
		    </div>
		    <div class="label">
			    <Row>
			        <Col class="title" span="4">文件</Col>
			        <Col span="20">
			        	<div class="files">
			        		<div class="file" v-for="item in details.files">
			        			<div class="left"></div>
			        			<div class="center">{{item.name}}</div>
			        			<div class="right">
			        				<a :href="oUrl+item.path" :download="item.name">
			        					<div>打开</div>
			        					<div>下载</div>
			        				</a>
			        			</div>
			        		</div>
			        	</div>
			        </Col>
		    </Row>
		    </div>
		</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	export default{
		data(){
			return{
				details:{},
				id:null,
				oUrl:api.uploadFileUrl+'/',
				indexs:'',
				visible:false,
			}
		},
		mounted(){
			this.id = this.$route.query.id;
			this.getRecord();
		},
		methods:{
			getRecord(){
				if(this.id){
					var that = this;
					var qs = require('qs');
					let odata = {};
					odata.token = that.$store.state.token;
					odata.id  = that.id;
					that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.bulletin,
						data: qs.stringify(odata) //传参变量
					})
					.then(function(res) {
						if(!res.data.error){
							that.details = res.data.data.list;
						}else{
							that.$Message.error(res.data.msg);
						}
					});
				}
			},
			handleView(item) {
				this.indexs = item;
				this.visible = true;
			},
			getTime(time){
				if(time){
					var date = new Date();
				    date.setTime(time * 1000);
				    var y = date.getFullYear();    
				    var m = date.getMonth() + 1;    
				    m = m < 10 ? ('0' + m) : m;    
				    var d = date.getDate();    
				    d = d < 10 ? ('0' + d) : d;    
				    var h = date.getHours();  
				    h = h < 10 ? ('0' + h) : h;  
				    var minute = date.getMinutes();  
				    var second = date.getSeconds();  
				    minute = minute < 10 ? ('0' + minute) : minute;    
				    second = second < 10 ? ('0' + second) : second;   
				    return y + '-' + m + '-' + d+' '+h+':'+minute+':'+second;
				}else{
					return
				}
			}
		},
	}
</script>

<style scoped>
	.approvalDetails{
		background: #fff;
		font-size: 18px;
		position: absolute;
		top:0px;
		width: 1090px;
		height: 100%;
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
	
	.details{
		padding-top: 34px;
	}
	.details .label{
		border: 1px solid #eeeeee;
		border-left: none;
		border-right: none;
		margin-bottom: 16px;
		padding: 26px 46px;
		color: #283033;
	}
	.details .title{
		color: rgba(40,48,51,.85);
	}
	.imgs{
		display: flex;
		flex-wrap:wrap;
	}
	.imgs>.img{
		border: 1px solid #aaaaaa;
		border-radius: 5px;
		overflow: hidden;
		width: 165px;
		max-height: 126px;
		line-height: 0;
		margin-right: 12px;
	}
	.imgs>.img>img{
		width: 100%;
		height: auto;
	}
	.files{
		display: flex;
		flex-wrap:wrap;
	}
	.files>.file{
		width: 234px;
		height: 53px;
		display: flex;
		border-radius: 5px;
		overflow: hidden;
		justify-content: space-between;
		border: 1px solid rgba(0,0,0,.15);
		line-height: 53px;
		font-size: 12px;
	}
	.files>.file+.file{
		margin-left: 10px;
	}
	.files>.file .left{
		width: 53px;
		height: 53px;
		background: #0ab3e9;
	}
	.files>.file .center{
		width: 128px;
		height: 53px;
		padding: 0 10px;
		overflow: hidden;
	    text-overflow: ellipsis;
	    white-space: nowrap;
	}
	.files>.file .right{
		width: 53px;
		height: 53px;
		border-left: 1px solid rgba(0,0,0,.15);
		line-height: 22px;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.files>.file .right>a{
		display: inline-flex;
		flex-direction: column;
		color: #0ab3e9;
	}
</style>