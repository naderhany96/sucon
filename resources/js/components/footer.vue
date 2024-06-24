<script>
import appConfig from "@/app.config";
export default {
  data() {
    return {
      AppTitle: appConfig.title,
      currentYear: new Date().getFullYear(),
    };
  }
};
</script>
<template>
  <footer class="footer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="text-sm d-none d-sm-block">
            {{AppTitle}} © {{currentYear}} 
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>