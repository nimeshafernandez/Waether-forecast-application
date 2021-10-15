<template>
	<div>
		<div class="row layout-top-spacing mb-4">
			<div class="col-lg-12 mb-3">
				<div class="card component-card_1">
					<div class="card-header">
						<div class="row" style="display: flex; align-items: center;">
							<div class="col">
								<h5 class="card-title">New Stock Arrivals Note ({{warehouse_name}})</h5>
							</div>
							<div class="col">
								<button
									v-show="super_admin"
									class="btn btn-danger mx-1 mt-2 float-right"
									@click="changeWarehouse"
								>Change Warehouse</button>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="col-lg-12">
							<form>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group mb-4">
											<label for="formGroupExampleInput">Supplier Name</label>
											<multiselect
												v-model="selected_supplier"
												:options="supplier_list"
												:options-limit="max_dropdown"
												:custom-label="customLabel"
												:allow-empty="false"
												@input="getSelectedSupplierId"
											></multiselect>
											<has-error :form="form" field="supplier_id"></has-error>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group mb-4">
											<label for="formGroupExampleInput">Invoice ID</label>
											<input
												type="text"
												class="form-control"
												v-model="txt_invoice"
												placeholder="Invoice ID"
												name="invoice"
												:class="{ 'is-invalid': form.errors.has('invoice') }"
											/>
											<has-error :form="form" field="invoice"></has-error>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-12">
				<div class="card component-card_1">
					<div class="card-body">
						<h5 class="card-title"></h5>
						<div class="col-lg-12">
							<form @submit.prevent="addProduct">
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group mb-4">
											<label for="formGroupExampleInput">Product Name</label>
											<multiselect
												v-model="selected_product"
												:options="product_list"
												:custom-label="customLavelSinhala"
												:allow-empty="false"
												:options-limit="max_dropdown"
												@input="getSelectedProductId"
											></multiselect>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group mb-4">
											<label for="formGroupExampleInput">{{changeUnitCost}}</label>
											<input
												type="text"
												class="form-control"
												placeholder="Unit Cost"
												v-model="txt_unit_cost"
												required
											/>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group mb-4">
											<label for="formGroupExampleInput">Quantity</label>
											<input
												type="text"
												class="form-control"
												placeholder="Quantity"
												v-model="txt_qty"
												required
											/>
										</div>
									</div>

									<div class="col-lg-4">
										<div class="form-group mb-4">
											<label for="formGroupExampleInput">Expiry Date</label>
											<input type="Date" class="form-control" v-model="txt_exp_date" />
										</div>
									</div>

									<div class="col-lg-8">
										<div class="form-group mb-4">
											<label for="formGroupExampleInput">Barcode</label>
											<input type="text" class="form-control" placeholder="Barcode" v-model="txt_barcode" />
										</div>
									</div>
									<div class="col-lg-3">
										<button type="submit" class="form-control btn btn-success mt-4">Add</button>
									</div>
								</div>
								<hr />
							</form>
							<div class="row mt-5">
								<div class="col-lg-12 layout-spacing">
									<div class="statbox widget box box-shadow">
										<div class="table-responsive">
											<table class="table table-bordered table-hover table-condensed mb-4">
												<thead>
													<tr>
														<th>Product Name</th>
														<th>Cost Per</th>
														<th>Quantity</th>
														<th>Barcode</th>
														<th>Total</th>
														<th>Actions</th>
													</tr>
												</thead>
												<tbody>
													<tr v-for="(product, index) in grn_products" :key="index">
														<td>{{product.product_name}}</td>
														<td>{{product.unit_cost | currency}}</td>
														<td>{{product.quantity}}</td>
														<td>{{product.barcode}}</td>
														<td>{{product.total | currency}}</td>
														<td style="text-align:center;">
															<i
																class="fa fa-trash text-danger"
																style="cursor:pointer;"
																@click="deleteProduct(index)"
															></i>
														</td>
													</tr>
												</tbody>
											</table>

											<div class="col-lg-4">
												<div class="form-group mb-4">
													<label for="formGroupExampleInput">Grand Total</label>
													<label>{{form.grand_total | currency}}</label>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-2">
											<button
												:disabled="addBtnDisabled"
												type="submit"
												@click="submitForm"
												class="form-control btn btn-lg btn-primary mt-4"
											>Add GRN</button>
										</div>
										<div class="col-lg-2">
											<button type="reset" @click="resetForm" class="form-control btn btn-danger mt-4">Cancel</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
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
</template>

