import axios, {showError} from '@/libs/api.request'

export const getList = (data) => {
  return new Promise((resolve, reject) => {
    axios.request({
      url: 'category.list',
      method: 'post',
      data
    }).then(rs => {
      if (!rs.data.error) {
        resolve(rs.data.data)
      }
    })
  })
}
