import {mount} from 'vue-test-utils'
import expect from 'expect'
import MatrixForm from '../../resources/assets/js/vue/components/MatrixForm.vue'

describe('MatrixFrom', () => {
  let component

  beforeEach(() => {
    component = mount(MatrixForm)
  })

  it('contains Matrix Table', () => {
    expect(component.html()).toContain('Example')
  })

})