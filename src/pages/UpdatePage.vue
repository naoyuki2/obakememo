<template>
  <button @click="back(this.$route.query.year,this.$route.query.month,this.$route.query.day)">戻る</button>
  Update
  <h1 class="date">{{ this.$route.query.month }}月{{ this.$route.query.day }}日の課題</h1>
  <div v-for="item in dataList" :key="item.id">
        <input type="text" id="task_name" placeholder="タスク名を入力" :value="item.task_name"><br>
        <input type="text" id="task_description" placeholder="タスクの説明を入力" :value="item.task_description"><br>
        <select id="priority_id" v-model="selectedPriority">
          <option>重要度を選択</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
        </select>
        <br>        
  </div>
      <br><h1 class="plus" @click="Update()">この内容で課題を変更する</h1>
</template>

<script>
import { EditDatabaseData, GetDatabaseData } from '../../database.js'

export default{
  data() {
    return {
      dataList: [], 
      selectedPriority: null
    }
  },
  mounted() {
    this.msgShow()
  },
  methods:{
      back(year,month,day){
      this.$router.push({
          name: 'TaskPage',
          query: {
              year:year,
              month:month,
              day:day
          }
      })
    },
    async msgShow() {
      const func = 'GetListAll';
      const id = this.$route.query.task_id;
      const args = {
        tbl: "task",
        where: `task_id = ${id}`,
      };

      const data = await GetDatabaseData(func, args);
      this.dataList = data;
      this.selectedPriority = data[0].priority_id;
    },
    async Update() {
      try{
        const tn = document.getElementById("task_name").value;
        const td = document.getElementById("task_description").value;
        const pi = document.getElementById("priority_id").value;
        const id = this.$route.query.task_id;
        const func = 'DbUpdate'
        const args = {
          tbl: "task",
          records: {
            task_name: tn,
            task_description: td,
            priority_id: pi,
          },
          where: `task_id = ${id}`,
        }
        await EditDatabaseData(func, args)
        this.back(this.$route.query.year,this.$route.query.month,this.$route.query.day)

      }catch(error){
        console.error('エラーが発生しました:',error);
      }
    },
  }
}
</script>

<style scoped>
.date{
  font-size: 30px;
  background-color:#808080;
  border-radius: 50px 50px 0 0;
  border: 3px solid #fff;
  width: 500px;
  padding: 25px;
  margin-left: auto;
  margin-right: auto;
}
input,select{
  margin-bottom: 8px;
  font-size: 30px;
  background-color:#808080;
  border: 3px solid #fff;
  width: 500px;
  height: 50px;
  margin-left: auto;
  margin-right: auto;
  color: #fff;
}
.plus{
  font-size: 30px;
  background-color:#808080;
  border-radius: 30px 30px 0 0;
  border: 3px solid #fff;
  width: 550px;
  padding: 25px;
  margin-left: auto;
  margin-right: auto;
}
input::placeholder {
  color: #fff; /* 好みの色を指定 */
}
input:focus {
  background-color: #696969; /* フォーカス時の背景色を指定 */
}
</style>