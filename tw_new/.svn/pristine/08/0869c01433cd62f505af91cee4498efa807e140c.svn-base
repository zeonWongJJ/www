<template>
	<div class="my_kask_x">
		
		<div class="butt">
			
			<div @click="r_plian()">添加计划</div>
			<!--<div @click="add_o" v-if="isshow == true">未完成</div>
			<div v-if="isshow == false" class="bacolco">未完成</div>
			<div @click="add_o">已完成</div>-->
		</div>
		<div class="box_body test-1">
			
			<div class="com_box">
				<!--<div v-if="list == ''" class="qk">
					暂无任务榜单
				</div>-->

				<div class="ul_div">
					<div class="ul_div_time">
<!--						{{item.task_date_limit}}-->	
							2018
				</div>
					<div class="ul_div_time-stop">
						截止时间
					</div>
					<div class="li_div">
						<div>
							<p class="li_div_img">
								<!--<img src="../../assets/img/time.png"/>-->
								
							</p>
							<p class="li_div_text">
								<!--{{item.task_title}}-->
								我我我我我我我我我我我我我我我我我我我我我我我我我我我我
							</p>
						</div>
						<div>
							我我我我我我我我我我我我我我我我我我我我我我我我我我我我我我我我我
							<!--{{item.task_project_names}}-->
						</div>
						<div>
							江周辉
							<!--<div class="ul_but">-->
								<!--<span v-for="itproc in item.task_procedures" :class="[ (itproc.status == -1) ? 'ul_but_4' : (itproc.status == 0) ? 'ul_but_3' : (itproc.status == 1) ? 'ul_but_2' : (itproc.status == 2) ? 'ul_but_1' : '']">{{itproc.department_name}}</span>-->
							<!--</div>-->
						</div>
						<div>
							<!--<p class="li_div_img_ri" ></p>-->
							<button @click="o_iss()">展开</button>
							<!--<button>sdf</button>-->
						</div>
					</div>
					<div class="" v-show="isshow" style="position: absolute;top: 164px;width: 980px; z-index: 9999;background: #f8f8f8;border-radius: 20px;padding: 10px 20px;">
						<div style="display: flex; font-size: 16px;margin:10px 0 0px 20px  ; border-bottom: 1px solid #fff;padding:0 0 10px 0;">
							<div style="width: 100px;">发起人 :</div>
							<div>发起人</div>
						</div>
						<div style="display: flex; font-size: 16px;margin:10px 0 0px 20px  ; border-bottom: 1px solid #fff;padding:0 0 10px 0;">
							<div style="width: 100px;">计划标题 :</div>
							<div>计划标题雷打石裂缝空间的浪费空间</div>
						</div>
						<div style="display: flex;  font-size: 16px;margin:10px 0 0px 20px  ; border-bottom: 1px solid #fff;padding:0 0 10px 0;">
							<div style="width: 100px;">计划描述 :</div>
							<div  style="width: 800px;">计划描述雷打石裂缝空间的浪费空间计划描述雷打石裂缝空间的浪费空间计划描述雷打石裂缝空间的浪费空间计划描述雷打石裂缝空间的浪费空间计划描述雷打石裂缝空间的浪费空间计划描述雷打石裂缝空间的浪费空间计划描述雷打石裂缝空间的浪费空间</div>
						</div>
						<div style="display: flex; font-size: 16px;margin:10px 0 0px 20px  ;">
							<div style="width: 100px;">参与人 :</div>
							<div>参与人</div>
						</div>
						
						<div class="sata_box">
							<div class="bm_x_box" v-for="(itlist,index) in list_bm">
								<div class="bmf_x">{{itlist.name}}</div>
										<!--状态控制bm-x-----0----->
								<div class="bm_x" v-if="stat == 1">
									<div class="bmf_name">
									</div>
									<div class="bmf_jd">
										<div class="">
										</div>
										<div>
										</div>
									</div>
									<div class="bmf_but">
										<div class="bmf_but_zb" @click="jies(index)">
											接手
										</div>
										<div class="bmf_but_js" @click="sishow(index)">
											指派
										</div>
									</div>
									<div class="bmf_but_img">
										<!--33-->
									</div>
								</div>
								<!--状态控制bm-------0----->
								
								
								<!--状态控制bm-x-----1-2 L----->
								<div class="bm_x" style="background: #ffc324;" v-if="stat == 2">
									<div class="bmf_name">
										<span>江周辉</span>
									</div>
									<div class="bmf_jd">
										<div class="">
											<Slider v-model="value" show-tip="never" :tip-format="format" ></Slider>
										</div>
										<div>
											<span>{{jdt}}</span>
										</div>
									</div>
									<div class="bmf_but" style="justify-content: flex-end;">
										<div class="bmf_but_js" @click="fangqi(index)">
											放弃
										</div>
									</div>
									<div class="bmf_but_img">
										<!--<img src=""/>-->
									</div>
								</div>
								<!--状态控制bm-------1-2----->
								
								<!--状态控制bm-x----3  4----->
								<div class="bm_x" style="background: #0ab3e9;" v-if="stat == 3">
									<div class="bmf_name">
										<span>江周辉</span>
									</div>
									<div class="bmf_jd">
										<div class="">
											<Slider v-model="value" show-tip="never" :tip-format="format" ></Slider>
										</div>
										<div>
											<span>{{jdt}}</span>
										</div>
									</div>
									<div class="bmf_but" style="justify-content: flex-end;">
										<div class="bmf_but_js">
											完成
										</div>
									</div>
									<div class="bmf_but_img">
										<!--33-->
									</div>
								</div>
								<!--状态控制bm-------3   4----->
							</div>
						</div>
					</div>
				</div>
				
				
				
			</div>
		</div>
		
		<div v-if="assign" class="divshow">
				<div class="divshow_div">
					<div class="divshow_divtit">
						指派人
					</div>
					<ul class="ul_Checkbox">
						<li v-for='(label,index) in label'>
							<div>{{index}}</div>
							<div >
								<div>
									<!--:id="labels.member_id" name="radios" :value="labels.member_id"  :for="labels.member_id"-->
									<input type="radio"  v-model="task_belonged">
									<label >{{label.name}}</label>
								</div>
							</div>
						</li>
					</ul>
					<div class='divshow_but'>
						<button style="background: #00C1DE;" @click.stop="iszhipa()">确定选择</button>
						<button style="background: #ddd;" @click.stop="assign = false">取消</button>
					</div>
				</div>
			</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	export default {
		data() {
			return {
				stat:1,
				isshow:true,
				value: 25,
				jdt:'',
				list_bm:[
				{name:'前端'},
				{name:'后端'},
				{name:'ios'},
				{name:'设计'},
				{name:'编辑'},
				{name:'安卓'},
				],
			assign:false,
			label:[
				{name:'前端'},
				{name:'后端',member_id:1},
				{name:'ios'},
				{name:'设计'},
				{name:'编辑'},
				{name:'安卓'},
			],
			task_belonged: [],
			}
		},
		created() {
		},
		methods: {
			o_iss(){
				let that = this
				that.isshow = !that.isshow
			},
			r_plian(){
					this.$router.push({
					path: 'release_plan_x'
				})
			},
//			进度条
 			 format (val) {
                 this.jdt =  val + '%';
            },
            	//			指派
			sishow(index) {
				let that = this
				that.assign = true
			

			},
//			接手
			jies(index){
				let that=this
				that.stat = 2
			
			},
//			放弃
		fangqi(index){
			let that=this
				that.stat = 1
		},
		}
	}
