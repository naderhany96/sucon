<script>
  export default {
    props: ['errors'],
  }
</script>

<template>
  <div v-if="errors" class="alert alert-danger">
    <div v-for="(v, k) in errors" :key="k">
      <div v-for="error in v" :key="error">
        {{ error }}
      </div>
    </div>
  </div>
</template>
