import HttpRequest from '@/libs/axios'
import config from '@/config.js'
import { Message } from 'iview'

const baseURL = config.baseUrl

const axios = new HttpRequest(baseURL)
export default axios

export const showError = rs => {
  const msg = rs.data.msg
  msg.forEach(e => {
    Message.info(e)
  })
}
