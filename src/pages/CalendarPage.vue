<script>
export default{
  data(){
    return{
    today:"",
    selectedDay:"",
    currentYear:0,
    currentMonth:0,
    currentDate:0,
    calendar:[],
    holidays:[],
    };
  },
  created(){
    const date  = new Date();
    [this.currentYear,  this.currentMonth, this.currentDate] = [date.getFullYear(), date.getMonth() + 1, date.getDate()];
    this.today = this.selectedDay = `${this.currentYear}-${('0' + this.currentMonth).slice(-2)}-${this.currentDate}`;
  },
  methods:{
    checkSelectedDay(day){
      return{
        'selectedDay':`${this.currentYear}-${('0' + this.currentMonth).slice(-2)}-${('0' + day).slice(-2)}` == this.selectedDay
      }
    },
    movePrevMonth(){
      this.currentMonth = this.currentMonth != 1 ? this.currentMonth - 1 : 12;
      this.currentYear = this.currentMonth != 12 ? this.currentYear : this.currentYear - 1;
    },
    moveNextMonth(){
      this.currentMonth = this.currentMonth != 12 ? this.currentMonth + 1 : 1;
      this.currentYear = this.currentMonth != 1 ? this.currentYear : this.currentYear + 1;
    },
    TaskPage(day,month,year){
      if(day != " "){
        this.$router.push({
        name: 'TaskPage',
        query: {
          id: this.userId,
          text: this.userText,
          day: day,
          month: month,
          year: year
        }
      });
      }
    },
    isToday(day) {
      return (
        day === this.currentDate &&
        this.currentMonth === new Date().getMonth() + 1 &&
        this.currentYear === new Date().getFullYear()
      );
    },
  },
  computed:{
    calendarMake(){
      const firstday = new Date(this.currentYear, this.currentMonth - 1, 1).getDay();
      const lastdate = new Date(this.currentYear, this.currentMonth, 0).getDate();
      const necessarySpace = firstday;
      const spaces = Array(necessarySpace).fill(" ");
      const dates = Array.from({ length: lastdate }, (_, i) => i + 1);
      const list = [spaces,dates]
      const week = list.reduce((pre,current) => {pre.push(...current);return pre},[]);
      return week;
    },
    calendarRows() {
      const rows = [];
      const calendarCopy = [...this.calendarMake];

      while (calendarCopy.length) {
        rows.push(calendarCopy.splice(0, 7));
      }

      return rows;
  },
  }
};
</script>

<template>
  <div id="app">
    <span class="btn-modal-close" @click="close($event)"></span>
    <button><router-link to="/">戻る</router-link></button>
    <div><h1 class="calendar-title">
      <span @click="movePrevMonth">[前の月]</span>
      {{currentYear+"年"+currentMonth+"月"}}
      <span @click="moveNextMonth">[次の月]</span>
    </h1></div>
    <div class="center">
      <table class="full-screen">
        <tr>
          <th class="sunday">日</th>
          <th>月</th>
          <th>火</th>
          <th>水</th>
          <th>木</th>
          <th>金</th>
          <th class="saturday">土</th>
        </tr>
        <tr v-for="(week, weekIndex) in calendarRows" :key="weekIndex">
          <td
            v-for="(day, dayIndex) in week"
            :key="dayIndex"
            class="day"
            :class="{ 'today': isToday(day) }"
            @click="TaskPage(day,currentMonth,currentYear)"
          >
            {{ day }}
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<style scoped>
.day {
  font-size: 30px;
  border: 3px solid #fff;
}
th {
  padding: 12px 0;
  text-align: center;
  font-size: 20px;
  justify-content: center;
  background-color: #808080;
  border: 3px solid #fff;
}
.sunday{
  background-color: #ff6347;
}
.saturday{
  background-color: #4682b4;
}
.center {
  height: 100vh;
}
.calendar-title{
  font-size: 30px;
  background-color:#808080;
  border-radius:56px;
  border: 3px solid #fff;
  width: 500px;
  padding: 12px 0;
  text-align: center;
}
.full-screen {
  width: 100%;
  height: 90%;
  table-layout: fixed;
}
#app {
  display: flex;
  flex-direction: column;
  align-items: center;
  height: 100vh;
}


.day {
  overflow: hidden;
  position: relative;
  transition-duration: .4s;
  z-index: 2;
}
.day::after {
  background-color: #fff;
  border-radius: 50%;
  content: "";
  display: block;
  margin: auto;
  opacity: 0;
  pointer-events: none;
  position: absolute;
  top: 50%;
  width: 100%;
  padding-top: 100%;
  z-index: -1;
  transform: translateY(-50%) scale(0.1);
  transition: opacity .5s, transform 0s;
  transition-delay: 0s, .4s;
}
.day:hover::after {
  opacity: 1;
  transform: translateY(-50%) scale(1.1);
  transition-delay: 0s;
  transition: opacity .8s, transform .6s ease-in-out;
}
.today {
  color: #808080;
  background-color:#d3d3d3;
}
</style>