<template>
  <div class="image-container">
    <div class="text-container">
      <div class="overlay-text" ref="textElement" :style="imageStyle"></div>
    </div>
    <img class="img" :src="imagePath" alt="Image" :style="imageStyle">
  </div>
</template>
  
<script>
export default {
  props: {
    imagePath: String,
    text: String,
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
  },
  beforeUpdate() {
    this.calculateMaxValues(); 
    this.moveImage();
  },
  methods: {
    splitText() {
      const textElement = this.$refs.textElement;
      const characters = this.text.split("");
      textElement.innerHTML = characters.map(char => `<span>${char}</span>`).join("");
    },
    calculateMaxValues() {
      const imageWidth = 100; 
      const imageHeight = 100; 
      this.maxX = (window.innerWidth - imageWidth)/2;
      this.maxY = (window.innerHeight - imageHeight)/2;
    },
    startMoving() {
      this.moveImage(); 
      setInterval(this.moveImage, 1000); 
    },
    moveImage() {
      const randomX = Math.floor(Math.random() * (this.maxX * 2)) - this.maxX;
      const randomY = Math.floor(Math.random() * this.maxY);

      this.imageStyle.top = `${randomY}px`;
      this.imageStyle.left = `${randomX}px`;
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
}</style>
