<template>
    <nav class="d-flex justify-content-end mt-3">
        <ul class="pagination mb-0">
            <li class="page-item" :class="{ disabled: pagination.prev_page_url == null}"><a class="page-link" href="#" @click="handlePagination(pagination.prev_page_url)">Previous</a></li>
            <li class="page-item disabled"><a class="page-link" href="#">{{ pagination.current_page }} / {{ pagination.last_page}}</a></li>
            <li class="page-item" :class="{ disabled: pagination.next_page_url == null}"><a class="page-link" href="#" @click="handlePagination(pagination.next_page_url)">Next</a></li>
        </ul>
    </nav>
</template>

<script>
export default {
  name: 'Pagination',
  props: {
    pagination: {
      type: Object,
      default: () => {}
    }
  },
  methods: {
    handlePagination (url) {
      this.$emit('click:pagination', url)
    }
  }
}
</script>

<style scoped>

</style>
