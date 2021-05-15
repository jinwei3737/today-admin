<template>
  <div class="site-wrapper site-page--login">
    <div class="site-content__wrapper">
      <div class="site-content">
        <div class="brand-info">
          <h2 class="brand-info__text">Today-Admin</h2>
          <p class="brand-info__intro">Today-Admin基于Laravel、Element-UI构建开发</p>
        </div>
        <div class="login-main" v-loading="loading">
          <h3 class="login-title">登录</h3>
          <el-form :model="dataForm" :rules="dataRule" ref="dataForm" status-icon>
            <el-form-item prop="userName">
              <el-input v-model="dataForm.email" type="email" placeholder="邮箱"></el-input>
            </el-form-item>
            <el-form-item prop="password">
              <el-input v-model="dataForm.password" type="password" placeholder="密码"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button class="login-btn-submit" type="primary" @click="dataFormSubmit('dataForm')">登录</el-button>
            </el-form-item>
          </el-form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'

export default {
  name: "Login",
  computed: {
    ...mapGetters([
      'routers',
      'active_index',
    ])
  },
  data() {
    return {
      loading: false,
      dataForm: {
        email: '',
        password: '',
      },
      dataRule: {
        email: [
          {required: true, message: '邮箱不能为空', trigger: 'blur'}
        ],
        password: [
          {required: true, message: '密码不能为空', trigger: 'blur'}
        ]
      }
    }
  },
  created() {
  },
  methods: {
    ...mapActions(['login']),
    // 提交表单
    dataFormSubmit(formName) {
      const {login} = this
      this.$refs[formName].validate((valid) => {
        if (valid) {
          this.loading = true
          login(this.dataForm).then(res => {
            this.loading = false
            if (res.code === 200) {
              this.$message.success(res.msg);

              this.$router.push({path: '/404'})
            } else {
              this.$message.error(res.msg);
            }
          })
        }
      })
    }
  }
}
</script>

<style lang="scss">
.site-wrapper.site-page--login {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background-color: rgba(38, 50, 56, .30);
  overflow: hidden;

  &:before {
    position: fixed;
    top: 0;
    left: 0;
    z-index: -1;
    width: 100%;
    height: 100%;
    content: "";
    background-image: url(~@/assets/img/login_bg.jpg);
    background-size: cover;
  }

  .site-content__wrapper {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    padding: 0;
    margin: 0;
    overflow-x: hidden;
    overflow-y: auto;
    background-color: transparent;
  }

  .site-content {
    min-height: 100%;
    padding: 30px 500px 30px 30px;
  }

  .brand-info {
    margin: 220px 100px 0 90px;
    color: #fff;
  }

  .brand-info__text {
    margin: 0 0 22px 0;
    font-size: 48px;
    font-weight: 400;
    text-transform: uppercase;
  }

  .brand-info__intro {
    margin: 10px 0;
    font-size: 16px;
    line-height: 1.58;
    opacity: .6;
  }

  .login-main {
    position: absolute;
    top: 0;
    right: 0;
    padding: 150px 60px 180px;
    width: 470px;
    min-height: 100%;
    background-color: #fff;
  }

  .login-title {
    font-size: 16px;
  }

  .login-btn-submit {
    width: 100%;
    margin-top: 38px;
  }
}
</style>
