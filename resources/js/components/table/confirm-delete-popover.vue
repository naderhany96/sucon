<script>
import { focusRef } from "@/helpers/crud-func";
/*
* confirm-popover
*/
export default {
  props: {
    isFile: { type: Boolean },
    row: { type: Object },
    deleteLink: { type: String },
    deleteItem: { type: Function },
    fetchComponentData: { type: Function },
    permissionName: { type: String },
  },
  data() { return { target_btn: '' }},
  methods: {
    targetBtn(e){
      this.target_btn = e.currentTarget;
    },
    onShow(elID){
      this.$root.$emit('bv::hide::popover');
      this.$root.$emit('bv::show::popover', elID);
    },
    onShown() {
      this.focusRef(this.$refs.confirm_del);
    },
    onClose(){
      this.$root.$emit('bv::hide::popover');
    },
    onOk(item){
      this.$root.$emit('bv::hide::popover');
      this.deleteItem(item, this.target_btn, this.deleteLink);
    }
  },
  created() {
    this.focusRef = focusRef.bind(this);
  }
};
</script>

<template>
  <div class="d-inline" v-if="$can(permissionName) && row.item.isDeleted != 1">
    <b-button
      :id="`delete-item-${ !isFile ? row.item.id : row.item.filename }`"
      size="sm"
      class="mr-1"
      v-b-tooltip.hover
      title="Delete"
      @click="targetBtn"
    >
      <i class="far fa-trash-alt"></i>
    </b-button>

    <b-popover
      :target="`delete-item-${ !isFile ? row.item.id : row.item.filename }`"
      triggers="click blur"
      placement="left"
      @show="onShow(`delete-item-${ !isFile ? row.item.id : row.item.filename }`)"
      @shown="onShown"
    >
      <div class="text-center">
        <p class="confirm_msg mb-0 pb-1">Confirm delete ?</p>
        <b-button @click="onClose" size="sm" variant="default">No</b-button>
        <b-button @click="onOk(row.item)" size="sm" variant="primary" ref="confirm_del">Yes</b-button>
      </div>
    </b-popover>
  </div>
</template>