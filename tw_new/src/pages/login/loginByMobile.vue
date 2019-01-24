<template>
	<div class="loginByMobile">
		<!--header-->
		<van-nav-bar title="手机登录" class="white" left-arrow @click-left="onClickLeft" />
		<!--main-->
		<div class="main">
			<van-cell-group style="padding: .2rem;">
			  <van-field
			    v-model="phone"
			    center
			    clearable
			    label="+86"
			    placeholder="输入手机号"
			  />
			  <van-field
			    v-model="sms"
			    center
			    clearable
			    label="验证码"
			    placeholder="输入验证码"
			  >
			    <van-button slot="button" size="small" @click="getSMS" class="plain">{{count_text}}</van-button>
			  </van-field>
			  <div class="protocol">
			  	<input :checked="checked" @click="checked = !checked" type="checkbox" />
			  	<Protocol showTip="2"></Protocol>
			  </div>
			  <van-button round  size="large" class="blue" @click="login">登录</van-button>
			</van-cell-group>
		</div>
		<!--footer-->
		<div class="footer">
			<img src="../../assets/img/logo_h.png"/>
			<div class="logo_name">广州柒度信息科技有限公司</div>
		</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	import Protocol from '@/components/protocol'
	export default{
		components:{
			Protocol
		},
		data(){
			return{
				phone:'',
				sms:'',
				time:60,
				count_text:'获取验证码',
				canSMS:true,//判断验证码按钮状态
				isGetSMS:false,//已点击获取验证码按钮
				checked:false,
			}
		},
		methods:{
			onClickLeft(){
				this.$router.push({
					path:'/login'
				})
			},
			getSMS(){
		        if(this.canSMS){
					var phoneReg = /^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/;
			        if (!phoneReg.test(this.phone)) {
			            this.$toast('手机号码不合法');
			        }else{
			        	this.$fetch('user_code_send', {'user_phone':this.phone}).then(rs => {
				            if (rs.error == 0) {
				              	this.$toast('验证码已发送');
					        	this.countDown();
					        	this.canSMS = false;
					        	this.isGetSMS = true;
				            } else {
				              	this.$toast(rs.msg[0]);
				            }
			          	})
			        }
				}else{
					this.$toast('请勿频繁操作')
				}
			},
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
			login(){
				var phoneReg = /^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/;
		        if (!phoneReg.test(this.phone)) {
		            this.$toast('手机号码不合法');
		        }else if(!this.isGetSMS){
		        	this.$toast('请先获取验证码');
		        }else if(this.sms.length === 0){
		        	this.$toast('请输入验证码');
		        }else if(!this.checked){
		        	this.$toast('请勾选并同意帮家洁平台相关协议');
		        }else{
		        	let data = {};
		        	data.mobile = this.phone;
		        	data.verify_code = this.sms;
		        	this.$fetch('user_login_msn', data).then(rs => {
			            if (rs.error == 0) {
				          	this.$store.commit('login', rs.token);
				          	this.$store.commit('user_id', rs.user_id);
				          	this.$router.back(-1);
			            } else {
			              	this.$toast(rs.msg[0]);
			            }
		          	})
		        }
			},
			
			
		}
	}
</script>

<style scoped>
	.loginByMobile{
		position: relative;
		height: 100%;
	}
	.loginByMobile .main{
		border-top: 1px solid #efefef;
	}
	.loginByMobile .footer{
		position: absolute;
		bottom: .15rem;
		text-align: center;
		width: 100%;
	}
	.loginByMobile .footer>img{
		width: .89rem;
		height: auto;
	}
	.loginByMobile .van-button.blue{
		margin-top: .3rem;
		background: #18b4ed;
		color: #fff;
		font-size: .18rem;
	}
	.loginByMobile .van-button.plain{
		border: 1px solid #18b4ed;
		color: #18b4ed;
		font-size: .14rem;
	}
	.loginByMobile .protocol{
		padding: .2rem 0;
		display: flex;
		align-items: center;
	}
	
	.loginByMobile .protocol input[type="checkbox"]{
		width: .2rem;
		height: .2rem;
		background: url(../../assets/img/check.png) no-repeat;
		background-position: center;
		background-size: .17rem .17rem;
		-webkit-appearance:none;
		outline: none;
	}
	.loginByMobile .protocol input[type="checkbox"]:checked{

		background: url(../../assets/img/checked_round.png) no-repeat;
		background-position: center;
		background-size: .17rem .17rem;
	}
</style>
<style>
	.loginByMobile .van-field__body{
		padding: .1rem 0;
		border-bottom: 1px solid #e1f0ff;
	}
</style>