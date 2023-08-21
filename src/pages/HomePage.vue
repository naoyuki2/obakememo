<script>
import ImageDisplay from "../components/ImageDisplay.vue";

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
        };
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
    }
};
</script>

<template>
    <div class="main">
        <div v-for="task in tasks" :key="task">
            <ImageDisplay :imagePath="parentImagePath(task['obake_path'])" :text="task['task_name']"
                @click="ObakePage(task)" />
        </div>
    </div>
</template>

  