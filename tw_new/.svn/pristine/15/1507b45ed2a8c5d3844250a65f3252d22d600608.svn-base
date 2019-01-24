<template>
	<div class="cai">
		<van-nav-bar title="添加菜式" left-arrow @click-left="onClickLeft">
		</van-nav-bar>
		<div class="box">
			<van-cell-group>
        <van-field placeholder="输入菜式" label="添加菜式" left-icon="points" v-model="foodname" />
      </van-cell-group>
      <div class="bottons">
        <van-button size="large" round @click="search" style="background: #18b4ed;color:#fff;margin-top: .2rem">确认添加</van-button>
      </div>
		</div>

	</div>
</template>

<script>
	export default {
		data() {
			return {
        foodname: ''
			}
		},
		mounted() {

		},
		methods: {
			onClickLeft() {
				this.$router.push({
					path:'/dishes_memder'
				})
			},
      search () {
			  if (this.foodname != '') {

          this.$fetch('food_select',require('qs').stringify({dish_name: this.foodname})).then(rs => {
            if (rs.list && rs.list.length > 0) {
              let data = '';
              rs.list.forEach((item, index) => {
                if (index == 0) {
                  data += item.dish_name
                } else {
                  data += ',' + item.dish_name
                }
              })
              this.$dialog.confirm({
                message: '您添加的“' + this.foodname + '”与现有的“' + data + '”可能是同一道菜，确认要继续添加吗？'
              }).then(() => {
                this.add(this.foodname)
              }).catch(() => {
                // on cancel
              });
            } else {
              this.add(this.foodname)
            }
          })


        }
      },
      add (foodname) {
        let req = {};
        req.member_id = this.$store.state.user_id;
        req.dish_name = foodname;
        this.$fetch('food_cuisine',require('qs').stringify(req)).then(rs => {
          this.foodname = '';
          this.$toast('添加成功')
        })
      }
		},
	}
</script>

<style scoped lang="less">
.cai{
	.box{
		padding: 0 0.12rem;
		margin-top: .1rem;

		.bottons{
			margin-top: .2rem;
		}
	}
}

</style>
