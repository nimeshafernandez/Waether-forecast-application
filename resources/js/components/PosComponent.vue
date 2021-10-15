<template>
	<div>
		<Keypress key-event="keyup" :multiple-keys="multiple" @success="checkFunctionKey" />
		<div class="row layout-top-spacing mb-4">
			<div class="col-lg-12 mb-3">
				<div class="card component-card_1">
					<div class="card-header">
						<div class="row" style="display: flex; align-items: center;">
							<div class="col">
								<h5 class="card-title">POS ({{warehouse_name}})</h5>
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
						<h5 class="card-title"></h5>
						<div class="col-lg-12">
							<form @submit.prevent="addProduct">
								<div class="row">
									<div class="col-lg-8">
										<div class="form-group">
											<label for="formGroupExampleInput">Product Name (F2)</label>
											<multiselect
												id="input_product_name"
												v-model="selected_product"
												:options="product_list"
												:custom-label="customLabelSinhala"
												:allow-empty="false"
												:options-limit="max_dropdown"
												@input="addProduct"
												@close="resetSearch"
											></multiselect>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="formGroupExampleInput">Barcode (F4)</label>
											<input
												id="input_product_barcode"
												@keypress.enter="addProductFromBarcode"
												type="text"
												class="form-control"
												placeholder="Barcode"
												v-model="txt_barcode"
											/>
										</div>
									</div>
								</div>
							</form>
							<div class="row mt-2">
								<div class="col-lg-12 layout-spacing">
									<div class="statbox widget box box-shadow">
										<div class="table-responsive">
											<table class="table table-bordered table-hover table-condensed">
												<div class="table-wrapper-scroll-y my-custom-scrollbar">
													<thead>
														<tr>
															<th class="text-primary">#</th>
															<th class="text-primary">Product Name</th>
															<th class="text-primary">Price</th>
															<th class="text-primary">Qty</th>
															<th class="text-primary">Discount</th>
															<th class="text-primary">Total</th>
															<th class="text-primary">Actions</th>
														</tr>
													</thead>
													<tbody>
														<tr v-for="(product, index) in pos_products" :key="index">
															<td class="text-primary">
																<strong>{{index + 1}}</strong>
															</td>
															<td>{{product.product_name}}</td>
															<td>{{product.unit_cost | currency}}</td>
															<td style="text-align:center;">
																<number-input
																	:name="'pr_' + index"
																	v-if="product.product_custom_scale == 1"
																	:min="0.050"
																	@change="updateProductTotal(product)"
																	@keydown="updateProductTotal(product)"
																	v-model="product.quantity"
																	size="small"
																	center
																	inline
																	ref="product_input"
																></number-input>
																<number-input
																	:name="'pr_' + index"
																	v-else
																	:min="1"
																	@change="updateProductTotal(product)"
																	@keydown="updateProductTotal(product)"
																	v-model="product.quantity"
																	size="small"
																	center
																	inline
																	controls
																	ref="product_input"
																></number-input>
															</td>
															<td>
																<div class="row">
																	<div class="col-5">
																		<number-input
																			:min="0.00"
																			:max="100"
																			@change="updateProductTotal(product)"
																			@keydown="updateProductTotal(product)"
																			v-model="product.discount"
																			size="small"
																			center
																			inline
																		></number-input>
																	</div>
																	<div class="col-1">
																		<i class="fa fa-percent text-success"></i>
																	</div>
																	<div class="col-5">{{product.allowed_discount | currency}}</div>
																</div>
															</td>
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
												</div>
											</table>

											<div class="col-lg-4">
												<div class="form-group mb-4">
													<label class="text-black">Grand Total:</label>
													<label class="text-primary">{{form.grand_total | currency}}</label>
													<br />
													<label class="text-black">Discount:</label>
													<label class="text-info">{{form.grand_total_discount | currency}}</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-3 p-1">
									<button @click="resetForm" class="btn btn-outline-warning btn-lg btn-block mainbutton">
										<i class="fa fa-sync mx-2"></i> New Session (Insert)
									</button>
								</div>
								<div class="col-lg-3 p-1">
									<button
										@click="showDiscountModel"
										class="btn btn-outline-info btn-lg btn-block mainbutton"
										:disabled="DisableBillPay"
									>
										<i class="fa fa-percent mx-2"></i> Bulk Discount
									</button>
								</div>
								<div class="col-lg-6 p-1">
									<button
										@click="showPaymentOptions"
										:disabled="DisableBillPay"
										class="btn btn-primary btn-lg btn-block mainbutton"
									>
										<i class="fas fa-cash-register mx-2"></i> Pay Bill (End)
									</button>
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

		<!-- Payment Select Modal -->
		<div
			class="modal fade"
			id="paymentoptions"
			tabindex="-1"
			role="dialog"
			aria-labelledby="showPaymentOptions"
			aria-hidden="true"
		>
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="showPaymentOptions">Pay Bill</h5>
					</div>
					<div class="col-lg-12">
						<div class="modal-body">
							<div class="row">
								<div class="col-lg-12">
									<label class="text-black mx-1">Total Amount</label>
									<label>{{form.grand_total | currency}}</label>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<label class="text-black mx-1">Balance</label>
									<label>{{cash_amount - form.grand_total | currency}}</label>
								</div>
							</div>
							<hr />
							<div class="row">
								<div class="col">
									<label>Paid Amount</label>
									<input
										type="number"
										@focus="$event.target.select()"
										class="form-control"
										v-model="cash_amount"
										id="pos_paid_amount"
									/>
								</div>
							</div>

							<hr />
							<div class="row" v-show="show_payment_options">
								<div class="col-lg-3">
									<button
										@click="submitForm('cash')"
										:disabled="isPaidAmountValid"
										style="height:80px"
										class="btn btn-outline-success"
									>
										<i class="fa fa-money-bill-wave"></i>
										Cash
									</button>
								</div>

								<div class="col-lg-3">
									<button style="height:80px" @click="submitForm('credit')" class="btn btn-outline-danger">
										<i class="fas fa-money-check-alt"></i>
										Credit
									</button>
								</div>

								<div class="col-lg-3">
									<button style="height:80px" disabled class="btn btn-outline-warning">
										<i class="fas fa-credit-card"></i>
										Card
									</button>
								</div>

								<div class="col-lg-3">
									<button style="height:80px" disabled class="btn btn-outline-dark">
										<i class="fas fa-money-check"></i>
										Cheque
									</button>
								</div>
							</div>
						</div>

						<div class="modal-footer" v-show="show_payment_options">
							<button type="reset" class="btn btn-dark">
								<i class="flaticon-cancel-12"></i>Reset
							</button>
							<button
								v-show="showPrintButton"
								style="width: 150px; height:60px ; font-size:15px;"
								type="button"
								class="btn btn-primary"
							>
								<i class="fas fa-print mx-2"></i>Print Bill
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--  -->

		<!-- Credit Bill Modal -->
		<div
			class="modal fade"
			id="showCustomersList"
			tabindex="-1"
			role="dialog"
			aria-labelledby="showCustomers"
			aria-hidden="true"
			data-keyboard="false"
			data-backdrop="static"
		>
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="showCustomers">Credit Bill</h5>
					</div>
					<div class="col-lg-12">
						<div class="modal-body">
							<div class="row">
								<div class="col-lg-12">
									<label class="text-black mx-1">Total Amount</label>
									<label>{{form.grand_total | currency}}</label>
								</div>
							</div>
							<hr />
							<div class="row">
								<div class="col">
									<label>Choose Customer</label>
									<multiselect
										v-model="form.credit_customer"
										:options="customer_list"
										:allow-empty="false"
										:options-limit="max_dropdown"
										:custom-label="customLabelCustomerName"
									></multiselect>
								</div>
							</div>
						</div>
						<div class="modal-footer" v-show="show_payment_options">
							<button type="reset" @click="resetCreditBillModal" class="btn btn-danger">
								<i class="flaticon-cancel-12"></i>Cancel
							</button>
							<button type="reset" @click="form.credit_customer = undefined" class="btn btn-dark">
								<i class="flaticon-cancel-12"></i>Reset
							</button>
							<button
								@click="submitForm('credit')"
								v-if="form.credit_customer"
								style="width: 150px; height:60px ; font-size:15px;"
								type="button"
								class="btn btn-primary"
							>
								<i class="fas fa-print mx-2"></i>Print Credit Bill
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--  -->

		<!-- Show Bill Modal -->
		<div id="printme" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
			<div id="invoice-POS">
				<!-- <p style="margin-left: 85px; margin-top:0px;">බිල්පත</p> -->
				<p style="margin-left: 15px; font-size:14px">
					--- රතුපස්කැටිය ස්ටෝර්ස් ----
					<br />රතුපස්කැටිය,දියකොබල,බිබිල
					<br />දුරකථ: 0552268036/0719362359
				</p>---------------------------------------------
				<div>
					<label style="font-size: 12px;">බිල්.නො :</label>
					<label style="font-size: 12px;">{{receipt_id}}</label>
					<label style="font-size: 12px; margin-left: 20px">දිනය :</label>
					<label style="font-size: 12px;">{{receipt_date | billDate}}</label>
				</div>

				<table style="width:250px;">
					<tr>
						<th style="text-align:left;font-size: 12px;">අයිතම</th>
						<th style="text-align:left;font-size: 12px;">ඒකක</th>
						<th style="text-align:left;font-size: 12px;">මිල</th>
						<th style="text-align:left;font-size: 12px;">%</th>
						<th style="text-align:left;font-size: 12px;">එකතුව</th>
					</tr>
					<tr v-for="(product, index) in pos_products" :key="index">
						<td style="text-align:left;font-size: 10px;">{{product.product_name}}</td>
						<td style="text-align:left;font-size: 10px;">{{product.quantity}}</td>
						<td style="text-align:left;font-size: 10px;">{{product.product_price}}</td>
						<td style="text-align:left;font-size: 10px;">{{product.discount}}</td>
						<td style="text-align:left;font-size: 10px;">{{product.total}}</td>
					</tr>
				</table>

				<label style="font-size: 12px;">වට්ටම් :</label>
				<label style="font-size: 12px; margin-left:10px;">{{form.grand_total_discount}}</label>
				<br />

				<label style="font-size: 12px;">එකතුව :</label>
				<label style="font-size: 12px;margin-left:5px;">{{form.grand_total}}</label>
				<br />---------------------------------------------
				<br />
				<div style="margin-left: 55px; font-size:12px">ස්තුතියි නැවත එන්න !</div>

				<p style="font-size: 10px;margin-left:15px;">Software by AppsDept (Pvt) ltd / www.appsdept.com</p>
			</div>
		</div>
		<!--  End Modal -->
	</div>
