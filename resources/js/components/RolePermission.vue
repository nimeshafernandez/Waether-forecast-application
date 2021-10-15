<template>
	<div class="card component-card_1">
		<div class="card-body">
			<h5 class="card-title">Role Permission Overview</h5>
			<div class="row pt-3">
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-condensed mb-4">
							<thead>
								<tr>
									<th>Functions</th>
									<th class="text-center">Create</th>
									<th class="text-center">View</th>
									<th class="text-center">Update</th>
									<th class="text-center">Delete</th>
									<th class="text-center">All</th>
								</tr>
							</thead>
							<tbody>
								<tr id="user_mgt">
									<td>All Permissions</td>

									<td class="text-center" id="create"></td>

									<td class="text-center" id="view"></td>

									<td class="text-center" id="update"></td>

									<td class="text-center" id="delete"></td>

									<td class="text-center" id="all">
										<div class="n-chk">
											<label class="new-control new-checkbox checkbox-primary">
												<input
													type="checkbox"
													class="new-control-input"
													@change="grantAllPermission"
													v-model="grant_all"
												/>
											</label>
										</div>
									</td>
								</tr>

								<tr id="user_mgt">
									<td>Point Of Sales (POS)</td>

									<td class="text-center" id="create"></td>

									<td class="text-center" id="view"></td>

									<td class="text-center" id="update"></td>

									<td class="text-center" id="delete"></td>

									<td class="text-center" id="all">
										<div class="n-chk">
											<label class="new-control new-checkbox checkbox-primary">
												<input
													type="checkbox"
													class="new-control-input"
													@change="changeArrayValues(permissions.pos, permissions.pos.enabled) ; savePermission()"
													v-model="permissions.pos.enabled"
												/>
											</label>
										</div>
									</td>
								</tr>

								<tr id="user_mgt">
									<td>User Management</td>
									<td
										v-for="(index, item) in this.permissions.user"
										v-bind:key="index + item"
										class="text-center"
									>
										<div class="n-chk">
											<label class="new-control new-checkbox checkbox-primary">
												<input
													v-if="item != 'all'"
													type="checkbox"
													class="new-control-input"
													v-model="permissions.user[item]"
													@change="savePermission()"
												/>
												<input
													v-if="item == 'all'"
													@change="changeArrayValues(permissions.user, permissions.user[item]) ; savePermission()"
													type="checkbox"
													class="new-control-input"
													v-model="permissions.user[item]"
												/>
											</label>
										</div>
									</td>
								</tr>

								<tr id="product_mgt">
									<td>Product Management</td>
									<td
										v-for="(index, item) in this.permissions.product"
										v-bind:key="index + item"
										class="text-center"
									>
										<div class="n-chk">
											<label class="new-control new-checkbox checkbox-primary">
												<input
													v-if="item != 'all'"
													type="checkbox"
													class="new-control-input"
													v-model="permissions.product[item]"
													@change="savePermission()"
												/>
												<input
													v-if="item == 'all'"
													@change="changeArrayValues(permissions.product, permissions.product[item]) ; savePermission()"
													type="checkbox"
													class="new-control-input"
													v-model="permissions.product[item]"
												/>
											</label>
										</div>
									</td>
								</tr>

								<tr id="cc_mgt">
									<td>Customer Management</td>
									<td
										v-for="(index, item) in this.permissions.customer"
										v-bind:key="index + item"
										class="text-center"
									>
										<div class="n-chk">
											<label class="new-control new-checkbox checkbox-primary">
												<input
													v-if="item != 'all'"
													type="checkbox"
													class="new-control-input"
													v-model="permissions.customer[item]"
													@change="savePermission()"
												/>
												<input
													v-if="item == 'all'"
													@change="changeArrayValues(permissions.customer, permissions.customer[item]) ; savePermission()"
													type="checkbox"
													class="new-control-input"
													v-model="permissions.customer[item]"
												/>
											</label>
										</div>
									</td>
								</tr>

								<tr id="sup_mgt">
									<td>Supplier Management</td>
									<td
										v-for="(index, item) in this.permissions.supplier"
										v-bind:key="index + item"
										class="text-center"
									>
										<div class="n-chk">
											<input
												v-if="item != 'all'"
												type="checkbox"
												class="new-control-input"
												v-model="permissions.supplier[item]"
												@change="savePermission()"
											/>
											<input
												v-if="item == 'all'"
												@change="changeArrayValues(permissions.supplier, permissions.supplier[item]) ; savePermission()"
												type="checkbox"
												class="new-control-input"
												v-model="permissions.supplier[item]"
											/>
										</div>
									</td>
								</tr>
								<tr id="wh_mgt">
									<td>Warehouse Management</td>
									<td
										v-for="(index, item) in this.permissions.warehouse"
										v-bind:key="index + item"
										class="text-center"
									>
										<div class="n-chk">
											<label class="new-control new-checkbox checkbox-primary">
												<input
													v-if="item != 'all'"
													type="checkbox"
													class="new-control-input"
													v-model="permissions.warehouse[item]"
													@change="savePermission()"
												/>
												<input
													v-if="item == 'all'"
													@change="changeArrayValues(permissions.warehouse, permissions.warehouse[item]) ; savePermission()"
													type="checkbox"
													class="new-control-input"
													v-model="permissions.warehouse[item]"
												/>
											</label>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!-- <button @click="checkPermissionsAndAll()">Test</button> -->
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: ["role_id"],
	mounted() {
		this.getPreviousPermission();
	},
	data: function () {
		return {
			form: new FormData(),

			grant_all: false,

			permissions: {
				pos: {
					enabled: false,
				},

				user: {
					create: false,
					view: false,
					update: false,
					delete: false,
					all: false,
				},

				product: {
					create: false,
					view: false,
					update: false,
					delete: false,
					all: false,
				},

				customer: {
					create: false,
					view: false,
					update: false,
					delete: false,
					all: false,
				},

				supplier: {
					create: false,
					view: false,
					update: false,
					delete: false,
					all: false,
				},

				warehouse: {
					create: false,
					view: false,
					update: false,
					delete: false,
					all: false,
				},
			},
		};
	},
	methods: {
		grantAllPermission: function () {
			for (let i in this.permissions) {
				for (let j in this.permissions[i]) {
					this.permissions[i][j] = this.grant_all;
				}
			}
			this.savePermission();
		},
		changeArrayValues: function (array, value) {
			for (let i in array) {
				array[i] = value;
			}
		},
		savePermission: function () {
			axios
				.put("/api/permissions/" + this.role_id, this.permissions)
				.then((response) => {
					console.log(response);
				});
		},
		getPreviousPermission: function () {
			axios.get("/api/permissions/role/" + this.role_id).then((response) => {
				var data = response.data;
				for (let i in data) {
					switch (data[i].name) {
						case "POS":
							this.permissions.pos.enabled = true;
							break;
						case "user_management_create":
							this.permissions.user.create = true;
							break;
						case "user_management_view":
							this.permissions.user.view = true;
							break;
						case "user_management_update":
							this.permissions.user.update = true;
							break;
						case "user_management_delete":
							this.permissions.user.delete = true;
							break;
						
						case "product_management_create":
							this.permissions.product.create = true;
							break;
						case "product_management_view":
							this.permissions.product.view = true;
							break;
						case "product_management_update":
							this.permissions.product.update = true;
							break;
						case "product_management_delete":
							this.permissions.product.delete = true;
							break;

						case "customer_management_create":
							this.permissions.customer.create = true;
							break;
						case "customer_management_view":
							this.permissions.customer.view = true;
							break;
						case "customer_management_update":
							this.permissions.customer.update = true;
							break;
						case "customer_management_delete":
							this.permissions.customer.delete = true;
							break;

						case "supplier_management_create":
							this.permissions.supplier.create = true;
							break;
						case "supplier_management_view":
							this.permissions.supplier.view = true;
							break;
						case "supplier_management_update":
							this.permissions.supplier.update = true;
							break;
						case "supplier_management_delete":
							this.permissions.supplier.delete = true;
							break;

						case "warehouse_management_create":
							this.permissions.warehouse.create = true;
							break;
						case "warehouse_management_view":
							this.permissions.warehouse.view = true;
							break;
						case "warehouse_management_update":
							this.permissions.warehouse.update = true;
							break;
						case "warehouse_management_delete":
							this.permissions.warehouse.delete = true;
							break;
					}
				}
			});
		},
		checkPermissionsAndAll: function () {
			
		},
	},
};
</script>
