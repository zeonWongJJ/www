<template>
	<div class="hello">
		<h1>{{ msg }}</h1>
		<h2>Essential Links</h2>
		<ul>
			<li>
				<a href="https://vuejs.org" target="_blank">
					Core Docs
				</a>
			</li>
			<li>
				<a href="https://forum.vuejs.org" target="_blank">
					Forum
				</a>
			</li>
			<li>
				<a href="https://chat.vuejs.org" target="_blank">
					Community Chat
				</a>
			</li>
			<li>
				<a href="https://twitter.com/vuejs" target="_blank">
					Twitter
				</a>
			</li>
			<br>
			<li>
				<a href="http://vuejs-templates.github.io/webpack/" target="_blank">
					Docs for This Template
				</a>
			</li>
		</ul>
		<h2>Ecosystem</h2>
		<ul>
			<li>
				<a href="http://router.vuejs.org/" target="_blank">
					vue-router
				</a>
			</li>
			<li>
				<a href="http://vuex.vuejs.org/" target="_blank">
					vuex
				</a>
			</li>
			<li>
				<a href="http://jiajie-mobile.7dugo.com/test" target="_blank">
					vue-loader
				</a>
			</li>
			<li>
				<a href="https://github.com/vuejs/awesome-vue" target="_blank">
					awesome-vue
				</a>
			</li>
		</ul>
		<div>
			{{img}} {{age}}
		</div>
		
		
		<input type="text" name="id" v-model="list.name" id="" value="" />
		<input type="text" name="id" v-model="list.id" id="" value="" />
		
		<input type="button" name="" id="" value="asdfdsa"  @click="aaa"/>
	</div>
</template>

<script>
	import api from '@/api/api'
	export default {
		name: 'HelloWorld',
		data() {
			return {
				msg: 'Welcome to Your Vue.js App',
				img: '',
				age: '',
				name:'',
				list:{
					id:'',
					name:''
				},
				pageInfo: {
					name: '',
					count: 10,
					page: 'sdfg', //page
					rows: 10 //rows

				},
			}
		},
			methods:{
		//post 的 qs方法 
				aaa(){
				let that = this;
				let asa = that.list;
				 var qs = require('qs');
				that.axios({
							method: 'post',
							header: {
								"Content-Type": 'application/x-www-form-urlencoded'
							},
							url: api.test,
							data: qs.stringify({asa})//传参变量
						})
						.then(function(res) {
								console.log('-----------', res)
							
						})	
			},
		},
		mounted() {	
			let that = this
//			that.axios.get(api.test)
//				.then(function(res) {
//					console.log('-----------', res)
//					let datas = res.data.data
//					if(datas.status == 1) {
//						that.age = datas.datas.age
//						that.img = datas.datas.name
//						console.log(datas.datas)
//
//					} else {
//						alert(datas.errCode)
//					}
//
//				})
//				.catch(function(error) {
//					console.log(error);
//				});
//第二种get方法
//	that.axios({
//						method: 'GET',
//						url: api.enrollVerification_forget + mobile + api.enrollVerificationRepair_forget
//					})
//					.then(function(res) {
//						//							
//						if(res.data.status == '1') {
//							//that.$Message.success("验证码已发送");
//							that.fun_yzm();
//						} else {
//							that.codeerro = true;
//							that.codeerro_m = res.data.message;
//						}
//
//					})
//					post方法

//			var oid = that.list;
//					that.axios({
//							method: 'post',
//							header: {
//									"Content-Type": 'application/x-www-form-urlencoded'
//							},
//							url: api.test,
//							data: api.convertParam(oid)//传参变量
//						})
//						.then(function(res) {
//								console.log('-----------', res)
//							let datas = res.data.data/
//							if(datas.status == 1) {
//								}
//						})	
					
					



		},
	
		
		
	
		
		
		
		
		
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
	h1,
	h2 {
		font-weight: normal;
	}
	
	ul {
		list-style-type: none;
		padding: 0;
	}
	
	li {
		display: inline-block;
		margin: 0 10px;
	}
	
	a {
		color: #42b983;
	}
</style>