import { getCookieValue } from './util'

window.axios = require('axios')

// Ajaxリクエストであることを示すヘッダーを付与する
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

window.axios.interceptors.request.use(config => {
    // クッキーからトークンを取り出してヘッダーに添付する
    config.headers['X-CSRF-TOKEN'] = getCookieValue('XSRF-TOKEN')

    return config
})