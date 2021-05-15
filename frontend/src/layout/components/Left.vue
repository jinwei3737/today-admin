<template>
  <el-menu
      :uniqueOpened="true"
      :router="true"
      :collapse="false"
      default-active=""
      class="el-menu-vertical menu"
      background-color="#545c64"
      text-color="#fff"
      active-text-color="#ffd04b"
  >
    <template v-for="(item,index) in items" :key="index">
      <div v-if="!item.hidden">
        <template v-if="item.children">
          <el-submenu :index="item.path" :key="item.index">
            <template #title>
              <i :class="item.meta.icon"></i>
              <span>{{ item.meta.title }}</span>
            </template>
            <template v-for="child in item.children">
              <el-submenu
                  v-if="child.children"
                  :index="child.path"
                  :key="child.index"
              >
                <template #title>{{ child.meta.title }}</template>
                <el-menu-item
                    v-for="(subs, i) in child.children"
                    :key="i"
                    :index="subs.path"
                >
                  <i :class="subs.meta.icon"></i>
                  <template #title>{{ subs.meta.title }}</template>
                </el-menu-item>
              </el-submenu>
              <el-menu-item
                  v-else
                  :index="child.path"
                  :key="child.index"
              >
                <i :class="child.meta.icon"></i>
                <template #title>{{ child.meta.title }}</template>
              </el-menu-item>
            </template>
          </el-submenu>
        </template>
        <template v-else>
          <el-menu-item :index="item.path" :key="item.index">
            <i :class="item.meta.icon"></i>
            <template #title>{{ item.meta.title }}</template>
          </el-menu-item>
        </template>
      </div>
    </template>
  </el-menu>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
  name: "Left",
  computed: {
    ...mapGetters([
      'menus',
      'active_index'
    ])
  },
  data() {
    return {
      items: []
    }
  },
  watch: {
    active_index() {
      this.updateMenu()
    }
  },
  created() {
    this.updateMenu()
  }
  ,
  methods: {
    updateMenu(){
      if(this.active_index === ''){
        return
      }

      this.items = []
      this.menus[this.active_index].children.forEach(item => {
        if (!item.hidden) {
          this.items.push(item)
        }
      })
    }
  }
}
</script>

<style scoped>
.menu {
  min-height: calc(100vh);
}
</style>
