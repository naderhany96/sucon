<script>
import Layout from "../../layout/mainLayout.vue";
import PageHeader from "@/components/page-header";
import CountersChart from "./counters_chart";
import BarChart from "./bar_chart";
import PieChart1 from "./pie_chart_1";
import PieChart2 from "./pie_chart_2";
/*
 * Dashboard page
 */
export default {
  components: {
    Layout,
    PageHeader,
    CountersChart,
    BarChart,
    PieChart1,
    PieChart2,
  },
  data() {
    return {
      title: "Dashboard",
      pending: false,
      countersChart: {
        first: 0,
        second: 0,
        third: 0,
        forth: 0,
      },
      barChart: [],
      pieChart1: [],
      pieChart2: [],
    };
  },
  methods: {
    async getDashboard1Data(){
      let that = this;
      await that.axios.get("dashboard").then(function (response) {
        that.countersChart = response.data.countersChart;
        that.barChart = response.data.barChart;
        that.pieChart1 = response.data.pieChart1;
        that.pieChart2 = response.data.pieChart2;
      });
    }
  },
  created() {
    this.getDashboard1Data();
  },
};
</script>

<template>
  <Layout>
    <PageHeader :title="title" :items="[]" />
    <div class="row">
      <div class="col-md-12">
        <CountersChart :data="countersChart"></CountersChart>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <BarChart :data="barChart"></BarChart>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <PieChart1 :data="pieChart1"></PieChart1>
      </div>
      <div class="col-md-6">
        <PieChart2 :data="pieChart2"></PieChart2>
      </div>
    </div>
  </Layout>
</template>