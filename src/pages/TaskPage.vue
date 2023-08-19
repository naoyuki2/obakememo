<template>
    <button><router-link to="/CalendarPage">戻る</router-link></button>
    <div>
        <h1>{{ $route.query.month }}月{{ $route.query.day }}日</h1>
        <h1>Java課題</h1>
        <h1>Java課題</h1>
        <h1>Java課題</h1>
        <h1>Java課題</h1>
        <h1>Java課題</h1>
        <h1>Java課題</h1>
        <h1>Java課題</h1>
    </div>
    <h1>Java課題</h1>
</template>

<style scoped>
h1{
  font-size: 30px;
  background-color:#808080;
  border-radius:56px;
  border: 3px solid #fff;
  width: 500px;
  padding: 12px 0;
  margin-left: auto;
    margin-right: auto;
}
</style>