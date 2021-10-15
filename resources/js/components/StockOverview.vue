<template>
	<div class="row layout-top-spacing mb-4">
		<div class="col-lg-12 my-3">
			<div class="card">
				<div class="card-header">
					<div class="row" style="display: flex; align-items: center;">
						<div class="col">
							<h5 class="card-title">Stock Overview ({{warehouse_name}})</h5>
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
					<div class="col-lg-7 pl-0 my-2">
						<input
							class="form-control"
							type="text"
							placeholder="Search"
							v-model="user_search"
							@keypress.enter="SearchProductsList()"
						/>
					</div>
					<div class="row pt-3">
						<div class="col-lg-12">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-condensed mb-4">
									<thead>
										<tr>
											<th>Id</th>
											<th>Name</th>
											<th>Code</th>
											<th>Selling Price</th>
											<th>Reorder Level</th>
											<th>Current Stock</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(stock, index) in stock_list.data" :key="index">
											<td>{{stock.id}}</td>
											<td>{{stock.name}}</td>
											<td>{{stock.code}}</td>
											<td>Rs. {{stock.selling_price}}</td>
											<td class="text-warning">{{stock.reorder_stock}}</td>
											<td :class="stock.stock.quantity <= 0 ? 'text-danger' : 'text-primary'">{{stock.stock.quantity}}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer" v-show="show_table_footer">
					<pagination :data="stock_list" @pagination-change-page="getProductList"></pagination>
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
	</div>
</template>

<script>
export default {
	props: ["warehouse_id", "super_admin"],
	mounted() {
		if (sessionStorage.warehouse) {
			this.warehouse = sessionStorage.warehouse;
			this.getWarehouseName();
			this.getProductList();
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

			show_table_footer: false,

			user_search: "",

			stock_list: {},
			stock_id: "",
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
				this.getProductList();
			}
		},
		changeWarehouse: function () {
			this.warehouse_model_name = "Change Warehouse?";
			$("#warehouses").modal("show");
		},
		getProductList: function (page = 1) {
			axios
				.get("/api/stock/warehouse/" + this.warehouse + "?page=" + page)
				.then((response) => {
					// console.log(response);
					this.stock_list = response.data;

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
				this.getProductList();

				$("#warehouses").modal("hide");
			} else {
				Toast.fire({
					icon: "warning",
					title: "Cannot continue without warehouse",
				});
			}
		},
		SearchProductsList: function () {
			if (this.user_search == "" || this.user_search == null) {
				this.getProductList();
			} else {
				axios
					.get(
						"/api/stock/search/" +
							this.user_search +
							"/warehouse/" +
							this.warehouse
					)
					.then((response) => {
						this.stock_list = response.data;
					});
			}
		},
	},
	computed: {},
};
</script>
