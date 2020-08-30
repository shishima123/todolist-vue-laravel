<template>
  <div id="app">
    <header>
      Todo Lists
    </header>
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-6 border rounded p-3 box-shadow">
          <Input
            @add:item="handleAddItem"
            :isAllTodoCompleted="isAllTodoCompleted"
            @tick-all:item="handleTickAll"
          />
          <TodoItem
            :listTodos="listTodos"
            @remove:item="handleRemoveItem"
            @done:item="handleDoneItem"
            :filters="filters"
            :editTodo="editTodo"
            @edit:item="handleEditItem"
            :pagination="pagination"
            @click:pagination="handlePagination"
          />
          <Footer
            :listTodos="listTodos"
            :filters="filters"
            @change:filter="handleChangeFilter"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Input from './components/Input'
import TodoItem from './components/TodoItem'
import Footer from './components/Footer'
import State from './constants/state'

export default {
  name: 'App',
  data () {
    return {
      editTodo: null,
      listTodos: [],
      filters: [
        { 'type': State.ALL, isActive: true },
        { 'type': State.ACTIVE, isActive: false },
        { 'type': State.COMPLETED, isActive: false }
      ],
      pagination: {},
      state: ''
    }
  },
  methods: {
    handleAddItem (data) {
      let url = '/todo'
      this.handleAjaxCommon(url, 'POST', data)
    },
    handleEditItem (data) {
      this.editTodo = data.editTodo
      if (data.action === 'edited') {
        let id = data.todo.id
        let url = `/todo/${id}`
        this.handleAjaxCommon(url, 'PUT', data.todo)
      }
    },
    handleRemoveItem (data) {
      let id = data.todo.id
      let url = `/todo/${id}`
      this.handleAjaxCommon(url, 'DELETE', data.todo)
    },
    handleDoneItem (data) {
      let id = data.todo.id
      let url = `/todo/${id}`
      data.todo.state = !data.todo.state
      this.handleAjaxCommon(url, 'PUT', data.todo)
    },
    handleTickAll () {
      let state = this.listTodos.filter(item => item.state === false).length > 0

      var ids = []
      for (var item of this.listTodos) {
        ids.push({id: item.id, state: state})
      }
      let url = `/todo/tick-all`
      this.handleAjaxCommon(url, 'PUT', ids)
    },
    handleChangeFilter (data) {
      this.state = data.type
      this.filters.map(
        item => {
          item.isActive = item.type === data.type
        }
      )
      this.fetchTodoList()
    },
    handlePagination (url) {
      this.fetchTodoList(url)
    },
    fetchTodoList (pageUrl) {
      let state = this.state || State.ALL
      if (pageUrl == null) {
        pageUrl = ('/todo' + `?state=${state}`)
      } else {
        pageUrl = (pageUrl + `&state=${state}`)
      }
      fetch(pageUrl)
        .then(response => response.json())
        .then(
          res => {
            let todos = res.data
            todos.map(item => {
              item.state = Boolean(item.state)
            })
            this.listTodos = todos
            this.makePagination(res)
          }
        )
    },
    makePagination (pagination) {
      this.pagination = {
        current_page: pagination.current_page,
        last_page: pagination.last_page,
        next_page_url: pagination.next_page_url,
        prev_page_url: pagination.prev_page_url
      }
    },
    handleAjaxCommon (url, method, data) {
      fetch(url, {
        method: method,
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
      }).then(response => response.json())
        .then(data => {
          this.fetchTodoList()
          this.$toasted.success(data.message)
        })
        .catch((error) => {
          alert(`Error: ${error}`)
        })
    }
  },
  computed: {
    isAllTodoCompleted () {
      return this.listTodos.filter(item => item.state === false).length > 0
    }
  },
  components: {
    Input,
    TodoItem,
    Footer
  },
  created () {
    this.fetchTodoList()
  }
}
</script>

<style>
body {
  background-color: #f5f5f5;
}
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
header {
  color: #2196f3;
  font-size: 70px;
  text-align: center;
  width: 100%;
  height: 150px;
  line-height: 150px;
  font-style: italic;
  font-weight: 700;
}
.box-shadow {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  background: #fff;
  transition: all 0.3s ease;
}
</style>
