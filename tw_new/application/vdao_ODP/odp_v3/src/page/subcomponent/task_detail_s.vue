<template>
	<div class="sub">

		<!--评论区-->
		<div class="evaluate_box">

			<div class="evaluate_con" v-for="(item,index) in list_plan" :key='index'>
				<div class="evaluate_con_img">
				</div>
				<div class="evaluate_con_com">
					<div> <span class="span_con_img"><img src="../../assets/img/erweima.png"/></span>{{item.my_name}} <span>{{item.add_date}}</span></div>
					<div>
						<pre style="width: 700px;color:#707070; white-space: pre-wrap;word-wrap: break-word;">{{item.content}}</pre>
					</div>

				</div>
				<div class="evaluate_con_p" @click="oeval(item,index)">
					<img src="../../assets/img/reply.png" />
				</div>
				<div>
					<s-eval :item_x="item_x" :item_p="item" :indexVal='item.parent_id'></s-eval>
				</div>

			</div>

			<div class="evaluate">
				<div class="evaluate_top">
					<div>
						<input ref="postcontent" rows="3" placeholder="请输入" v-model="texts" @click="isshow = true">
					</div>
				</div>
				<div>
					<button v-show="!isshow">评论</button>
					<button v-show="isshow" @click="tijiao()">评论</button>
				</div>
			</div>

			<!--任务评价-->
			<!--<div class="evaluate_con" v-if="list != ''" v-for="(item,index) in list" :key='index'>
				<div class="evaluate_con_img">
				</div>
				<div class="evaluate_con_com">
					<div> <span class="span_con_img"><img src="../../assets/img/erweima.png"/></span>{{item.my_name}} <span>{{item.task_record_add_date}}</span></div>
					<div>{{item.task_record_desc}}</div>
					<div class="del_file">
						<div v-for="itfile in item.task_record_file_data">
							<a :href="uploadFileUrls + '/' +itfile" :download="itfile">{{itfile}}</a>
						</div>

					</div>
					<div class="del_file">
						<div v-for="itpic in item.task_record_pic_data">
							<a :href="uploadFileUrls + '/' + itpic" :download="itpic"><img style="width: 80px;" :src="uploadFileUrls + '/' + itpic" /></a>
						</div>
					</div>
				</div>
				<div class="evaluate_con_p" @click="oeval(item,index)">
					<img src="../../assets/img/reply.png" />
				</div>
				<div>
					<s-eval :ksid='kid' :name='item.my_name' :taskId='item.task_id' :indexVal='index_val' :idsi="item.task_record_id" :ishow='item.parent_id' :divp='list'></s-eval>

				</div>

			</div>-->
			<!--...-->
		</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	import sEval from '@/page/subcomponent/task_detail_s_eval'
	export default {
		components: {
			sEval
		},
		props: ["item_x"],
		data() {
			return {
				//				v2
				//				item_x :{},
				isshow: false,
				texts: '',
				divp: [],
				list: [],
				list_plan: [],
				defaultList: [],
				num: 0,
				index_val: false,
			}
		},
		created() {
			//			this.list_pl();

		},
		mounted() {
			//			console.log('1111111',this.item_x.discusses)
			this.list_plan = this.item_x.discusses
			//			this.isShows()

		},
		methods: {

			list_pl() {
				let that = this;
				let lists = {};
				list.plan_id = that.$store.state.member_id;
				list.type = that.$store.state.plan_type
				lists.rows = 500
				var qs = require('qs');
				that.axios({
						method: 'post',
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						url: api.plan_sub,
						data: qs.stringify(lists) //传参变量
					})
					.then(function(res) {
						if(res.data.error == 0) {

							that.list_plan = res.data.data.list
						} else {
							that.$Message.error(res.data.msg);
						}

					})

			},
			tijiao() {
				let that = this;
				let josn = {};
				josn.member_id = that.$store.state.member_id
				josn.content = that.texts
				josn.id = that.item_x.plan_sub_id
				josn.discuss_type = 1
				josn.type = 1
				var qs = require('qs');
				that.axios({
						method: 'post',
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						url: api.plan_discuss,
						data: qs.stringify(josn) //传参变量
					})
					.then(function(res) {
						if(res.data.error == 0) {
							console.log('----22---', res)
							if(that.list_plan == undefined) {
								that.list_plan = res.data.data.discuss

							} else {

								that.list_plan.push(res.data.data.discuss)
								//										that.list_plan = that.list_plan.reverse()
							}
							that.isshow = false
							that.uploadFile = []
							that.uploadList = []
							that.texts = ''
						} else {
							console.log('----22---', res.data.msg)
						}

					})

				//计划评价
				//			if(this.$route.query.oid_details != undefined) {
				//				let value = that.texts
				//				value = value.replace(/(^\s*)|(\s*$)/g, "");
				//				if(value.length > 0) {
				//					let josn = {};
				//					josn.plan_id = 
				//					josn.member_id = that.$store.state.member_id
				//					josn.content = that.texts
				//					josn.id = that.$route.query.item.plan_sub_id
				//		
				//
				//					var qs = require('qs');
				//					that.axios({
				//							method: 'post',
				//							headers: {
				//								"Content-Type": "application/x-www-form-urlencoded"
				//							},
				//							url: api.plan_discuss,
				//							data: qs.stringify(josn) //传参变量
				//						})
				//						.then(function(res) {
				//							if(res.data.error == 0) {
				//								console.log('----22---', res)
				////									if(that.list_plan == ''){
				////										that.list_plan = res.data.data.record
				////									}else{
				////										that.list_plan.push(res.data.data.record)
				////									}
				//								that.isshow = false
				//								that.uploadFile = []
				//								that.uploadList = []
				//								that.texts = ''
				//							} else {
				//								console.log('----22---', res.data.msg)
				//							}
				//
				//						})
				//
				//				} else {
				//					that.$Message.error('请输入评论');
				//				}
				//
				//			} else { //任务评价
				//				let value = that.texts
				//				value = value.replace(/(^\s*)|(\s*$)/g, "");
				//
				//				if(value.length > 0) {
				//					let josn = {};
				//					josn.task_id = this.$route.query.task_id
				//					josn.task_record_desc = that.texts
				//					josn.member_id = this.$store.state.member_id
				//					josn.task_record_file = that.uploadFiles // 文件
				//					josn.task_record_pic = that.imges //  图片
				//					var qs = require('qs');
				//					that.axios({
				//							method: 'post',
				//							headers: {
				//								"Content-Type": "application/x-www-form-urlencoded"
				//							},
				//							url: api.plan_discuss,
				//							data: qs.stringify(josn) //传参变量
				//						})
				//						.then(function(res) {
				//
				//							if(res.data.error == 0) {
				////								that.list.push(res.data.data.record)
				//								if(that.list == ''){
				//										that.list = res.data.data.record
				//									}else{
				//										
				//										that.list.push(res.data.data.record)
				//									}
				//								
				//								that.uploadFile = []
				//								that.uploadList = []
				//								that.texts = ''
				//							} else {
				//								that.$Message.error(res.data.msg);
				//							}
				//
				//						})
				//
				//				} else {
				//					that.$Message.error('请输入评论');
				//				}
				//			}

			},
			//		oshow() {
			//			let that = this;
			//			
			//		},
			oeval(item, index) {
				let that = this;
				that.num = index
				item.parent_id = !item.parent_id

			},

			tok() {
				var op = {}
				var token_ids = this.$store.state.token;
				op = JSON.stringify(token_ids);
				var str1 = JSON.parse(op);
				this.token = str1
				//				this.token_i = JSON.parse(token_id)
			},
			//			delFile(idx) {
			//				this.file.splice(idx, 1);
			//			}
		},

	}
