<template>
    <section>
      <div>{{message()}}</div>
      <div v-cloak v-text="message"></div>
    </section>
</template>

<script>
  export default {
    name: "test",
    data () {
      return {
        message: ''
      }
    },
    beforeCreate () {
      this.$nextTick(() => {
      })
    },
  }
</script>

<style scoped>
[v-cloak] {
  display: none !important;
}
</style>
