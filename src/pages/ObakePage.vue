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
  created() {
    this.loadPointsFromLocalStorage();
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
      let processingData = splitData[0] + "。<br><br>"
      for (let index = 1; index < splitData.length - 1; index++) {
        processingData += splitData[index] + "。<br><br>"
      }
      return processingData
    },
    async buddhahood() {
      const func = "DbDelete"
      const args = {
        tbl: "task",
        where: `task_id = ${this.taskId}`
      }
      await EditDatabaseData(func, args)
      this.isVisible = true
      this.incrementTotal();
    },
    savePointsToLocalStorage() {
      // ローカルストレージにポイントを保存
      localStorage.setItem('totalPoints', this.TotalPoint);
      localStorage.setItem('dailyPoints', this.DailyPoint);
    },
    loadPointsFromLocalStorage() {
      // ローカルストレージからポイントを読み込む
      const storedTotalPoints = localStorage.getItem('totalPoints');
      const storedDailyPoints = localStorage.getItem('dailyPoints');
      if (storedTotalPoints !== null && storedDailyPoints !== null) {
        this.TotalPoint = parseInt(storedTotalPoints, 10);
        this.DailyPoint = parseInt(storedDailyPoints, 10);
      }
    },
    incrementTotal() {
      // 1増やす
      this.TotalPoint += 1;
      this.DailyPoint += 1;
      // ローカルストレージに更新された Total Points を保存
      this.savePointsToLocalStorage();
    },
  }
}
</script>

<template>
  <div class="wrap">
    <div class="flex-container">
      <obakeDescArea class="obake-desc-area" :obakeDesc=obakeDesc></obakeDescArea>
      <div class="left-area">
        <oharaiButton class="oharai-button" @buddhahood-call="buddhahood" @incrementTotal-call="incrementTotal"></oharaiButton>
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