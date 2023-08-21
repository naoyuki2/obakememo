<script>
export default {
    props: {
        obakeDesc: String,
    },
    mounted() {
        this.innerHTML()
    },
    methods: {
        innerHTML() {
            let obakeDeaArea = document.querySelector(".obake-desc-area")
            obakeDeaArea.innerHTML = this.obakeDesc
        }
    }
}
</script>

<template>
    <div class="obake-desc-area"></div>
</template>

<style>
.obake-desc-area {
    background-color: #c0c0c0;
    height: 80vh;
    width: 50vw;
    text-align: left;
    font-size: 40px;
}
</style>