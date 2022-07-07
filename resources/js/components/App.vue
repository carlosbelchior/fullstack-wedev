<template>
    <Navbar></Navbar>
    <main class="py-4">
        <router-view></router-view>
    </main>
</template>

<script>
import Navbar from "./Navbar.vue";
export default {
  name: "App",
  components: {
    Navbar,
  },
};
</script>

<style lang="scss" scoped>
</style>
