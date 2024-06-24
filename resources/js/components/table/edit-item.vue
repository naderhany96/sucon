<script>
/*
* Edit-Item
*/
export default {
  props: {
    row: { type: Object },
    routeName: { type: String },
    editItem: { type: Function },
    permissionName: { type: String },
  }
};
</script>
<template>
  <div class="d-inline" v-if="$can(permissionName) && row.item.isDeleted != 1">
    <b-button
      size="sm"
      @click="editItem(row.item, $event.target, routeName)"
      class="mr-1"
      v-b-tooltip.hover
      title="Edit"
    >
      <i class="fas fa-edit"></i>
    </b-button>
  </div>
</template>