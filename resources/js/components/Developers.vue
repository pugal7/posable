<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card" v-if="$gate.isAdmin()">
              <div class="card-header">
                <h3 class="card-title">Developer List</h3>

                <div class="card-tools">
                  
                  <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                      <i class="fa fa-plus-square"></i>
                      Add New
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <button style="margin-bottom: 10px" class="btn btn-primary delete_all" @click="deleteUserNew">Delete All Selected</button>
                <table class="table table-hover">
                  <thead>
                    <tr>
                    <th>

                            <input type="checkbox" @click="select_all_via_check_box" v-model="all_select"> 

                            <span> {{ all_select == true ? 'Uncheck All' : "Select All" }} </span>
                        </th>
                      <th>ID</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <th>Phone Number</th>
                      <th>Address</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="developer in developers.data" :key="developer.id">
                     <td><input type="checkbox" v-model="deleteItems" :value="`${developer.id}`"></td>
                      <td>{{developer.id}}</td>
                      <td class="text-capitalize">{{developer.first_name}}</td>
                      <td class="text-capitalize">{{developer.last_name}}</td>
                      <td class="text-capitalize">{{developer.email}}</td>
                      <td>{{developer.phone_number}}</td>
                      <td>{{developer.address}}</td>

                      <td>

                        <a href="#" @click="editModal(developer)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="deleteUser(developer.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="developers" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>


        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Create New Developer</h5>
                    <h5 class="modal-title" v-show="editmode">Update Developers's Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- <form @submit.prevent="createUser"> -->

                <form enctype="multipart/form-data" @submit.prevent="editmode ? updateUser() : createUser()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>First Name</label>
                            <input v-model="form.first_name" type="text" name="first_name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('first_name') }">
                            <has-error :form="form" field="first_name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input v-model="form.last_name" type="text" name="last_name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('last_name') }">
                            <has-error :form="form" field="last_name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input v-model="form.email" type="text" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Phone Number</label>
                            <input v-model="form.phone_number" type="text" name="phone_number"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('phone_number') }">
                            <has-error :form="form" field="phone_number"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input v-model="form.address" type="text" name="address"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                            <has-error :form="form" field="address"></has-error>
                        </div>      
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
  </section>
</template>

<script>
    export default {
        data () {
            return {
                editmode: false,
                developers : {},
                deleteItems: [],
               select: '',
               all_select: false,
                form: new Form({
                    id : '',
                    first_name : '',
                    last_name: '',
                    email: '',
                    phone_number: '',
                    address: '',
                })
            }
        },
        methods: {

            getResults(page = 1) {

                  this.$Progress.start();
                  
                  axios.get('api/developer?page=' + page).then(({ data }) => (this.developers = data.data));

                  this.$Progress.finish();
            },
            updateUser(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/developer/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });
                    this.$Progress.finish();
                        //  Fire.$emit('AfterCreate');

                    this.loadUsers();
                })
                .catch(() => {
                    this.$Progress.fail();
                });

            },
            editModal(user){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(user);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteUser(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {

                        // Send request to the server
                         if (result.value) {
                                this.form.delete('api/developer/'+id).then(()=>{
                                        Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        );
                                    // Fire.$emit('AfterCreate');
                                    this.loadUsers();
                                }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                         }
                    })
            },
            deleteUserNew(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {

                        // Send request to the server
                         if (result.value) {
                                this.form.delete('api/developer/'+this.deleteItems).then(()=>{
                                        Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        );
                                    // Fire.$emit('AfterCreate');
                                    this.loadUsers();
                                }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                         }
                    })
            },
            select_all_via_check_box(){
                console.log(this.developers);
                if(this.all_select == false){
                    this.all_select = true
                    this.developers.data.forEach(developer => {
                      this.deleteItems.push(developer.id)
                    });
                }else{
                    this.all_select = false
                    this.deleteItems = []
                }
            },
          loadUsers(){
            this.$Progress.start();

            if(this.$gate.isAdmin()){
              axios.get("api/developer").then(({ data }) => (this.developers = data.data));
            }

            this.$Progress.finish();
          },
          
          createUser(){

              this.form.post('api/developer')
              .then((response)=>{
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: response.data.message
                  });

                  this.$Progress.finish();
                  this.loadUsers();

              })
              .catch(()=>{

                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });
              })
          }

        },
        mounted() {
            console.log('Developer Component mounted.')
        },
        created() {

            this.$Progress.start();
            this.loadUsers();
            this.$Progress.finish();
        }
    }
</script>
