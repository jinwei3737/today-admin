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
      <el-button type="primary" size="small" v-auth="'system.menu.add'" @click="dialogForm = true">添加</el-button>
    </div>

    <div>
      <el-table
          v-loading="loading"
          :data="tableData.data"
          row-key="id"
          :tree-props="{children: 'children', hasChildren: 'hasChildren'}"
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
            prop="uri"
            label="路由">
        </el-table-column>
        <el-table-column
            label="按钮权限">
          <template #default="scope">
            <el-tag v-for="item in scope.row.btns" :key="item.id"
                    @close="handleDelete(item.id)" class="tag" type="danger">{{ item.name }}
              <i class="el-tag__close el-icon-close" v-auth="'system.menu.delete'"></i>
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
                v-auth="'system.menu.edit'"
                @click="handleEdit(scope.row)"
            >编辑
            </el-button>
            <el-button
                type="text"
                icon="el-icon-delete"
                class="red"
                v-auth="'system.menu.delete'"
                @click="handleDelete(scope.row.id)"
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

  <el-dialog title="菜单管理" v-model="dialogForm" @open="getViewData()" @close="$refs['menuForm'].resetFields()">
    <el-form :model="menuForm" ref="menuForm" size="small">
      <el-form-item label="ID" prop="id" hidden>
        <el-input v-model="menuForm.id" autocomplete="off"></el-input>
      </el-form-item>

      <el-form-item label="类型" prop="type">
        <el-select v-model="menuForm.type" placeholder="请选择路由类型" style="width:100%"
                   @change="cutShow()">
          <el-option label="菜单" :value="1"></el-option>
          <el-option label="按钮" :value="2"></el-option>
        </el-select>
      </el-form-item>

      <el-form-item label="上级菜单" prop="parent_id">
        <el-select ref="select" v-model="menuForm.parent_id" :disabled="menuShow" clearable @clear="clearHandle"
                   placeholder="请选择"
                   style="width: 100%">
          <el-option :value="valueId" :label="valueTitle"
                     style="height:100%;max-height: 245px;overflow: auto;background-color:#fff">
            <el-tree
                id="tree-option"
                ref="selectTree"
                :data="menus"
                :props="{children: 'children',label: 'name'}"
                node-key="id"
                :default-expanded-keys="[1,2]"
                @node-click="handleNodeClick">
            </el-tree>
          </el-option>
        </el-select>
      </el-form-item>

      <el-form-item label="名称" prop="name">
        <el-input type="text" v-model="menuForm.name" autocomplete="off"></el-input>
      </el-form-item>

      <el-form-item label="Key" prop="key">
        <el-input type="text" v-model="menuForm.key" autocomplete="off"></el-input>
      </el-form-item>

      <el-form-item label="路由" prop="uri">
        <el-input type="text" v-model="menuForm.uri" autocomplete="off"></el-input>
      </el-form-item>
    </el-form>
    <template #footer>
    <span class="dialog-footer">
      <el-button size="small" @click="dialogForm = false">取 消</el-button>
      <el-button type="primary" size="small" @click="onSubmitMenu()">确 定</el-button>
    </span>
    </template>
  </el-dialog>
</template>

<script>
import {getMenus, add, edit, del, viewData} from "@/api/menus"
import {ElMessage} from "element-plus";


export default {
  name: "Index",
  components: {},
  data() {
    return {
      query: {
        name: '',
        offset: 1,
        limit: 1000
      },
      tableData: {
        data: [],
        total: 0,
      },
      loading: false,
      dialogForm: false,
      menuForm: {
        id: '',
        parent_id: '',
        name: '',
        key: '',
        uri: '',
        type: 1,
      },
      menus: [],
      fullscreenLoading: false,
      valueTitle: '',
      valueId: '',
      menuShow: false,
    }
  },
  created() {
    this.getData()
  },
  methods: {
    getData() {
      this.loading = true
      getMenus(this.query).then(res => {
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
        this.menus = res.data
      })
    },
    onSubmitMenu() {
      this.loading = true
      if (!this.menuForm.id) {
        delete this.menuForm.id
        add(this.menuForm).then(res => {
          this.loading = false
          this.dialogForm = false
          ElMessage.success(res.msg)

          this.getData()
        })
      } else {
        edit(this.menuForm).then(res => {
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
        this.menuForm.id = row.id
        this.menuForm.parent_id = row.parent_id
        this.valueTitle = row.parent_name
        this.valueId = row.parent_id
        this.menuForm.name = row.name
        this.menuForm.key = row.key
        this.menuForm.uri = row.uri
      })
    },
    handleDelete(id) {
      this.loading = true
      del({id: id}).then(res => {
        this.loading = false
        if (res.code === 200) {
          ElMessage.success(res.msg)
          this.getData();
        } else {
          ElMessage.error(res.msg)
        }
      })
    },

    handleNodeClick(node) {
      this.valueTitle = node.name;
      this.valueId = node.id;
      this.menuForm.parent_id = node.id;
      this.$refs.select.blur();
    },
    clearHandle() {
      this.valueTitle = ''
      this.valueId = null
      this.clearSelected()
    },
    /* 清空选中样式 */
    clearSelected() {
      let allNode = document.querySelectorAll('#tree-option .el-tree-node');
      allNode.forEach((element) => element.classList.remove('is-current'))
    },
    cutShow() {
      if (this.menuForm.type === 1) {
        this.menuForm.parent_id = ''
        this.menuShow = true
      } else {
        this.menuShow = false
      }
    }
  }
}
</script>

<style scoped>

</style>
