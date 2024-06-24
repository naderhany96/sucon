<script>
/**
 * PieChart2 Component
 */
export default {
  props: {
    data: {type: Array},
  },
  data() {
    return {
      options: {
        theme: { mode: 'light' },
        
        colors: ["#fcb92c", "#5664d2", "#ff3d60"],
        legend: {
          show: true,
          position: 'bottom',
          horizontalAlign: 'center',
          verticalAlign: 'middle',
          floating: false,
          fontSize: '14px',
          offsetX: 0,
          offsetY: -10
        }
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
        height="320"
        type="pie"
        dir="ltr"
        :series="data"
        :options="options"
      ></apexchart>
    </div>
  </div>
  <!-- end card -->
</template>