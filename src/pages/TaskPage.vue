<script> 
  import { GetDatabaseData} from '../../database.js'

  export default {
    data() {
      return {
        dataList: [],
        dayOfWeek: '',
      }
    },
    mounted() {
      this.msgShow()
    },
    methods:{
      UpdatePage(year,month,day,week,task_id){
        this.$router.push({
          name: 'UpdatePage',
          query: {
            year:year,
            month:month,
            day:day,
            week:week,
            task_id:task_id
          }
        });
      },
      InsertPage(year,month,day,week){
        this.$router.push({
          name: 'InsertPage',
          query: {
            year:year,
            month:month,
            day:day,
            week:week
          }
        });
      },
      async msgShow() {
        const func = 'GetListAll';
        const year = this.$route.query.year;
        const month = this.$route.query.month;
        const day = this.$route.query.day;
        const bdl = `${year}-${month}-${day}`;
        const dl = bdl + " 00:00:00";
        
        const args = {
          tbl: "task",
          where: `dead_line = '${dl}'`,
          join: "inner join obake on task.obake_id = obake.obake_id"
        };

        const data = await GetDatabaseData(func, args);
        this.dataList = data;

        const dateObj = new Date(`${year}-${month}-${day}`);
        const daysOfWeek = ['日', '月', '火', '水', '木', '金', '土'];
        const dayOfWeek = daysOfWeek[dateObj.getDay()];
        this.dayOfWeek = dayOfWeek;
      },
    }
  };
</script>

<template>
    <button><router-link to="/CalendarPage">戻る</router-link></button>
    <h1 class="date">{{ this.$route.query.month }}月{{ this.$route.query.day }}日({{ dayOfWeek }})の課題</h1>
        <div v-for="item in dataList" :key="item.id">
          <h1 class="task" @click="UpdatePage(this.$route.query.year,this.$route.query.month,this.$route.query.day,dayOfWeek,item['task_id'])">{{ item['task_name'] }} </h1>
        </div>
    <h1 class="plus" @click="InsertPage(this.$route.query.year,this.$route.query.month,this.$route.query.day,dayOfWeek)">課題を追加</h1>
</template>

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
.task{
  margin-bottom: 8px;
  font-size: 30px;
  background-color:#808080;
  border: 3px solid #fff;
  width: 500px;
  height: 50px;
  margin-left: auto;
  margin-right: auto;
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
</style>