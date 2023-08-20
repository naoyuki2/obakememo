<template>
    <h1>{{ this.$route.query.month }}月{{ this.$route.query.day }}日の課題</h1>
      <button @click="back(this.$route.query.year,this.$route.query.month,this.$route.query.day)">戻る</button>
          タスク名<input type="text" id="msg"><br>
          おばけタイプ<input type="number" id="path" >
        <button @click="msgAdd">送信</button>
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
  import { GetDatabaseData, EditDatabaseData } from '../../database.js'
  import ImageDisplay from "../components/ImageDisplay.vue";
  
  export default {
    components: {
      ImageDisplay,
    },
    data() {
      return {
        dataList: [],
        text: ''
      }
    },
    mounted() {
      this.msgShow()
    },
    methods: {
      async msgShow() {
        const func = 'GetListAll'
        const args = {
          tbl: "sampletbl",
        }
        const data = await GetDatabaseData(func, args)
        this.dataList = data
      },
      async msgAdd() {
        const msg = document.getElementById("msg").value;
        const path = document.getElementById("path").value;
        const func = 'DbInsert'
        const args = {
          tbl: "sampletbl",
          records: {
            id: '',
            text: msg,
            path: path
          }
        }
        await EditDatabaseData(func, args)
        await this.msgShow()
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
      }
      
    },
  }
  </script>
  