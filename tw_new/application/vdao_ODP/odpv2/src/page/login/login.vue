<template>
	<div class="login">
		<div class="box">
			<div class="box_logn">
				<div class="box_tit">
					ODP
				</div>
				<div class="box_com">
					<Tabs v-model="tabName" @on-click="tabClick($event)">
						<TabPane label="登陆" name="login">
							<div class="errotip_tit">
								{{errotip}}
							</div>
							<div class="box_com_mobile">
								<img src="../../assets/img/mobile.png" />
								<input type="text" v-model="mobile" name="" id="mobile" placeholder="手机号/用户名" />

							</div>
							<div class="box_com_mobile">
								<img src="../../assets/img/pass.png" />
								<input type="password" v-model="opassword" name="" id="password" placeholder="密码" @keyup.enter="logins" />
							</div>
							<!--							
							<div class="box_com_code">
								<div>
									<img src="../../assets/img/secu.png" />
									<input type="text" v-model="secu" name="" id="secu" placeholder="验证码" />

								</div>

								<div class="box_com_code_ri" @click="aaqq()">
									9879
								</div>

							</div>-->

							<div class="box_com_check">
								<!--<div>
									<input type="checkbox" name="" id="" value="" />
									<p>记住密码</p>
								</div>-->
								<!--<div>
									忘记密码？
								</div>-->
							</div>

							<div class="box_com_but" @click="logins">
								登陆
							</div>

							<div class="box_com_register">
								<span>其他平台登陆</span>
								<p @click="erweima_r()"><img src="../../assets/img/weixin.png" /></p>
							</div>
						</TabPane>
						<!--注册-->
						<TabPane label="注册" name="register">
							<!--<div class="errotip_tit">
								{{errotip}}
							</div>
							<div class="box_com_mobile">
								<img src="../../assets/img/mobile.png" />
								<input type="text" v-model="mobile2" name="" id="mobile2" placeholder="手机号" />
							</div>
							<div class="box_com_code2">
								<div>
									<img src="../../assets/img/secu.png" />
									<input type="text" v-model="vcode" name="" id="vcode" placeholder="验证码" />
								</div>
								<div class="box_com_code_ri2" @click="fun_count_down">
									{{count_down}}{{count_down2}}
								</div>
							</div>
							<div class="box_com_mobile">
								<img src="../../assets/img/pass.png" />
								<input type="password" v-model="opassword2" name="" id="password2" placeholder="请输入6-20位密码" />

							</div>
							<div class="box_com_but2" @click="register">
								注册
							</div>
							<div class="box_com_register">
								<span>其他平台注册</span>
								<p @click="erweima_r()"> <img src="../../assets/img/weixin.png" /></p>
							</div>-->
						</TabPane>
					</Tabs>

				</div>
			</div>
		</div>
		<div class="erweima" @click="erweima_r()" v-show="erweima">
			<div class="erweima_div">
				<img src="../../assets/img/erweima.png" />
			</div>
		</div>
	</div>
</template>

