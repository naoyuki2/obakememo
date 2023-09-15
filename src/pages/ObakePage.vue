<script>
import obakeDescArea from "@/components/obakeDescArea.vue"
import obakeShowArea from "@/components/obakeShowArea.vue"
import oharaiButton from '@/components/oharaiButton.vue'
import commonHeader from "@/components/commonHeader.vue"
import { EditDatabaseData } from '../../database.js'

export default {
  components: {
    obakeDescArea,
    obakeShowArea,
    oharaiButton,
    commonHeader
  },
  data() {
    return {
      taskId: '',
      taskName: '',
      obakeDesc: '',
      obakePath: '',
      isVisible: false,
      plusPoint: 0
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
      this.css = this.$route.query.css
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
      if(this.css >= 0){
        this.savePointsToLocalStorage();
      }else{
        setTimeout(() => {
          alert('期限を過ぎたためポイントを獲得できません');
      }, 750);
      }
    },
    savePointsToLocalStorage() {
        let pointDataManage = JSON.parse(localStorage.getItem('pointDataManage'));
        if (pointDataManage['dailyPoint'] < 5) {
            pointDataManage['dailyPoint'] += 1;
            pointDataManage['totalPoint'] += 1;
            this.plusPoint = 1;
            localStorage.setItem('pointDataManage', JSON.stringify(pointDataManage));
        } else {
            setTimeout(() => {
              alert('今日の獲得ポイントは上限に達しました。');
            }, 750);
        }
    },
  }
}
</script>

<template>
  <commonHeader :outside-total-point="plusPoint" :outside-daily-point="plusPoint"></commonHeader>
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