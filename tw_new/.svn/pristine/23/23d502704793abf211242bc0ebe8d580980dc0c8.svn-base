import Main from '@/components/main'

/**
 * iview-admin中meta除了原生参数外可配置的参数:
 * meta: {
 *  title: { String|Number|Function }
 *         显示在侧边栏、面包屑和标签栏的文字
 *         使用'{{ 多语言字段 }}'形式结合多语言使用，例子看多语言的路由配置;
 *         可以传入一个回调函数，参数是当前路由对象，例子看动态路由和带参路由
 *  hideInBread: (false) 设为true后此级路由将不会出现在面包屑中，示例看QQ群路由配置
 *  hideInMenu: (false) 设为true后在左侧菜单不会显示该页面选项
 *  notCache: (false) 设为true后页面在切换标签后不会缓存，如果需要缓存，无需设置这个字段，而且需要设置页面组件name属性和路由配置的name一致
 *  access: (null) 可访问该页面的权限数组，当前路由设置的权限会影响子路由
 *  icon: (-) 该页面在左侧菜单、面包屑和标签导航处显示的图标，如果是自定义图标，需要在图标名称前加下划线'_'
 *  beforeCloseName: (-) 设置该字段，则在关闭当前tab页时会去'@/router/before-close.js'里寻找该字段名对应的方法，作为关闭前的钩子函数
 * }
 */
export default [
  {
    path: '/login',
    name: 'login',
    meta: {
      title: 'Login - 登录',
      hideInMenu: true
    },
    component: () => import('@/view/login/login.vue')
  },
  {
    path: '/',
    name: '_home',
    meta: {
      title: '首页',
      hideInMenu: true
    },
    // redirect: '/home',
    component: Main
  },
  {
    path: '/order',
    name: 'order',
    meta: {
      title: '交易管理',
      icon: 'logo-buffer'
    },
    component: Main,
    children: [
      {
        path: 'ordered',
        name: 'orderedIndex',
        meta: {
          title: '预约管理',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/order/ordered.vue')
      },
      {
        path: 'list',
        name: 'orderList',
        meta: {
          title: '订单列表',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/order/list.vue')
      },
      {
        path: 'orderGenerate',
        name: 'orderGenerate',
        meta: {
          title: '订单生成',
          icon: 'logo-buffer',
          hideInMenu: true
        },
        component: () => import('@/view/order/orderGenerate.vue')
      }
    ]
  },
  {
    path: '/services',
    name: 'services',
    redirect: '/services/index',
    meta: {
      title: '服务管理',
      icon: 'logo-buffer'
    },
    component: Main,
    children: [
      {
        path: 'index',
        name: 'servicesIndex',
        meta: {
          title: '服务列表',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/service/index.vue')
      },
      {
        path: 'insert',
        name: 'serviceInsert',
        meta: {
          title: '发布服务',
          icon: 'logo-buffer',
          hideInMenu: true
        },
        component: () => import('@/view/service/insert.vue')
      },
      {
        path: 'update',
        name: 'serviceUpdate',
        meta: {
          title: '修改服务',
          icon: 'logo-buffer',
          hideInMenu: true
        },
        component: () => import('@/view/service/update.vue')
      },
      {
        path: 'chargeStrategy',
        name: 'chargeStrategy',
        meta: {
          title: '修改服务',
          icon: 'logo-buffer',
          hideInMenu: true
        },
        component: () => import('@/view/service/chargeStrategy.vue')
      },
      {
        path: 'category',
        name: 'categoriesIndex',
        meta: {
          title: '分类管理',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/category/index.vue')
      },
      {
        path: 'comment',
        name: 'commentsIndex',
        meta: {
          title: '用户评价',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/comment/list.vue')
      },
      {
        path: 'trash',
        name: 'serviceTrash',
        meta: {
          title: '服务回收站',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/category/index.vue')
      }
    ]
  },
  {
    path: '/auth',
    name: 'auth',
    redirect: '/auth/index',
    meta: {
      title: '权限管理',
      icon: 'logo-buffer'
    },
    component: Main,
    children: [
      {
        path: 'index',
        name: 'authIndex',
        meta: {
          title: '角色管理',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/auth/index.vue')
      },
      {
        path: 'ruleList',
        name: 'ruleIndex',
        meta: {
          title: '权限管理',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/auth/ruleIndex.vue')
      },
      {
        path: 'adminList',
        name: 'adminIndex',
        meta: {
          title: '管理员列表',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/setting/adminList.vue')
      },
      {
        path: 'adminLog',
        name: 'adminLog',
        meta: {
          title: '管理员日志',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/setting/adminLog.vue')
      }
    ]
  },
  {
    path: '/report',
    name: 'reportForm',
    meta: {
      title: '报表管理',
      icon: 'logo-buffer'
    },
    component: Main,
    children: [
      {
        path: 'flow',
        name: 'flowStats',
        meta: {
          title: '流量分析',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/service/insert.vue')
      },
      {
        path: 'guest',
        name: 'guestStats',
        meta: {
          title: '客户分析',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/service/insert.vue')
      },
      {
        path: 'order',
        name: 'orderStats',
        meta: {
          title: '订单统计',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/service/insert.vue')
      },
      {
        path: 'sale',
        name: 'saleStats',
        meta: {
          title: '销售概况',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/service/insert.vue')
      }
    ]
  },
  {
    path: '/app',
    name: 'app',
    meta: {
      title: '移动端管理',
      icon: 'logo-buffer'
    },
    component: Main,
    children: [
      {
        path: 'slide',
        name: 'slideList',
        meta: {
          title: '轮播管理',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/broadcast/index.vue')
      },
      {
        path: 'leancloud',
        name: 'leancloud',
        meta: {
          title: '推送管理',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/service/insert.vue')
      }
    ]
  },
  {
    path: '/settings',
    name: 'settings',
    meta: {
      title: '设置管理',
      icon: 'logo-buffer'
    },
    component: Main,
    children: [
      {
        path: 'message_template',
        name: 'MessageTemplate',
        meta: {
          title: '短信模板设置',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/setting/MessageTemplate')
      },
      {
        path: 'config',
        name: 'configList',
        meta: {
          title: '系统参数设置',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/setting/configList')
      }
    ]
  },
  {
    path: '/store',
    name: 'store',
    component: Main,
    meta: {
      title: '店铺管理',
      icon: 'logo-buffer'
    },
    children: [
      {
        path: 'list',
        name: 'storeList',
        meta: {
          title: '店铺列表',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/store/storeList')
      },
      {
        path: 'staff',
        name: 'staffList',
        meta: {
          title: '店员管理',
          icon: 'logo-buffer',
          hideInMenu: true
        },
        component: () => import('@/view/store/staffList')
      }
    ]
  },
  {
    path: '/demand',
    name: 'demand',
    component: Main,
    children: [
      {
        path: 'getList',
        name: 'list',
        meta: {
          title: '审核管理',
          icon: 'logo-buffer'
        },
        component: () => import('@/view/demand/demandList')
      }
    ]
  }
]
