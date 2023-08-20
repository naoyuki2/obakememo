<template>
  <div>
    <h1>Data List</h1>
    <button><router-link to="/">戻る</router-link></button>
    <ul>
        タスク名<input type="text" id="msg"><br>
        おばけタイプ<input type="number" id="path" >
      <button @click="msgAdd">送信</button>
      <li v-for="item in dataList" :key="item.id">
        {{ item['id'] }} : {{ item['text'] }} : 
        <ImageDisplay 
        :imagePath="parentImagePath(item['path'])"
        :text="item['text']"
        />
        
      </li>

    </ul>
  </div>
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
      return require(`@/assets/obake${imagePath}.png`); // 変数を使用して画像のパスを指定
    },
  },
}
</script>

  