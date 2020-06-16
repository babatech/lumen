<template>
  <div class="home">
    <h1>Matrix multiplication with lumen</h1>
    <MatrixInput  />
  </div>
</template>

<script>
// @ is an alias to /src
import MatrixInput from '@/components/MatrixInput.vue'

export default {
  name: 'home',
  components: {
    MatrixInput
  }
}
</script>
