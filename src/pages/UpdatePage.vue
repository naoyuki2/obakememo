<template>
  <h1 class="date" :class="weekend(this.$route.query.week)">{{ this.$route.query.month }}月{{ this.$route.query.day }}日({{ this.$route.query.week }})の課題</h1>
  <div v-for="item in dataList" :key="item.id">
    <input class="IUgrave" type="text" id="task_name" placeholder="タスク名を入力" :value="item.task_name" :class="weekend(this.$route.query.week)"><br>
    <input class="IUgrave" type="text" id="task_description" placeholder="タスクの説明を入力" :value="item.task_description" :class="weekend(this.$route.query.week)"><br>
    <select class="IUgrave" id="obake_id" :class="weekend(this.$route.query.week)" v-model="SelectedObake">
      <option>お化けを選択</option>
      <option v-for="obake in obakes" :key="obake.id" :value="obake">{{ obake.obake_id }}</option>
    </select>
  </div>
  <h1 class="plus" @click="Update()" :class="weekend(this.$route.query.week)">この内容で課題を変更する</h1>
  <div v-if="SelectedObake">
    <img :src="parentImagePath(SelectedObake.obake_path)" width="100" height="100" />
  </div>
</template>

<script>
import { EditDatabaseData, GetDatabaseData } from '../../database.js'

export default{
  data() {
    return {
      dataList: [], 
      selectedPriority: null,
      obakes: [],
      SelectedObake: ''
    }
  },
  mounted() {
    this.msgShow(),
    this.getObakeList()
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
        const id = this.$route.query.task_id;
        const oi = this.SelectedObake.obake_id;
        const func = 'DbUpdate'
        const args = {
          tbl: "task",
          records: {
            task_name: tn,
            task_description: td,
            obake_id: oi,
          },
          where: `task_id = ${id}`,
        }
        await EditDatabaseData(func, args)
        this.back(this.$route.query.year,this.$route.query.month,this.$route.query.day)

      }catch(error){
        console.error('エラーが発生しました:',error);
      }
    },
    async getObakeList() {
      const func = 'GetListAll'
      const args = {
        tbl: "obake",
      }
      const data = await GetDatabaseData(func, args)
      this.obakes = data
    },
    weekend(dayOfWeek) {
        if(dayOfWeek === "土"){
          return 'saturday';
        }else if(dayOfWeek === "日"){
          return 'sunday';
        }else{
          return '';
        }
    },
    parentImagePath(imagePath) {
      const PathSplit = imagePath.split("/")
      return require(`@/assets/img/${PathSplit[3]}`); // 変数を使用して画像のパスを指定
    },
  }
}
</script>