<script>
import ICountUp from 'vue-countup-v2';
/**
 * CountersChart Component
 */
export default {
  props: {
    data: {type: Object},
  },
  components: {
    ICountUp
  },
  data() {
    const easingFn = function (t, b, c, d) {
      var ts = (t /= d) * t;
      var tc = ts * t;
      return b + c * (tc + -3 * ts + 3 * t);
    }

    return {
      darkMode: false,
      options: {
        useEasing: true,
        useGrouping: true,
        duration: 5,
        easingFn
      }
    };
  },
  created(){
    if (localStorage.getItem('layoutColor') != 'white') {
      this.darkMode = true;
    }
  }
};
</script>
<template>
  <div>
    <div class="row">
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <div class="media">
              <div class="media-body overflow-hidden">
                <p class="text-truncate font-size-16 mb-2" :class="{'text-white': darkMode}">Users</p>
                <h4 class="mb-0">
                  <ICountUp
                    :delay="1000"
                    :endVal="data.first"
                    :options="options"
                  />
                </h4>
              </div>
              <div class="text-primary">
                <i class="ri-stack-line font-size-24"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <div class="media">
              <div class="media-body overflow-hidden">
                <p class="text-truncate font-size-16 mb-2" :class="{'text-white': darkMode}">Number of Sales</p>
                <h4 class="mb-0">
                  <ICountUp
                    :delay="1300"
                    :endVal="data.second"
                    :options="options"
                  />
                </h4>
              </div>
              <div class="text-primary">
                <i class="ri-stack-fill font-size-24"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <div class="media">
              <div class="media-body overflow-hidden">
                <p class="text-truncate font-size-16 mb-2" :class="{'text-white': darkMode}">Sales Revenue</p>
                <h4 class="mb-0">
                  <ICountUp
                    :delay="1600"
                    :endVal="data.third"
                    :options="options"
                  />
                </h4>
              </div>
              <div class="text-primary">
                <i class="ri-arrow-left-up-line font-size-24"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <div class="media">
              <div class="media-body overflow-hidden">
                <p class="text-truncate font-size-16 mb-2" :class="{'text-white': darkMode}">Average Price</p>
                <h4 class="mb-0">
                  <ICountUp
                    :delay="1900"
                    :endVal="data.forth"
                    :options="options"
                  />
                </h4>
              </div>
              <div class="text-primary">
                <i class="ri-arrow-right-down-line font-size-24"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </div>
</template>