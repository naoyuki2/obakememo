<template>
    <button @click="back(this.$route.query.year,this.$route.query.month,this.$route.query.day)">戻る</button>
    Update
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
        <br><h1 class="plus" @click="msgAdd()">この内容で課題を変更する</h1>
        <div v-for="item in dataList" :key="item.id">
          {{ item['id'] }} : {{ item['text'] }} : 
          <ImageDisplay 
          :imagePath="parentImagePath(item['path'])"
          :text="item['text']"
          />
        </div>
</template>

<script>
export default{
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
      }
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