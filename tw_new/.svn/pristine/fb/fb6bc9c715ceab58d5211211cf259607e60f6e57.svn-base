<template>
	<div class="periodicReservation">
		<van-popup class="body" v-model="show" position="bottom" :close-on-click-overlay="false">
			<div class="close">
				<img @click="close" src="../assets/img/close_white.png"/>
			</div>
			<div class="center">
				<div class="setLong">
					<div class="label">服务时长</div>
					<div class="btn">
						<div class="left" @click="setLong(0)">-</div>
						<div class="middle">{{defaultLong}}小时</div>
						<div class="right" @click="setLong(1)">+</div>
					</div>
				</div>
				<div class="time">
					<div class="title">请选择每周服务时间段</div>
					<div class="label">
						<div class="li" :class="{checked : defaultWeek == item.type}" v-for="item in week" @click="selectWeek(item.type)">{{item.name}}</div>
					</div>
					<div class="arr">
						<!--
							{nochecked : getGray(index)}
							
						-->
						<div class="li"
							:class="[{checked : checked && periodicData[defaultWeek] && periodicData[defaultWeek].order.indexOf(item[0]) >= 0},
							{nochecked : getGray(index)}]"
							v-for="(item,index) in arr" @click="selectTime(item[0],index)">{{getH(item[0])}}~{{getH(item[1])}}</div>
						<!--为了最后一行能左对齐-->
						<div class="li" style="height: 0px;visibility: hidden;"></div>
						<div class="li" style="height: 0px;visibility: hidden;"></div>
						<div class="li" style="height: 0px;visibility: hidden;"></div>
						<div class="li" style="height: 0px;visibility: hidden;"></div>
						<!--为了最后一行能左对齐-->
					</div>
				</div>
				<div class="cycle">
					<div class="title">服务周期</div>
					<div class="label">
						<span :class="{check:cycleLong == 4}" @click="cycleLong = 5">1个月</span>
						<span :class="{check:cycleLong == 12}" @click="cycleLong = 13">3个月</span>
						<span :class="{check:cycleLong == 24}" @click="cycleLong = 26">半年</span>
						<span :class="{check:cycleLong == 48}" @click="cycleLong = 52">1年</span>
						<div class="btn">
							<div class="left" @click="setCycle(0)">-</div>
							<div class="middle">{{cycleLong}}星期</div>
							<div class="right" @click="setCycle(1)">+</div>
						</div>
					</div>
				</div>
				<div class="tip">
					<div v-if="periodicData[1]">
						<div class="li" v-for="item in periodicData[1].order">每周一 {{getH(item)}}~{{getH(item + periodicData[1].long * 60)}}</div>
					</div>
					<div v-if="periodicData[2]">
						<div class="li" v-for="item in periodicData[2].order">每周二 {{getH(item)}}~{{getH(item + periodicData[2].long * 60)}}</div>
					</div>
					<div v-if="periodicData[3]">
						<div class="li" v-for="item in periodicData[3].order">每周三 {{getH(item)}}~{{getH(item + periodicData[3].long * 60)}}</div>
					</div>
					<div v-if="periodicData[4]">
						<div class="li" v-for="item in periodicData[4].order">每周四 {{getH(item)}}~{{getH(item + periodicData[4].long * 60)}}</div>
					</div>
					<div v-if="periodicData[5]">
						<div class="li" v-for="item in periodicData[5].order">每周五 {{getH(item)}}~{{getH(item + periodicData[5].long * 60)}}</div>
					</div>
					<div v-if="periodicData[6]">
						<div class="li" v-for="item in periodicData[6].order">每周六 {{getH(item)}}~{{getH(item + periodicData[6].long * 60)}}</div>
					</div>
					<div v-if="periodicData[0]">
						<div class="li" v-for="item in periodicData[0].order">每周日 {{getH(item)}}~{{getH(item + periodicData[0].long * 60)}}</div>
					</div>
				</div>
				<div class="startTime" @click="selectStart = true">
					<div class="left" v-if="!startTime">请选择开始时间</div>
					<div class="left" v-else>开始时间{{formatTime(startTime,1)}}</div>
					<div class="right"></div>
				</div>
			</div>
			<van-button  size="large" class="blue" @click="finish">确认选择</van-button>
			
		</van-popup>
		
		<van-dialog class="selectStart" v-model="selectStart" title="首次服务时间" confirmButtonText="关闭">
			<div class="ul">
				<div class="li" v-for="item in allStartTime" @click="selectStart = false;startTime = item">
					<div class="left">{{formatTime(item,1)}}({{getDay(item)}})</div>
					<input :checked="startTime == item" type="checkbox" />
				</div>
			</div>
		</van-dialog>
	</div>
</template>

