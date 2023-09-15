<script>
import { EditDatabaseData, GetDatabaseData } from '../../database.js'
import commonHeader from '@/components/commonHeader.vue'

export default {
  components: {
    commonHeader
  },
  data() {
    return {
      dataList: [],
      obakes: [],
      SelectedObake: '',
      taskName: '', // タスク名の入力値を管理
      taskDescription: '', // タスク説明の入力値を管理
      errorMessage: '', // エラーメッセージを管理
    }
  },
  mounted() {
    this.getObakeList()
  },
  methods: {
    async msgAdd() {
      // 入力値の検証
      if (!this.taskName || !this.taskDescription || !this.SelectedObake) {
        this.errorMessage = 'エラー: 未入力の項目があります';
        return; // エラーがある場合は処理を中断
      }

      // 以下のコードはエラーがない場合の処理
      try {
        const tn = this.taskName;
        const td = this.taskDescription;
        const year = this.$route.query.year;
        const month = this.$route.query.month;
        const day = this.$route.query.day;
        const bdl = `${year}-${month}-${day}`;
        const dl = bdl + " 00:00:00";
        const oi = this.SelectedObake.obake_id;
        const func = 'DbInsert'
        const args = {
          tbl: "task",
          records: {
            task_id: '',
            task_name: tn,
            task_description: td,
            obake_id: oi,
            dead_line: dl,
          }
        }
        await EditDatabaseData(func, args)
        this.back(this.$route.query.year, this.$route.query.month, this.$route.query.day)

      } catch (error) {
        console.error('エラーが発生しました:', error);
      }
    },
    async getObakeList() {
      const func = 'GetListAll'
      const args = {
        tbl: "obake",
        where: "lock_id = 0"
      }
      const data = await GetDatabaseData(func, args)
      this.obakes = data
    },
    back(year, month, day) {
      this.$router.push({
        name: 'TaskPage',
        query: {
          year: year,
          month: month,
          day: day
        }
      })
    },
    weekend(dayOfWeek) {
      if (dayOfWeek === "土") {
        return 'saturday';
      } else if (dayOfWeek === "日") {
        return 'sunday';
      } else {
        return '';
      }
    },
    parentImagePath(imagePath) {
      if (imagePath) {
        const PathSplit = imagePath.split("/")
        return require(`@/assets/img/${PathSplit[3]}`); // 変数を使用して画像のパスを指定
      }
    },
  },
}
</script>

<template>
  <commonHeader></commonHeader>
  <div>
    <!-- エラーメッセージがある場合に表示 -->
    <div v-if="errorMessage" class="error-message">
      {{ errorMessage }}
    </div>
    <h1 class="date" :class="weekend(this.$route.query.week)">{{ this.$route.query.month }}月{{ this.$route.query.day }}日({{ this.$route.query.week }})の課題</h1>
    <input class="IUgrave" type="text" id="task_name" placeholder="タスク名を入力" :class="weekend(this.$route.query.week)" v-model="taskName"><br>
    <input class="IUgrave" type="text" id="task_description" placeholder="タスクの説明を入力" :class="weekend(this.$route.query.week)" v-model="taskDescription"><br>
    <div>
      <select class="IUgrave" id="obake_id" :class="weekend(this.$route.query.week)" v-model="SelectedObake">
        <option value="" disabled selected style="display:none;">お化けを選択</option>
        <option v-for="obake in obakes" :key="obake.id" :value="obake">{{ obake.obake_id }}</option>
      </select>
    </div>
    <h1 class="plus" @click="msgAdd()" :class="weekend(this.$route.query.week)">この内容で課題を追加する</h1>
    <div v-if="SelectedObake.obake_path">
      <img :src="parentImagePath(SelectedObake.obake_path)" width="100" height="100" />
    </div>
  </div>
</template>

<style>
.error-message {
  color: red;
  margin-top: 10px;
}
</style>
