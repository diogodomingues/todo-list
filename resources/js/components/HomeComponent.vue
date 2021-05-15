<template>
  <div id="app">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">{{ "Home Page" }}</div>

            <div class="card-body">
              <button
                v-if="todoList.length === 0"
                type="submit"
                class="btn btn-primary"
                v-on:click="showNewTodoListPopup"
              >
                Create New To-do List
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "home",
  props: [],

  components: {},
  data: function () {
    return {
      todoList: [],
      showNewTodoListPop : false,
    };
  },
  methods: {
    getTodoListByClient() {
      let that = this;

      let temptoken = window.sessionStorage.getItem("usertoken");

      axios({
        method: "get",
        url: themeConfig.apiurl + "/profile/countriesbyspaclient",
        params: {
          token: temptoken,
        },
      })
        .then(function (res) {
          if (res.status == 200) {
            that.todoList = res.data;
          }
        })
        .catch(function (err) {
          console.log(err);
        });
    },
    createNewTodoList() {
        alert('Create new To-do List');
    },
    showNewTodoListPopup() {
        this.showNewTodoListPopup = true;
    }
  },
  created() {},

  mounted() {},

  computed: {},

  watch: {},
};
</script>

<style scoped>
</style>
