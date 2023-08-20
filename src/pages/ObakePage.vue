<script>
import obakeDescArea from "@/components/obakeDescArea.vue"
import obakeShowArea from "@/components/obakeShowArea.vue"
import oharaiButton from '@/components/oharaiButton.vue'
import { EditDatabaseData } from '../../database.js'

export default {
  components: {
    obakeDescArea,
    obakeShowArea,
    oharaiButton
  },
  data() {
    return {
      taskId: '',
      taskName: '',
      obakeDesc: '',
      obakePath: '',
      isVisible: false
    }
  },
  beforeMount() {
    this.dataSetup()
  },
  methods: {
    dataSetup() {
      this.taskId = this.$route.query.taskId
      this.taskName = this.$route.query.taskName
      const description = this.dataProcessing(this.$route.query.taskDescription)
      this.obakeDesc = description
      this.obakePath = this.$route.query.obakePath
    },
    dataProcessing(rawData) {
      let splitData = rawData.split("。")
      let processingData = ""
      for (let index = 0; index < splitData.length - 1; index++) {
        processingData += splitData[index] + "。<br><br>"
      }
      return processingData
    },
    async buddhahood() {
      const func = "DbDelete"
      const args = {
        tbl: "task",
        expression: `task_id = ${this.taskId}`
      }
      await EditDatabaseData(func, args)
      this.isVisible = true
    }
  }
}
</script>

<template>
  <div class="wrap">
    <div class="flex-container">
      <obakeDescArea class="obake-desc-area" :obakeDesc=obakeDesc></obakeDescArea>
      <div class="left-area">
        <oharaiButton class="oharai-button" @buddhahood-call="buddhahood"></oharaiButton>
        <obakeShowArea class="obake-show-area" :obakePath=obakePath :taskName=taskName :isVisible=isVisible>
        </obakeShowArea>
      </div>
    </div>
  </div>
</template>

<style>
.wrap {
  padding-bottom: 5vh;
}

.flex-container {
  display: flex;
}

.obake-desc-area {
  margin-top: 5vh;
  margin-left: 5vw;
}

.obake-show-area {
  margin-top: 10vh;
  margin-left: 5vw;
}

.oharai-button {
  margin-top: 12vh;
  margin-left: 2vw;
}
</style>