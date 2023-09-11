<template>
  <div class="image-container">
    <img class="img" :src="imagePath" alt="Image" :style="imageStyle" :class="{'image-large': css < 3}">
    <div class="text-container">
      <div class="overlay-text" ref="textElement" :style="imageStyle"></div>
    </div>
  </div>
</template>
  
<script>
export default {
  props: {
    imagePath: String,
    text: String,
    limit: String,
    css: Number,
  },
  computed: {
    combinedText() {
      return this.text + this.limit;
    }
  },
  data() {
    return {
      imageStyle: {
        position: 'absolute',
        top: '0',
        left: '0',
      },
      maxX: 0,
      maxY: 0,
    };
  },
  mounted() {
    this.splitText();
    this.calculateMaxValues();
    this.startMoving();
    console.log(this.CSS);
    console.log(this.limit);
  },
  beforeUpdate() {
    this.calculateMaxValues();
  },
  methods: {
    splitText() {
      const textElement = this.$refs.textElement;
      const characters = this.combinedText.split("");
      textElement.innerHTML = characters.map(char => `<span>${char}</span>`).join("");
    },
    calculateMaxValues() {
      const imageWidth = 100;
      const imageHeight = 100;
      this.maxX = (window.innerWidth - imageWidth) / 2;
      this.maxY = (window.innerHeight - imageHeight) / 2;
    },
    startMoving() {
      this.moveImage();
    },
    moveImage() {
      const randomX = Math.floor(Math.random() * (this.maxX * 2)) - this.maxX;
      const randomY = Math.floor(Math.random() * this.maxY);

      this.animateMovement(randomX, randomY);
    },
    animateMovement(targetX, targetY) {
      const duration = 5000; // アニメーションの時間（ミリ秒）
      const startX = parseInt(this.imageStyle.left);
      const startY = parseInt(this.imageStyle.top);
      const startTime = performance.now();

      const animate = (timestamp) => {
        const progress = (timestamp - startTime) / duration;

        if (progress < 1) {
          const currentX = startX + (targetX - startX) * progress;
          const currentY = startY + (targetY - startY) * progress;

          this.imageStyle.top = `${currentY}px`;
          this.imageStyle.left = `${currentX}px`;
          requestAnimationFrame(animate);
        } else {
          // アニメーション終了時の座標を設定
          this.imageStyle.top = `${targetY}px`;
          this.imageStyle.left = `${targetX}px`;

          // 次のランダム座標に移動
          this.moveImage();
        }
      };

      requestAnimationFrame(animate);
    },
  },
};
</script>
  
<style>
.img {
  width: 100px;
  height: 100px;
}

.image-container {
  position: relative;
  display: inline-block;
}

.text-container {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  display: flex;
  /* テキストを横に並べるために Flex レイアウトを使用 */
}

.overlay-text {
  color: white;
  font-size: 18px;
  text-align: center;
  background-color: rgba(0, 0, 0, 0.7);
  padding: 5px;
  transition: opacity 0.3s ease-in-out;
  white-space: nowrap;
  /* テキストを改行させないようにする */
  margin-bottom: 80px;
}

.image-container:hover .overlay-text {
  opacity: 1;
  /* カーソルを合わせたときに表示 */
}

.image-large{
  transform: scale(1.5);
}
</style>