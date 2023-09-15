<!-- Popup.vue -->
<template>
    <div class="popup-overlay">
      <div class="popup-content">
        <div v-if="lock">
          <button @click="closePopup">閉じる</button>
          <button @click="ReleaseObake">{{ value }}ポイントで購入する</button><br>
          <img :src="path()">
        </div>
        <div v-else>
          <p>購入済みです</p>
          <button @click="closePopup">閉じる</button><br>
          <img :src="path()">
        </div>
      </div>
    </div>
  </template>

    <script>
    export default {
        props:{ 
          imagepath:String,
          lock:Number,
          value:Number
        },

        methods: {
            closePopup() {
            this.$emit('close');
            },
            ReleaseObake() {
              this.$emit('Release');
            },
            path() {
              const PathSplit = this.imagepath.split("/")
              return require(`@/assets/img/${PathSplit[3]}`);
            },
        }
    }
    </script>
  
  <style scoped>
  .popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* 半透明の背景を設定 */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999; /* 他の要素よりも上に表示するためのz-index */
  }
  
  .popup-content {
    background: #a9a9a9; /* ポップアップの背景色を設定 */
    padding: 20px;
    border-radius: 5px;
  }
  img {
        background-color: #f5f5f5;
        width: 200px;
        height: 200px;
        margin: 20px;
        border: 3px solid black;
    }
  </style>
  