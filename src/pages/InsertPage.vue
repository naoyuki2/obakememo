<template>
  <h1 class="date">{{ this.$route.query.month }}月{{ this.$route.query.day }}日({{ this.$route.query.week }})の課題</h1>
  <div class="">
    <input class="IUgrave" type="text" id="task_name" placeholder="タスク名を入力"><br>
        <input class="IUgrave" type="text" id="task_description" placeholder="タスクの説明を入力"><br>
        <select class="IUgrave" id="priority_id">
          <option>重要度を選択</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
        </select>
        <br>        
  </div>
      <br>
      <h1 class="plus" @click="msgAdd()">この内容で課題を追加する</h1>
</template>

<script>
import { EditDatabaseData, GetDatabaseData } from '../../database.js'

export default {
  data() {
    return {
      dataList: [],
      Rand: ''
    }
  },
  created() {
    this.Count();
  },
  methods: {
    async msgAdd() {
      try {
        const tn = document.getElementById("task_name").value;
        const td = document.getElementById("task_description").value;
        const pi = document.getElementById("priority_id").value;
        const year = this.$route.query.year;
        const month = this.$route.query.month;
        const day = this.$route.query.day;
        const bdl = `${year}-${month}-${day}`;
        const dl = bdl + " 00:00:00";
        const oi = this.generateRandomObakeId();
        const func = 'DbInsert'
        const args = {
          tbl: "task",
          records: {
            task_id: '',
            task_name: tn,
            task_description: td,
            obake_id: oi,
            priority_id: pi,
            dead_line: dl,
          }
        }
        await EditDatabaseData(func, args)
        this.back(this.$route.query.year, this.$route.query.month, this.$route.query.day)

      } catch (error) {
        console.error('エラーが発生しました:', error);
      }
    },
    async Count() {
      try {
        const func = 'GetCount'
        const args = {
          tbl: "obake",
        }
        const a = await GetDatabaseData(func, args);
        this.Rand = a;
      } catch (error) {
        console.error('エラーが発生しました:', error);
      }
    },
    generateRandomObakeId() {
      return Math.floor(Math.random() * this.Rand) + 1;
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
  },
}
</script>