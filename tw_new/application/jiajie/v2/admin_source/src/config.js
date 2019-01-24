export default {
  cookieExpires: 1,
  useI18n: false,
  baseUrl: window.config.api_prefix || 'http://jiajie-serve_v2.7dugo.com',
  homeName: 'home',
  plugin: {
    'error-store': {
      showInHeader: true,
      developmentOff: true
    }
  }
}
