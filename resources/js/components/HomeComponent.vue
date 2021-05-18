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
                  <v-col align="end">
                    <v-spacer></v-spacer>
                    <v-btn
                      v-on:click="showNewTodoListPopup"
                      class="ma-2"
                      outlined
                      color="indigo"
                    >
                      <v-icon dark right> mdi-plus </v-icon>
                      &nbsp; To-do List
                    </v-btn>
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
                      <v-icon dark right> mdi-check </v-icon>
                    </v-btn>
                    <v-btn color="primary" text @click="dialog = false">
                      <v-icon dark right> mdi-close </v-icon>
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>

              <v-dialog v-model="editDialog" max-width="500">
                <v-card>
                  <v-card-title class="headline grey lighten-2">
                    Edit Task
                  </v-card-title>
                  <v-card-text>
                    <v-form ref="form" v-model="valid" lazy-validation
                      ><v-text-field
                        v-model="editTaskItem.title"
                        :rules="nameRules"
                        label="title"
                        required
                      ></v-text-field>

                      <v-text-field
                        v-model="editTaskItem.description"
                        :rules="descriptionRules"
                        label="Description"
                        required
                      ></v-text-field>

                      <v-select
                        v-model="editTaskItem.status_id"
                        item-text="code"
                        item-value="id"
                        :items="taskStatus"
                        label="Status"
                      ></v-select>
                    </v-form>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="updateTask()">
                      <v-icon dark right> mdi-check </v-icon>
                    </v-btn>
                    <v-btn color="primary" text @click="editDialog = false">
                      <v-icon dark right> mdi-close </v-icon>
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>

              <v-dialog v-model="createTaskDialog" max-width="500">
                <v-card>
                  <v-card-title class="headline grey lighten-2">
                    Create Task
                  </v-card-title>
                  <v-card-text>
                    <v-form ref="form" v-model="valid" lazy-validation
                      ><v-text-field
                        v-model="createTaskItem.title"
                        :rules="nameRules"
                        label="Title"
                        required
                      ></v-text-field>

                      <v-text-field
                        v-model="createTaskItem.description"
                        :rules="descriptionRules"
                        label="Description"
                        required
                      ></v-text-field>
                    </v-form>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="createNewTask()">
                      <v-icon dark right> mdi-check </v-icon>
                    </v-btn>
                    <v-btn
                      color="primary"
                      text
                      @click="createTaskDialog = false"
                    >
                      <v-icon dark right> mdi-close </v-icon>
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

              <v-dialog v-model="deleteDialogTask" max-width="400">
                <v-card>
                  <v-card-title class="headline grey lighten-2">
                    Delete Task
                  </v-card-title>
                  <v-card-text>
                    <p>Do you want to delete Task {{ deleteTaskItem.title }}</p>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="removeTask()">
                      <v-icon dark right> mdi-check </v-icon>
                    </v-btn>
                    <v-btn
                      color="primary"
                      text
                      @click="deleteDialogTask = false"
                    >
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

              <v-row no-gutters align="center"> 
                <ul v-for="(item, index) in todoList">
                  <v-col align-self="center" align="center">
                    <v-card outlined width="200">
                      <v-card-title>{{ item.name }}</v-card-title>
                      <v-card-text>{{ item.description }}</v-card-text>
                      <v-card-actions>
                        <v-btn
                          bottom
                          @click="tasksByTodoList(item)"
                          class="ma-2"
                          outlined
                          color="indigo"
                          small
                        >
                          <v-icon dark>
                            mdi-format-list-bulleted-square
                          </v-icon>
                        </v-btn>
                        <v-spacer></v-spacer>
                        <v-btn
                          text
                          @click="deleteTodoList(item)"
                          class="ma-2"
                          outlined
                          color="indigo"
                          small
                          fab
                        >
                          <v-icon dark> mdi-delete </v-icon>
                        </v-btn>
                      </v-card-actions>
                      <br />
                    </v-card>
                  </v-col>
                </ul>
              </v-row>

              <v-row no-gutters>
                <v-col align-self="center">
                  <v-card class="" max-width="600">
                    <v-card-title> Tasks </v-card-title>
                    <v-card-subtitle>
                      To-do List {{ selectedTodoList.name }}</v-card-subtitle
                    >
                    <v-card-actions>
                      <v-spacer></v-spacer>

                      <v-btn icon @click="showTasksCard = !showTasksCard">
                        <v-icon>{{
                          showTasksCard ? "mdi-chevron-up" : "mdi-chevron-down"
                        }}</v-icon>
                      </v-btn>
                    </v-card-actions>
                    <v-expand-transition>
                      <div v-show="showTasksCard">
                        <v-divider></v-divider>
                        <v-card-text>
                          <v-data-table
                            :headers="tableHeaders"
                            :items="tasksList"
                          >
                            <template v-slot:top>
                              <v-toolbar flat>
                                <v-toolbar-title></v-toolbar-title>
                                <v-spacer></v-spacer>
                                <v-btn
                                  color="primary"
                                  dark
                                  class="mb-2"
                                  v-on:click="showCreateNewTask()"
                                >
                                  New Task
                                </v-btn>
                              </v-toolbar>
                            </template>
                            <template v-slot:item.actions="{ item }">
                              <v-icon
                                small
                                class="mr-2"
                                @click="editTask(item)"
                              >
                                mdi-pencil
                              </v-icon>
                              <v-icon small @click="deleteTask(item)">
                                mdi-delete
                              </v-icon>
                            </template>
                          </v-data-table>
                        </v-card-text>
                      </div>
                    </v-expand-transition>
                  </v-card>
                </v-col>
              </v-row>
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
      tasksList: [],
      showSuccessMessage: false,
      dialog: false,
      deleteDialog: false,
      deleteDialogTask: false,
      createTaskDialog: false,
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
      showTodoListCard: false,
      showTasksCard: false,
      tableHeaders: [
        { text: "Title", value: "title" },
        { text: "Description", value: "description" },
        { text: "Status", value: "status.code" },
        { text: "Actions", value: "actions" },
      ],
      selectedTodoList: {},
      createTaskItem: {},
      editTaskItem: {},
      deleteTaskItem: {},
      editDialog: false,
      taskStatus: [],
    };
  },
  methods: {
    getTasksStatus() {
      let that = this;
      axios({
        method: "get",
        url: this.baseUrl + "/tasks/status/all",
      })
        .then(function (res) {
          if (res.status == 200) {
            that.taskStatus = res.data;
          }
        })
        .catch(function (err) {
          console.log(err);
        });
    },

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
          if (res.status == 200) {
            that.sucessMessage = "To-do List deleted.";
            that.showSuccessMessage = true;
            //close popup
            that.deleteDialog = false;
            //close datatable view
            that.showTasksCard = false;
            //clear tasks from datatable
            that.tasksList = [];
            //remove to-do list element from display
            that.removeTodoFromDisplay(that.deleteItem);
            //reset object
            that.deleteItem = {};
          }
        })
        .catch(function (error) {});
    },

    getTasksByTodoList(item) {
      let that = this;
      axios({
        method: "get",
        url: this.baseUrl + "/tasks/by-todo-list",
        params: {
          todoId: item.id,
        },
      })
        .then(function (res) {
          if (res.status == 200) {
            that.tasksList = res.data;
          }
        })
        .catch(function (err) {
          console.log(err);
        });
    },

    editTask(item) {
      //create a new object with the same properties but different reference
      this.editTaskItem = JSON.parse(JSON.stringify(item));
      // this.editTaskItem =  item;
      this.editDialog = true;
    },

    updateTask() {
      let that = this;
      axios({
        method: "put",
        url: this.baseUrl + "/tasks/update/" + this.editTaskItem.id,
        data: {
          todoListId: this.editTaskItem.todo_list_id,
          title: this.editTaskItem.title,
          description: this.editTaskItem.description,
          statusId: this.editTaskItem.status_id,
        },
      })
        .then(function (res) {
          if (res.status == 200) {
            that.sucessMessage = "Tasks Updated";
            that.showSuccessMessage = true;
            that.editDialog = false;
            that.getTasksByTodoList(that.selectedTodoList);
          }
        })
        .catch(function (error) {
          that.sucessMessage = error.response.data;
          that.showSuccessMessage = true;
        });
    },

    deleteTask(item) {
      this.deleteDialogTask = true;
      this.deleteTaskItem = item;
    },

    removeTask() {
      let that = this;
      axios({
        method: "delete",
        url: this.baseUrl + "/tasks/delete/" + this.deleteTaskItem.id,
      })
        .then(function (res) {
          if (res.status == 200) {
            that.sucessMessage = "Task deleted.";
            that.showSuccessMessage = true;
            //close popup
            that.deleteDialogTask = false;
            //remove to-do list element from display
            that.getTasksByTodoList(that.selectedTodoList);
            //reset object
            that.deleteTaskItem = {};
          }
        })
        .catch(function (error) {});
    },

    showCreateNewTask() {
      this.createTaskDialog = true;
      this.createTaskItem = {};
    },

    createNewTask() {
      let that = this;
      axios({
        method: "post",
        url: this.baseUrl + "/tasks/create",
        data: {
          todoListId: this.selectedTodoList.id,
          title: this.createTaskItem.title,
          description: this.createTaskItem.description,
        },
      })
        .then(function (res) {
          if (res.status == 200 || res.status == 201) {
            that.sucessMessage = "New Task created.";
            that.showSuccessMessage = true;
            that.tasksList.push(res.data);
            that.createTaskDialog = false;
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

    tasksByTodoList(item) {
      this.selectedTodoList = item;
      this.showTasksCard = true;
      this.getTasksByTodoList(item);
    },

    removeTodoFromDisplay(item) {
      //get index from item
      let index = this.todoList.findIndex((x) => x.id == item.id);
      if (index > -1) {
        //remove deleted item from being displayed
        this.todoList.splice(index, 1);
      }
    },

    updateTaskFromDisplay(item) {
      let index = this.tasksList.findIndex((x) => x.id == item.id);
      if (index > -1) {
        //update task item
        this.tasksList[index] = item;
      }
    },
  },
  created() {
    //decode json
    this.loggedUser = JSON.parse(this.userdetails);

    this.getTodoListByClient(this.loggedUser.id);

    this.getTasksStatus();
  },

  mounted() {},

  computed: {},

  watch: {
  },
};
</script>

<style scoped>
</style>
