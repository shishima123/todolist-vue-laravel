<template>
    <div v-if="listTodos.length > 0">
        <ul class="todo-list">
            <li
                v-for="(item, index) in listTodos"
                class="todo-list-item mt-3"
                :key="index"
                :class="{ 'item-deleted' : item.state, editting : item == editTodo}">
                <div class="view">
                    <img
                        src="../assets/img/uncheck.svg"
                        alt="uncheck"
                        class="icon-size mr-3 icon-state-item"
                        @click="handleDoneItem(item)">
                    <div class="d-flex justify-content-between align-items-center">
                        <p
                            ref="item"
                            class="m-0 text-break w-100">
                            {{ item.name }}
                        </p>
                        <div class="item-action">
                            <img
                                src="../assets/img/edit.svg"
                                alt="edit"
                                class="icon-size btn-delete-item mr-3"
                                @click="handleEditItem(item)">
                            <img
                                src="../assets/img/untick.png"
                                alt="delete"
                                class="icon-size btn-delete-item mr-3"
                                @click="handleRemoveItem(item)">
                        </div>
                    </div>
                </div>
                <input
                    type="text"
                    class="edit w-100"
                    v-model="item.name"
                    @blur="handleDoneEdit(item)"
                    @keyup.enter="handleDoneEdit(item)"
                    @keyup.esc="handleCancelEdit(item)"
                    v-focus="item == editTodo">
            </li>
        </ul>
        <pagination
            :pagination="pagination"
            @click:pagination="handlePagination"></pagination>
    </div>
    <h3 class="text-center my-3 text-success font-weight-bold"
        v-else>
        Nothing here
    </h3>
</template>

<script>
import pagination from './Pagination'

export default {
  name: 'TodoItem',
  props: {
    listTodos: {
      type: Array,
      default: () => []
    },
    filters: {
      type: Array,
      default: () => []
    },
    editTodo: {
      type: Object,
      default: () => {}
    },
    pagination: {
      type: Object,
      default: () => {}
    }
  },
  methods: {
    handleEditItem (item) {
      this.beforeEditCache = item.name
      this.$emit('edit:item', {
        editTodo: item,
        todo: item,
        action: 'edit'
      })
    },
    handleDoneEdit (item) {
      let action = _.isEqual(this.beforeEditCache, item.name) ? 'cancel' : 'edited'
      this.beforeEditCache = null
      this.$emit('edit:item', {
        editTodo: null,
        todo: item,
        action: action
      })
    },
    handleCancelEdit (item) {
      item.name = this.beforeEditCache
      this.$emit('edit:item', {
        editTodo: null,
        todo: item,
        action: 'cancel'
      })
    },
    handleRemoveItem (item) {
      this.$emit('remove:item', {
        todo: item
      })
    },
    handleDoneItem (item) {
      this.$emit('done:item', {
        todo: item
      })
    },
    handlePagination (url) {
      this.$emit('click:pagination', url)
    }
  },
  directives: {
    'focus': function (el, binding) {
      if (binding.value) {
        el.focus()
      }
    }
  },
  components: {
    pagination
  }
}
</script>

<style>
    .todo-list {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .item-action {
        display: none;
    }

    .todo-list-item:hover > .view > div > .item-action {
        display: block;
        animation: fadeIn 0.5s ease;
        cursor: pointer;
    }

    .todo-list-item > .view {
        display: flex;
    }

    .todo-list-item > .view > div {
        width: calc(100% - 32px - 1rem);
    }

    .item-action {
        position: absolute;
        right: 0;
    }

    .icon-state-item {
        transition: 0.3s;
        border-radius: 20px;
    }

    .icon-state-item:hover {
        background-color: #4baf88 !important;
    }

    .item-deleted > .view > img {
        background-color: #4baf88 !important;
        opacity: 0.5;
    }

    .item-deleted div > p, .item-deleted .item-action > img {
        text-decoration: line-through;
        opacity: 0.5;
    }

    .todo-list-item.editting > .view {
        display: none;
    }

    .todo-list-item > .edit {
        display: none;
    }

    .todo-list-item.editting > .edit {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>
