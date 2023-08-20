<template>
  <div>
    <router-link to="/">戻る</router-link>
    <h1>Data List</h1>
    <ul>
      メッセージ <input type="text" id="msg">
      <button @click="msgAdd">送信</button>
      <li v-for="item in dataList" :key="item.id">
        {{ item['id'] }} : {{ item['text'] }}
      </li>

    </ul>
  </div>
</template>

<script>
import { GetDatabaseData, EditDatabaseData } from '../../database.js'

export default {
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
      const func = 'DbInsert'
      const args = {
        tbl: "sampletbl",
        records: {
          id: '',
          text: msg
        }
      }
      await EditDatabaseData(func, args)
      await this.msgShow()
    }
  },
}
</script>

  