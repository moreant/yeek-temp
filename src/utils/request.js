import axios from 'axios'
import { Message } from 'element-ui'

const service = axios.create({
  baseURL: 'https://www.yeek.top/api', // url = base url + request url
  // withCredentials: true, // send cookies when cross-domain requests
  timeout: 5000 // request timeout
})

service.interceptors.request.use(
  config => {
    return config
  },
  error => {
    Message({
      message: '请求失败',
      type: 'error',
      duration: 5 * 1000
    })
    console.log(error) // for debug
    return Promise.reject(error)
  }
)

service.interceptors.response.use(
  response => {
    const res = response.data
    if (response.status === 200) {
      return res
    } else {
      Message({
        message: res.message || '错误码:' + response.status,
        type: 'error',
        duration: 5 * 1000
      })
    }
  },
  error => {
    console.log('err' + error) // for debug
    if (error.message === 'Network Error') {
      error.message = '连接超时！'
    }
    Message({
      message: error.message,
      type: 'error',
      duration: 0,
      showClose: true
    })
    return Promise.reject(error)
  }
)

export default service
