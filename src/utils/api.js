import request from './request'

export function works () {
  return request({
    url: '/works.php'
  })
}

export function files (dir) {
  return request({
    url: '/files.php',
    params: { dir }
  })
}
