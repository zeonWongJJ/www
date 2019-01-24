<template>
	<div class="fastReservation">
		<!--header-->
		<van-nav-bar title="快速预约" left-arrow @click-left="onClickLeft" />
		<!--main-->
		<div class="main">
			<div class="form">
				<div class="label flex category" @click="categorySelect = true">
					<div class="logo">
						<img src="../../assets/img/fastReservation/category.png"/>
					</div>
					<div class="category_div" :class="{black : category}">{{category ? categoryType.name : '请选择服务分类'}}</div>
					<div class="more">
						<img src="../../assets/img/fastReservation/category_more.png"/>
					</div>
				</div>
				<div class="label flex sms">
				  	<div class="logo">
				  		<img src="../../assets/img/fastReservation/phone_blue.png"/>
				  	</div>
				  	<van-field
					    v-model="phone"
					    center
					    clearable
					    placeholder="请填写您的手机号码"
					    ></van-field>
			  	</div>
			  	<div class="label flex sms">
				  	<div class="logo">
				  		<img src="../../assets/img/fastReservation/sms_blue.png"/>
				  	</div>
				  	<van-field
					    v-model="sms"
					    center
					    clearable
					    placeholder="请输入短信中的验证码"
					    >
					    <van-button slot="button" size="large" class="blue" @click="getSMS">{{count_text}}</van-button>
					</van-field>
			  	</div>
			  	<!--协议-->
			  	<div class="protocol">
			  		<input :checked="checked" @click="checked = !checked" type="checkbox" />
			  		<Protocol showTip="3"></Protocol>
			  	</div>
			  	<van-button round  size="large" class="reservation" :class="{canReservation:canReservation}" @click="reservation">预约</van-button>
			</div>
		</div>
		<!--category-->
		<Category v-model="categorySelect" :category="category" @select="finishCategory"></Category>
		<!--reservationSuccess-->
		<van-popup v-model="reservationSuccess" :close-on-click-overlay="false" class="reservationSuccess">
			<div class="body" @click="closeSuccess">
				<div class="top"></div>
				<div class="success_png">
					<img src="../../assets/img/fastReservation/reservationSuccess.png"/>
				</div>
				<div class="center">
					<div class="close"><img src="../../assets/img/fastReservation/close_blue.png"/></div>
					<div class="tip">恭喜！您已预约成功</div>
					<div class="info">稍后会有客服人员电话与您确认具体的服务需求，请留意18998301449号码的来电，感谢您的支持！</div>
					<van-button round  size="large" class="success"  @click="reservation">确认</van-button>
				</div>
			</div>
		</van-popup>
	</div>
</template>

<script>
	import Protocol from '@/components/protocol'
	import Category from '@/components/category'
	export default{
		components:{
			Protocol,
			Category
		},
		data(){
			return{
				category:0,
				phone:'',
				sms:'',
				time:60,
				count_text:'获取验证码',
				canSMS:true,//判断验证码按钮状态
				categorySelect:false,//分类列表状态
				categoryType:{},
				isGetSMS:false,//已点击获取验证码按钮
				canReservation:false,//预约按钮状态
				reservationSuccess:false,//预约成功
				checked:false,
			}
		},
		watch:{
			category:function(newVal,oldVal){
				this.canReservation = this.inspect()
			},
			phone:function(newVal,oldVal){
				this.canReservation = this.inspect()
			},
			sms:function(newVal,oldVal){
				this.canReservation = this.inspect()
			},
			checked:function(newVal,oldVal){
				this.canReservation = this.inspect()
			},
		},
		methods:{
			onClickLeft(){
				this.$router.push({
					path:'/home'
				})
			},
			//预约
			reservation(){
				if(this.canReservation){
					this.reservationSuccess = true;
				}else{
					console.log(2222)
				}
//				this.reservationSuccess = true;
			},
			//关闭预约成功提示，跳转到首页
			closeSuccess(){
				this.onClickLeft()
			},
			//获取验证码
			getSMS(){
				if(this.canSMS){
					var phoneReg = /^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/;
			        if (!phoneReg.test(this.phone)) {
			            this.$toast('手机号码不合法');
			        }else{
			        	this.countDown();
			        	this.canSMS = false;
			        	this.isGetSMS = true
			        }
				}else{
					this.$toast('请勿频繁操作')
				}
			},
			//倒计时
			countDown() {
				let that = this
				that.count_text = that.time + '秒'
				if(that.time === 0) {
					that.count_text = '获取验证码'
					that.time = 60
					that.canSMS = true
				} else {
					that.count_text = (that.time--) + '秒'
					setTimeout(that.countDown, 1000);
				}
			},
			//判断预约按钮状态
			inspect(){
				var phoneReg = /^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/;
				if(!this.category){
					return false
				}else if(!phoneReg.test(this.phone)){
					return false
				}else if(this.sms.length === 0){
					return false
				}else if(!this.checked){
					return false
				}else{
					return true
				}
			},
			
			//选择服务分类
			finishCategory(type){
				console.log(type)
				this.categoryType = type;
				this.category = type.id
			}
		}
	}
