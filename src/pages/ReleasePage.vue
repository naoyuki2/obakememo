<script>
import Popup from "@/components/PopUp.vue";
import { EditDatabaseData, GetDatabaseData } from "../../database.js";
import commonHeader from "@/components/commonHeader.vue";

export default {
  components: {
    Popup,
    commonHeader
  },
  data() {
    return {
      isPopupVisible: false,
      SelectedImage: null,
      obakes: [],
      minusPoint: 0
    };
  },
  mounted() {
    this.getObakeList();
  },
  methods: {
    showPopup(imageSrc, lock_id, value) {
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
      const PathSplit = path.split("/");
      return require(`@/assets/img/${PathSplit[3]}`);
    },
    async getObakeList() {
      const func = "GetListAll";
      const args = {
        tbl: "obake",
      };
      const data = await GetDatabaseData(func, args);
      this.obakes = data;
    },
    judge() {
      let pointDataManage = JSON.parse(localStorage.getItem('pointDataManage'));
      if (pointDataManage['totalPoint'] - this.value < 0) {
        alert("ポイントが足りないよ");
      } else {
        this.Update();
      }
    },
    async Update() {
      try {
        const func = "DbUpdate";
        const args = {
          tbl: "obake",
          records: {
            lock_id: 0,
          },
          where: `obake_path = '${this.SelectedImage}'`,
        };
        await EditDatabaseData(func, args);
        let pointDataManage = JSON.parse(localStorage.getItem('pointDataManage'));
        pointDataManage['totalPoint'] -= this.value;
        localStorage.setItem('pointDataManage', JSON.stringify(pointDataManage));
        this.minusPoint += -this.value;
        this.hidePopup();
        this.getObakeList();
      } catch (error) {
        console.error("エラーが発生しました:", error);
      }
    },
  },
};
</script>

<template>
  <commonHeader :outsideTotalPoint="minusPoint"></commonHeader>
  <div>
    <Popup
      v-if="isPopupVisible"
      @close="hidePopup"
      @Release="judge"
      :imagepath="SelectedImage"
      :lock="lock"
      :value="value"
    />
    <div class="image-grid">
      <div v-for="obake in obakes" :key="obake.id">
        <img
          :src="path(obake.obake_path)"
          :class="{ lock: obake.lock_id === 1 }"
          @click="showPopup(obake.obake_path, obake.lock_id, obake.value)"
        />
      </div>
    </div>
  </div>
</template>

<style scoped>
.image-grid {
  display: grid;
  grid-template-columns: repeat(6, 1fr); /* 4つの列 */
  grid-gap: 10px; /* 画像間のスペースを調整 */
  justify-items: center;
}

.grid-item {
  width: 100%;
  text-align: center;
}

img {
  background-color: #f5f5f5;
  width: 100%; /* 画像の幅を200pxに設定 */
  height: 100%; /* 画像の高さも200pxに設定 */
  border: 3px solid black;
}

.lock {
  opacity: 0.3;
}
</style>
