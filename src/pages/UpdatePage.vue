<template>
    <button @click="back(this.$route.query.year,this.$route.query.month,this.$route.query.day)">戻る</button>
    Update
</template>

<script>
export default{
    methods:{
        back(year,month,day){
        this.$router.push({
            name: 'TaskPage',
            query: {
                year:year,
                month:month,
                day:day
            }
        })
      }
    }
}
</script>