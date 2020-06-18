export const actions = {
    setMatrixA({commit}, value){
        commit("SET_MATRIX_A", value)
    },
    setMatrixB({commit}, value){
        commit("SET_MATRIX_B", value)
    },
    resetMatrix({commit}){
        commit("SET_MATRIX_A", []);
        commit("SET_MATRIX_B", [])
    }
 
 
}