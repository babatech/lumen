<template>
  <div class="matrix-input">
    <div class="row" v-show="!result">
      <div class="col-md-12">
        <h3>Enter Matrix data</h3>
      </div>
      <div class="col-md-12" v-show="error.length>0">
        <div class="alert alert-danger">
          <p v-for="msg in error" v-bind:key="msg">{{msg}}</p>
        </div>
      </div>
      <div class="col-md-6">
        <h3>Matrix A</h3>
        <table class="table">
          <MatrixForm v-bind:matrix="this.matrixA" />
          <tfoot>
            <tr class="matrix-row">
              <td class="matrix-cell add" @click="addRow(matrixA)">Add row</td>
              <td class="matrix-cell add" @click="addColumn(matrixA)">Add column</td>
              <td class="matrix-cell add" @click="setSample('A')">Sample data</td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="col-md-6">
        <h3>Matrix B</h3>
        <table class="table">
          <MatrixForm v-bind:matrix="this.matrixB" />
          <tfoot>
            <tr class="matrix-row">
              <td class="matrix-cell add" @click="addRow(matrixB)">Add row</td>
              <td class="matrix-cell add" @click="addColumn(matrixB)">Add column</td>
              <td class="matrix-cell add" @click="setSample('B')">Sample data</td>
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
          <MatrixForm v-bind:matrix="this.result" v-bind:result="true" />
        </table>
      </div>

      <div class="col-md-12">
        <button type="button" class="btn btn-primary" @click="back()">Back</button>
      </div>
    </div>
  </div>
</template>

<script>
import MatrixForm from "./MatrixForm";
import { mapState } from "vuex";
export default {
  name: "MatrixInput",
  computed: mapState({
    matrixA: state => state.matrixA,
    matrixB: state => state.matrixB,
    result: state => state.result
  }),
  components: {
    MatrixForm
  },
  data: function() {
    return {
      count: 0,
      error: []
    };
  },
  methods: {
    setSample(matrix){
      if(matrix === "A"){
        this.matrixA.push([{x: 0, y:0, value: 8},{x: 1, y:0, value: 6},{x: 2, y:0, value: 2}])
        this.matrixA.push([{x: 0, y:1, value: 3},{x: 1, y:1, value: 1},{x: 2, y:1, value: 4}])
      }else if(matrix === "B"){
        this.matrixB.push([{x: 0, y:0, value: 4},{x: 1, y:0, value: 6}])
        this.matrixB.push([{x: 0, y:1, value: 5},{x: 1, y:1, value: 9}])
        this.matrixB.push([{x: 0, y:1, value: 7},{x: 1, y:1, value: 6}])
      }

    },
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
     * Send calculation request
     */
    calculate() {
      this.error = [];
      const payload = { matrixA: this.matrixA, matrixB: this.matrixB };
      this.$axios
        .post("/api/calculate", payload)
        .then(res => {
          this.result = res.data.result;
          console.log(res.data.result);
        })
        .catch(err => {
          if (err.response.data.error) this.error = err.response.data.error;
          else this.error = [err.response.statusText];
        });
    },
    /**
     * Reset both Matrix's
     */
    reset() {
      this.$store.dispatch ("resetMatrix");
    },
    /**
     * Reset result matrix
     */
    back() {
      this.result = null;
    },

    /**
     * Download result file as CSV
     */
    download() {
      this.error = [];
      this.$axios
        .post("/api/download", { result: this.result})
        .then(() => {
        })
        .catch(err => {
          this.error = err.response.data.error;
        });
    },
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
  min-width: 120px;
}
.matrix-cell input,
.matrix-cell label {
  max-width: 100px;
  border: 1px solid #42b983;
  padding: 5px 15px;
}
</style>
