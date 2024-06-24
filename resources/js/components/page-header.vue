<script>
export default {
  components: {},
  props: {
    title: {
      type: String,
      default: '',
    },
    items: {
      type: Array,
      default: () => {
        return []
      },
    },
  },
}
</script>

<template>
  <!-- start page title -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="mb-0 font-size-18">{{ title }}</h4>
        <div class="page-title-right">
          <span dir="ltr" v-for="(item,k) in items" :key="k">
            <router-link v-if="item.href" :to="item.href" class="text-muted">
              {{ item.text }}
              <span v-if="items && items.length > 1 && items.length -1 == k"> / </span>
            </router-link>
            <span v-else>
              <span class="text-muted">
                {{ item.text }}
                <span v-if="items && items.length > 1 && items.length -1 == k">&nbsp; / &nbsp;</span>
              </span>
            </span>
          </span>
        </div>
      </div>
    </div>
  </div>
  <!-- end page title -->
</template>
