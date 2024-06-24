<script>
/*
* Navigate to
*/
export default {
  props: {
    routeName: { type: String },
    routeLabel: { type: String },
  }
};
</script>
<template>
    <div>
        <router-link :to="{ name: routeName }" class="btn btn-primary">
            {{ routeLabel }}
            <i class="mdi mdi-plus mr-1"></i>
        </router-link>
    </div>
</template>