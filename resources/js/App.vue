<template>
  <div class="container-fluid">
    <!-- Page Content -->
    <main>
      <router-view></router-view>
    </main>
  </div>
</template>

<script>

export default {
  name: "MainComponent",
  data() {
    return {
      test: ''
    }
  },
  methods: {
  }
}
</script>

<style></style>