</template>

<script>
import { Printd } from "printd";

export default {
	props: ["warehouse_id", "super_admin", "max_dropdown", "user_id"],
	components: {
		Keypress: () => import("vue-keypress"),
	},
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
		pos_products: {
			handler(newValue) {
				localStorage.pos_products = JSON.stringify(newValue);
			},
			deep: true,
		},
	},
	data() {
		return {
			multiple: [
				{
					keyCode: 113, // F2
					modifiers: [],
					preventDefault: true,
				},
				{
					keyCode: 115, // F4
					modifiers: [],
					preventDefault: false,
				},
				{
					keyCode: 45, //Insert
					modifiers: [],
					preventDefault: false,
				},
				{
					keyCode: 35, //End
					modifiers: [],
					preventDefault: false,
				},
			],

			show_payment_options: true,

			selected_product: undefined,
			product_list: [],

			customer_list: [],

			showPrintButton: false,
			cash_amount: 0,

			warehouse: this.warehouse_id,
			warehouse_name: "",
			warehouse_list: "",
			warehouse_model_name: "",

			pos_products: [],

			txt_barcode: "",

			receipt_id: "",
			receipt_date: "",

			form: new Form({
				//new GRN esentials
				warehouse_id: "",
				user_id: this.user_id,
				grand_total: 0,
				grand_total_discount: 0,
				payment_method: null,
				credit_customer: null,

				//GRN List
				products: "",
			}),
		};
	},

	methods: {
		checkFunctionKey: function (response) {
			switch (response.event.keyCode) {
				case 113:
					document.getElementById("input_product_name").focus();
					break;
				case 115:
					document.getElementById("input_product_barcode").focus();
					break;
				case 35:
					if (!this.DisableBillPay) {
						this.showPaymentOptions();
					}
					break;
				case 45:
					this.resetForm();
					break;

				default:
					break;
			}
		},
		onMounted: function () {
			this.checkWarehouse();
			this.getWarehouseList();
			this.getProductlist();

			if (localStorage.pos_products) {
				this.pos_products = JSON.parse(localStorage.pos_products);
				this.getPOSTotal();
			}
		},
		checkWarehouse: function () {
			if (this.warehouse == 0) {
				this.getWarehouseList();
				this.warehouse_model_name = "Warehouse unassigned!";
				$("#warehouses").modal("show");
			} else {
				this.getWarehouseName();
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
						localStorage.removeItem("pos_products");
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
		customLabelSinhala: function ({ name, search_term }) {
			return `${search_term} – ${name}`;
		},
		customLabelCustomerName: function ({ name, nic_no }) {
			return `${name} - ${nic_no}`;
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
		addProduct: function () {
			let default_qty = 0;

			for (let i in this.pos_products) {
				if (this.pos_products[i].product_id == this.selected_product.id) {
					let ref_stock = (this.pos_products[i].quantity += 1);
					this.pos_products[i].total =
						this.selected_product.selling_price * ref_stock;

					this.getPOSTotal();
					this.txt_barcode = "";
					return;
				}
			}

			this.pos_products.push({
				product_id: this.selected_product.id,
				product_name: this.selected_product.name,
				product_custom_scale: this.selected_product.custom_scale,
				product_price: this.selected_product.selling_price,
				unit_cost: this.selected_product.selling_price,
				quantity: 1,
				discount: 0,
				allowed_discount: 0,
				total: 1 * Number(this.selected_product.selling_price),
			});

			this.forcusNextProduct();

			this.txt_barcode = "";
			this.getPOSTotal();
			this.selected_product = undefined;
		},
		addProductFromBarcode: function () {
			axios
				.get(
					"/api/product/get/barcode/" +
						this.txt_barcode +
						"/warehouse/" +
						this.warehouse
				)
				.then((response) => {
					let default_qty = 0;
					let br_product = response.data;

					for (let i in this.pos_products) {
						if (this.pos_products[i].product_id == br_product.id) {
							let ref_stock = (this.pos_products[i].quantity += 1);
							this.pos_products[i].total = br_product.selling_price * ref_stock;

							this.getPOSTotal();
							this.txt_barcode = "";
							return;
						}
					}

					this.pos_products.push({
						product_id: br_product.id,
						product_name: br_product.name,
						product_custom_scale: br_product.custom_scale,
						product_price: br_product.selling_price,
						unit_cost: br_product.selling_price,
						quantity: 1,
						discount: 0,
						allowed_discount: 0,
						total: 1 * Number(br_product.selling_price),
					});

					this.forcusNextProduct();

					this.txt_barcode = "";
					this.getPOSTotal();
				})
				.catch((error) => {
					Toast.fire({
						icon: "error",
						title: error.response.data.message,
					});
					this.txt_barcode = "";
					// console.log(error.response.data.message);
				});
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
						this.pos_products.splice(index, 1);
						Toast.fire({
							icon: "info",
							title: "Product Removed!",
						});
						this.getPOSTotal();
					}
				});
		},
		getPOSTotal: function () {
			let total = 0;

			for (let i in this.pos_products) {
				total += this.pos_products[i].total;
			}

			this.form.grand_total = total;
		},
		getCreditCustomers: function () {
			axios
				.get("/api/customer/all")
				.then((response) => {
					this.customer_list = response.data;
				})
				.catch((error) => {
					console.log(error);
				});
		},
		showPaymentOptions: function () {
			$("#paymentoptions").modal("show");
			setTimeout(() => {
				document.getElementById("pos_paid_amount").focus();
			}, 100);
		},
		resetCreditBillModal: function () {
			$("#showCustomersList").modal("hide");
			this.form.credit_customer = undefined;
		},
		submitForm: async function (payment_method) {
			try {
				if (this.form.grand_total <= 0) {
					Toast.fire({
						icon: "error",
						title: "Add products to continue",
					});
				} else {
					this.show_payment_options = false;

					this.form.products = this.pos_products;
					this.form.warehouse_id = this.warehouse;
					this.form.payment_method = payment_method;

					if (payment_method == "credit" && !this.form.credit_customer) {
						this.getCreditCustomers();
						this.show_payment_options = true;
						$("#paymentoptions").modal("hide");
						setTimeout(() => {
							$("#showCustomersList").modal("show");
						}, 250);
						return;
					}

					const response = await this.form.post("/api/pos");
					if (response.status == 200) {
						console.log(response.data);
						this.receipt_id = response.data.receipt_id;
						this.receipt_date = response.data.receipt_date;

						setTimeout(() => {
							const d = new Printd();
							d.print(document.getElementById("printme"));
						}, 1000);

						Toast.fire({
							icon: "info",
							title: "Please wait!",
						}).then(() => {
							this.resetForm();
						});
						$("#paymentoptions").modal("hide");
					}
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
		updateProductTotal: function (product) {
			let ref_quantity = product.quantity;
			let ref_price = product.unit_cost;
			let ref_discount = product.discount;
			let total = Number(ref_quantity) * Number(ref_price);
			let discount = (total / 100) * ref_discount;
			product.total = total - discount;
			product.allowed_discount = discount;
			this.getPOSTotal();
		},
		resetForm: function () {
			Toast.fire({
				icon: "info",
				title: "Please wait, loading!",
			});
			localStorage.removeItem("pos_products");
			window.location.reload();
		},
		showDiscountModel: async function () {
			this.form.grand_total += this.form.grand_total_discount;
			this.form.grand_total_discount = 0;

			const { value: bulk_discount } = await swal.fire({
				title: "Bulk Discount Amount, in percentage",
				input: "text",
				inputPlaceholder: "Please enter the discount in percentage!",
			});

			if (bulk_discount) {
				let discount = (this.form.grand_total / 100) * bulk_discount;
				this.form.grand_total_discount = discount;
				this.form.grand_total -= discount;
			}
		},
		resetSearch: function () {
			this.selected_product = undefined;
		},
		forcusNextProduct: function () {
			this.$nextTick(() => {
				let index = this.pos_products.length - 1;
				let name = 'pr_' + index;

				let elements = document.getElementsByName(name);
				elements[0].select();
				elements[0].focus();

				// let input = this.$refs.product_input[index];
				// console.log(
				// 	elements
				// 	// input.$el.lastElementChild.select();
				// );
			});
		},
	},
	computed: {
		isPaidAmountValid: function () {
			if (this.cash_amount >= this.form.grand_total) {
				return false;
			} else {
				return true;
			}
		},
		DisableBillPay: function () {
			if (this.form.grand_total > 0) {
				return false;
			} else {
				return true;
			}
		},
	},
};
</script>

<style scoped>
.mainbutton {
	height: 4em !important;
}
.my-custom-scrollbar {
	position: relative;
	height: 26em;
	overflow: auto;
}
.table-wrapper-scroll-y {
	display: block;
}
table.table-hover tbody tr td:hover {
	background-color: skyblue;
}
#invoice-POS {
	padding: 0mm;
	margin: 0 auto;
	margin-bottom: 1px;
	width: 100mm;
	background: #fff;
}
</style>
