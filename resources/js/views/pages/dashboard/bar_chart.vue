<script>
/**
 * BarChart Component
 */
export default {
  props: {
    data: {type: Array},
  },
  data() {
    return {
      options: {
        xaxis: {
 
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '45%',
            borderRadius: 3
          },
        },
        theme: { mode: 'light' },
        colors: ['#fcb92c', '#5664d2'],
        grid: { borderColor: '#f1f1f1' },
        dataLabels: { enabled: false },
      }
    };
  },
  created(){
    if (localStorage.getItem('layoutColor') != 'white') {
      this.options.theme.mode = 'dark';
    }
  }
};
</script>

<template>
  <div class="card">
    <div class="card-body">
      <apexchart
        class="apex-charts"
        height="350"
        type="bar"
        dir="ltr"
        :series="data"
        :options="options"
      ></apexchart>
    </div>
  </div>
  <!-- end card -->
</template>