</script>

<style scoped>
	.tit_box {
		position: absolute;
		top: -88px;
		left: 0px;
		height: 85px;
		margin: 0 0 0 50px;
		border-bottom: 1px solid rgba(186, 233, 249, .5);
		z-index: 999;
	}
	.sata_box{
		margin: 20px 0 0 0 ;
	}
	.bm_x_box{
		width: 100%;
		height: 60px;
		display: flex;
		/*justify-content: space-between;*/
		align-items: center;
		background: #fff;
		font-size: 18px;
		border-radius: 50px;
		overflow: hidden;
		margin-bottom: 21px;
	
	}
	.bm_x{
		width: 100%;
		height: 60px;
		display: flex;
		/*justify-content: space-between;*/
		align-items: center;
		background: #f00;
		font-size: 18px;
			color: #fff;
			
	}
	.bmf_x{
		flex: 0 0 140px;
		text-align: center;
		background: #fff;
		
	}
	.bmf_name{
		flex: 0 0 160px;
		text-align: center;
	}
	.bmf_name span{
		background: #fff;
		color: #000;
		padding: 8px 20px;
		border-radius: 50px;
		
	}
	.bmf_jd{
		flex: 0 0 300px;
		margin: 0 10px;
		display: flex;
		align-items: center;
	}
	.bmf_jd>div:nth-child(2){
		flex: 0 0 80px;
		text-align: center;
	}
	.bmf_but{
		flex: 0 0 200px;
		display: flex;
		justify-content: space-between;
	}
	.bmf_but div {
		width: 80px;
		height: 44px;
		line-height: 44px;
		text-align: center;
		border-radius: 50px;
	}
	.bmf_but_zb{
		border: 2px solid #fff;
	}
	.bmf_but_js{
		border: 2px solid #fff;
	}
	.bmf_but_img{
		flex: 0 0 120px;
		text-align: center;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	.tit_box_ul {
		display: flex;
		width: 800px;
		margin: 0 auto;
	}
	
	.tit_box_ul li {
		text-align: center;
		font-size: 18px;
		width: 160px;
		line-height: 85px;
		height: 85px;
		position: relative;
	}
	
	.tit_box_ul li:hover:before {
		content: "";
		position: absolute;
		bottom: 0;
		left: 30px;
		height: 2px;
		width: 100px;
		background-color: #0ab3e9;
	}
	
	.tit_box_li {
		color: #0ab3e9;
	}
	
	.tit_box_li:before {
		content: "";
		position: absolute;
		bottom: 0;
		left: 30px;
		height: 2px;
		width: 100px;
		background-color: #0ab3e9;
	}
	
	.box_body {
		position: absolute;
		top: 90px;
		width: 1090px;
		height: 90%;
		padding: 0 0 50px 0;
		/*overflow: auto;*/
		overflow: hidden;
		overflow-y: scroll;
		overflow-x: auto;
		z-index: 99;
	}
	
	.com_box {
		position: relative;
		/*top: 0;*/
		/*width: 1050px;*/
		height: 220px;
		margin: 10px 0;
		
	}
	
	.ul_div {
		width: 99%;
		height: 99%;
		padding: 30px 55px;
		position: relative;
		transition: all 0.3s;
	}
	
	.ul_div:hover {
		transform: scale(1.01);
	}
	
	.ul_div:hover .li_div {
		box-shadow: 0 0 15px rgba(10, 179, 233, .2);
	}
	
	.ul_div:hover .li_div_img {
		width: 27px;
		height: 34px;
		background-image: url(../../assets/img/time.png);
		background-repeat: no-repeat;
	}
	
	.ul_div:hover .li_div_img_ri {
		width: 32px;
		height: 32px;
		background-image: url(../../assets/img/kasta_ri_h.png);
		background-repeat: no-repeat;
		cursor: pointer;
	}
	
	.ul_div_time {
		position: absolute;
		top: 0;
		left: 90px;
		width: 170px;
		height: 58px;
		line-height: 48px;
		text-align: center;
		font-size: 20px;
		background: #0ab3e9;
		border-radius: 30px;
		color: #fff;
		border: 5px solid #cef0fb;
	}
	
	.ul_div_time-stop {
		position: absolute;
		top: 10px;
		left: 270px;
		font-size: 10px;
		color: rgba(0, 0, 0, .3);
	}
	
	.li_div {
		width: 976px;
		height: 134px;
		line-height: 134px;
		border-radius: 20px;
		background: #fff;
		box-shadow: 0 0 5px rgba(10, 179, 233, .06);
		display: flex;
		align-items: center;
	}
	
	.li_div div:nth-child(1) {
		width: 365px;
		font-size: 32px;
		position: relative;
		display: flex;
		align-items: center;
	}
	
	.li_div_img {
		display: block;
		width: 25px;
		height: 32px;
		margin-top: 3px;
		margin-left: 35px;
		margin-right: 20px;
		background-image: url(../../assets/img/time_stop.png);
		background-repeat: no-repeat;
	}
	
	.li_div_text {
		width: 225px;
		font-size: 20px;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	
	.li_div>div:nth-child(1):before {
		content: "";
		position: absolute;
		top: 50%;
		right: 0px;
		height: 55px;
		width: 2px;
		margin: -27.5px 0 0 0;
		background-color: #0ab3e9;
	}
	
	.li_div div:nth-child(2) {
		width: 306px;
		padding: 0 10px;
		font-size: 16px;
		position: relative;
		text-align: center;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	
	.li_div div:nth-child(2):before {
		width: 315px;
		font-size: 22px;
		content: "";
		position: absolute;
		top: 50%;
		right: 0px;
		height: 55px;
		width: 2px;
		margin: -27.5px 0 0 0;
		background-color: #0ab3e9;
	}
	
	.li_div div:nth-child(3) {
		width: 105px;
		text-align: center;
	}
	
	div.ul_but {
		display: flex;
		flex-wrap: wrap;
		width: 255px !important;
		margin-left: 80px;
		padding: 8px 0 0 0;
	}
	
	.ul_but span {
		display: block;
		margin: 0 5px 8px 0;
		width: 56px;
		height: 30px;
		line-height: 30px;
		font-size: 14px;
		text-align: center;
		border-radius: 15px;
	}
	
	.ul_but_1 {
		color: #0ab3e9;
	}
	
	.ul_but_1_h {
		background: #0ab3e9;
		color: #fff;
	}
	
	.ul_but_2 {
		color: #ffc324;
	}
	
	.ul_but_3 {
		color: #ff5b6e;
	}
	
	.ul_but_4 {
		color: #9b9b9b;
	}
	
	.li_div div:nth-child(4) {
		width: 150px;
		height: 134px;
		/*line-height: 134px;*/
		display: flex;
		flex-wrap: wrap;
		padding: 20px 0 0 20px;
	}
	.li_div div:nth-child(4) button{
		width: 120px;
		height: 44px;
		line-height: 44px;
		border-radius: 8px;
		border: 0;
	}
	.li_div_img_ri {
		display: block;
		width: 30px;
		height: 30px;
		background-image: url(../../assets/img/kasta_ri.png);
		background-repeat: no-repeat;
	}
	
	.butt {
		padding: 22px 56px;
		display: flex;
		justify-content: flex-end;
		border-bottom: 1px solid rgba(10, 179, 233, .1);
	}
	
	.butt div {
		width: 90px;
		height: 40px;
		line-height: 40px;
		text-align: center;
		font-size: 15px;
		cursor: pointer;
	}
	
	.butt div:nth-child(1) {
		background: #fff;
		border-radius: 6px;
		margin-right: 26px;
	}
	
	.butt div:nth-child(2) {
		background: #fff;
		border-radius: 6px 0 0 6px;
		box-shadow: 0 0 2px #0ab3e9;
	}
	
	.butt div:nth-child(3) {
		background: #0ab3e9;
		border-radius: 0 6px 6px 0;
		color: #fff;
	}
	
	.bacolco {
		background: #eee !important;
		color: #fff !important;
	}
	
	.qk {
		text-align: center;
		margin-top: 30px;
		color: #999;
		font-size: 14px;
	}
	
	.divshow {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		z-index: 999999;
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, .2);
	}
	
	.divshow_div {
		position: absolute;
		top: 50%;
		left: 50%;
		border-radius: 10px;
		width: 660px;
		height: 460px;
		margin: -230px 0 0 -330px;
		background: #fff;
	}
	
	.divshow_divtit {
		font-size: 16px;
		height: 54px;
		line-height: 54px;
		text-align: center;
	}
	
	.divshow_but {
		position: absolute;
		bottom: 20px;
		width: 660px;
		text-align: center;
	}
	
	.divshow_but button {
		width: 120px;
		height: 44px;
		line-height: 44px;
		border: 0;
		border-radius: 10px;
		margin: 0 0 0 20px;
		color: #fff;
		font-size: 14px;
		cursor: pointer;
	}
	
</style>
<style type="text/css">
	.my_kask_x .ivu-slider-wrap{
		width: 200px !important;
	}
	.my_kask_x .ivu-slider-button-wrap{
		top: -10px !important;
	}
</style>