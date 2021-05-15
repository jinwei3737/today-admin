<template>
  <div class="common-layout">
    <el-container>
      <el-header style="padding: 0">
        <Header/>
      </el-header>
      <el-container>
        <el-aside width="210px">
          <Left :key="isAlive"/>
        </el-aside>
        <el-main>
          <Main/>
        </el-main>
      </el-container>
    </el-container>
  </div>
</template>

<script>
import {Header, Left, Main} from "@/layout/components";

export default {
  components: {Header, Left, Main},
  name: "Layout",
  data() {
    return {
      isAlive: '',
    };
  },
  methods: {
  }
}
</script>

<style scoped>

</style>
