<template>
  <div id="app">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">{{ "Home Page" }}</div>

            <div class="card-body">
              <v-container>
                <v-row>
                  <v-col> </v-col>
                  <v-spacer></v-spacer>

                  <v-col>
                    <v-card class="pa-2" outlined tile>
                      <v-btn
                        v-on:click="showNewTodoListPopup"
                        class="ma-2"
                        outlined
                        color="indigo"
                      >
                        New To-do List
                      </v-btn>
                    </v-card>
                  </v-col>
                </v-row>
              </v-container>
              <br />
              <!-- <v-data-table
                :headers="todoTableHeaders"
                :items="todoList"
                :items-per-page="10"
                class="elevation-1"
              >
                <template v-slot:item.actions="{ item }">
                  <v-btn class="ma-3" v-on:click="showTasks">
                    View Tasks
                  </v-btn>
                </template>
              </v-data-table> -->

              <!-- <v-dialog v-model="dialog" width="500">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn color="red lighten-2" dark v-bind="attrs" v-on="showNewTodoListPopup">
                    Click Me
                  </v-btn>
                </template>

                <v-card>
                  <v-card-text>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                    ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    Duis aute irure dolor in reprehenderit in voluptate velit
                    esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
                    occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum.
                  </v-card-text>
                </v-card>
              </v-dialog> -->

              <!-- <v-row justify="center">
                <v-btn color="primary" dark @click.stop="dialog = true"
                  >Open Dialog
                </v-btn>
                <v-dialog v-model="dialog" max-width="290">
                  <v-card>
                    <v-card-title class="headline">
                      Use Google's location service?
                    </v-card-title>
                    <v-card-text>
                      Let Google help apps determine location. This means
                      sending anonymous location data to Google, even when no
                      apps are running.
                    </v-card-text>
                  </v-card>
                </v-dialog>
              </v-row> -->
              <v-alert
                v-if="showNewTodoList === true"
                dismissible
                type="success"
              >
                I'm a success alert.
              </v-alert>

              <ul v-for="(item, index) in todoList">
                <v-card outlined max-width="300">
                  <v-card-title>{{ item.name }}</v-card-title>
                  <v-card-text>{{ item.description }}</v-card-text>
                  <v-card-actions>
                    <v-btn
                      text
                      @click="getTasksByTodoList(item)"
                      class="ma-2"
                      outlined
                      color="indigo"
                    >
                      View Tasks
                    </v-btn>
                  </v-card-actions>
                  <br />
                </v-card>
              </ul>
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
  props: ['userdetails'],

  components: {},
  data: function () {
    return {
      baseUrl: "http://127.0.0.1:8000",
      todoList: [],
      showNewTodoList: false,
      dialog: false,
      loggedUser :{}
    };
  },
  methods: {
    getTodoListByClient(userId) {
      let that = this;
      axios({
        method: "get",
        url: this.baseUrl + "/todolist/by-user",
        params: {
          userId : userId
        }
      })
        .then(function (res) {
          if (res.status == 200) {
            console.log(res.data);
            that.todoList = res.data;
          }
        })
        .catch(function (err) {
          console.log(err);
        });
    },
    createNewTodoList() {
      alert("Create new To-do List");
    },
    showNewTodoListPopup() {
      this.showNewTodoList = true;
      alert("Create new To-do List");
    },
    getTasksByTodoList(item) {
      alert("View Tasks");
      console.log(item);
    },
  },
  created() {
    //decode json 
    this.loggedUser = JSON.parse(this.userdetails);

    this.getTodoListByClient(this.loggedUser.id);    
  },

  mounted() {},

  computed: {},

  watch: {},
};
</script>

<style scoped>
</style>