<script>
	import api from '@/api/api'

	export default {

		data() {
			return {
				tabName: 'login',
				mobile: '', //手机
				opassword: '', //密码
				secu: '', //验证码
				mobile2: '', //手机
				opassword2: '', //密码
				secu2: '', //验证码
				count_down: '获取验证码', //获取验证码按钮
				count_down2: '', //获取验证码按钮
				vcode: '', //输入验证码
				time: 60, //倒计时
				dx_type: true, //阻止获取验证码按钮多次点
				re_do: '', //提示组件
				do_yn: false, //提示组件
				do_no: false, //提示组件
				logns: false,
				logns_r: false,
				errotip: '', //错误返回
				erweima: false, //二维码

			}
		},
		mountde() {
			console.log(this.store.state.token)
			console.log(this.$store.state.member_id)
		},
		methods: {
			logins() {
				let that = this;
				let re = /(1[3-9]\d{9}$)/;
				if(that.mobile == "") {
					that.errotip = "手机号或用户名不能为空！";
					//					that.$Message.warning("手机号不能为空");
					return false;
				}
//				else if(!re.test(that.mobile)) {
//					that.errotip = "请输入正确的手机号！";
//					return false;
//				}
				else if(that.opassword == '') {
					that.errotip = "密码不能为空！";
					return false;
				} else if(that.opassword != that.opassword) {
					that.errotip = "密码有误！";
					return false;
				} else {
					let asa = {};
					that.errotip = ''
					asa.member_name = that.mobile
					asa.password = that.opassword
					var qs = require('qs');
					
					that.axios({
							method: 'post',
							headers: {
								"Content-Type": "application/x-www-form-urlencoded"
							},
							url: api.test,
							data: qs.stringify(asa) //传参变量
							
						})
						.then(function(res) {
							let data = res.data
							if(data.error) {
								that.$Message.error(data.msg)
							} else {
										console.log(res.data)
								that.$store.commit('set_token', data.data.token);
								that.$store.commit('member_id', data.data.member_id);
								that.$store.commit('real_name', data.data.real_name);
								that.$store.commit('department_name', data.data.department_id);
								that.$store.commit('department', data.data.department_name);
								that.$store.state.member_id = data.data.member_id;
								that.$router.push({
									path: '/main'
								})
							}

						})
				}
			},
			ass() {
				let that = this;
				that.$router.push({
					path: '/main'
				})
			},
			register() {
				let that = this;
				that.$router.push({
					path: '/register'
				})
			},
			erweima_r() {
				let that = this;
				that.erweima = !that.erweima
			},
			showlogns_r() {
				let that = this;
				that.logns_r = !that.logns_r
				that.logns = false
			},
			//获取验证码事件
			fun_count_down() {
				let that = this
				let mobile2 = that.mobile2;
				let re = /(1[3-9]\d{9}$)/;
				// 验证手机号
				if(that.mobile2 == "") {
					that.errotip = "密码手机号不能为空！";
					that.$Message.warning("手机号不能为空");
					return false;
				}
				if(!re.test(that.mobile2)) {
					that.errotip = "请输入正确的手机号！";
					that.$Message.warning("请输入正确的手机号");
					return false;
				}
				if(that.dx_type) {
					that.dx_type = false;
					that.fun_yzm();
					that.errotip = ''
					//					that.axios({
					//							method: 'GET',
					//							url: api.enrollVerification + mobile + api.enrollVerificationRepair
					//						})
					//						.then(function(res) {
					//							if(res.data.status == '1') {
					//								//that.$Message.success("验证码已发送");
					//								that.fun_yzm();
					//							} else {
					//								//that.$Message.error(res.data.message);
					//								that.errotip = res.data.message;
					//							}
					//							
					//						})
				}
			},
			//			倒计时
			fun_yzm() {
				let that = this
				that.count_down = that.time
				that.count_down2 = '秒'
				if(that.time === 0) {
					that.count_down = '获取验证码'
					that.count_down2 = ''
					that.time = 60
					that.dx_type = true
				} else {
					that.count_down = that.time--
						setTimeout(that.fun_yzm, 1000);
				}
			},
			fun_count_down2() {

				let that = this
				//				let mobile = that.codemobile.mobile;
				let re = /(1[3-9]\d{9}$)/;
				// 验证手机号

				if(that.mobile == "") {
					that.errotip = "手机号不能为空！";
					return false;
				} else if(!re.test(that.mobile)) {
					that.errotip = "请输入正确的手机号！";
					return false;
				} else if(that.opassword == '') {
					that.errotip = "密码不能为空！";
					return false;
				} else if(that.opassword.length < 6) {
					that.errotip = "密码不能少6位！";
					return false;
				} else if(that.opassword != that.opassword) {
					that.errotip = "密码有误！";
					return false;
				} else if(that.secu == '') {
					that.errotip = "验证码不能为空！";
					return false;
				} else if(that.secu != that.secu) {
					that.errotip = "验证码有误！";
					return false;
				} else {}

			},
			register() {
				let that = this;
				let re = /(1[3-9]\d{9}$)/;
				if(that.enterpriseName == '') {
					that.errotip = "请输入企业名称！";
					/*that.$Message.error("请输入企业名称")*/
					return false;
				} else if(that.enterpriseName.length > 50) {
					that.errotip = "企业名称不能超过50个字！";
					/*that.$Message.error("企业名称不能超过50个字")*/
					return false;
				} else if(that.IndividualName == '') {
					that.errotip = "请输入用户名称！";
					/*that.$Message.error("请输入用户名称")*/
					return false;
				} else if(that.Password == '') {
					that.errotip = "请输入密码！";
					/*that.$Message.error("请输入密码")*/
					return false;
				} else if(that.Password.length < 6) {
					that.errotip = "密码不能小与6位！";
					/*that.$Message.error("密码不能小与6位")*/
					return false;
				} else if(that.Password2 != that.Password) {
					that.errotip = "密码不一致！";
					/*that.$Message.error("密码不一致，")*/
					return false;
				}
				// 验证手机号
				else if(that.mobile == "") {
					that.errotip = "手机号不能为空！";
					/*that.$Message.error("手机号不能为空");*/

					return false;
				} else if(!re.test(that.mobile)) {
					that.errotip = "请输入正确的手机号！";
					/*that.$Message.error("请输入正确的手机号");*/
					return false;
				} else if(that.vcode == '') {
					that.errotip = "验证码不能为空！";
					/*that.$Message.error("验证码不能为空");*/
					return false;
				}
				//else验证成功返回提示
				else {}
			},
			tabClick(val) {
				if(val == 'register') {
					window.open("https://project.7dugo.com/login.html");
				}
			},
			register() {
				this.$Message.warning('暂时无法注册！')
			}
		}
	}
