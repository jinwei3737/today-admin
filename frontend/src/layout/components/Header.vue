<template>
  <div class="logo menu-left" style="width: 190px;background-color: rgb(84, 92, 100)">Today-Admin</div>
  <div class="el-menu" style="background-color: #545c64;margin-left: 210px;">
    <el-menu
        :default-active="active_index"
        class="menu-left"
        mode="horizontal"
        @select="handleSelect"
        background-color="#545c64"
        text-color="#fff"
        active-text-color="#ffd04b">
      <el-menu-item :index="index" v-for="(item,index) in topMenus" :key="index">{{ item.meta.title }}
      </el-menu-item>
    </el-menu>

    <div class="menu-right">
      <el-dropdown class="">
        <div class="head" style="width: 40px;height: 40px;margin: 10px 10px;">
          <img :src="avatar?avatar:require('../../assets/img/head.jpg')" :alt="name"
               style="width: 40px;height: 40px;border-radius: 3px;"/>
        </div>
        <template #dropdown>
          <el-dropdown-menu>
            <el-dropdown-item>{{ name }}</el-dropdown-item>
            <el-dropdown-item divided @click="onSubmit()" v-loading.fullscreen.lock="fullscreenLoading">退出
            </el-dropdown-item>
          </el-dropdown-menu>
        </template>
      </el-dropdown>
    </div>

  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
  name: "top",
  computed: {
    ...mapGetters([
      'routers',
      'active_index',
      'avatar',
      'name'
    ])
  },
  data() {
    return {
      topMenus: [],
      fullscreenLoading: false,
    }
  },
  created() {
    this.setTopMenus()
  },
  methods: {
    ...mapActions(['logout']),
    setTopMenus() {
      this.routers.forEach(layout => {
        if (!layout.hidden) {
          layout.children.forEach(menu => {
            if (!menu.hidden) {
              this.topMenus.push(menu)
            }
          })
        }
      })

      this.$store.commit('SET_MENUS', this.topMenus)
    },
    handleSelect(key) {
      this.$store.commit('SET_ACTIVE_INDEX', key)
    },
    onSubmit() {
      const {logout} = this

      this.fullscreenLoading = true
      logout().then(res => {
        this.fullscreenLoading = false
        if (res.code === 200) {
          this.$router.push({path: '/login'})
        } else {
          this.$message({type: 'error', message: res.msg})
        }
      })
    }
  }
}
</script>

<style scoped>
.logo {
  background-color: rgb(84, 92, 100);
  line-height: 60px;
  color: #FFF;
  font-size: 20px;
  font-weight: 600;
  text-align: left;
  padding-left: 20px;
}

.menu-left {
  float: left;
  z-index: 999;
}

.menu-right {
  float: right;
  z-index: 999;
}
</style>
