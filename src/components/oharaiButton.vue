<template>
    <button class="oharai-button">
        <img class="oharai-img" src="@/assets/img/oharai_bou.png" @click="$emit('buddhahood-call')">
    </button>
</template>

<style>
.oharai-button {
    border-radius: 30px;
    background-color: rgb(20, 20, 20);
    color: white;
    border: none;
    cursor: pointer;
    transition: transform 0.2s, background-color 0.2s;
    /* アニメーションのプロパティを指定 */

    /* ボタンが押されたときのスタイル */
    &:active {
        transform: translateY(2px);
        /* Y軸方向に2px押し込む */
        background-color: rgb(40, 40, 40);
        /* 色を少し濃くする */
    }
}

.oharai-img {
    height: 180px;
    width: 240px;
}
</style>