<script>
import { GetDatabaseData } from '../../database.js'
import commonHeader from '@/components/commonHeader.vue';

export default {
  components: {
    commonHeader
  },
  data() {
    return {
      tasks: {
        threeDays: [], // 3日分のタスクを格納する配列
        fourDays: [], // 4日分のタスクを格納する配列
      },
      taskCounts: {
        threeDays: [], // 3日分のタスク数を格納する配列
        fourDays: [], // 4日分のタスク数を格納する配列
      },
      count: 1
    }
  },
  created() {
    const date = new Date();
    [this.currentYear, this.currentMonth, this.currentDate] = [date.getFullYear(), date.getMonth() + 1, date.getDate()];
    this.today = this.selectedDay = `${this.currentYear}-${('0' + this.currentMonth).slice(-2)}-${this.currentDate}`;
  },
  mounted() {
    this.getObakeList();
  },
  methods: {
    async getObakeList() {
      const currentDate = new Date();
      const taskPromises = [];

      for (let i = 0; i < 7; i++) {
        const date = new Date(currentDate);
        date.setDate(currentDate.getDate() + i);
        const formattedDate = date.toISOString().split('T')[0];
        const func = 'GetListAll';
        const args = {
          tbl: "task",
          where: `dead_line = '${formattedDate}'`,
        };
        const promise = GetDatabaseData(func, args);
        taskPromises.push(promise);
      }

      // 7日分のデータを待機
      const taskResults = await Promise.all(taskPromises);

      // タスクを日付ごとに分けて保存
      for (let i = 0; i < taskResults.length; i++) {
        if (i < 3) {
          this.tasks.threeDays.push(taskResults[i]);
          this.taskCounts.threeDays.push(taskResults[i].length);
        } else {
          this.tasks.fourDays.push(taskResults[i]);
          this.taskCounts.fourDays.push(taskResults[i].length);
        }
      }
    },
    increment(date, index) {
      const newDate = new Date(date);
      newDate.setDate(newDate.getDate() + index);
      const month = String(newDate.getMonth() + 1)
      const day = String(newDate.getDate())
      const dayOfWeek = ['日', '月', '火', '水', '木', '金', '土'][newDate.getDay()];
      return `${month}月${day}日(${dayOfWeek})`;
    },
    weekend(dateStr) {
      const matchResult = dateStr.match(/\((.*?)\)/);
      if (matchResult && matchResult.length > 1) {
        const dayOfWeek = matchResult[1];
        if (dayOfWeek === "土") {
          return 'saturday';
        } else if (dayOfWeek === "日") {
          return 'sunday';
        } else {
          return '';
        }
      } else {
        return '';
      }
    },
    TaskPage(deadline) {
       //正規表現を使用して日、月、年を抽出
      const matchResult = deadline.match(/(\d{1,2})月(\d{1,2})日\((.*?)\)/);
      if (matchResult && matchResult.length === 4) {
        const day = parseInt(matchResult[2], 10);
        const month = parseInt(matchResult[1], 10);
        const year = this.currentYear; // ここで年を設定していますが、必要に応じて変更してください
        this.$router.push({
          name: "TaskPage",
          query: {
            day: day,
            month: month,
            year: year,
          },
        });
      }
    },
  }
}
</script>

<template>
  <commonHeader></commonHeader>
  <div class="outer-container">
    <div class="inner-container">
      <div class="C1">
        <!-- 3日分のタスクを表示 -->
        <div v-for="(dayTasks, index) in tasks.threeDays" :key="index">
          <h1 class="date" :class="weekend(increment(this.today, index))">{{ increment(this.today, index) }}</h1>
          <div v-if="dayTasks.length > 0">
            <!-- タスクがある場合 -->
            <div class="task-container">
              <h1 class="task" :class="weekend(increment(this.today, index))" @click="TaskPage(increment(this.today, index))">{{ dayTasks[0].task_name }}</h1>
              <h1 class="plus" :class="weekend(increment(this.today, index))" v-if="dayTasks.length > 1">他{{ dayTasks.length - 1 }}体</h1>
              <h1 class="plus" :class="weekend(increment(this.today, index))" v-else></h1>
            </div>
          </div>
          <div v-else>
            <!-- タスクがない場合 -->
            <h1 class="task" :class="weekend(increment(this.today, index))" @click="TaskPage(increment(this.today, index))">なし</h1>
            <h1 class="plus" :class="weekend(increment(this.today, index))"></h1>
          </div>
        </div>
      </div>
      <div class="C2">
        <!-- 4日分のタスクを表示 -->
        <div v-for="(dayTasks, index) in tasks.fourDays" :key="index">
          <h1 class="date" :class="weekend(increment(this.today, index + 3))">{{ increment(this.today, index + 3) }}</h1>
          <div v-if="dayTasks.length > 0">
            <!-- タスクがある場合 -->
            <div class="task-container">
              <h1 class="task" :class="weekend(increment(this.today, index + 3))" @click="TaskPage(increment(this.today, index + 3))">{{ dayTasks[0].task_name }}</h1>
              <h1 class="plus" :class="weekend(increment(this.today, index + 3))" v-if="dayTasks.length > 1">他{{ dayTasks.length - 1 }}体</h1>
              <h1 class="plus" :class="weekend(increment(this.today, index + 3))" v-else></h1>
            </div>
          </div>
          <div v-else>
            <!-- タスクがない場合 -->
            <h1 class="task" :class="weekend(increment(this.today, index + 3))" @click="TaskPage(increment(this.today, index + 3))">なし</h1>
            <h1 class="plus" :class="weekend(increment(this.today, index + 3))"></h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>



  <style scoped>
  .outer-container {
    display: flex;
    justify-content: center; /* 横方向中央揃え */
    height: 100vh; /* ウィンドウの高さいっぱいに設定 */
  }
  
  .inner-container {
    display: flex;
    flex-direction: column;
    align-items: center; /* 縦方向中央揃え */
  }
  
  .C1 {
    display: flex;
    margin: 10px; /* 必要に応じてマージンを調整 */
  }
  .C2 {
    display: flex;
    margin: 10px; /* 必要に応じてマージンを調整 */
  }
  
  .date {
    height: 80px;
    width: 330px;
  }
  .task {
    height: 120px;
    width: 330px;
    display: flex;
    justify-content: center; /* 横方向中央揃え */
    align-items: center; /* 縦方向中央揃え */
  }
  
  .plus {
    height: 70px;
    width: 370px;
    margin-left: 10px;
  }
  </style>
  