<script>
	export default{
		props:{
			value:{
				type:Boolean,
				default:false
			},
			businessTime:{
				type:Array,
				default:()=>['08:00','20:30']
			}
		},
		data(){
			return{
				defaultLong:1,
				cycleLong:1,
				show:false,
				arr:[],
				week:[
					{
						type:'1',
						name:'周一'
					},
					{
						type:'2',
						name:'周二'
					},
					{
						type:'3',
						name:'周三'
					},
					{
						type:'4',
						name:'周四'
					},
					{
						type:'5',
						name:'周五'
					},
					{
						type:'6',
						name:'周六'
					},
					{
						type:'0',
						name:'周日'
					},
				],
				defaultWeek:'1',
				periodicData:{},
				checked:0,//无意义，用来刷新dom
				startDay:'',
				allStartTime:[],
				allOrder:{},
				startTime:'',
				selectStart:false,
			}
		},
		watch:{
			value:function(val){
				this.show = val;
			},
			defaultLong:function(val){
				this.setArr();
			},
			startTime:function(val){
				if(val){
					this.getOrder();
				}
			},
			cycleLong:function(val){
				this.getOrder();
			}
			
			
		},
		mounted(){
			this.setArr();
		},
		methods:{
			getGray(index){
				let gray = false;
				if(this.periodicData[this.defaultWeek]){
					let arr = this.periodicData[this.defaultWeek].order;
					let grayIndex = this.defaultLong * 2 - 1;
					arr.forEach(item =>{
						//this.defaultLong*2-1
						let itemIndex = (item - 480)/30;
						if(index > itemIndex && index <= itemIndex + grayIndex || index < itemIndex && index >= itemIndex - grayIndex){
							gray = true
						}
					})
				}
				return gray
			},
			setArr(){
				this.arr = [];;
				let startTimeH = Number(this.businessTime[0].split(":")[0]);
				let startTimeM = Number(this.businessTime[0].split(":")[1]);
				let endTimeH = Number(this.businessTime[1].split(":")[0]);
				let endTimeM = Number(this.businessTime[1].split(":")[1]);
				let startTime = startTimeH * 60 + startTimeM;
				let endTime = endTimeH * 60 + endTimeM;
				let defaultM = this.defaultLong * 60;
				let end = (endTime - startTime) / 30;
				let add = (endTime - startTime) % 30;//!(end == parseInt(end));
				add ? end = parseInt(end)+1 : end
				let start = startTime;
				for(let i=1;i<=end;i++){
					let addTime = start + defaultM;
					if(addTime <= endTime){
						let arr2 = []
						arr2.push(start,addTime)
						this.arr.push(arr2)
						start += 30;
					}
				}
			},
			getH(str){
				let add = str % 60;
				let h = parseInt(str / 60);
				let m = 0;
				if(add){
					m = str - h * 60
				}
				return this.add0(h) + ':' + this.add0(m)
			},
			getDay(time){
				let data = new Date(time)
				if(data){
					let day = data.getDay();
					let cnDay = '';
					switch (day){
						case 0 :
							cnDay = '周日';
							break;
						case 1 :
							cnDay = '周一';
							break;
						case 2 :
							cnDay = '周二';
							break;
						case 3 :
							cnDay = '周三';
							break;
						case 4 :
							cnDay = '周四';
							break;
						case 5:
							cnDay = '周五';
							break;
						case 6 :
							cnDay = '周六';
							break;
					}
					return cnDay
				}else{
					console.log('时间格式有误：' + time);
		          	return ''
				}
			},
			//转换时间
	      	formatTime(time,day) {
		        let data = new Date(time)
		        if (data) {
		          	let year = data.getFullYear();
		         	let month = this.add0(data.getMonth() + 1);
		          	let day = this.add0(data.getDate());
		          	let hour = this.add0(data.getHours());
		          	let minute = this.add0(data.getMinutes());
		          	if(day){
		          		return year + '-' + month + '-' + day
		          	}else{
		          		return year + '-' + month + '-' + day + '-' + hour + ':' + minute
		          	}
	        	} else {
		         	console.log('时间格式有误：' + time);
		          	return ''
		        }
	      	},
		    add0(time) {
		        var time = Number(time);
		        if (time < 10) {
		            time = '0' + time
		        }
		        return time
		    },
			setLong(type){//设置服务时长
				if(this.periodicData[this.defaultWeek]){
					this.$dialog.confirm({
				      	message: '已选择' + this.defaultLong + '服务时长，是否重新选择'
				    }).then(() => {
				    	this.checked = 1;
					  	delete this.periodicData[this.defaultWeek];
					}).catch(() => {
					  	// on cancel
					});
				}else{
					if(type){
						this.defaultLong += 0.5;
					}else{
						this.defaultLong -= 0.5;
					}
					if(this.defaultLong < 1){this.defaultLong = 1}
					if(this.defaultLong > 6){this.defaultLong = 6}
				}
			},
			setCycle(type){//设置服务周期
				if(type){
					this.cycleLong++
				}else{
					this.cycleLong--
				}
				if(this.cycleLong < 1){this.cycleLong = 1}
			},
			close(){//关闭组件
				this.$emit('input',false)
			},
			selectWeek(type){
				this.defaultWeek = type;
				if(this.periodicData[type]){
					this.defaultLong = this.periodicData[type].long;
				}
			},
			selectTime(time,index){//添加服务时间
				if(!this.getGray(index)){
					//重新编辑了服务时间需要重新计算可首次服务时间
					if(this.startTime){
						this.$dialog.confirm({
					      	message: '已选择首次服务时间，是否要重新选择'
					  	}).then(() => {
							this.startTime = '';
						}).catch(() => {
							
						});
					}else{
						this.checked++;//没啥意义，为了刷新dom
					
						if(this.periodicData[this.defaultWeek] && this.defaultLong == this.periodicData[this.defaultWeek].long){
							let had = false;
							let arr = this.periodicData[this.defaultWeek].order
							arr.forEach(item =>{
								if(item == time){
									had = true
								}
							})
							if(had){//以选择，删除
								let index = arr.indexOf(time);
								arr.splice(index, 1);
								if(arr.length == 0){
									delete this.periodicData[this.defaultWeek];
								}
							}else{//添加
								arr.push(time);
							}
						}else{//啥都没，直接添加
							this.periodicData[this.defaultWeek] = {};
							this.periodicData[this.defaultWeek].long = this.defaultLong;
							this.periodicData[this.defaultWeek].order = [];
							this.periodicData[this.defaultWeek].order.push(time);
						}
						
						//每次添加服务时间都去计算可首次服务时间
						this.getStartTime();
					}
				}
			},
			getStartTime(){
				let now = new Date();
				let year = now.getFullYear();
	          	let month = this.add0(now.getMonth() + 1);
	          	let day = this.add0(now.getDate());
	          	let nowDate = new Date(year+'/'+month+'/'+day);
	          	//最小开始时间为当天+2
	          	let minDate = new Date(nowDate.getTime() + 48 * 3600 * 1000);
	          	let minDay = minDate.getDay();
	          	let arr = Object.keys(this.periodicData);
	          	let index = 0;
	          	let startDay = 0;
	          	//从最小开始时间找可开始时间
          		for(var i=0;i<6;i++){
          			let min = minDay + i > 6 ? minDay + i -7 : minDay + i;
	          		if(arr.indexOf(min.toString()) >= 0){
	          			index = i;
	          			startDay = min;
	          			break;
	          		}
	          	}
          		let startDate = new Date(minDate.getTime() + index * 24 * 3600 * 1000);
          		//找到可开始时间，计算所有可开始时间，上限暂时为一星期
          		let allStartTime = [];
//        		
          		for(var i=0;i<7;i++){
          			let j = startDay + i > 6 ? startDay + i -7 : startDay + i;
					if(this.periodicData[j.toString()]){
						let time = new Date(startDate.getTime() + i * 24 * 3600 * 1000);
						allStartTime.push(time);
					}
				}
          		this.allStartTime = allStartTime;
			},
			getOrder(){
				if(this.startTime){
					let startDay = new Date(this.startTime).getDay();
					let allOrder = [];
					let reqOrder = {};
					let cycleLong = this.cycleLong * 7;
					for(var i=0;i<cycleLong;i++){
	          			let j = startDay + i > 6 ? (startDay + i) % 7 : startDay + i;
						if(this.periodicData[j.toString()]){
							let order = this.periodicData[j.toString()].order.sort(sortNumber);
							order.forEach(item =>{
								let time = new Date(this.startTime.getTime() + i * 24 * 3600 * 1000 + item * 60 * 1000)
								allOrder.push({time:time,long:this.periodicData[j.toString()].long})
								if(reqOrder[j.toString()]){
									if(reqOrder[j.toString()].order){
										reqOrder[j.toString()].order.push(time);
									}else{
										reqOrder[j.toString()].order = [];
										reqOrder[j.toString()].order.push(time);
									}
								}else{
									reqOrder[j.toString()] = {};
									reqOrder[j.toString()].order = [];
									reqOrder[j.toString()].order.push(time);
								}
							})
						}
					}
					Object.keys(this.periodicData).forEach(key =>{
						reqOrder[key].long = this.periodicData[key].long
					})
					this.allOrder.resOrder = allOrder;
					this.allOrder.order = reqOrder;
					this.allOrder.cycleLong = this.cycleLong;
					this.allOrder.startTime = this.startTime;
				}
			},
			finish(){
				if(Object.keys(this.allStartTime).length && !this.startTime){
					this.selectStart = true;
				}else{
					this.$emit('input',false);
					this.$emit('finish',this.allOrder);
				}
			}
		}
	}
	function sortNumber(a,b){
		return a - b
	}
</script>

<style lang="less"  scoped>
	@import "./periodcReservation.less";
</style>