</script>

<style></style>
<style scoped>
	.sub {
		margin-top: 30px;
		margin-bottom: 40px;
		/*border:1px solid #707070;
		border-right:none;
		border-bottom:none;*/
	}
	
	.evaluate {
		width: 80%;
		display: flex;
		font-size: 16px;
		align-items: center;
		/*margin: 0 0 0 80px;*/
		/*padding-bottom: 50px;*/
		/*align-items: center;*/
		/*border-bottom: 1px solid #efefef;*/
	}
	
	.evaluate_top {
		width:100%;
		border-radius: 10px;
	}
	.evaluate_top input{
		padding-left:10px;
		width:100%;
		color:white;
		background: #3F3D49;
	}
	.evaluate_top>div:nth-child(1) {
		width: 100%;
		height:40px;
		border: 1px solid #707070;
		background: #eee;
		border-radius: 2px;
		overflow: hidden;
		display: flex;
	}
	
	.evaluate_top>div:nth-child(1) textarea {
		height:43px;
		flex: 0 0 760px;
		background: #eee;
		padding: 5px;
		resize: none;
		font-size: 14px;
	}
	
	.evaluate_top>div:nth-child(1)>div {
		flex: 0 0 50px;
		margin-top: 57px;
		text-align: center;
	}
	/*.evaluate_top>div:nth-child(2) {
	margin: 15px 0 0 0;
}*/
	
	.evaluate>div:nth-child(2) button {
		border: 0;
		width: 120px;
		height: 40px;
		border-radius: 1px;
		line-height: 40px;
		text-align: center;
		color: #c0c1c2;
	}
	
	.evaluate>div:nth-child(2) button:nth-child(1) {
		background: #3F3D49;
		border:1px solid #707070;
		margin-left:20px;
	}
	
	.evaluate>div:nth-child(2) button:nth-child(2) {
		color: #fff;
		background: #3F3D49;
		border:1px solid #707070;
		margin-left:20px;
	}
	
	.evaluate_con {
		width: cala( 100% - 120px; );
		display: flex;
		font-size: 16px;
		align-items: center;
		flex-wrap: wrap;
		/*padding: 50px 0;*/
		/*margin: 0px 0 0 80px;*/
		/*border-bottom: 1px solid #efefef;*/
	}
	
	.evaluate_con_img {
		flex: 0 0 0px;
	}
	
	.evaluate_con_img div {
		text-align: center;
	}
	
	.evaluate_con_img img {
		width: 50px;
		height: 50px;
		border-radius: 50%;
	}
	
	.evaluate_con_com {
		flex: 0 0 670px;
	}
	
	.evaluate_con_com div:nth-child(1) {
		padding-top:10px;
		padding-left:20px;
		color:white;
		font-size: 16px;
		font-weight: 700;
		margin-bottom: 20px;
		display: flex;
		align-items: center;
	}
	
	.span_con_img {
		margin: 0 15px 0 0 !important;
	}
	
	.span_con_img img {
		width: 44px;
		border-radius: 50%;
	}
	
	.evaluate_con_com div:nth-child(1) span {
		margin-left: 15px;
		font-size: 16px !important;
		color: white;
	}
	
	.evaluate_con_com div:nth-child(2) {
		margin-left: 80px;
	}
	
	.evaluate_con_p {
		flex: 0 0 150px;
		text-align: center;
	}
	/*文件上传*/
	
	.file_blue {
		width: 18px;
		height: 20px;
		display: inline-block;
		background: url(../../assets/img/file_blue.png);
		cursor: pointer;
	}
	
	.fileBox {
		width: 234px;
		height: 53px;
		border-radius: 5px;
		border: 1px solid #aaaaaa;
		background: #ffffff;
		overflow: hidden;
		display: inline-flex;
		justify-content: space-between;
		align-items: center;
		margin-right: 14px;
	}
	
	.file-win {
		width: 53px;
		height: 53px;
		flex-shrink: 0;
		background: url(../../assets/img/win.png);
		margin-right: 14px;
	}
	
	.file-name {
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	
	.upload-file {
		margin-bottom: 8px;
	}
	
	.upload-file .del_image {
		width: 35px;
		height: 35px;
		flex-shrink: 0;
		background: url(../../assets/img/del_img.png);
		margin-left: 14px;
		align-self: flex-start;
	}
	/*图片上传*/
	
	.del_images {
		position: absolute;
		top: 0;
		right: 0;
		width: 35px;
		height: 35px;
		flex-shrink: 0;
		background: url(../../assets/img/del_img.png);
		margin-left: 14px;
		align-self: flex-start;
		z-index: 9999;
	}
	
	.upload-img .demo-upload-list {
		display: inline-block;
		width: 184px;
		height: 133px;
		text-align: center;
		line-height: 60px;
		border-radius: 5px;
		overflow: hidden;
		background: #fff;
		position: relative;
		border: 1px solid #aaaaaa;
		/*box-shadow: 0 1px 1px rgba(0,0,0,.2);*/
		margin-right: 10px;
	}
	
	.upload-img .demo-upload-list img {
		width: 100%;
		height: auto;
	}
	
	.upload-img .demo-upload-list-cover {
		position: absolute;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		text-align: right;
	}
	
	.demo-upload-list-cover i {
		color: #fff;
		font-size: 20px;
		cursor: pointer;
	}
	
	.upload-img .del_image {
		width: 35px;
		height: 35px;
		display: inline-block;
		background: url(../../assets/img/del_img.png);
	}
	
	.image_blue {
		width: 22px;
		height: 20px;
		display: inline-block;
		background: url(../../assets/img/image_blue.png);
	}
	/*图*/
	
	.demo-upload-list {
		display: inline-block;
		width: 60px;
		height: 60px;
		text-align: center;
		line-height: 60px;
		border: 1px solid transparent;
		border-radius: 4px;
		overflow: hidden;
		background: #fff;
		position: relative;
		box-shadow: 0 1px 1px rgba(0, 0, 0, .2);
		margin-right: 4px;
	}
	
	.demo-upload-list img {
		width: 100%;
		height: 100%;
	}
	
	.demo-upload-list-cover {
		display: none;
		position: absolute;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		background: rgba(0, 0, 0, .6);
	}
	
	.demo-upload-list:hover .demo-upload-list-cover {
		display: block;
	}
	
	.demo-upload-list-cover i {
		color: #fff;
		font-size: 20px;
		cursor: pointer;
		margin: 0 2px;
	}
	
	.del_file {
		display: flex;
		/*flex-wrap: wrap;*/
	}
	
	.del_file div {
		margin-top: 20px;
		margin-right: 20px;
	}
</style>
<style>
	.ivu-upload-drag {
		border: none;
		background: none;
	}
	
	.ivu-upload-drag:hover {
		border: none;
	}
	
	.ivu-upload-input {
		border: 1px solid #eee !important;
	}
</style>