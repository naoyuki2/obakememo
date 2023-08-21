<template>
    <h1 class="date">{{ this.$route.query.month }}月{{ this.$route.query.day }}日の課題</h1>
    <div class="">
          <input type="text" id="task_name" placeholder="タスク名を入力"><br>
          <input type="text" id="task_descrption" placeholder="タスクの説明を入力"><br>
          <select id="priority_id">
            <option value="" disabled selected>重要度を選択</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
          <br>        
    </div>
        <br><h1 class="plus" @click="msgAdd()">この内容で課題を追加する</h1>
        <div v-for="item in dataList" :key="item.id">
          {{ item['id'] }} : {{ item['text'] }} : 
          <ImageDisplay 
          :imagePath="parentImagePath(item['path'])"
          :text="item['text']"
          />
        </div>
        <div class="Insert"></div>
  </template>
  
  <script>
  import { EditDatabaseData, GetDatabaseData } from '../../database.js'
  import ImageDisplay from "../components/ImageDisplay.vue";
  
  export default {
    components: {
      ImageDisplay,
    },
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
        try{
          const tn = document.getElementById("task_name").value;
          const td = document.getElementById("task_descrption").value;
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
              task_descrption: td,
              obake_id: oi,
              priority_id: pi,
              dead_line: dl,
              insert_date: `default`,
              update_date: `default`
            }
          }
          await EditDatabaseData(func, args)
          this.back(this.$route.query.year,this.$route.query.month,this.$route.query.day)

        }catch(error){
          console.error('エラーが発生しました:',error);
        }
      },
      async Count() {
        try{
          const func = 'GetCount'
          const args = {
            tbl: "obake",
          }
          const a =  await GetDatabaseData(func, args);
          this.Rand = a;
        }catch(error){
          console.error('エラーが発生しました:',error);
        }
      },
      generateRandomObakeId() {
        return Math.floor(Math.random() * this.Rand) + 1;
      },
      parentImagePath(imagePath) {
        return require(`@/assets/img/obake${imagePath}.png`); // 変数を使用して画像のパスを指定
      },
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
    },
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