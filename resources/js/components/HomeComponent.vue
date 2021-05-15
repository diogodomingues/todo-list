<template>
  <div id="app">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">{{ "Home Page" }}</div>

            <div class="card-body">
              <v-container v-if="todoList.length === 0">
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
              <br /><br /><br />
              <v-data-table
                :headers="todoTableHeaders"
                :items="todoList"
                :items-per-page="10"
                class="elevation-1"
              >
                <template v-slot:item.actions="{ item }">
                  <v-btn
                        class="ma-3"
                        v-on:click="showTasks"                 
                      >
                        View Tasks
                      </v-btn>
                </template>
              </v-data-table>

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
      todoList: [
        {
          name: "to-do list 1",
          description: "work to-do list 1",
        },
        {
          name: "to-do list 2",
          description: "work to-do list 2",
        },
      ],
      showNewTodoList: false,
      dialog: false,
      todoTableHeaders: [
        {
          text: "Name",
          align: "start",
          sortable: false,
          value: "name",
        },
        { text: "Description", value: "description" },
        { text: 'Action', value: 'actions', sortable: false },
      ],
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
      alert("Create new To-do List");
    },
    showNewTodoListPopup() {
      this.showNewTodoList = true;
      alert("Create new To-do List");
    },
  },
  created() {},

  mounted() {},

  computed: {},

  watch: {},
};
</script>

<style scoped>
</style>
