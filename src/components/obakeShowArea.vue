<script>
export default {
    props: {
        taskName: String,
        obakePath: String,
        isVisible: Boolean
    },
    methods: {
        parentImagePath(imagePath) {
            const PathSplit = imagePath.split("/")
            return require(`@/assets/img/${PathSplit[3]}`); // 変数を使用して画像のパスを指定
        },
    }
}
</script>

<template>
    <div class="obake-show-area">
        <span class="task-name" :class="{ 'visible': isVisible }">{{ taskName }}</span>
        <img class="obake-image" :class="{ 'visible': isVisible }" :src="parentImagePath(obakePath)">
        <img class="tenshinowa-image" :class="{ 'visible': !isVisible }" src="@/assets/img/tenshi_ring.png">
    </div>
</template>

<style>
.obake-show-area {
    background-color: #323232;
    height: 45vh;
    width: 30vw;
    border: solid 5px black;
}

.obake-image {
    position: relative;
    height: 40vh;
    width: 30vw;
    z-index: 2;
    opacity: 1;
    transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
}

.tenshinowa-image {
    position: absolute;
    top: 0;
    left: 0;
    margin-top: 50vh;
    margin-left: 60vw;
    height: 20vh;
    width: 30vw;
    opacity: 1;
    transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
    z-index: 10;
}

.task-name {
    position: absolute;
    margin-top: 23vh;
    margin-left: 3vw;
    color: white;
    font-size: 40px;
    text-align: center;
    background-color: rgba(0, 0, 0, 0.7);
    padding-left: 15vh;
    padding-right: 15vh;
    transition: opacity 0.3s ease-in-out;
    white-space: nowrap;
    z-index: 3;
    opacity: 1;
    transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
}

.visible {
    transform: translateY(-200px);
    opacity: 0;
}
</style>