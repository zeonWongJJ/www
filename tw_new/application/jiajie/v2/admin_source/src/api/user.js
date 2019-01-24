import axios, {showError} from '@/libs/api.request'
import {Message} from 'iview'

export const login = ({userName, password}) => {
  const data = {
    username: userName,
    password
  }
  return new Promise((resolve, reject) => {
    axios.request({
      url: 'user.login',
      data,
      method: 'post'
    }).then(rs => {
      if (!rs.data.error) {
        Message.success('登录成功!')
        return resolve(rs.data.data.token)
      }
      showError(rs)
      return reject(rs)
    })
  })
}
