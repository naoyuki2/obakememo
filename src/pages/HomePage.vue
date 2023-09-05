<script>
import ImageDisplay from "../components/ImageDisplay.vue";
import { GetDatabaseData } from '../../database.js'

export default {
    components: {
        ImageDisplay,
    },
    data() {
        return {
            tasks: [
                /*
                {
                    task_id: 1,
                    task_name: 'Java課題',
                    task_description: 'JSの課題だ。DOM操作を使用した動きのあるアプリケーションの開発を行いう。9月までだ。',
                    obake_path: '@/assets/img/obake1.png'
                },
                {
                    task_id: 2,
                    task_name: 'PHP課題',
                    task_description: 'JSの課題だ。DOM操作を使用した動きのあるアプリケーションの開発を行いう。9月までだ。',
                    obake_path: '@/assets/img/obake2.png'
                },
                */
            ],

        };
    },
    created() {
        const date = new Date();
        [this.currentYear, this.currentMonth, this.currentDate] = [date.getFullYear(), date.getMonth() + 1, date.getDate()];
        this.today = this.selectedDay = `${this.currentYear}-${('0' + this.currentMonth).slice(-2)}-${this.currentDate}`;
    },
    mounted() {
        this.getObakeList()
    },
    methods: {
        parentImagePath(imagePath) {
            const PathSplit = imagePath.split("/")
            return require(`@/assets/img/${PathSplit[3]}`); // 変数を使用して画像のパスを指定
        },
        ObakePage(task) {
            this.$router.push({
                name: 'ObakePage',
                query: {
                    taskId: task['task_id'],
                    taskName: task['task_name'],
                    taskDescription: task['task_description'],
                    obakePath: task['obake_path']
                },
            });
        },
        async getObakeList() {
            const todayDateTime = this.today
            const designationDateTime = document.getElementById('date').value
            console.log(designationDateTime)
            let expression = ""
            if (designationDateTime) {
                expression = `dead_line = '${designationDateTime}'`
            } else {
                expression = `dead_line >= '${todayDateTime}'`
            }
            const func = 'GetListAll'
            const args = {
                tbl: "task",
                where: expression,
                join: "inner join obake on task.obake_id = obake.obake_id"
            }

            const data = await GetDatabaseData(func, args)
            this.tasks = data
        },
        calendarClear() {
            document.getElementById('date').value = ""
        },
        calculateRemainingDays(deadline) {
            const oneDayMilliseconds = 24 * 60 * 60 * 1000; // 1日のミリ秒数
            const deadlineDate = new Date(deadline);
            const currentDate = new Date();
            const differenceMilliseconds = deadlineDate - currentDate;
            const remainingDays = Math.ceil(differenceMilliseconds / oneDayMilliseconds);

            if (remainingDays === 0) {
                return `（本日）`;
            } else if (remainingDays > 0) {
                return `（あと ${remainingDays} 日）`;
            } else {
                return `（${-remainingDays} 日遅れています）`;
            }
        },
    }
};
</script>

<template>
    <div class="main">
        <input type="date" id="date" :value="today">
        <button @click="getObakeList">のタスクを表示</button>
        <button @click="calendarClear">日付クリア</button>
        <div v-for="task in tasks" :key="task">
            <ImageDisplay :imagePath="parentImagePath(task['obake_path'])"
                :text="task['task_name']"
                :limit="calculateRemainingDays(task['dead_line'])"
                @click="ObakePage(task)" />
        </div>
    </div>
</template>

  