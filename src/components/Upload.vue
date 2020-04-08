<template>
  <div class="main">
    <div>
      <el-image
        :fit="cover"
        :src="'/images/course/' + work.icon"
        style="width: 100px; height: 100px"
      ></el-image>
      <h1 class="mb">{{ work.course + " - " + work.name }}</h1>
      <el-row type="flex" justify="center">
        <el-col :span="20" :lg="12">
          <el-progress
            :text-inside="true"
            :stroke-width="26"
            :percentage="percentage"
          ></el-progress>
        </el-col>
      </el-row>
      <el-row class="mb" type="flex" justify="center">
        <el-col :span="20" :lg="14"> {{ fileList.length }} / 56 </el-col>
      </el-row>
      <el-row class="mb" type="flex" justify="center">
        <el-col :span="20" :lg="14" >

            <el-upload
              action="https://www.yeek.top/api/post.php"
              :data="{ id: work.id, course: work.course }"
              :file-list="fileList"
              :on-success="successHandle"
              :on-error="errorHandel"
              :on-remove="remove"
            >
              <el-button slot="trigger" size="small" type="primary"
                ><i class="el-icon-upload2"></i> 上传</el-button
              >
              <el-button
                ref="refresh"
                size="small"
                type="primary"
                plain
                style="margin-left: 20px;"
                :loading="loading"
                @click="getFilelist"
              >
                <i class="el-icon-refresh"></i
              ></el-button>
              <div slot="tip" class="el-upload__tip">
                <h3>下面是已上传的文件列表</h3>
              </div>
            </el-upload>

        </el-col>
      </el-row>
    </div>
  </div>
</template>

<script>
import { files } from '@/utils/api.js'
import { Message, Notification } from 'element-ui'
export default {
  name: 'upload',
  data () {
    return {
      percentage: 0,
      loading: false,
      fileList: []
    }
  },
  watch: {
    work () {
      this.getFilelist()
    }
  },
  props: ['work'],
  mounted () {
    this.getFilelist()
  },
  methods: {
    getFilelist () {
      this.loading = true
      return new Promise((resolve, reject) => {
        files(this.work.id + '_' + this.work.course).then(response => {
          this.loading = false
          this.fileList = response
          this.percentage = ((response.length / 56) * 100) | 0
        })
      })
    },
    remove (file) {
      if (!file.raw) {
        Notification({
          title: '删除成功',
          message: '服务器文件不删除',
          type: 'success'
        })
      }
    },
    successHandle (response, file, fileList) {
      this.getFilelist()
      Message({ message: `上传文件 ${file.name} 成功`, type: 'success' })
    },
    errorHandel (err, file, fileList) {
      try {
        const a = /{.+?}/.exec(err)
        Message(JSON.parse(a[0]))
      } catch {
        Message({ message: '上传错误，未知问题', type: 'error' })
      }
    }

    // check (file) {
    //   try {
    //     const extension = /.do(c|cx)$/.exec(file.name)
    //     console.log(extension[0])
    //     return true
    //   } catch {
    //     Message({ message: '请上传指定类型的文件', type: 'error' })
    //     return false
    //   }
    // }
  }
}
</script>

<style lang="scss" scoped>
.main {
  text-align: center !important;
}
.mb {
  margin-bottom: 24px;
}
</style>
