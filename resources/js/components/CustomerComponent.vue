<template>
	<div class="row layout-top-spacing">
		<div class="col-lg-12">
			<div class="card component-card_1">
				<div class="card-body">
					<h5 class="card-title">Add Credit Customer</h5>
					<div class="col-lg-12 mt-4">
						<form method="POST" @submit.prevent="submitForm">
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group mb-4">
										<label for="name">Customer Name</label>
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
									<div class="form-group mb-4">
										<label for="address">Address</label>
										<input
											v-model="form.address"
											type="text"
											name="address"
											class="form-control"
											:class="{ 'is-invalid': form.errors.has('address') }"
										/>
										<has-error :form="form" field="address"></has-error>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="form-group mb-4">
										<label for="nic_no">NIC NO</label>
										<input
											v-model="form.nic_no"
											type="text"
											name="nic_no"
											class="form-control"
											:class="{ 'is-invalid': form.errors.has('nic_no') }"
										/>
										<has-error :form="form" field="nic_no"></has-error>
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group mb-4">
										<label for="phone">Phone</label>
										<input
											v-model="form.phone"
											type="text"
											name="phone"
											class="form-control"
											:class="{ 'is-invalid': form.errors.has('phone') }"
										/>
										<has-error :form="form" field="phone"></has-error>
									</div>
								</div>
					
							</div>

							<div class="float-right">
								<button type="submit" id="add_product" class="btn btn-primary mt-2">Add</button>
								<button type="reset" class="btn btn-danger mt-2">Reset</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12 mt-3 mb-5">
			<div class="card component-card_1">
				<div class="card-body">
					<h5 class="card-title">Credit Customer Overview</h5>
					<div class="row pt-3">
						<div class="col-lg-12">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-condensed mb-4">
									<thead>
										<tr>
											<th>ID</th>
											<th>Name</th>
											<th>Address</th>
											<th>Phone</th>
											<th>NIC</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(customer) in this.customers.data" :key="customer.id">
											<td>{{customer.id}}</td>
											<td>{{customer.name}}</td>
											<td>{{customer.address}}</td>
											<td>{{customer.phone}}</td>
											<td>{{customer.nic_no}}</td>
											<td style="text-align:center">
												<i
													@click="showEditModal(customer)"
													class="fas fa-edit mx-1 text-primary"
													style="cursor:pointer;"
												></i>
												<i
													@click="deleteCustomer(customer)"
													class="fas fa-trash mx-1 text-danger"
													style="cursor:pointer;"
												></i>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer" v-show="show_table_footer">
					<pagination :data="customers" @pagination-change-page="getCustomerList"></pagination>
				</div>
			</div>
		</div>

		<!-- Update Modal -->
		<div
			class="modal fade"
			id="editUserModal"
			tabindex="-1"
			role="dialog"
			aria-labelledby="editUserModalTitle"
			aria-hidden="true"
		>
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Edit Customer Details</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form @submit.prevent="updateCustomer">
							<div class="form-group">
								<label>Name</label>
								<input
									v-model="uform.name"
									type="text"
									name="name"
									class="form-control"
									:class="{ 'is-invalid': uform.errors.has('name') }"
								/>
								<has-error :form="uform" field="name"></has-error>
							</div>

							<div class="form-group">
								<label>Address</label>
								<input
									v-model="uform.address"
									type="address"
									name="address"
									class="form-control"
									:class="{ 'is-invalid': uform.errors.has('address') }"
								/>
								<has-error :form="uform" field="address"></has-error>
							</div>

							<div class="form-group">
								<label>Phone</label>
								<input
									v-model="uform.phone"
									type="phone"
									name="phone"
									class="form-control"
									:class="{ 'is-invalid': uform.errors.has('phone') }"
								/>
								<has-error :form="uform" field="phone"></has-error>
							</div>

							<div class="form-group">
								<label>NIC NO</label>
								<input
									v-model="uform.nic_no"
									type="text"
									name="nic_no"
									class="form-control"
									:class="{ 'is-invalid': uform.errors.has('nic_no') }"
								/>
								<has-error :form="uform" field="nic_no"></has-error>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button :disabled="form.busy" type="submit" class="btn btn-primary">Update changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- END Update Modal -->
	</div>
</template>

<script>
export default {
	mounted() {
		this.getCustomerList();
	},
	data() {
		return {
			customers: {},
			show_table_footer: false,

			form: new Form({
				name: "",
				address: "",
				phone: "",
				nic_no: "",
			}),

			//uform is the Update Form
			u_customer_id: "",
			uform: new Form({
				name: "",
				address: "",
				phone: "",
				nic_no: "",
			}),
		};
	},

	methods: {
		submitForm: async function () {
			try {
				const response = await this.form.post("/api/customer");
				if (response.status == 200) {
					Toast.fire({
						icon: "success",
						title: "Customer Added",
					});
					this.form.reset();
					this.getCustomerList();
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
		getCustomerList: function (page = 1) {
			axios
				.get("/api/customer?page=" + page)
				.then((response) => {
					this.customers = response.data;

					let per_page = response.data.per_page;
					let total = response.data.total;

					if (Number(total) > Number(per_page)) {
						this.show_table_footer = true;
					}
				})
				.catch((error) => {
					console.log(error);
				});
		},
		showEditModal: function (customer) {
			this.uform.reset();
			this.uform.fill(customer);
			this.u_customer_id = customer.id;
			$("#editUserModal").modal("show");
		},
		updateCustomer: async function () {
			try {

				const response = await this.uform.patch('/api/customer/' + this.u_customer_id);
				if (response.status == 200) {
					Toast.fire({
						icon: "success",
						title: "Customer Details Updated",
					});
					this.uform.reset();
					$("#editUserModal").modal("hide");
					this.getCustomerList();
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
		deleteCustomer: function (customer) {
			swal
				.fire({
					title: "Are you sure?",
					text: "You won't be able to revert this!",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Yes, delete it!",
				})
				.then((result) => {
					if (result.value) {
						axios
							.delete("/api/customer/" + customer.id)
							.then((response) => {
								if (response.status == 200) {
									swal.fire("Deleted!", "Successfully deleted.", "success");
									this.getCustomerList();
								}
							})
							.catch((error) => {
								console.log(error);
							});
					}
				});
		},
	},
};
</script>
