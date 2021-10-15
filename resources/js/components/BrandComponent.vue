<template>
	<div class="row layout-top-spacing mb-4">
		<div class="col-lg-12 my-3">
			<div class="card">
				<div class="card-header">
					<div class="row" style="display: flex; align-items: center;">
						<div class="col">
							<h5 class="card-title">Actions and Overview ({{warehouse_name}})</h5>
						</div>
						<div class="col">
							<button
								v-show="super_admin"
								class="btn btn-danger mx-1 mt-2 float-right"
								@click="changeWarehouse"
							>Change Warehouse</button>
							<button  v-if="$can('product_management_create')" class="btn btn-success mx-1 mt-2 float-right" @click="newModal">Add Brand</button>
						</div>
					</div>
				</div>
				<div class="card-body">
					<!-- <h5 class="card-title">Actions and Overview ({{warehouse_name}}) </h5> -->
					<div class="row pt-3">
						<div class="col-lg-12">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-condensed mb-4">
									<thead>
										<tr>
											<th>Id</th>
											<th>Name</th>
											<th>Created Date</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(brand, index) in brand_list" :key="index">
											<td>{{brand.id}}</td>
											<td>{{brand.name}}</td>
											<td>{{brand.created_at| myDate }}</td>
											<td style="vertical-align: middle; text-align: center;">
												<i v-if="$can('product_management_update')"  class="fas fa-edit text-primary mx-1" style="cursor:pointer;" @click="editModal(brand)">												
												</i>
												<i v-if="$can('product_management_delete')"  class="fas fa-trash text-danger mx-1" style="cursor:pointer;" @click="deleteBrand(brand)">											
												</i>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal Add Brand -->
			<div
				class="modal fade"
				id="addBrand"
				tabindex="-1"
				role="dialog"
				aria-labelledby="addBrandTitle"
				aria-hidden="true"
			>
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<form @submit.prevent="createEditBrand">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">{{form_title}}</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="form-group">
									<label>Brand Name</label>
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
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">{{form_type}}</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- End Modal -->

			<!-- Modal Select Warehouse -->
			<div
				class="modal fade"
				id="warehouses"
				tabindex="-1"
				role="dialog"
				aria-labelledby="warehousesTitle"
				aria-hidden="true"
				data-keyboard="false"
				data-backdrop="static"
			>
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">{{warehouse_model_name}}</h5>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label>Please select a warehouset</label>
								<select class="form-control" v-model="warehouse">
									<option
										v-for="(wh, index) in warehouse_list"
										v-bind:value="wh.id"
										:key="index"
									>{{wh.name}} ({{wh.location}})</option>
								</select>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" @click="assignWarehouse">Select</button>
						</div>
					</div>
				</div>
			</div>
			<!-- End Modal -->
		</div>
	</div>
</template>

<script>
export default {
	props: ["warehouse_id", "super_admin"],
	mounted() {
		if (sessionStorage.warehouse) {
			this.warehouse = sessionStorage.warehouse;
			this.getBrandList();
			this.getWarehouseName();
		}
		this.getWarehouseList();
		this.checkWarehouse();
	},
	watch: {
		warehouse(newValue) {
			sessionStorage.warehouse = newValue;
		},
	},
	data() {
		return {
			warehouse: this.warehouse_id,
			warehouse_name: "",
			warehouse_list: "",
			warehouse_model_name: "",

			brand_list: "",
			brand_id: "",

			form_title: "",
			form_type: "",
			form: new Form({
				name: "",
				warehouse_id: "",
			}),
		};
	},

	methods: {
		checkWarehouse: function () {
			if (this.warehouse == 0) {
				this.getWarehouseList();
				this.warehouse_model_name = "Warehouse unassigned!";
				$("#warehouses").modal("show");
			} else {
				this.getWarehouseName();
				this.getBrandList();
			}
		},
		changeWarehouse: function () {
			this.warehouse_model_name = "Change Warehouse?";
			$("#warehouses").modal("show");
		},
		getWarehouseName: function () {
			if (this.warehouse != 0) {
				axios
					.get("/api/warehouse/" + this.warehouse)
					.then((response) => {
						this.warehouse_name = response.data.name;
						// console.log(response);
					})
					.catch((error) => {
						console.log(error);
					});
			}
		},
		getWarehouseList: function () {
			axios
				.get("/api/warehouse")
				.then((response) => {
					this.warehouse_list = response.data;
				})
				.catch((error) => {
					console.log(error);
				});
		},
		assignWarehouse: function () {
			if (this.warehouse != 0) {
				this.form.warehouse_id = this.warehouse;
				this.getWarehouseName();
				this.getBrandList();
				$("#warehouses").modal("hide");
			} else {
				Toast.fire({
					icon: "warning",
					title: "Cannot continue without warehouse",
				});
			}
		},
		getBrandList: function () {
			axios
				.get("/api/brand/warehouse/" + this.warehouse)
				.then((response) => {
					this.brand_list = response.data;
					// console.log(response);
				})
				.catch((error) => {
					console.log(error);
				});
		},
		createEditBrand: function () {
			if (this.form_type == "Create") {
				this.addNewBrand();
			} else if (this.form_type == "Edit") {
				this.editBrand();
			}
		},
		newModal: function () {
			this.form_title = "Add New Brand";
			this.form_type = "Create";
			this.form.reset();
			this.form.clear();
			this.form.warehouse_id = this.warehouse;
			$("#addBrand").modal("show");
		},
		editModal: function (brand) {
			this.form_title = "Edit Brand";
			this.form_type = "Edit";
			this.brand_id = brand.id;
			this.form.reset();
			this.form.clear();
			this.form.fill(brand);
			this.form.warehouse_id = this.warehouse;
			$("#addBrand").modal("show");
		},
		addNewBrand: async function () {
			try {
				const response = await this.form.post("/api/brand");
				if (response.status == 200) {
					Toast.fire({
						icon: "success",
						title: "Brand Added",
					});
					$("#addBrand").modal("hide");
					this.getBrandList();
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
				this.getBrandList();
			}
		},
		editBrand: async function () {
			try {
				const response = await this.form.patch("/api/brand/" + this.brand_id);
				if (response.status == 200) {
					Toast.fire({
						icon: "success",
						title: "Brand Updated",
					});
					$("#addBrand").modal("hide");
					this.getBrandList();
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
				this.getBrandList();
			}
		},
		deleteBrand: function (brand) {
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
							.delete("/api/brand/" + brand.id)
							.then((response) => {
								if (response.status == 200) {
									swal.fire(
										"Deleted!",
										"Your file has been deleted.",
										"success"
									);
									this.getBrandList();
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
