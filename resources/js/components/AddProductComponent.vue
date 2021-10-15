<template>
    <div>
        <br/><br/>
        <div class="container">
            <div class="card">
  <div class="card-body">
    <h1>Add Todo</h1>
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
      <input type="text" class="form-control" v-model="todo.dtask" required placeholder="Enter Daily Task">
    </div>
    <div class="col">
         <label for="exampleInputPassword1">Date</label>
      <input type="text" class="form-control" v-model="todo.date" required placeholder="Day/month/year">
    </div>
  </div><br/>
  <button type="submit" @click="to_do()" class="btn btn-primary">Add </button>
   <button type="button" @click="todo_reset()"  class="btn btn-outline-primary">Reset</button>
</form>
<br><br>


    </div>
</div>
    <br><br>

    <br><br>

        </div>
    </div>
</template>


<script>
export default {

     data() {
         return {
             todo: new Form({
                id:"",
                uname:"",
                ename:"",
                dtask:"",
                date:"",
             }),


         };
     },
    //  created() {
    //     //  this.lodash();
    //     this.get_todo();
    // },




     methods:{

        to_do() {
             this.todo.post("/api/add_todo")
             .then((response) => {
               if(response.status == 200){
                  this.$toaster.success("Craeated Successs");
                  this.todo.reset();
               }
             })
             .catch((error)=>{
               console.log(error);
             });
         },

         todo_reset() {
             this.todo.reset();
         },


     }

}


</script>
