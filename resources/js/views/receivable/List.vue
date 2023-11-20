<template>
  <div class="app-container">
    <div class="filter-container">
      <el-button class="filter-item" type="primary" icon="el-icon-plus" @click="handleCreateForm">
        {{ $t('table.add') }}
      </el-button>
    </div>
    <el-table v-loading="loading" :data="list" border fit highlight-current-row>
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="年月" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.happen_month }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="店铺" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.account_name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="站点" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.site }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="平台单号">
        <template slot-scope="scope">
          <span>{{ scope.row.platform_order_sn }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="余额">
        <template slot-scope="scope">
          <span>{{ scope.row.end_rmb_balance }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="发货金额">
        <template slot-scope="scope">
          <span>{{ scope.row.delivery_amount }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="发货时间">
        <template slot-scope="scope">
          <span>{{ scope.row.delivery_time }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="收款金额">
        <template slot-scope="scope">
          <span>{{ scope.row.receive_amount }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="收款时间">
        <template slot-scope="scope">
          <span>{{ scope.row.receive_time }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Actions" width="350">
        <template slot-scope="scope">
          <el-button type="primary" size="small" icon="el-icon-edit" @click="handleEditForm(scope.row.id, scope.row.account_name);">
            Edit
          </el-button>
          <el-button type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.row.id, scope.row.account_name);">
            Delete
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-dialog :title="'新增余额'" :visible.sync="receivableFormVisible">
      <div class="form-container">
        <el-form ref="receivableForm" :model="currentReceivable" label-position="left" label-width="150px" style="max-width: 500px;">
          <el-form-item label="月份" prop="happen_month">
            <el-date-picker
              v-model="currentReceivable.happen_month"
              type="month"
              placeholder="选择月份"
            />
          </el-form-item>
          <el-form-item label="店铺" prop="account_name">
            <el-input v-model="currentReceivable.account_name" />
          </el-form-item>
          <el-form-item label="余额" prop="end_rmb_balance">
            <el-input v-model="currentReceivable.end_rmb_balance" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="receivableFormVisible = false">
            Cancel
          </el-button>
          <el-button type="primary" @click="handleSubmit()">
            Confirm
          </el-button>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';
const receivableResource = new Resource('receivables');

export default {
  name: 'ReceivableList',
  data() {
    return {
      list: [],
      loading: true,
      receivableFormVisible: false,
      currentReceivable: {},
      formTitle: '',
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      this.loading = true;
      const { data } = await receivableResource.list({});
      this.list = data;
      this.loading = false;
    },
    handleSubmit() {
      if (this.currentReceivable.id !== undefined) {
        receivableResource.update(this.currentReceivable.id, this.currentReceivable).then(response => {
          this.$message({
            type: 'success',
            message: 'Receivable info has been updated successfully',
            duration: 5 * 1000,
          });
          this.getList();
        }).catch(error => {
          console.log(error);
        }).finally(() => {
          this.receivableFormVisible = false;
        });
      } else {
        receivableResource
          .store(this.currentReceivable)
          .then(response => {
            this.$message({
              message: 'New Receivable ' + this.currentReceivable.account_name + ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.currentReceivable = {
              account_name: '',
              end_rmb_balance: '',
              happen_month: '',
            };
            this.receivableFormVisible = false;
            this.getList();
          })
          .catch(error => {
            console.log(error);
          });
      }
    },
    handleCreateForm() {
      this.receivableFormVisible = true;
      this.currentReceivable = {
        account_name: '',
        end_rmb_balance: '',
        happen_month: '',
      };
    },
    handleDelete(id, name) {
      this.$confirm('This will permanently delete receive ' + name + '. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        receivableResource.destroy(id).then(response => {
          this.$message({
            type: 'success',
            message: 'Delete completed',
          });
          this.getList();
        }).catch(error => {
          console.log(error);
        });
      }).catch(() => {
        this.$message({
          type: 'info',
          message: 'Delete canceled',
        });
      });
    },
    handleEditForm(id) {
      this.formTitle = 'Edit Receivable';
      this.currentReceivable = this.list.find(receivable => receivable.id === id);
      this.receivableFormVisible = true;
    },
  },
};
</script>
