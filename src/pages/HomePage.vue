<script>
import ImageDisplay from "../components/ImageDisplay.vue";
import { GetDatabaseData} from '../../database.js'

export default {
    components: {
        ImageDisplay,
    },
    data() {
        return {
            tasks: [
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
            ],
            dataList: [],
        };
    },
    created(){
        const date  = new Date();
        [this.currentYear,  this.currentMonth, this.currentDate] = [date.getFullYear(), date.getMonth() + 1, date.getDate()];
        this.today = this.selectedDay = `${this.currentYear}-${('0' + this.currentMonth).slice(-2)}-${this.currentDate}`;

    },
    mounted() {
      this.msgShow()
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
                    taskDescription: task['task_descrption'],
                    obakePath: task['obake_path']
                },
            });
        },
        async msgShow() {
            const dl = this.today + " 00:00:00";
            const func = 'GetListAll';
            const args = {
            tbl: "task",
            where: `dead_line = '${dl}'`,
            join: "inner join obake on task.obake_id = obake.obake_id"
            };

            const data = await GetDatabaseData(func, args);
            this.dataList = data;
        },
        async reload() {
            const bdl = document.getElementById("date").value;
            const dl = bdl + " 00:00:00";
            const func = 'GetListAll';
            const args = {
            tbl: "task",
            where: `dead_line = '${dl}'`,
            join: "inner join obake on task.obake_id = obake.obake_id"
            };

            const data = await GetDatabaseData(func, args);
            this.dataList = data;
        },
    }
};
</script>

<template>
    <div class="main">
        <input type="date" id="date"><button @click="reload">のタスクを表示</button>
        <div v-for="task in tasks" :key="task">
            <ImageDisplay :imagePath="parentImagePath(task['obake_path'])" :text="task['task_name']"
                @click="ObakePage(task)" />
        </div>
        <div v-for="item in dataList" :key="item">
            <ImageDisplay :imagePath="parentImagePath(item['obake_path'])" :text="item['task_name']"
                @click="ObakePage(item)" />
        </div>
    </div>
</template>

  