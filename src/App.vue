<script>
import commonHeader from './components/commonHeader.vue'

export default {
  components:{
    commonHeader
  }
}
</script>

<template>
  <commonHeader></commonHeader>
  <router-view></router-view>
</template>

<style>
    @import './assets/css/style.css';
</style>