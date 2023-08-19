<script>
  import ImageDisplay from "../components/ImageDisplay.vue";
  
  export default {
    components: {
        ImageDisplay,
    },
    methods:{
        parentImagePath(imagePath) {
            return require(`@/assets/obake${imagePath}.png`); // 変数を使用して画像のパスを指定
        },
    }
  };
</script>

<template>
    <button><router-link to="/">戻る</router-link></button>
    <ImageDisplay :imagePath="parentImagePath($route.query.path)"
    :text="$route.query.text"/>
</template>