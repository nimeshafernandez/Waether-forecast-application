<template>
	<div>
		<div class="row">
			<div class="col-lg-12">
				<button type="button" class="btn btn-primary btn-lg btn-block" @click="showModal">
					<i class="fa fa-edit mx-2"></i>Edit User
				</button>
			</div>			
		</div>
		<!-- Modal -->
		<div
			class="modal fade bd-editUserTitle-modal-lg"
			id="editUser"
			tabindex="-1"
			role="dialog"
			aria-labelledby="editUserTitle"
			aria-hidden="true"
		>
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<form @submit.prevent="submitForm">
						<div class="modal-header">
							<h5 class="modal-title">Edit User</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group mb-4">
											<label for="warehouse_id">Warehouse</label>
											<select
												class="form-control"
												v-model="form.warehouse_id"
												:class="{ 'is-invalid': form.errors.has('warehouse_id') }"
											>
												<option
													v-for="(warehouse, index) in warehouse_list"
													v-bind:value="warehouse.id"
													:key="index"
												>{{warehouse.name}}</option>
											</select>
											<has-error :form="form" field="warehouse_id"></has-error>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group mb-4">
											<label for="role_id">User Role</label>
											<select
												class="form-control"
												v-model="form.role_id"
												:class="{ 'is-invalid': form.errors.has('role_id') }"
											>
												<option
													v-for="(role, index) in role_list"
													v-bind:value="role.id"
													:key="index"
												>{{role.name}}</option>
											</select>
											<has-error :form="form" field="role_id"></has-error>
										</div>
									</div>
								</div>
								<hr />

								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label>Name</label>
											<input
												v-model="form.name"
												type="text"
												name="name"
												class="form-control"
												:class="{ 'is-invalid': form.errors.has('name') }"
											/>
											<has-error :form="form" field="name"></has-error>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label>Username</label>
											<input
												v-model="form.username"
												type="text"
												name="username"
												class="form-control"
												:class="{ 'is-invalid': form.errors.has('username') }"
											/>
											<has-error :form="form" field="username"></has-error>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label>Email</label>
											<input
												v-model="form.email"
												type="text"
												name="email"
												class="form-control"
												:class="{ 'is-invalid': form.errors.has('email') }"
											/>
											<has-error :form="form" field="email"></has-error>
										</div>
									</div>
								</div>

								<hr />

								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label>Password</label>
											<input
												v-model="form.password"
												type="password"
												name="password"
												class="form-control"
												:class="{ 'is-invalid': form.errors.has('password') }"
											/>
											<has-error :form="form" field="password"></has-error>
										</div>
									</div>

									<div class="col-lg-6">
										<div class="form-group">
											<label>Confirm Password</label>
											<input
												v-model="form.password_confirmation"
												type="password"
												name="password_confirmation"
												class="form-control"
											/>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Update Details</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- End Modal -->
	</div>
</template>

<script>
export default {
	props: ["user_id", "logged_user_id", "current_role_id"],
	mounted() {
		this.onMountFunctions();
	},
	data() {
		return {
			role_list: "",
			warehouse_list: "",

			form: new Form({
				name: "",
				username: "",
				email: "",
				password: "",
				warehouse_id: "",
				role_id: "",
				password: "",
				password_confirmation: "",
			}),
		};
	},

	methods: {
		onMountFunctions: function () {
			this.getRoleList();
			this.getUserDetails();
			this.getWarehouseList();
		},
		showModal: function () {
			$("#editUser").modal("show");
		},
		submitForm: async function () {
			try {
				const response = this.form.patch("/api/user/" + this.user_id);
				
				if (response.status == 200) {
					Toast.fire({
						icon: "success",
						title: "User Updated",
					});
					// window.location.href = "/user";
				}
			} catch (e) {
				let errors = e.response.data.errors;
				let myerror = "";
				for (let i in errors) {
					myerror += " " + errors[i];
				}
				console.log(myerror);
				Toast.fire({
					icon: "error",
					title: myerror,
				});
			}
		},	
		getUserDetails: async function () {
			try {
				const response = await axios.get("/api/user/" + this.user_id);

				if (response.status == 200) {
					this.form.fill(response.data);
				}
			} catch (error) {
				console.log(error);
			}
		},
		getRoleList: async function () {
			try {
				const response = await axios.get(
					"/api/role/get/user/" + this.logged_user_id
				);
				if (response.status == 200) {
					this.role_list = response.data;
					this.form.role_id = this.current_role_id[0];
				}
			} catch (error) {
				console.log(error);
			}
		},
		getWarehouseList: async function () {
			try {
				const response = await axios.get("/api/warehouse");
				if (response.status == 200) {
					this.warehouse_list = response.data;
				}
			} catch (error) {
				console.log(error);
			}
		},
	},
};
</script>