</script>

<style scoped>
	.fastReservation{
		height: 100%;
		background: #f5f5f5;
		position: relative;
	}
	.fastReservation .form{
		padding: .1rem;
	}
	.fastReservation .label{
		border: none;
		box-shadow: 0px 5px 13px rgba(148,213,237,.2);
		margin-bottom: .2rem;
		background: #fff;
		border-radius: 5px;
		overflow: hidden;
	}
	.fastReservation .label.flex{
		display: flex;
		align-items: center;
		justify-content: space-between;
	}
	.fastReservation .category_div{
		line-height: .6rem;
		flex: 1;
    	font-size: .16rem;
    	color:#757575;
	}
	.fastReservation .category_div.black{
		color: #000;
	}
	
	.fastReservation .label .logo,.fastReservation .label .more{
		width: .2rem;
		height: .2rem;
		overflow: hidden;
		margin: 0 .2rem;
	}
	.fastReservation .label .logo>img,.fastReservation .label .more>img{
		height: 100%;
	}
	.fastReservation .label .more{
		margin: .2rem;
	}
	.fastReservation .van-cell{
		padding: 0px;
    	height: 0.6rem;
    	font-size: .16rem;
	}
	
	.fastReservation .label .van-button.blue{
		background: #18b4ed;
		color: #fff;
		border: 1px solid #18b4ed;
		height: .6rem;
		width: 1rem;
		font-size: .16rem;
	}
	.fastReservation .van-button.reservation{
		margin-top: .3rem;
		background: #b2b2b2;
		color: #fff;
		font-size: .18rem;
	}
	.fastReservation .van-button.reservation.canReservation{
		background: #18b4ed;
	}
	
	.fastReservation .van-button.success{
		background: #18b4ed;
		color: #fff;
		font-size: .18rem;
	}
	
	.fastReservation .reservationSuccess{
		background: none;
		width: calc(100% - .4rem);
		padding:.35rem 0;
	}
	.fastReservation .reservationSuccess .body{
		position: relative;
	}
	.fastReservation .top{
		width: .95rem;
		height: .95rem;
		border-radius: 50%;
		background: #fff;
		position: absolute;
		left: 50%;
		top: -.35rem;
		margin-left: -.475rem;
		z-index: -1;
	}
	.fastReservation .success_png{
		width: .4rem;
		position: absolute;
		left: 50%;
		top: -.3rem;
		margin-left: -.2rem;
	}
	.fastReservation .success_png>img{
		width: 100%;
		height: auto;
	}
	.fastReservation .center{
		padding: .1rem;
		background: #fff;
		border-radius: 5px;
	}
	.fastReservation .center .tip{
		font-size: .2rem;
		color: #18B4ED;
		padding: .1rem 0;
		border-bottom: 1px solid #18B4ED;
		text-align: center;
	}
	.fastReservation .center .info{
		padding: .1rem 0;
		font-size: .16rem;
	}
	.fastReservation .center .close{
		height: .15rem;
		display: flex;
		justify-content: flex-end;
	}
	.fastReservation .center .close>img{
		height: 100%;
		width: auto;
	}
	.fastReservation .protocol{
		padding: .2rem 0;
		display: flex;
		align-items: center;
	}
	
	.fastReservation .protocol input[type="checkbox"]{
		width: .2rem;
		height: .2rem;
		background: url(../../assets/img/check.png) no-repeat;
		background-position: center;
		background-size: .17rem .17rem;
		-webkit-appearance:none;
		outline: none;
	}
	.fastReservation .protocol input[type="checkbox"]:checked{

		background: url(../../assets/img/checked_round.png) no-repeat;
		background-position: center;
		background-size: .17rem .17rem;
	}
</style>
<style type="text/css">
	.fastReservation .van-hairline--bottom::after{
		border:none;
	}
</style>