<template>
	<div class="releaseService">
		<!--header-->
		<van-nav-bar title="发布服务" left-arrow @click-left="onClickLeft" />
		<!--main-->
		<div class="main">
			<div class="form">
				<!--服务分类-->
				<div class="cell flex category" @click="categorySelect = true">
					<div class="logo">
						<img src="../../assets/img/fastReservation/category.png"/>
					</div>
					<div class="category_div" :class="{black : category}">{{category ? categoryType.name : '请选择服务分类'}}</div>
					<div class="more">
						<img src="../../assets/img/fastReservation/category_more.png"/>
					</div>
				</div>
				<!--填写内容-->
				<div class="cell message">
					<van-field
					    v-model="message"
					    type="textarea"
					    placeholder="请填写您的收费标准、服务内容、服务流程、 服务保障等。详细的服务介绍可以吸引更多客 户下单。"
					    rows="4"
					    autosize
					/>
				</div>
				<!--上传图片-->
				<div class="cell photo">
					<div>请上传您的现场图片</div>
					<div class="upload_box">
						<div class="upload_img" v-for="(item,index) in uploadList">
							<div class="delete" @click="deleteImg(index)"><img src="../../assets/img/delete.png"/></div>
							<img :src="item"/>
						</div>
						<van-uploader :after-read="onRead" :before-read="beforeRead" accept="image/gif, image/jpeg" multiple>
					  		<div class="upload_icon"><img src="../../assets/img/upload.png"/></div>
						</van-uploader>
					</div>
				</div>
				<!--收费方式-->
				<div class="cell flex fees">
					<div class="label">服务收费</div>
					<div class="right" @click="showFees = true">
						<div class="gray" v-show="!feesType.type.id">去编辑</div>
						<div class="price" v-if="feesType.type.id != 3">{{feesType.price}}<span v-if="feesType.type.id == 1">{{feesType.unit.name}}</span></div>
						<div class="red">{{feesType.type.name}}</div>
					</div>
				</div>
				<!--服务范围-->
				<div class="cell flex range">
					<div class="label">服务范围</div>
					<div class="right">
						<div>定位中...</div>
						<div class="plain">附近30公里</div>
					</div>
				</div>
			  	<!--协议-->
			  	<div class="protocol">
			  		<input :checked="checked" @click="checked = !checked" type="checkbox" />
			  		<Protocol showTip="3"></Protocol>
			  	</div>
			  	<van-button round  size="large" class="release" :class="{canReservation:canReservation}" @click="release">发布</van-button>
			</div>
		</div>
		<!--category-->
		<Category v-model="categorySelect" :category="category" @select="finishCategory"></Category>
		<Fees v-model="showFees" :data="feesType" @select="finishFees"></Fees>
	</div>
</template>

<script>
	import Protocol from '@/components/protocol'
	import Category from '@/components/category'
	import Fees from '@/pages/service/way_of_fees'
	export default{
		components:{
			Protocol,
			Category,
			Fees
		},
		data(){
			return{
				categorySelect:false,
				category:0,
				categoryType:{},
				message:'',
				checked:false,
				canReservation:false,
				uploadList:[],
				showFees:false,
				feesType:{
					type:{
						id:'',
						name:''
					},
					price:'',
					unit:{
						id:'',
						name:''
					}
				},
				
			}
		},
		methods:{
			onClickLeft(){
				this.$router.back(-1);
			},
			finishCategory(type){
				this.categoryType = type;
				this.category = type.type.id;
			},
			finishFees(type){
				this.feesType = type;
			},
			release(){
				if(this.canReservation){
					
				}
			},
			beforeRead(){
				if(this.uploadList.length >= 8){
					this.$toast('最多上传8张图片')
					return false
				}
				return true
			},
			onRead(file){
				if(file.length){
					file.forEach(item =>{
						if(this.uploadList.length >= 8){
							this.$toast('最多上传8张图片')
							return
						}
						this.uploadList.push(item.content)
					})
				}else{
					this.uploadList.push(file.content)
				}
			},
			deleteImg(index){
				this.uploadList.splice(index, 1); 
			}
		}
	}
</script>
<style lang="less" scoped>
	.releaseService{
		height: 100%;
		background: #f5f5f5;
		position: relative;
		.form{
			padding: .1rem;
		}
		.cell{
			border: none;
			box-shadow: 0px 5px 13px rgba(148,213,237,.2);
			margin-bottom: .2rem;
			background: #fff;
			border-radius: 5px;
			overflow: hidden;
			font-size: .16rem;
			.right{
				display: flex;
				align-items: center;
				height: 100%;
				.gray{
					color: #b2b2b2;
				}
				.red{
					background: #ff3434;
					color: #fff;
					font-size:.14rem;
					padding: 0 .06rem;
					line-height: .24rem;
					border-radius: .05rem;
					margin-left: .1rem;
				}
				.price{
					color: #ff3434;
				}
				.plain{
					border: 1px solid #ff9c0f;
					color: #ff9c0f;
					border-radius: .1rem;
					font-size: .12rem;
					padding: .02rem .05rem;
					margin-left: .1rem;
				}
			}
			.right:after{
				content: '';
				display: block;
				height: .12rem;
				width: .12rem;
				margin-left: .1rem;
				background: url(../../assets/img/right.png) no-repeat;
				background-position: center;
				background-size: auto .12rem;
			}
		}
		.cell.flex{
			display: flex;
			align-items: center;
			justify-content: space-between;
		}
		.cell.category{
			.category_div{
				line-height: .6rem;
				flex: 1;
		    	font-size: .16rem;
		    	color:#757575;
			}
			.category_div.black{
				color: #000;
			}
			.logo,.more{
				width: .2rem;
				height: .2rem;
				overflow: hidden;
				margin: 0 .2rem;
				img{
					height: 100%;
				}
			}
			.more{
				margin: .2rem;
			}
		}
		.cell.photo{
			padding: .2rem;
			color: #757575;
			.upload_box{
				display:flex;
				flex-wrap: wrap;
				.upload_img,.upload_icon{
					width: .8rem;
					height: .8rem;
					margin-top: .1rem;
					margin-right: .1rem;
					position: relative;
					.delete{
						position: absolute;
						right: -.1rem;
						top:-.1rem;
						width:.2rem;
						height:.2rem;
						img{
							width: 100%;
							height: 100%;
						}
					}
					img{
						width: 100%;
						height: 100%;
					}
				}
			}
		}
		.cell.fees{
			line-height:.24rem;
			padding: .2rem;
		}
		.cell.range{
			padding: .2rem;
		}
		.protocol{
			padding: .1rem 0;
			display: flex;
			align-items: center;
			input[type="checkbox"]{
				width: .2rem;
				height: .2rem;
				background: url(../../assets/img/check.png) no-repeat;
				background-position: center;
				background-size: .17rem .17rem;
				-webkit-appearance:none;
				outline: none;
			}
			input[type="checkbox"]:checked{
				background: url(../../assets/img/checked_round.png) no-repeat;
				background-position: center;
				background-size: .17rem .17rem;
			}
		}
		
		.van-button.release{
			margin-top: .1rem;
			background: #b2b2b2;
			color: #fff;
			font-size: .18rem;
		}
		.van-button.release.canReservation{
			background: #18b4ed;
		}
	}

</style>