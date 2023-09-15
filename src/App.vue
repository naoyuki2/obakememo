<template>
  <Transition>
    <router-view></router-view>
  </Transition>
</template>

<style>
@import "./assets/css/style.css";

.v-enter-active,
.v-leave-active {
  transition: opacity 1s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>
