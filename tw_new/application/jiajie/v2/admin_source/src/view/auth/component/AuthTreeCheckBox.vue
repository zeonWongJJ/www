<template>
  <section>
    <Tree :data="authList" show-checkbox ref="tree"></Tree>
  </section>
</template>

<script>
export default {
  name: 'AuthTreeCheckBox',
  computed: {
    roleId () {
      return this.$store.state.auth.roleId || 0
    }
  },
  data () {
    return {
      authList: []
    }
  },
  watch: {
    roleId (n, o) {
      if (n) {
        this.$http(`auth.role.assigned-${n}`).then(rs => {
          this.authList = rs.data
        })
      }
    }
  }
}
</script>

<style scoped>
.block {
  display: block;
}
</style>
