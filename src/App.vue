<template>
  <div id="app">
    <app-web-page></app-web-page>
  </div>
</template>

<script>
import WebPage from "./components/WebPage.vue";

export default {
  name: 'app',
  data () {
    return {};
  },
  components: {
    appWebPage: WebPage
  }
}


</script>

<style>

</style>
