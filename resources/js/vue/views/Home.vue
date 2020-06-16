<template>
  <div class="home container">
    <h1>Matrix multiplication with lumen</h1>
    <MatrixContainer  />
  </div>
</template>

<script>
import MatrixContainer from '@/components/MatrixContainer.vue'

export default {
  name: 'home',
  components: {
    MatrixContainer
  }
}
</script>
