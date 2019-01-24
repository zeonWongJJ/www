export default {
  state: {
    orderSN: '',
    comment: {
      comment_content: '', // 评论内容
      comment_img_urls: [], // 评论图片
      attitude_star: 5, // 服务态度星级
      time_efficiency_star: 5, // 时间效率星级
      skill_star: 5, // 技能星级
      comment_type_star: 1, // 评价类型 1好评 2中评 3差评
    }
  },
  mutations: {
    SET_ORDER_SN (state, orderSN) {
      state.orderSN = orderSN
    },
    SET_COMMENT (state, comment) {
      Object.keys(state.comment).forEach(key => {
        state.comment[key] = comment[key] || ''
      })
    }
  }
}
