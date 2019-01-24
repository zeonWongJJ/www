<template>
	<div class='login'>
		<div class='bg'></div>
		<div class="loginBox">
			<van-cell-group>
			  <van-field
			    v-model="userName"
			    clearable
			    label="用户名"
			    placeholder="请输入用户名"
			    @click-icon="$toast('question')"
			  />
	
			  <van-field
			    v-model="userPwd"
			    type="password"
			    label="密码"
			    placeholder="请输入密码"
			  />
			</van-cell-group>
		</div>
		<div class="btnBox">
			<van-button size="large" @click="goGo" class="btn" type="default">登录</van-button>
		</div>
		
	</div>
</template>

<script>
export default{
	data(){
		return{
			userName:'',
			userPwd:'',
		}
	},
	mounted() { 
      
    },
	methods:{
		goGo(){
			this.$router.push({
              path: '/setMenu',
            })
		}
	}
}
</script>

<style scoped>
	.bg{
		width:100%;
		height:2.35rem;
		background-image:url('../../static/img/topBg.png');
		background-size:100% 100%;
		margin-bottom: 0.5rem;
	}
	.loginBox{
		width:80%;
		margin:0 auto;
		font-size:0.16rem;
	}
	.btnBox{
		width:80%;
		margin:0.5rem auto;
	}
	.btn{
		background:#ff9000;
		color:white;
		font-size:0.14rem;
		border-radius: 0.4rem;
	}
	.van-button--large{
		height:42px;
		line-height:42px;
	}
	[class*=van-hairline]::after{
		border:none;
	}
</style>