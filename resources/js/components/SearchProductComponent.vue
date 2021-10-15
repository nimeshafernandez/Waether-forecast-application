<template>
<div>
    <br/><br/>
<div class="container">
   <div class="card">
  <div class="card-body">
    <form class="form-inline" @submit.prevent>
  <div class="form-group mx-sm-3 mb-2">
    <label for="inputPassword2" class="sr-only">Search</label>
    <input type="text" class="form-control" id="inputPassword2" v-model="serach_data" placeholder="Search Here">
  </div>
  <button type="submit" @click="search_data()" class="btn btn-primary mb-2">Search Now</button>
</form>
  </div>

    <div class="card">

<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">User Name</th>
      <th scope="col">Event</th>
      <th scope="col">Daily Task</th>
      <th scope="col">Date</th>
      <th>Action</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(data,index) in  todo_data" :key="index">
      <th>{{data.User_Name}}</th>
      <td>{{data.Event_Name}}</td>
      <td>{{data.Daily_Task}}</td>
      <td>{{data.Date}}</td>
      <td><button type="button" @click="updateModal(data)" class="btn btn-outline-success" data-toggle="modal" data-target="#update_modal" data-whatever="@fat">Update</button></td>
      <td>
          <button type="button"  @click="delete_row_modal(data)" class="btn btn-danger" data-toggle="modal" data-target="#">
          Delete
         </button>
      </td>
    </tr>
  </tbody>
</table>
    </div>
        <!--delete modal start-->
    <!-- Modal -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>Are Your Sure?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
        <button type="button" @click="delete_todo()" class="btn btn-primary">Delete</button>
      </div>
    </div>
  </div>
 </div>
 <!--update modal -->
 <div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="Add_New_Data" id="exampleModalLabel">Add New Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form @submit.prevent>
  <div class="row">
    <div class="col">
         <label for="exampleInputEmail1">User Name</label>
      <input type="text" class="form-control" v-model="todo.uname" required placeholder="Enter User Name">
    </div>
    <div class="col">
         <label for="exampleInputPassword1">Event</label>
      <input type="text" class="form-control" v-model="todo.ename" required placeholder="Enter Event Name">
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col">
        <label for="exampleInputPassword1">Daily Task</label>
      <input type="text" class="form-control" v-model="todo.dtask"  required placeholder="Enter Daily Task">
    </div>
    <div class="col">
         <label for="exampleInputPassword1">Date</label>
      <input type="text" class="form-control" v-model="todo.date"  required placeholder="Day/month/year">
    </div>
  </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
        <button type="button"  @click="update_todo()" class="btn btn-primary">Save </button>
      </div>
    </div>
  </div>
</div>
</div>
<!-- update modal -->

</div>
<!--delete modal end-->



</div>
</template>


<script>

export default {

   data() {
         return {
             todo_data: {},

             serach_data: "",

            todo:new Form({
                uname:"",
                ename:"",
                dtask:"",
                date:"",
             }),

             todo_id: "",
         };
     },


     created() {
        //  this.lodash();
        this.get_todo();
    },

 methods:{
     get_todo() {
             axios.get("/api/get_todo_data")
                .then((response)=>{
                if(response.status == 200){
                    this.todo_data = response.data;
                }
            })
            .catch((error)=>{
                console.log(error);
            });
         },

         search_data() {
                axios
                .get("/api/search_todo_data/" + this.serach_data)
                .then(response => {
                    if (response.status == 200) {
                        this.todo_data = response.data;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
         },

         delete_row_modal: function(data) {
              this.todo_id = data.id;
              $("#delete_modal").modal("show");
              this.todo.fill(data);
         },

         update_modal: function(data) {
              this.todo_id = data.id;
              $("#update_modal").modal("show");
              this.todo.fill(data);

         },



        delete_todo: function() {
            this.todo
                .delete("/api/delete_todo/" + this.todo_id)
                .then(response => {
                    if (response.status == 200) {
                        this.$toaster.info("delete Successs");
                        this.todo_data = response.data;
                    }
                    this.get_todo();
                    $("#delete_modal").modal("hide");
                })
                .catch(error => {
                    console.log(error);
                });
        },

        update_todo() {
            this.todo
                .patch("/api/update_todo/" + this.todo_id)
                .then(response => {
                    if (response.status == 200) {
                        this.$toaster.info("Update Successs");
                        this.todo_data = response.data;
                    }
                    this.get_todo();
                    this.todo.reset();
                    $("#user_modal").modal("hide");
                })
                .catch(error => {
                    console.log(error);
                });
        },



        },

}
</script>

<style scoped>


</style>
