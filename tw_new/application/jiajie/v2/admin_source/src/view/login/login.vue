<template>
  <div class="login">
    <div class="login-con">
      <Card icon="log-in" title="欢迎登录" :bordered="false">
        <div class="form-con">
          <login-form @on-success-valid="handleSubmit" :isLoading="isLoading"></login-form>
          <p class="login-tip">这里是登录提示</p>
        </div>
      </Card>
    </div>
  </div>
</template>

<script>
import LoginForm from '@/components/login-form'
import { mapActions } from 'vuex'
export default {
  data () {
    return {
      isLoading: false
    }
  },
  components: {
    LoginForm
  },
  methods: {
    ...mapActions([
      'handleLogin'
    ]),
    handleSubmit ({userName, password}) {
      this.isLoading = true
      this.handleLogin({userName, password}).then(rs => {
        this.isLoading = false
        this.$router.push({name: '_home'})
      }).catch(e => {
        this.isLoading = false
      })
    }
  }
}
</script>

<style lang="less">
@import './login.less';
</style>
