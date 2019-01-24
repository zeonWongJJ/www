import {hasOneOf, forEach} from './tools'

/**
 * 判断对象是否有子对象
 * @param item
 * @returns {*|boolean}
 */
export const hasChild = (item) => {
  return item.children && item.children.length !== 0
}

/**
 * 判断是否显示菜单对象
 * @param item
 * @param access
 * @returns {boolean}
 */
export const showThisMenuEle = (item, access) => {
  if (item.meta && item.meta.access && item.meta.access.length) {
    return !!hasOneOf(item.meta.access, access)
  }
  return true
}

/**
 * @param item
 * @param vm
 * @returns {*}
 */
export const showTitle = (item, vm) => {
  let title = item.meta.title
  if (!title) return
  if (vm.$config.useI18n) {
    if (title.includes('{{') && title.includes('}}') && vm.$config.useI18n) title = title.replace(/({{[\s\S]+?}})/, (m, str) => str.replace(/{{([\s\S]*)}}/, (m, _) => vm.$t(_.trim())))
    else title = vm.$t(item.name)
  } else title = (item.meta && item.meta.title) || item.name
  return title
}

/**
 * 通过路由列表获取菜单列表
 * @param list
 * @param access
 * @returns {Array}
 */
export const getMenuByRouter = (list, access) => {
  let res = []
  forEach(list, item => {
    if (!item.meta || (item.meta && !item.meta.hideInMenu)) {
      let obj = {
        icon: (item.meta && item.meta.icon) || '',
        name: item.name,
        meta: item.meta
      }

      if ((hasChild(item) || (item.meta && item.meta.showAlways)) && showThisMenuEle(item, access)) {
        obj.children = getMenuByRouter(item.children, access)
      }
      if (item.meta && item.meta.href) obj.href = item.meta.href
      if (showThisMenuEle(item, access)) res.push(obj)
    }
  })
  return res
}

export const localRead = (key) => {
  return localStorage.getItem(key) || ''
}

export const findKey = (obj,value, compare = (a, b) => a === b) => {
  return Object.keys(obj).find(k => compare(obj[k], value))
}
