<template>
  <div class="side-menu-wrapper">
    <slot></slot>
    <Menu width="auto" :theme="theme" @on-select="handleSelect">
      <template v-for="item in menuList">
        <template v-if="item.children && item.children.length === 1">
          <side-menu-item v-if="showChildren(item)" :key="`menu-${item.name}`" :parent-item="item"></side-menu-item>
          <menu-item v-else :name="getNameOrHref(item, true)" :key="`menu-${item.children[0].name}`">
            <common-icon :type="item.children[0].icon || ''"/>
            <span>{{ showTitle(item.children[0]) }}</span></menu-item>
        </template>
        <template v-else>
          <side-menu-item v-if="showChildren(item)" :key="`menu-${item.name}`" :parent-item="item"></side-menu-item>
          <menu-item v-else :name="getNameOrHref(item)" :key="`menu-${item.name}`">
            <common-icon :type="item.icon || ''"/>
            <span>{{ showTitle(item) }}</span></menu-item>
        </template>
      </template>
    </Menu>
  </div>
</template>

<script>
import SideMenuItem from './side-menu-item.vue'
import mixin from './mixin'

export default {
  name: 'SideMenu',
  mixins: [mixin],
  components: {
    SideMenuItem
  },
  data () {
    return {
      theme: 'dark'
    }
  },
  props: {
    menuList: {
      type: Array,
      default () {
        return []
      }
    }
  },
  methods: {
    handleSelect (name) {
      this.$emit('on-select', name)
    }
  }
}
</script>

<style lang="less">
  @import './side-menu.less';
</style>
