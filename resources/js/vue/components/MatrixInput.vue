<template>
  <div class="matrix-input">

    <div class="row" v-show="!result">
    <h3>Enter Matrix data</h3>
      <div class="col-md-12" v-show="error.length>0">
        <div class="alert alert-danger">
          <p v-for="msg in error" v-bind:key="msg">{{msg}}</p>
        </div>
      </div>
      <div class="col-md-6">
        <h3>Matrix A</h3>
        <table class="table">
          <tbody>
            <tr v-for="(row, index) in matrixA" class="matrix-row" v-bind:key="index">
              <td v-for="(cell, columnNumber) in row" class="matrix-cell" v-bind:key="columnNumber">
                <input type="number" v-model.number="cell.value" />
              </td>
            </tr>
          </tbody>
          <tfoot>
            <tr class="matrix-row">
              <td class="matrix-cell add" @click="addRow(matrixA)">Add row</td>
              <td class="matrix-cell add" @click="addColumn(matrixA)">Add column</td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="col-md-6">
        <h3>Matrix B</h3>
        <table class="table">
          <tbody>
            <tr v-for="(row, index) in matrixB" class="matrix-row" v-bind:key="index">
              <td v-for="(cell, columnNumber) in row" class="matrix-cell" v-bind:key="columnNumber">
                <input type="number" v-model.number="cell.value" />
              </td>
            </tr>
          </tbody>
          <tfoot>
            <tr class="matrix-row">
              <td class="matrix-cell add" @click="addRow(matrixB)">Add row</td>
              <td class="matrix-cell add" @click="addColumn(matrixB)">Add column</td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="col-md-12">
        <button type="button" class="btn btn-primary" @click="calculate()">Calculate</button>
        <button type="button" class="btn btn-secondary" @click="reset()">Reset</button>
      </div>
    </div>
    <div class="row" v-if="result">
      <div class="col-md-12">
        <h3>Result Matrix</h3>
        <table class="table">
          <tbody>
            <tr v-for="(row, index) in result" class="matrix-row" v-bind:key="index">
              <td v-for="(cell, columnNumber) in row" class="matrix-cell" v-bind:key="columnNumber">
                <label>{{cell.x}}:{{cell.y}} => {{cell.value}}</label>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="col-md-12">
        <button type="button" class="btn btn-primary" @click="back()">Back</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "MatrixInput",
  data: function() {
    return {
      count: 0,
      matrixA: [],
      matrixB: [],
      result: null,
      error: []
    };
  },
  methods: {
    add() {
      if (this.count === 0) {
        this.matrixA[this.count].push({ x: 0, y: 0, value: 0 });
      } else {
        this.matrixA[this.count] = [];
        const self = this;
        this.matrixA.forEach((row, rowCount) => {
          if (rowCount !== self.count) {
            self.matrixA[rowCount].push({
              x: rowCount,
              y: self.count,
              value: 0
            });
          } else {
            self.matrixA[rowCount] = [];
            for (let index = 0; index <= rowCount; index++) {
              this.matrixA[rowCount].push({
                x: index,
                y: rowCount,
                value: 0
              });
            }
          }
        });
      }

      this.count++;
    },
    /**
     * Add row to matrix
     * @param matrix refernce for matrix array
     */
    addRow(matrix) {
      if (matrix.length === 0) {
        matrix.push([{ x: 0, y: 0, value: 0 }]);
      } else {
        console.log(matrix[matrix.length - 1]);
        let newRow = [];
        for (let index = 0; index < matrix[matrix.length - 1].length; index++) {
          newRow.push({
            x: index,
            y: matrix[0].length,
            value: 0
          });
        }
        matrix.push(newRow);
      }
    },
    /**
     * Add Column to matrix
     * @param matrix refernce for matrix array
     */
    addColumn(matrix) {
      if (matrix.length === 0) {
        matrix.push([{ x: 0, y: 0, value: 0 }]);
      } else {
        matrix.forEach((row, rowCount) => {
          matrix[rowCount].push({ x: 0, y: 0, value: 0 });
        });
      }
    },

    /**
     * validate and send calculation request
     */
    calculate() {
      this.error = [];
      const payload = { matrixA: this.matrixA, matrixB: this.matrixB };
      this.$axios
        .post("/api/calculate", payload)
        .then(res => {
          this.result = res.data.result
          console.log(res.data.result);
        })
        .catch(err => {
          this.error = err.response.data.error;
        });
    },
    /**
     * Reset both Matrix's
     */
    reset() {
      this.matrixA = [];
      this.matrixB = [];
    },
    /**
     * Reset result matrix
     */
    back(){
      this.result = null;
    }
  }
};
</script>

<style scoped>
.matrix-row {
  display: block;
  width: 100%;
}
.matrix-cell {
  display: inline-block;
  padding: 0;
}
.matrix-cell.add {
  cursor: pointer;
  text-align: center;
  border: 2px dotted #42b983;
  padding: 5px;
  max-width: 100px;
}
.matrix-cell input , .matrix-cell label {
  max-width: 100px;
  border: 1px solid #42b983;
  padding: 5px 15px;
}
</style>
