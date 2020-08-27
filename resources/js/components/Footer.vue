<template>
  <div class="d-flex border-top align-items-center justify-content-between mt-3">
    <div class="mt-3">
      <p class="m-0 count-item px-3">{{ countItemLeft }} Item Left</p>
    </div>
    <ul class="nav nav-pills nav-fill mt-3 d-flex justify-content-between">
      <li
        v-for="(filter, index) in filters"
        :key="index"
        class="nav-item"
      ><span
          class="nav-link sort-item mx-1 text-center text-capitalize"
          :class="{ active: filter.isActive}"
          @click="handleChangeFilter(filter)"
        >{{ filter.type }}</span>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'Footer',
  props: {
    filters: {
      type: Array,
      default: () => []
    },
    listTodos: {
      type: Array,
      default: () => []
    }
  },
  methods: {
    handleChangeFilter (item) {
      this.$emit('change:filter', item)
    }
  },
  computed: {
    countItemLeft () {
      return this.listTodos.filter(item => item.state === false).length
    }
  }
}
</script>

<style>
.sort-item {
  cursor: pointer;
  transition: 0.3s;
  width: 115px;
  border: 1px solid #777;
}
.sort-item.active {
  border: 1px solid #007bff;
}
.sort-item:hover {
  background-color: #2196f3;
  color: #fff;
}
.count-item {
  font-weight: 700;
}
</style>
