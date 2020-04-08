<template>
  <div id="app">
    <h1 class="title">Yeek 作业中心</h1>
    <!-- <router-view></router-view> -->
    <div class="works">
      <el-row :gutter="20">
        <el-col v-for="(item, index) in workList" :key="index" :span="6">
          <el-card shadow="hover" style="position:relative;">
            <div slot="header" class="clearfix">
              <span>{{ item.course + " - " + item.name }}</span>
              <span class="id">#{{ item.id }}</span>
            </div>
            <div class="work-text">
              <span>内容</span>
              <p>{{ item.content }}</p>
              <span>截止于：{{ item.end }}</span>
            </div>
            <br />
            <div>
              <el-button @click="drawerHandle(index)">提交作业</el-button>
            </div>
            <img :src="'/images/course/' + item.icon" class="course" />
          </el-card>
        </el-col>
      </el-row>
    </div>
    <el-drawer :visible.sync="drawer">
      <div class="drawer">
        <el-scrollbar style="height:100%;">
          <Upload :work="workList[this.workId]"></Upload>
        </el-scrollbar>
      </div>
    </el-drawer>
    <footer>
      <p>我也觉得丑，将就用一下吧</p>
      <a href="http://gd.beian.miit.gov.cn/">粤ICP备19003211号-1</a>
      | icon by <a target="_blank" href="https://icons8.cn">Icons8</a>
    </footer>
  </div>
</template>

<script>
import { works } from '@/utils/api.js'
import Upload from '@/components/Upload.vue'

export default {
  name: 'app',
  components: {
    Upload
  },
  data () {
    return {
      workList: [],
      drawer: false,
      workId: 0
    }
  },
  created () {
    this.getWorks()
  },
  methods: {
    async getWorks () {
      return new Promise((resolve, reject) => {
        works().then(response => {
          console.log(response)
          this.workList = response
        })
      })
    },
    drawerHandle (index) {
      this.drawer = true
      this.workId = index
    }
  }
}
</script>
<style>
.el-scrollbar__wrap {
  overflow-x: hidden;
}
</style>
<style lang="scss" scoped>
.works {
  margin: 0 10vh;
  flex-shrink: 0;
}
.drawer {
  height: 85vh;
}

.el-row {
  // margin: 0 24vh;
}
.el-col {
  padding: 10px 0;
}
.title {
  margin: 5vh 0;
  text-align: center;
}
.id {
  float: right;
  color: #c0c4cc;
}
.work-text {
  span {
    font-size: 14px;
    color: #909399;
  }
}
.course {
  transform: rotate(20deg);
  bottom: -20px;
  right: -20px;
  opacity: 0.2;
  position: absolute;
}
footer {
  text-align: center;
  margin-top: auto;
  padding: 8px 0;
  color: #c0c4cc;
  p {
    color: #c0c4cc;
  }
  a {
    color: #c0c4cc;
  }
}
#app {
  height: 100% !important;
  display: flex;
  flex-direction: column;
}
</style>

<style>
p,
h1,
h2,
h3,
h4,
h5 {
  color: #303133;
}
html {
  margin: 0;
  padding: 0;
  height: 100% !important;
}
body {
  margin: 0;
  padding: 0;
  height: 100% !important;
}
</style>
