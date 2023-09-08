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
            selectButtonValid: ""
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
        async getObakeList(maxRange = -1, selectButton = "") {
            let expression = ""
            this.selectButtonValid = selectButton
            if (maxRange >= 0) {
                const currentDate = new Date()
                const maxRangeDate = new Date()
                maxRangeDate.setDate(maxRangeDate.getDate() + maxRange)
                const formattedCurrentDate = this.formatDate(currentDate)
                const formattedMaxRangeDate = this.formatDate(maxRangeDate)
                expression = `dead_line >= '${formattedCurrentDate}' and dead_line <= '${formattedMaxRangeDate}'` 
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
        formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // 月は0から始まるため+1する
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day} 00:00:00`;
        }
    }
};
</script>

<template>
    <div class="main">
        <div class="flex-container">
            <div class="show-range-button" @click="getObakeList(-1, 'all_button')" v-bind:class="{ 'select-valid-button': selectButtonValid === 'all_button'}">
                全表示
            </div>
            <div class="show-range-button" @click="getObakeList(0, 'today_button')" v-bind:class="{ 'select-valid-button': selectButtonValid === 'today_button'}">
                本日
            </div>
            <div class="show-range-button" @click="getObakeList(7, 'week_button')" v-bind:class="{ 'select-valid-button': selectButtonValid === 'week_button'}">
                1週間
            </div>
            <div class="show-range-button" @click="getObakeList(31, 'month_button')" v-bind:class="{ 'select-valid-button': selectButtonValid === 'month_button'}">
                1ヵ月
            </div>
        </div>
        <div v-for="task in tasks" :key="task">
            <ImageDisplay :imagePath="parentImagePath(task['obake_path'])" :text="task['task_name']"
                :limit="calculateRemainingDays(task['dead_line'])" @click="ObakePage(task)" />
        </div>
    </div>
</template>

<style>
.show-range-button {
    font-size: 30px;
    background-color: #808080;
    border-radius: 56px;
    border: 3px solid #fff;
    width: 250px;
    padding: 12px 0;
    text-align: center;
}

.flex-container {
    display: inline-flex;
}

.select-valid-button {
    font-size: 30px;
    background-color: #808080;
    border-radius: 56px;
    border: 3px solid #000;
    color: #000;
    width: 250px;
    padding: 12px 0;
    text-align: center;
}
</style>