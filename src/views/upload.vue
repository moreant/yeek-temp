<template>
  <div class="main">
    <div>
      <img src="https://img.icons8.com/color/144/000000/swift.png" />
      <h1>Swift 作业</h1>
      <el-row type="flex" justify="center"
        ><el-col :span="8">
          <el-upload
            action="api/post.php"
            :file-list="fileList"
            :on-success="successHandle"
            :on-error="errorHandel"
            :on-remove="remove"
            :before-upload="check"
          >
            <el-button slot="trigger" size="small" type="primary"
              ><i class="el-icon-upload2"></i> 点击上传</el-button
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
              <i class="el-icon-refresh"></i> 手动刷新列表</el-button
            >
            <div slot="tip" class="el-upload__tip">
              <h2>只能上传 doc/docx 文件，且不超过500kb</h2>
              <h3>下面是已上传的文件列表</h3>
            </div>
          </el-upload>
        </el-col>
      </el-row>
    </div>
    <div class="icon">
      <p>
        本页基于
        <img src="https://img.icons8.com/color/16/000000/vue-js.png" /> |
        <i class="el-icon-platform-eleme"></i>
      </p>
      <p>
        <a class="icon" href="https://icons8.com/icon/24465/swift"
          >Swift icon by Icons8</a
        >
      </p>
    </div>
  </div>
</template>

<script>
import { Message, Notification } from 'element-ui'
export default {
  name: 'upload',
  data () {
    return {
      loading: false,
      fileList: []
    }
  },
  mounted () {
    this.setTile()
    this.getFilelist()
  },
  methods: {
    setTile () {
      document.title = 'Swift 作业上传 | Yeek'
    },
    remove (file) {
      if (!file.raw) {
        Notification({ title: '删除成功', message: '服务器文件不删除', type: 'success' })
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
    },
    getFilelist () {
      this.loading = true
      this.axios('api/get.php').then(response => {
        this.fileList = response.data
        this.loading = false
      })
    },
    check (file) {
      try {
        const extension = /.do(c|cx)$/.exec(file.name)
        console.log(extension[0])
        return true
      } catch {
        Message({ message: '请上传指定类型的文件', type: 'error' })
        return false
      }
    }
  }
}
</script>

<style lang="scss" scoped>
h1 {
  margin-top: 0;
}
.icon {
  margin-top: auto !important;
}
.main {
  text-align: center !important;
  height: 100% !important;
  display: flex !important;
  flex-direction: column !important;
}
</style>
<style>
#app {
  height: 100% !important;
}
body {
  margin: 0;
  height: 100% !important;
}
</style>
