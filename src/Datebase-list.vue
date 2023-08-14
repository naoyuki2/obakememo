<template>
  <div>
    <h1>Data List</h1>
    <ul>
      <li v-for="item in dataList" :key="item.id">{{ item.name }}</li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dataList: []
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    async fetchData() {
      try {
        const response = await fetch('/DBapi/get_data.php');
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data = await response.json();
        this.dataList = data;
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    }
  }
};
</script>

  