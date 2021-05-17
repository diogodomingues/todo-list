<template>
  <div id="app" data-app>
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
                        <v-icon dark right> mdi-plus </v-icon>
                        To-do List
                      </v-btn>
                    </v-card>
                  </v-col>
                </v-row>
              </v-container>
              <br />

              <v-dialog v-model="dialog" max-width="500">
                <v-card>
                  <v-card-title class="headline grey lighten-2">
                    New To-do List
                  </v-card-title>
                  <v-card-text>
                    <v-form ref="form" v-model="valid" lazy-validation
                      ><v-text-field
                        v-model="name"
                        :rules="nameRules"
                        label="Name"
                        required
                      ></v-text-field>

                      <v-text-field
                        v-model="description"
                        :rules="descriptionRules"
                        label="Description"
                        required
                      ></v-text-field>
                    </v-form>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="createNewTodoList()">
                      Save
                    </v-btn>
                    <v-btn color="primary" text @click="dialog = false">
                      Cancel
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>

              <v-dialog v-model="deleteDialog" max-width="400">
                <v-card>
                  <v-card-title class="headline grey lighten-2">
                    Delete To-do List
                  </v-card-title>
                  <v-card-text>
                    <p>
                      Do you want to delete To-do List {{ deleteItem.name }}
                    </p>
                    <p>
                      <strong
                        >This action will also delete all tasks inside To-do
                        List</strong
                      >
                    </p>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="deleteTodoListAction()">
                      <v-icon dark right> mdi-check </v-icon>
                    </v-btn>
                    <v-btn color="primary" text @click="deleteDialog = false">
                      <v-icon dark right> mdi-close </v-icon>
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>

              <v-snackbar
                v-model="showSuccessMessage"
                color="success"
                top
                centered
                :timeout="2000"
              >
                <v-icon dark> mdi-check-outline</v-icon>
                {{ sucessMessage }}
              </v-snackbar>

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
                      <v-icon dark> mdi-pencil </v-icon>
                      Tasks
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn
                      text
                      @click="deleteTodoList(item)"
                      class="ma-2"
                      outlined
                      color="indigo"
                      small
                    >
                      <v-icon dark> mdi-delete </v-icon>
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
  props: ["userdetails"],

  components: {},
  data: function () {
    return {
      baseUrl: "http://127.0.0.1:8000",
      todoList: [],
      showSuccessMessage: false,
      dialog: false,
      deleteDialog: false,
      loggedUser: {},
      valid: true,
      name: "",
      description: "",
      nameRules: [
        (v) => !!v || "Name is required",
        (v) => (v && v.length >= 3) || "Name must be at least 3 characters",
      ],
      descriptionRules: [
        (v) => !!v || "Description is required",
        (v) =>
          (v && v.length >= 10) || "Description must be at least 10 characters",
      ],
      sucessMessage: "",
      deleteItem: {},
    };
  },
  methods: {
    getTodoListByClient(userId) {
      let that = this;
      axios({
        method: "get",
        url: this.baseUrl + "/todolist/by-user",
        params: {
          userId: userId,
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
      let that = this;

      axios({
        method: "post",
        url: this.baseUrl + "/todolist/create",
        data: {
          userId: this.loggedUser.id,
          name: this.name,
          description: this.description,
        },
      })
        .then(function (res) {
          if (res.status == 200 || res.status == 201) {
            that.sucessMessage = "New To-do List added.";
            that.showSuccessMessage = true;
            that.todoList.push(res.data);
            that.dialog = false;
          }
        })
        .catch(function (error) {});
    },

    deleteTodoList(item) {
      this.deleteDialog = true;
      this.deleteItem = item;
    },

    deleteTodoListAction() {
      let that = this;

      axios({
        method: "delete",
        url: this.baseUrl + "/todolist/delete/" + this.deleteItem.id,
      })
        .then(function (res) {
          if (res.status == 200 || res.status == 201) {
            that.sucessMessage = "To-do List deleted.";
            that.showSuccessMessage = true;
            //close popup
            that.deleteDialog = false;
            //remove to-do list element from display
            that.removeTodoFromDisplay(that.deleteItem);
            //reset object
            that.deleteItem = {};
          }
        })
        .catch(function (error) {});
    },

    showNewTodoListPopup() {
      //clear fields data
      this.name = "";
      this.description = "";
      //display popup
      this.dialog = true;
    },

    getTasksByTodoList(item) {
      // alert("View Tasks");
      console.log(item);
      this.$router.push('tasks');
    },

    removeTodoFromDisplay(item) {
      //get index from item
      let index = this.todoList.findIndex(x => x.id == item.id);
      if (index > -1) {
        //remove deleted item from being displayed
        this.todoList.splice(index, 1);
      }
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
