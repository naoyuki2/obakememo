<script>
  import ImageDisplay from "../components/ImageDisplay.vue";
  
  export default {
    components: {
        ImageDisplay,
    },
    data() {
      return {
        imagePaths: [
            "1",
            "2",
            "3",
            "4",
            "5",
            "6",
            "7",
            "8",
            "9",
            "10",
            "11",
            "12",
            // 他の画像パスを追加
        ],
        texts: [
            "Javaの課題",
            "2",
            "3",
            "4",
            "5",
            "6",
            "7",
            "8",
            "9",
            "10",
            "11",
            "12",
            // 他の画像パスを追加
        ],
      };
    },
    methods:{
        parentImagePath(imagePath) {
            return require(`@/assets/obake${imagePath}.png`); // 変数を使用して画像のパスを指定
        },
        ObakePage(imagePath,text){
            this.$router.push({
                name: 'ObakePage',
                query:{
                    path:imagePath,
                    text:text
                }
            });
        },
    }
  };
</script>

<template>
    <div class="main">
        <button><router-link to="/CalendarPage">カレンダー</router-link></button>
        <button><router-link to="/TestPage">テスト</router-link></button>
        <div v-for="(imagePath, index) in imagePaths" :key="imagePath">
            <ImageDisplay 
            :imagePath="parentImagePath(imagePath)" 
            :text="texts[index]"
            @click="ObakePage(imagePath,texts[index])" />
        </div>
    </div>
</template>

  