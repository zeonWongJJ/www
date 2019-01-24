<template>
	<div class="login">
		<!--header-->
		<van-nav-bar title="登录" left-arrow @click-left="onClickLeft" />
		<!--main-->
		<div class="main">
			<div class="tip">{{info}}</div>
			<div class="login_box">
				<div class="login_btn" @click="toLogin(1)">
					<img src="../../assets/img/login/wechat_L.png"/>
					<div>微信登录</div>
				</div>
				<div class="login_btn" @click="toLogin(2)">
					<img src="../../assets/img/login/alipay_L.png"/>
					<div>支付宝登录</div>
				</div>
				<div class="login_btn" @click="toLogin(3)">
					<img src="../../assets/img/login/mibile_L.png"/>
					<div>手机登录</div>
				</div>
			</div>
		</div>
		<!--协议-->
		<div class="protocol">
			<Protocol showTip="1"></Protocol>
		</div>
		<!--footer-->
		<div class="footer">
			<img src="../../assets/img/logo_h.png"/>
			<div class="logo_name">广州柒度信息科技有限公司</div>
		</div>
	</div>
</template>

<script>
	import Protocol from '@/components/protocol'
	import utils from '@/utils/utils'
	export default{
		components:{
			Protocol
		},
		data(){
			return{
				info:'你可以用以下方式登录',
				wechat: {
		          wx_nickname: sessionStorage.getItem('wechat_nickname') || '',
		          wx_openid: sessionStorage.getItem('wechat_openid') || '',
        		},
			}
		},
		methods:{
			onClickLeft(){
				this.$router.push({
					path:'/home'
				})
			},
			toLogin(type){
				if(type === 3){
					this.$router.replace({
						path:'/loginByMobile'
					})
				}else if(type === 1){
					// 微信公众号打开的时候，直接获取
			        const is_completed = utils.getUrlParam('is_completed')
			        console.log(is_completed);
			        if (utils.is_weixin() && is_completed != 'true') {
			          	window.location.href = `${this.$config.baseURL}wechat.get.userinfo?refer=${this.$config.touchURL}&route=login`
			        } else {
			        	const wx_nickname = decodeURIComponent(utils.getUrlParam('user_name'));
			        	const wx_openid = utils.getUrlParam('open_id');
			        	sessionStorage.setItem('wechat_nickname',wx_nickname)
			      		sessionStorage.setItem('wechat_openid', wx_openid)
			          	this.wechat.wx_nickname = wx_nickname;
			          	this.wechat.wx_openid = wx_openid;
			        }
//			        let data = {};
//					data.wx_openid = 'osAKb1WtZuKUhM3kYZLfyMt_2Nmo';
//					data.wx_nickname = '11';
//					data.wx_unionid = 'ocSxFxKoReM6PFImaqUIWJj5yM81';
//					this.$fetch('user_login_wechat',data).then(rs =>{
//						console.log(rs)
//						return
//						this.$store.commit('login', rs.token);
//			          	this.$router.push({
//			          		path:'/home'
//			          	})
//					});
			        // 安卓APP
			        if (utils.is_android()) {
			          	android.wxAuthorizationLogin();
			        }
			        // IOS app
			        if (utils.is_ios()) {
			          	window.webkit.messageHandlers.wxAuthorizationLogin.postMessage({});
			        }
				} else if (type === 2) {

//					let data = {};
//					data.auth_code = 'dc30a8bc3d3d44a28565304474e0wx16';
//					this.$fetch('user_login_alipay',data).then(rs =>{
//						this.$store.commit('login', rs.token);
//			          	this.$router.replace({
//			          		path:'/home'
//			          	})
//					})
		          	if (utils.is_android()) {
			            android.alipayAuth2();
		          	}
		          	if (utils.is_ios()) {
			            window.webkit.messageHandlers.alipayAuth2.postMessage({});
		          	}
		        }
			}
		},
		mounted(){
			let toPath = this.$store.state.path.to;
			if( toPath === '/member'){
				this.info = '登录后可查看个人主页'
			}
			if( toPath === '/mymess'){
				this.info = '登录后可查看消息'
			}
			if(this.$route.query.open_id && this.$route.query.user_name){
				let data = {};
				data.wx_openid = this.$route.query.open_id;
				data.wx_nickname = this.$route.query.user_name;
				this.$fetch('user_login_wechat',data).then(rs =>{
                    utils.loginToJPush(rs.user_id)
					this.$store.commit('login', rs.token);
		          	this.$router.replace({
		          		path:'/home'
		          	})
				});
			}
			//微信登录回调
			window['wxAuthorizationLoginSuccess'] = obj =>{
				let data = {};
				data.wx_openid = obj.openid;
				data.wx_nickname = obj.nickname;
				data.wx_unionid = obj.unionid;
				this.$fetch('user_login_wechat',data).then(rs =>{
                    utils.loginToJPush(rs.user_id)
					this.$store.commit('login',rs.token)
					if(rs.need_bind_phone){
						this.$router.replace({
							path:'/loginByMobile',
							query:{
								bind:1
							}
						})
					}else{
			          	this.$router.replace({
			          		path:'/home'
			          	})
					}
				}).catch(e =>{

				});
			}
			//支付宝登录回调
			window['aliPayAuthSuccess'] = obj =>{
				let data = {};
				data.auth_code = obj.auth_code;
				this.$fetch('user_login_alipay',data).then(rs =>{
                    utils.loginToJPush(rs.user_id)
					this.$store.commit('login', rs.token);
		          	this.$router.replace({
		          		path:'/home'
		          	})
				}).catch(e=>{
					console.log(err);
				});
			}
		}
	}
</script>

<style scoped>
	.login{
		position: relative;
		height: 100%;
	}
	.login .header{
		font-size: .18rem;
		text-align: center;
		line-height: .46rem;
		height: .46rem;
		color: #fff;
		background: #18b4ed;
	}
	.login .footer{
		position: absolute;
		bottom: .15rem;
		text-align: center;
		width: 100%;
	}
	.login .footer>img{
		width: .89rem;
		height: auto;
	}
	.login .main{
		text-align: center;
		font-size: .16rem;
	}
	.login .main .tip{
		padding: .4rem 0;
	}
	.login .main .login_box{
		display: flex;
		justify-content: space-between;
		padding: 0 .3rem;
	}
	.login .main .login_box .login_btn>img{
		width: .75rem;
		height: auto;
	}
	.login .protocol{
		padding: .2rem 0;
		font-size: .12rem;
	}
</style>
