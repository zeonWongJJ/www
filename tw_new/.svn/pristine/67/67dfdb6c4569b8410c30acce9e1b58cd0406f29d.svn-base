import axios, {showError} from '@/libs/api.request'

export const insert = (data, serviceId) => {
  return new Promise((resolve, reject) => {
    axios.request({
      url: `service.item.add-${serviceId}`,
      method: 'post',
      data
    }).then(rs => {
      if (!rs.data.error) {
        resolve(rs.data)
      }
    })
  })
}
