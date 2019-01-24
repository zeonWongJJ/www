<template>
<div>
	<div class="a">
		<!--<input type="text" name="" id="" value=""  />
		<input type="button" id="" value="按钮"  @click="aaw"/>-->
		  <button @click="increment">+</button>
        <button @click="decrement">-</button>
        <p><span>{{num}}</span></p>
	</div>
	
</div>
</template>

<script>
		export default {
			 props: ["num"],
		data() {
			return {
				aa:'',
				num: 0
			}
		},

		methods: {
		aaw(){
			this.$emit('ahader','aaaaaaa');
		},
  increment(){
                this.$emit('incre');
            },
            decrement(){
                this.$emit('decre');
            }
		}
	}
</script>

<style scoped>
</style>