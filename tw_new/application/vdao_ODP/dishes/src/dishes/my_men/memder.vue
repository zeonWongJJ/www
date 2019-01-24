<template>
	<div class="my">
    <div class="body" v-show="loader">
      <van-uploader :after-read="onRead" accept="image/gif, image/jpeg" multiple class="top_img">
        <div class="imgs">
          <img src="../../assets/img/home/toux.jpg"/>
        </div>
        <div class="imgs">
          <div>
            {{$store.state.username}}
          </div>
          <div @click="toDetails">
            本月就餐次数{{meal_times}}餐
          </div>
        </div>
        <img :src="background" class="background">
      </van-uploader>
      <div class="box">
        <ul>
          <li>
            <div style="display: flex; justify-content: center;">

              <div @click="changeMeal(!mealState)" style="margin-right: .1rem;">
                <van-switch size="0.2rem" v-model="mealState" />
              </div>
              暂停/开启用餐
            </div>
          </li>
          <li @click="onStatistics">
            <div>
              <img src="../../assets/img/hom_5.png"/>
            </div>
            <div>
              菜式偏好
            </div>
          </li>
          <li @click="adds">
            <div>
              <img  src="../../assets/img/store_server.png"/>
            </div>
            <div>
              添加菜式
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="loader" v-show="!loader">
      <van-loading />
      <van-loading color="white" />
    </div>
	</div>
</template>

<script>
		export default {
			data(){
				return{
				  loader: false,
				  firstState:'',
				  mealState:0,
          mealSwitch:true,
          mealNum:'',
          background: localStorage.getItem('background') || require('../../assets/img/home/mhqx.jpg'),
          meal_times:'',
				}
			},
      created () {
        this.userInfo();
      },
			methods:{
			  userInfo(){
          this.$fetch('member',
            this.$qs.stringify({
              member_id: this.$store.state.user_id
            })
          ).then(rs => {
            this.mealState = rs.meal_status == 1
            this.meal_times = rs.meal_times
            this.loader = true
          })
        },
        changeMeal(checked){
          this.$fetch('member_meal_status',
            this.$qs.stringify({
              member_id:this.$store.state.user_id,
              meal_status: checked ? 0 : 1
            })
          ).then(rs => {

          }).catch(e =>{
            this.mealState = checked
          })
        },
				adds(){
					this.$router.push({
						path:'/addcai'
					})
				},
        zanyong(){
				  this.$router.push({
            path:'/Statistics'
          })
        },
				onStatistics(){
					this.$router.push({
						path:'/setLikes',
            query:{
						   show_id : 1
            }
					})
				},
        onRead(file){
			    console.log(file)
          this.background = file.content;
          localStorage.setItem('background',file.content)
        },
        toDetails(){
			    this.$router.push({path: '/censusDetails'})
        }
			},
		}
</script>

<style scoped lang='less'>
.my{
  height: 100%;
  width: 100%;
  .loader{
    position: absolute;
    top: 50%;
    left: 50%;
    margin-top: - 50%;
    margin-left: - 50%;
  }
	.body{
    .top_img{
      position: relative;
      display: flex;
      align-items: center;
      height: 1.5rem;
      .background{
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        opacity: 0.6;
      }
      .imgs{
        position: relative;
        z-index: 100;
        margin-left: .2rem;
        font-size: .14rem;
        img{
          border-radius: 50%;
          width: .8rem;
          height: .8rem;
        }
        div{
          font-size: .16rem;
          margin-bottom: .1rem;
          color: #333;
          span{
            color: #333;
          }
        }
      }

    }
    .box{
      ul{
        li{
          display: flex;
          align-items: center;
          height: .44rem;
          padding: 0 .15rem;
          border-bottom: .01rem solid #eee;
          div{
            font-size: .14rem;
            img{
              padding: .05rem 0 0 0;
              width: .22rem;
              height: .22rem;
              margin-right: .1rem;
            }
          }
        }
      }
    }
  }

}


</style>
