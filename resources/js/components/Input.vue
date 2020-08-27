<template>
  <div class="border-bottom d-flex align-items-center">
    <img
      :src="this.imageInput"
      class="icon-size mr-2"
      alt="tick"
      @click="handleTickAll()"
    >
    <input
      class="border-bottom border-0 todo-add-item"
      type="text"
      name="todo"
      placeholder="What need to be done?"
      @keyup.enter="handleAddItem"
      ref="input"
    >
  </div>

</template>

<script>
import TickImage from '../assets/img/tick.png'
import UnTickImage from '../assets/img/untick.png'
export default {
  name: 'Input',
  data () {
    return {}
  },
  props: {
    isAllTodoCompleted: Boolean
  },
  methods: {
    handleAddItem (e) {
      var text = e.target.value.trim()
      if (text) {
        this.$emit('add:item', {
          name: e.target.value,
          state: false
        })
        this.$refs.input.value = ''
      }
    },
    handleTickAll () {
      this.$emit('tick-all:item')
    }
  },
  computed: {
    imageInput () {
      return this.isAllTodoCompleted ? TickImage : UnTickImage
    }
  }
}
</script>

<style>
.todo-add-item {
  width: calc(100%);
  border: 0;
  padding: 0 10px;
  outline: 0;
  font-size: 32px;
}

.icon-size {
  height: 32px;
  min-height: 32px;
  width: 32px;
  min-width: 32px;
  cursor: pointer;
}
</style>