</script>

<style scoped>
	.login {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		/*background: #0ab3e9;*/
		background: url(../../../static/imgs/ba_jing.png) no-repeat;
		background-size: 100% 100%;
	}
	
	.box {
		/*position: relative;*/
	}
	
	.box_logn {
		position: absolute;
		width: 414px;
		height: 560px;
		top: 50%;
		left: 50%;
		margin-top: -280px;
		margin-left: -207px;
	}
	
	.box_tit {
		height: 100px;
		text-align: center;
		font-size: 30px;
		font-weight: 700;
		color: #fff;
	}
	
	.box_com {
		width: 414px;
		height: 500px;
		background: #fff;
		border-radius: 15px;
		padding: 20px 50px;
	}
	
	.box_com_tit {
		display: flex !important;
		font-size: 22px;
		color: #283033;
		margin: 0 0 15px 0;
	}
	
	.box_com_tit div {
		width: 50%;
		text-align: center;
		padding: 15px 0;
		font-size: 22px;
		border-bottom: 2px solid #e5e5e5;
	}
	
	.box_com_tit div:hover {
		font-size: 22px;
		color: #0ab2e9;
		border-bottom: 2px solid #0ab2e9;
	}
	
	.box_com_tit_div {
		text-align: center;
		padding: 15px 0;
		font-size: 22px;
		color: #0ab2e9;
		border-bottom: 2px solid #0ab2e9 !important;
	}
	
	.box_com_mobile {
		width: 314px;
		height: 50px;
		border: 1px solid #dadbdc;
		border-radius: 24px;
		padding: 12px 25px;
		margin: 10px 0 15px 0;
		display: flex !important;
		position: relative;
	}
	
	.box_com_mobile input {
		font-size: 16px;
		margin-left: 10px;
		padding: 0 10px;
		color: #283033;
	}
	
	.box_com_code {
		width: 314px;
		height: 50px;
		/*border: 1px solid #eee;*/
		/*border-radius: 24px ;*/
		display: flex !important;
		justify-content: flex-start;
		align-items: center;
		margin-bottom: 25px;
		position: relative;
	}
	
	.box_com_code div:nth-child(1) {
		width: 220px;
		height: 50px;
		display: flex;
		padding: 10px 25px;
		border: 1px solid #dadbdc;
		border-radius: 24px;
	}
	
	.box_com_code div:nth-child(1) img {
		width: 20px;
		height: 26px;
		font-size: 16px;
	}
	
	.box_com_code div:nth-child(1) input {
		width: 140px;
		font-size: 16px;
		margin-left: 10px;
		padding: 0 10px;
		color: #283033;
	}
	
	.box_com_code_ri {
		width: 80px !important;
		height: 50px;
		line-height: 50px;
		font-size: 16px;
		border: 1px solid #0ab2e9;
		margin-left: 20px;
		border-radius: 24px;
		text-align: center;
		/*background: #00C1DE;*/
		color: #0ab2e9;
	}
	
	.box_com_check {
		margin-top: 20px;
		display: flex !important;
		justify-content: space-between;
	}
	
	.box_com_check div:nth-child(1) {
		display: flex;
		justify-content: flex-start;
		align-items: center;
	}
	
	.box_com_check div:nth-child(1) p {
		margin-left: 8px;
	}
	
	.box_com_check div:nth-child(1) input {
		background: #fff !important;
		cursor: pointer
	}
	
	.box_com_check div:nth-child(2) {
		color: #0ab3e9;
		cursor: pointer
	}
	
	.box_com_but {
		width: 314px;
		height: 50px;
		border-radius: 24px;
		line-height: 50px;
		background: #0ab3e9;
		font-size: 20px;
		text-align: center;
		color: #fff;
		margin: 20px 0;
	}
	
	.box_com_register {
		text-align: center;
	}
	
	.box_com_register span {
		position: relative;
	}
	
	.box_com_register span:before {
		content: "";
		position: absolute;
		right: -100px;
		bottom: 6px;
		height: 1px;
		width: 80px;
		margin: -27.5px 0 0 0;
		background-color: #dadbdc;
	}
	
	.box_com_register span:after {
		content: "";
		position: absolute;
		left: -100px;
		bottom: 6px;
		height: 1px;
		width: 80px;
		margin: -27.5px 0 0 0;
		background-color: #dadbdc;
	}
	
	.box_com_register p {
		margin-top: 30px;
		color: #0ab3e9;
		cursor: pointer;
	}
	
	.lierro {
		display: flex;
		align-items: center;
		position: absolute;
		left: 50px;
		top: 50px;
		width: 300px;
		color: #f00;
	}
	
	.lierro img {
		width: 20px;
		height: 20px;
	}
	
	.box_com_code .lierro img {
		width: 20px;
		height: 20px;
	}
	
	.box_com_code2 {
		width: 314px;
		height: 50px;
		/*border: 1px solid #eee;*/
		/*border-radius: 24px ;*/
		display: flex !important;
		justify-content: flex-start;
		align-items: center;
		margin-bottom: 15px;
		position: relative;
	}
	
	.box_com_code2 div:nth-child(1) {
		width: 180px;
		height: 50px;
		display: flex;
		padding: 10px 25px;
		border: 1px solid #dadbdc;
		border-radius: 24px;
	}
	
	.box_com_code2 div:nth-child(1) img {
		width: 20px;
		height: 26px;
		font-size: 16px;
	}
	
	.box_com_code2 div:nth-child(1) input {
		width: 80px;
		font-size: 16px;
		margin-left: 10px;
		padding: 0 10px;
		color: #283033;
	}
	
	.box_com_code_ri2 {
		width: 150px !important;
		height: 50px;
		line-height: 50px;
		font-size: 16px;
		border: 1px solid #eee;
		margin-left: 20px;
		border-radius: 24px;
		text-align: center;
		background: #00C1DE;
		color: #fff;
		cursor: pointer;
	}
	
	.box_com_but2 {
		width: 314px;
		height: 50px;
		border-radius: 24px;
		line-height: 50px;
		background: #0ab3e9;
		font-size: 20px;
		text-align: center;
		color: #fff;
		margin: 50px 0 20px 0;
	}
	
	.errotip_tit {
		text-align: center;
		color: #f00;
	}
	
	.erweima {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: rgba(0, 0, 0, .3);
		z-index: 9999;
	}
	
	.erweima_div {
		width: 300px;
		height: 300px;
		position: absolute;
		top: 50%;
		left: 50%;
		margin: -150px 0 0 -150px;
	}
	
	.erweima_div img {
		width: 100%;
	}
</style>
<style type="text/css">
	.ivu-tabs-nav {
		width: 100% !important
	}
	
	.ivu-tabs-nav .ivu-tabs-tab-active {
		text-align: center;
		font-size: 20px;
		width: 50%;
	}
	
	.ivu-tabs-nav .ivu-tabs-tab {
		text-align: center;
		width: 50%;
		font-size: 20px;
	}
	
	.ivu-tabs-tab .ivu-tabs-tab-active .ivu-tabs-tab-focused {
		text-align: center;
	}
</style>