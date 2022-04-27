<template>
  <div class="small">
    <h4> Orders Chart</h4>
    <line-chart :chart-data="datacollection" :height="100"></line-chart>
  </div>
</template>

<script>
import LineChart from "./LineChart.js";
import axios from "axios";

export default {
  components: {
    LineChart
  },
  data() {
    return {
      items: [],
      labels: [],
      activePage: 1,
      canceledOrderPrice: 0,
      returnedOrderPrice: 0,
      damagedOrderPrice: 0,
      fail_retunedOrderPrice: 0,

      canceledOrderCount: 0,
      returnedOrderCount: 0,
      damagedOrderCount: 0,
      fail_retunedOrderCount: 0,
      datacollection: null
    };
  },
  created() {
    this.getFleets();
  },
  mounted() {
    setTimeout(() => {
      this.fillData();
    }, 3000);
  },
  methods: {
    getFleets() {
      this.loading = true;
      let self = this;
      axios
        .post("/api/chart?token=" + localStorage.getItem("api_token"))
        .then(function(response) {
          self.items = self.items.concat(response.data.fleets);

          self.items.forEach(item => {
            self.canceledOrderPrice += parseInt(item.totalCanceledPrice);
          });

          self.items.forEach(item => {
            self.returnedOrderPrice += parseInt(item.totalReturnedPrice);
          });

          self.items.forEach(item => {
            self.fail_retunedOrderPrice += parseInt(item.totalFReturnedPrice);
          });

          self.items.forEach(item => {
            self.damagedOrderPrice += parseInt(item.totalDamagePrice);
          });

          self.items.forEach(item => {
            self.canceledOrderCount += parseInt(item.totalCanceledCount);
          });

          self.items.forEach(item => {
            self.returnedOrderCount += parseInt(item.totalReturnedCount);
          });

          self.items.forEach(item => {
            self.fail_retunedOrderCount += parseInt(item.totalFReturnedCount);
          });

          self.items.forEach(item => {
            self.damagedOrderCount += parseInt(item.totalDamageCount);
          });
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    fillData() {
      self = this;
      let arr = ["", "Returned", "Canceled", "Damaged", "Failed returned"];
      this.datacollection = {
        labels: arr,
        datasets: [
          {
            label: "price",
            backgroundColor: "green",
            data: [
              0,
              self.returnedOrderPrice,
              self.canceledOrderPrice,
              self.damagedOrderPrice,
              self.fail_retunedOrderPrice
            ]
          },
          {
            label: "count",
            backgroundColor: "yellow",
            data: [
              0,
              self.returnedOrderCount,
              self.canceledOrderCount,
              self.damagedOrderCount,
              self.fail_retunedOrderCount
            ]
          }
        ]
      };
    }
  }
};
</script>

<style lang="css" scoped>
.small {
  width: 100%;
  height: 500px;
  margin: 10px auto;
}
#line-chart {
  width: 100%;
  height: 100%;
}
</style>
