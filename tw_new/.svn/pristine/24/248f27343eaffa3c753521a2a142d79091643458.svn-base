<template>
	<div class="informadton">
		<div>
			<van-nav-bar title="通知消息" left-arrow @click-left="onClickLeft" />
		</div>
		<div class="box">
			<div class="inform margins" v-for="(list,index) in list">
				<div class="inform_img">
					<img src="../../assets/img/fastReservation/reservationSuccess.png" />
				</div>
				<div class="inform_text">
					<div class="inform_text_top">
						<div class="inform_text_top_title  span_po">
							通知
							<span :class="{unread : unread(list.id)}"></span>
						</div>
						<div class="inform_text_top_deta">
							{{getTime(list.message_post_at)}}
						</div>
					</div>
					<div class="inform_new">
						<!--<h4>审核提醒</h4>-->
						{{list.message_content}}
					</div>
				</div>
			</div>
			<!--////其他的-->
			<div class="box_inform">

			</div>
		</div>
	</div>
</template>


<script>
	import api from '@/api/api'
    import utils from '@/utils/utils'
	export default {
		data() {
			return {
				list : [],
			};
		},
		mounted() {
			//console.log(this.$store.state.token)
			this.init();
//			localStorage.clear();
			//console.log(JSON.parse(localStorage.getItem("msg")))
		},
		methods: {
			onClickLeft() {
				this.$router.push({
					path: '/mymess'
				})
			},
			init() {
			    this.$store.commit('SET_UNREAD_MESSAGE', 0)
				let that = this;
				that.$fetch('message_list', {})
				.then(rs => {
					that.list = rs
				})
				// 极光推送，把未读消息变成0
                const json={"unReadCount":"0"}
                if (utils.is_android()) {
                    android.unReadMessageCount(JSON.stringify(json));
                }
                // IOS app
                if (utils.is_ios()) {
                    window.webkit.messageHandlers.unReadMessageCount.postMessage(json);
                }
			},
			unread(id){
				let oldVal = localStorage.getItem("msg");
				if(oldVal){
					var arr = JSON.parse(oldVal).concat();
					arr.indexOf(id) === -1 ? arr.push(id) : 0;
					localStorage.setItem('msg', JSON.stringify(arr))
					return arr.indexOf(id) === -1 ? 1 : 0;
				}else{
					var arr = [];
					arr.push(id)
					localStorage.setItem('msg', JSON.stringify(arr))
					return 1
				}
			},
			getTime(time){
				//js内的时间戳指的是当前时间到1970年1月1日00:00:00 UTC对应的毫秒数，和unix时间戳不是一个概念，后者表示秒数，差了1000倍
				//new Date(timestamp)中的时间戳必须是number格式，string会返回Invalid Date。所以比如new Date('11111111')这种写法是错的
				time = Number(time)*1000;
				var date = new Date(time);
				if(date){
					var Y,M,D,h,m,s;
					Y = date.getFullYear() + '-';
					M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
					D = date.getDate() + ' ';
					h = date.getHours() + ':';
					m = date.getMinutes() + ':';
					s = date.getSeconds();

					//与当前日期对比
					var now = new Date();
					if(now.getFullYear() == date.getFullYear()){
						if(now.getMonth() == date.getMonth() && now.getDate() == date.getDate()){
							return (h+m+s)
						}else{
							return (M+D+h+m+s)
						}
					}else{
						return (Y+M+D+h+m+s)
					}

				}else{
					console.log('时间格式有误----:'+time);
				}

			}
		}
	}
</script>
<style scoped>
	.informadton {
		background: #F5F5F5;
	}

	.box {
		position: absolute;
		top: .46rem;
		left: 0;
		right: 0;
		bottom: 0;
		overflow: auto;
		height: calc(100% - 0.46rem);
		background: #F5F5F5;
	}

	.inform {
		display: flex;
		padding: 0.1rem .12rem;
	}

	.inform_img {
		flex: 0 0 .65rem
	}

	.span_po {
		position: relative;
	}

	/*.inform_text_top_title>span {
		margin-left: .03rem;
		position: absolute;
		color: #fff;
		width: 0.08rem;
		height: .08rem;
		background: #18b4ed;
		border-radius: 50%;
	}*/
	 .unread:after{
		content: '';
		background: red;
		display: inline-block;
		width:.06rem;
		height: .06rem;
		border-radius: 50%;
		position: absolute;
		right: .15rem;
		top: .15rem;
	}
	.inform_img img {
		width: .4rem;
	}

	.inform_text {
		flex: 0 0 2.8rem;
	}

	.inform_text_top {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: .15rem;
	}

	.inform_text_top_title {
		flex: 0 0 1.85rem;
		font-size: .16rem;
		font-weight: 700;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}

	.inform_text_top_deta {
		font-size: .12rem;
		color: #666666;
	}

	.inform_new {
		border-radius: .05rem;
		font-size: .12rem;
		color: #666666;
		background: #fff;
		line-height: .2rem;
		padding: .12rem 0.1rem;
	}

	.inform_new h4 {
		margin: 0 0 0.05rem 0;
		padding: 0 0;
		font-size: .18rem;
	}

	.margins {
		margin: 0.1rem 0;
	}

	.inform_border {
		border-bottom: .01rem solid #eee;
	}
</style>