<script>
export default {
	props: ["warehouse_id", "super_admin", "max_dropdown", "user_id"],
	mounted() {
		if (sessionStorage.warehouse) {
			this.warehouse = sessionStorage.warehouse;
			this.onMounted();
		} else {
			this.onMounted();
		}
	},
	watch: {
		warehouse(newValue) {
			sessionStorage.warehouse = newValue;
		},
		grn_products(newValue) {
			localStorage.grn_products = JSON.stringify(newValue);
		},
	},
	data() {
		return {

			addBtnDisabled: false,

			selected_supplier: undefined,
			selected_supplier_id: "",
			supplier_list: [],

			selected_product: undefined,
			selected_product_id: "",
			product_list: [],
			product_custom_scaled: 0,

			warehouse: this.warehouse_id,
			warehouse_name: "",
			warehouse_list: "",
			warehouse_model_name: "",

			grn_products: [],

			txt_invoice: "",
			txt_product_id: "",
			txt_product_name: "",
			txt_unit_cost: "",
			txt_qty: "",
			txt_barcode: "",
			txt_exp_date: "",

			form: new Form({
				//new GRN esentials
				warehouse_id: "",
				supplier_id: "",
				user_id: this.user_id,
				invoice: "",
				grand_total: 0,

				//GRN List
				products: "",
			}),
		};
	},

	methods: {
		onMounted: function () {
			this.checkWarehouse();
			this.getSupplierList();
			this.getWarehouseList();
			this.getProductlist();

			if (localStorage.grn_products) {
				this.grn_products = JSON.parse(localStorage.grn_products);
				this.getGRNTotal();
			}
		},
		checkWarehouse: function () {
			if (this.warehouse == 0) {
				this.getWarehouseList();
				this.warehouse_model_name = "Warehouse unassigned!";
				$("#warehouses").modal("show");
			} else {
				this.getWarehouseName();
				// this.getBrandList();
				// this.getCategoryList();
			}
		},
		changeWarehouse: function () {
			this.warehouse_model_name = "Change Warehouse?";

			swal
				.fire({
					title: "Changing warehouse, you sure?",
					text: "All data will be lost, sure you wanna continue?",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Yep! Go ahead!",
				})
				.then((result) => {
					if (result.value) {
						localStorage.removeItem("grn_products");
						$("#warehouses").modal("show");
					}
				});
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
				this.onMounted();
				$("#warehouses").modal("hide");
				window.location.reload();
			} else {
				Toast.fire({
					icon: "warning",
					title: "Cannot continue without warehouse",
				});
			}
		},

		changeSupplierName: function (name) {
			this.product_search_term = name;
		},
		getSupplierList: function () {
			axios
				.get("/api/supplier/get/all")
				.then((response) => {
					this.supplier_list = response.data;
				})
				.catch((error) => {
					console.log(error);
				});
		},
		getSelectedSupplierId: function () {
			this.selected_supplier_id = this.selected_supplier.id;
			// console.log('here');
		},
		customLabel: function (custom_object) {
			return custom_object.name;
		},
		customLavelSinhala: function ({ name, search_term }) {
			return `${search_term} – ${name}`;
		},
		getProductlist: function () {
			axios
				.get("/api/product/np/warehouse/" + this.warehouse)
				.then((response) => {
					this.product_list = response.data;
				})
				.catch((error) => {
					console.log(error);
				});
		},
		getSelectedProductId: function () {
			this.selected_product_id = this.selected_product.id;
			this.product_custom_scaled = this.selected_product.custom_scale;
		},
		addProduct: function () {
			for (let i in this.grn_products) {
				if (this.grn_products[i].product_id == this.selected_product_id) {
					swal.fire(
						"Warning!",
						`${this.grn_products[i].product_name} already exists!`,
						"info"
					);
					return;
				}
			}

			this.txt_product_id = this.selected_product.id;
			this.txt_product_name = this.selected_product.name;

			this.grn_products.push({
				product_id: this.txt_product_id,
				product_name: this.txt_product_name,
				unit_cost: this.txt_unit_cost,
				quantity: this.txt_qty,
				barcode: this.txt_barcode,
				exp_date: this.txt_exp_date,
				total: Number(this.txt_unit_cost) * Number(this.txt_qty),
			});

			Toast.fire({
				icon: "success",
				title: "Product added!",
			});

			this.txt_unit_cost = "",
			this.txt_qty = "",
			this.txt_barcode = "",
			this.txt_exp_date = "",
			this.selected_product = undefined;

			this.getGRNTotal();
		},
		deleteProduct: function (index) {
			swal
				.fire({
					title: "You are removing a product, you sure?",
					text: "You won't be able to revert this!",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Yes, delete it!",
				})
				.then((result) => {
					if (result.value) {
						this.grn_products.splice(index, 1);
						swal.fire("Deleted!", "Product Removed!", "success");
						this.getGRNTotal();
					}
				});
		},
		getGRNTotal: function () {
			let total = 0;

			for (let i in this.grn_products) {
				total += this.grn_products[i].total;
			}

			this.form.grand_total = total;
		},
		submitForm: function () {

			this.addBtnDisabled = true;

			this.form.warehouse_id = this.warehouse;
			this.form.supplier_id = this.selected_supplier_id;
			this.form.invoice = this.txt_invoice;
			this.form.products = this.grn_products;

			this.form
				.post("/api/stock")
				.then((response) => {
					if (response.status == 200) {
						Toast.fire({
							icon: "success",
							title: "Adding stock! Please wait!",
						}).then(() => {
							localStorage.removeItem("grn_products");
							window.location.href = "/stock";
						});
					}
				})
				.catch((error) => {
					console.log(error);
					this.addBtnDisabled = false;
				});
		},
		resetForm: function () {
			localStorage.removeItem("grn_products");
			window.location.reload();
		},
	},
	computed: {
		changeUnitCost: function () {
			if (this.product_custom_scaled == 0) {
				return "Unit Cost / Unit";
			} else if (this.product_custom_scaled == 1) {
				return "Unit Cost / Kg";
			}
		},
	},
};
</script>
