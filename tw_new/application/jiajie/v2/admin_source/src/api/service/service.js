import axios, {showError} from '@/libs/api.request'

export const getList = () => {
  return new Promise((resolve, reject) => {
    axios.request({
      url: 'service.list',
      method: 'post'
    }).then(rs => {
      if (!rs.data.error) {
        resolve(rs.data)
      }
    })
  })
}

export const insert = async (data) => {
  const result = await axios.request({
    url: 'service.add',
    method: 'post',
    data
  })
  console.log(result)
}
