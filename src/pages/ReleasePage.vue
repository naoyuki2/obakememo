<template>
    <Popup v-if="isPopupVisible"
  @close="hidePopup"
  @Release="judge"
  :imagepath="SelectedImage"
  :lock="lock"
  :value="value"
  />
<div v-for="obake in obakes" :key="obake.id">
    <img :src="path(obake.obake_path)" :class="{lock:obake.lock_id == 1}" @click="showPopup(obake.obake_path,obake.lock_id,obake.value)">
</div>
</template>

<script>
import Popup from '@/components/PopUp.vue';
import { EditDatabaseData,GetDatabaseData } from '../../database.js'

export default {
components: {
Popup
},
data() {
return {
  isPopupVisible: false,
  SelectedImage: null,
  obakes:[],
};
},
mounted() {
this.getObakeList()
this.loadPointsFromLocalStorage()
},
methods: {
showPopup(imageSrc,lock_id,value) {
  this.SelectedImage = imageSrc;
  this.lock = lock_id;
  this.value = value;
  this.isPopupVisible = true;
},
hidePopup() {
  this.SelectedImage = null;
  this.isPopupVisible = false;
},
path(path) {
  const PathSplit = path.split("/")
  return require(`@/assets/img/${PathSplit[3]}`);
},
async getObakeList() {
  const func = 'GetListAll'
  const args = {
    tbl: "obake",
  }
  const data = await GetDatabaseData(func, args)
  this.obakes = data;
},
judge(){
  if(this.TotalPoint - this.value < 0){
    this.PayAlert();
  }else{
    this.Update();
  }
},
async Update() {
  try{ 
    const func = 'DbUpdate';
    const args = {
      tbl: "obake",
      records: {
        lock_id:0,
      },
      where: `obake_path = '${this.SelectedImage}'`,
    }
    await EditDatabaseData(func, args)
    this.PayPoint();
    this.hidePopup();
    this.getObakeList();
  }catch(error){
    console.error('エラーが発生しました:',error);
  }
},
loadPointsFromLocalStorage() {
  // ローカルストレージからポイントを読み込む
  const storedTotalPoints = localStorage.getItem('totalPoints');
  const storedDailyPoints = localStorage.getItem('dailyPoints');
  if (storedTotalPoints !== null && storedDailyPoints !== null) {
    this.TotalPoint = parseInt(storedTotalPoints, 10);
    this.DailyPoint = parseInt(storedDailyPoints, 10);
  }
},
PayPoint(){
    this.TotalPoint -= this.value;
    this.savePointsToLocalStorage();
},
savePointsToLocalStorage() {
  // ローカルストレージにポイントを保存
  localStorage.setItem('totalPoints', this.TotalPoint);
  localStorage.setItem('dailyPoints', this.DailyPoint);
},
PayAlert(){

}
}
}
</script>

<style scoped>
img {
    background-color: #f5f5f5;
    width: 200px;
    height: 200px;
    margin: 20px;
    border: 3px solid black;
}
.lock {
    opacity: 0.3;
}
</style>