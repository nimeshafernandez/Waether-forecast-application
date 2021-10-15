<template>
	<div class="row layout-top-spacing">
		<div class="col-lg-12 mt-3 mb-5">
			<div class="card component-card_1">
				<div class="card-header">
					<div class="row">
						<div class="col">
							<h5 class="card-title">Credit Customer Payments</h5>
						</div>
						<div class="col">
							<input
								@keyup="searchCustomer"
								v-model="search_term"
								class="form-control float-right"
								type="text"
								placeholder="Search"
							/>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="row pt-3">
						<div class="col-lg-12">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-condensed mb-4">
									<thead>
										<tr>
											<th>ID</th>
											<th>Name</th>
											<th>Debt</th>
											<th>Phone</th>
											<th>NIC</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(customer) in this.customers.data" :key="customer.id">
											<td>{{customer.id}}</td>
											<td>{{customer.name}}</td>
											<td
												:class="customer.credit.total > 0 ? 'text-danger' : 'text-success' "
											>{{customer.credit.total | currency}}</td>
											<td>{{customer.phone}}</td>
											<td>{{customer.nic_no}}</td>
											<td style="text-align:center">
												<i
													v-if="customer.credit.total 
                                                > 0 "
													@click="makePayment(customer)"
													class="fas fa-hand-holding-usd mx-1 text-success"
													style="font-size:20px; cursor:pointer;"
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
		<!-- Payment Modal -->
		<div
			class="modal fade"
			id="paymentModal"
			tabindex="-1"
			role="dialog"
			aria-labelledby="paymentModalTitle"
			aria-hidden="true"
		>
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Credit Payment</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div v-if="Object.keys(selected_customer).length != 0">
							<div class="form-group col-12">
								<label class="d-inline">Customer Name:</label>
								<p class="d-inline">{{selected_customer.name}}</p>
							</div>
							<div class="form-group col-12">
								<label class="d-inline">NIC Number:</label>
								<p class="d-inline">{{selected_customer.nic_no}}</p>
							</div>
							<div class="form-group col-12">
								<label class="d-inline">Current arrears:</label>
								<p class="d-inline text-danger">{{selected_customer.credit.total | currency}}</p>
							</div>
							<div class="form-group col-12">
								<label class="d-inline">Paid:</label>
								<p class="d-inline text-success">{{selected_customer.credit.paid_total | currency}}</p>
							</div>
						</div>
						<hr />
						<div class="form-group">
							<label>Amount:</label>
							<input @keypress.enter="submitPayment" id="pay_amount" v-model="form.amount" type="number" class="form-control" />
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button
							:disabled="disable_submit"
							@click="submitPayment"
							type="button"
							class="btn btn-primary"
						>Make Payment</button>
					</div>
				</div>
			</div>
		</div>
		<!-- End Payment Modal -->
	</div>
</template>

<script>
export default {
	created() {
		Fire.$on("searching", () => {
			this.getSearchCustomer();
		});

		Fire.$on("payment_accepted", () => {
			this.getCustomerList();
		});
	},
	mounted() {
		this.getCustomerList();
	},
	data() {
		return {
			disable_submit: false,

			customers: {},
			selected_customer: {},

			show_table_footer: false,

			search_term: "",

			form: new Form({
				customer_id: "",
				amount: 0,
			}),
		};
	},

	methods: {
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
		getSearchCustomer: function () {
			if (this.search_term == "" || this.search_term == null) {
				this.getCustomerList();
				return;
			}

			axios
				.get("/api/customer/search/" + this.search_term)
				.then((response) => {
					this.customers = response.data;
				})
				.catch((error) => {
					console.log(error);
				});
		},
		searchCustomer: _.debounce(() => {
			Fire.$emit("searching");
		}, 500),
		makePayment: function (customer) {
			this.form.reset();

			this.form.customer_id = customer.id;
			this.selected_customer = customer;

			$("#paymentModal").modal("show");
			setTimeout(() => {
				document.getElementById("pay_amount").focus();
				document.getElementById("pay_amount").select();
			}, 100);
		},
		submitPayment: async function () {
			try {
				if (this.form.amount > this.selected_customer.credit.total) {
					Toast.fire({
						icon: "error",
						title: "Amount cannot be more than the current arrears!",
					});
					return;
				}

				this.disable_submit = true;

				const response = await this.form.post(
					"/api/customer/payment/" + this.form.customer_id
				);

				if (response.status == 200) {
					this.disable_submit = false;
					$("#paymentModal").modal("hide");
					Fire.$emit("payment_accepted");

					Toast.fire({
						icon: "success",
						title: "Payment Accepted!",
					});
				}

			} catch (error) {
				console.log(error);
			}
		},
	},
};
</script>
