<template>
  <el-card class="box-card" style="margin-bottom: 20px;">
    <el-form :inline="true" :model="query" size="small" class="form-inline">
      <el-form-item label="">
        <el-input v-model="query.name" placeholder="名称"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" size="small" @click="onSearch">查询</el-button>
      </el-form-item>
    </el-form>
  </el-card>

  <el-card class="box-card">
    <div style="margin-bottom: 20px;">
      <el-button type="primary" size="small" v-auth="'system.role.add'" @click="dialogForm = true">添加</el-button>
    </div>

    <div>
      <el-table
          v-loading="loading"
          :data="tableData.data"
          border
          style="width: 100%">
        <el-table-column
            prop="id"
            label="ID">
        </el-table-column>
        <el-table-column
            prop="name"
            label="名称">
        </el-table-column>
        <el-table-column
            prop="key"
            label="Key">
        </el-table-column>
        <el-table-column
            prop="permissions"
            label="权限">
          <template #default="scope">
            <el-tag v-for="item in scope.row.permissions" :key="item.id"
                    @close="delPermission(scope.row.id,item.id)" class="tag" type="danger">{{ item.name }}
              <i class="el-tag__close el-icon-close" v-auth="'system.role.remove_permission'"></i>
            </el-tag>
          </template>
        </el-table-column>
        <el-table-column
            prop="updated_at"
            label="更新时间">
        </el-table-column>
        <el-table-column
            label="操作">
          <template #default="scope">
            <el-button
                type="text"
                icon="el-icon-edit"
                v-auth="'system.role.edit'"
                @click="handleEdit(scope.row)"
            >编辑
            </el-button>
            <el-button
                type="text"
                icon="el-icon-delete"
                class="red"
                v-auth="'system.role.delete'"
                @click="handleDelete(scope.row)"
            >删除
            </el-button>
          </template>
        </el-table-column>
      </el-table>
      <div class="pagination">
        <el-pagination
            background
            @current-change="handleCurrentChange"
            :current-page="query.offset"
            :page-sizes="[20, 50, 100, 200, 500]"
            :page-size="query.limit"
            layout="total, prev, pager, next"
            :total="tableData.total">
        </el-pagination>
      </div>
    </div>
  </el-card>

  <el-dialog title="角色操作" v-model="dialogForm" @open="getViewData()" @close="$refs['roleForm'].resetFields()">
    <el-form :model="roleForm" ref="roleForm" size="small">
      <el-form-item label="ID" prop="id" hidden>
        <el-input v-model="roleForm.id" autocomplete="off"></el-input>
      </el-form-item>
      <el-form-item label="名称" prop="name">
        <el-input type="text" v-model="roleForm.name" autocomplete="off"></el-input>
      </el-form-item>
      <el-form-item label="Key" prop="key">
        <el-input type="text" v-model="roleForm.key" autocomplete="off"></el-input>
      </el-form-item>
      <el-form-item label="权限" prop="permissions">
        <el-select v-model="roleForm.permissions" filterable multiple placeholder="请选择" style="width:100%">
          <el-option
              v-for="item in permissions"
              :key="item.id"
              :label="item.name"
              :value="item.id">
          </el-option>
        </el-select>
      </el-form-item>
    </el-form>
    <template #footer>
    <span class="dialog-footer">
      <el-button size="small" @click="dialogForm = false">取 消</el-button>
      <el-button type="primary" size="small" @click="onSubmitRole()">确 定</el-button>
    </span>
    </template>
  </el-dialog>
</template>

<script>
import {getRoles, add, edit, del, removePermission, viewData} from "@/api/roles"
import {ElMessage} from "element-plus";

export default {
  name: "Index",
  data() {
    return {
      query: {
        name: '',
        offset: 1,
        limit: 10
      },
      tableData: {
        data: [],
        total: 0,
      },
      loading: false,
      dialogForm: false,
      roleForm: {
        id: '',
        title: '',
        name: '',
        permissions: []
      },
      permissions: [],
      fullscreenLoading: false,
    }
  },
  created() {
    this.getData()
  },
  methods: {
    getData() {
      this.loading = true
      getRoles(this.query).then(res => {
        this.loading = false
        this.tableData = res.data
      })
    },
    onSearch() {
      this.query.offset = 1
      this.getData()
    },
    handleCurrentChange(val) {
      this.query.offset = val
      this.getData();
    },
    getViewData() {
      this.fullscreenLoading = true
      viewData().then(res => {
        this.fullscreenLoading = false
        this.permissions = res.data
      })
    },
    onSubmitRole() {
      this.loading = true
      if (!this.roleForm.id) {
        delete this.roleForm.id
        add(this.roleForm).then(res => {
          this.loading = false
          this.dialogForm = false
          ElMessage.success(res.msg)

          this.getData()
        })
      } else {
        edit(this.roleForm).then(res => {
          this.loading = false
          this.dialogForm = false
          ElMessage.success(res.msg)

          this.getData()
        })
      }
    },
    handleEdit(row) {
      this.dialogForm = true
      this.$nextTick(() => {
        let _this = this

        this.roleForm.id = row.id
        this.roleForm.name = row.name
        this.roleForm.key = row.key
        row.permissions.forEach(function (item) {
          _this.roleForm.permissions.push(item.id)
        })
      });
    },
    handleDelete(row) {
      this.loading = true
      del({id: row.id}).then(res => {
        this.loading = false
        ElMessage.success(res.msg)

        this.getData();
      })
    },
    delPermission(role_id, permission_id) {
      this.loading = true
      removePermission({role_id: role_id, permission_id: permission_id}).then(res => {
        this.loading = false
        ElMessage.success(res.msg)

        this.getData();
      })
    }
  }
}
</script>

<style scoped>

</style>
