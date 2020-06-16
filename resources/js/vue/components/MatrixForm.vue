<template>
  <tbody>
    <tr v-for="(row, index) in matrix" class="matrix-row" v-bind:key="index">
      <td v-for="(cell, columnNumber) in row" class="matrix-cell" v-bind:key="columnNumber">
        <input v-if="!result" type="number" v-model.number="cell.value" />
        <label v-if="result">{{cell.x}}:{{cell.y}} => {{cell.value}}</label>
      </td>
    </tr>
  </tbody>
</template>

<script>
export default {
  name: "MatrixForm",
  props: ["matrix","result"],
  mounted() {
    console.log(this.matrix);
  }
};
</script>

<style>
.matrix-row {
  display: block;
  width: 100%;
}
.matrix-row .matrix-cell {
  display: inline-block;
  padding: 0;
}
.matrix-row .matrix-cell.add {
  cursor: pointer;
  text-align: center;
  border: 2px dotted #42b983;
  padding: 5px;
  max-width: 100px;
}
.matrix-cell input,
.matrix-cell label {
  max-width: 100px;
  border: 1px solid #42b983;
  padding: 5px 15px;
}
</style>