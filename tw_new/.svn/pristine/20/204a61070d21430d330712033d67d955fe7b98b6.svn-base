<template>
	<transition name="category-transition">
		<div class="categorySelect" v-show="selectShow">
			<van-nav-bar title="选择服务分类">
			  	<div class="close" slot="right" @click="close">
			  		<img src="@/assets/img/fastReservation/close_round.png" />
		  		</div>
			</van-nav-bar>
			<div class="ul">
				<div class="li" :class="{select : category == item.id}" @click="select(item)" v-for="(item,index) in list">
					<img :src="item.url"/>
					<div class="name">{{item.name}}</div>
				</div>
			</div>
		</div>
	</transition>
</template>

<script>
	export default{
		name:'category',
		props:{
			value:{
				type:Boolean,
				default:false,
			},
			category:{
				type:Number,
				default:0
			}
		},
		computed: {
	      selectShow() {
	        return this.value
	      },
	    },
		data(){
			return{
				list:[
					{	
						id:1,
						url:require('@/assets/img/LOGO.png'),
						name:'家庭钟点'
					},
					{
						id:2,
						url:require('@/assets/img/LOGO.png'),
						name:'办公清洁'
					},
				],
			}
		},
		methods:{
			close(){
				this.$emit('input', false);
			},
			//选择服务分类
			select(type){
				this.close();
				this.$emit('select',type);
			},
			
		}
	}
</script>

<style class="less" scoped>
	
	.categorySelect{
		position: absolute;
		top: 0;
		height: 100%;
		width: 100%;
		background: rgba(0,0,0,.4);
	}
	
	.categorySelect .close{
		display: flex;
		height: .46rem;
		align-items: center;
	}
	.categorySelect .close>img{
		width: .24rem;
		height: .24rem;
	}
	.categorySelect .ul{
		background: #18b4ed;
		padding-top: .1rem;
		color: #fff;
		font-size: .18rem;
	}
	.categorySelect .ul .li{
		display: flex;
		align-items: center;
		height: .6rem;
		padding: 0 .1rem;
	}
	.categorySelect .ul .li.select{
		background: #fff;
		color: #18B4ED;
	}
	.categorySelect .ul .li+.li{
		border-top: 1px solid #fff;
	}
	.categorySelect .ul .li>img{
		width: .25rem;
		height: .25rem;
		padding: 0 .2rem;
	}
</style>
<style class="less">
	.category-transition-enter-active, .category-transition-leave-active{
	  transition: opacity 0.3s linear;
	}
	.category-transition-enter, .category-transition-leave-to{
	  opacity: 0;
	}
</style>