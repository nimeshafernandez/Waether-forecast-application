<template>
	<div class="row layout-top-spacing">
		<div class="col-lg-12 mt-3 mb-5">
			<div class="card component-card_1">
				<div class="card-body">
					<div class="card-title">
						<h5>{{customer.name}}'s Credit Profile</h5>
					</div>
					<hr />
					<div class="row pt-3">
						<div class="col-4">
							<h6 class="d-inline">Name:</h6>
							<span class="d-inline">{{customer.name}}</span>
						</div>
						<div class="col-4">
							<h6 class="d-inline">Address:</h6>
							<span class="d-inline">{{customer.address}}</span>
						</div>
						<div class="col-4">
							<h6 class="d-inline">NIC:</h6>
							<span class="d-inline">{{customer.nic_no}}</span>
						</div>
						<div class="col-4">
							<h6 class="d-inline">Phone:</h6>
							<span class="d-inline">{{customer.phone}}</span>
						</div>
						<div class="col-4">
							<h6 class="d-inline">Debt:</h6>
							<span
								class="d-inline"
								:class="customer.credit.total > 0 ? 'text-danger' : 'text-success' "
							>{{customer.credit.total | currency}}</span>
						</div>
						<div class="col-4">
							<h6 class="d-inline">Paid:</h6>
							<span class="d-inline">{{customer.credit.paid_total | currency}}</span>
						</div>
					</div>
				</div>
			</div>

			<div class="card component-card_1 mt-3">
				<div class="card-body">
					<div class="card-title">
						<h5>Customer's Credit Transactions</h5>
					</div>
					<div class="row pt-3">
						<div class="col-lg-12">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-condensed mb-4">
									<thead>
										<tr>
											<th>Receipt #</th>
											<th>Date</th>
											<th>Amount</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(receipt, index) in receipts.data" :key="index">
											<td>{{receipt.id}}</td>
											<td>{{receipt.created_at | myDate}}</td>
											<td>{{receipt.total | currency}}</td>
											<td style="vertical-align: middle; text-align: center;">
												<i
													class="fas fa-shopping-cart text-info mx-1"
													style="cursor:pointer;"
													@click="getReceiptItems(receipt.id)"
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
					<pagination :data="receipts" @pagination-change-page="getReceipts"></pagination>
				</div>
			</div>
		</div>

		<!-- Cart Model -->
		<div
			class="modal fade"
			id="receiptItemModal"
			tabindex="-1"
			role="dialog"
			aria-labelledby="receiptItemModalTitle"
			aria-hidden="true"
		>
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="receiptItemModalTitle">Receipt Item List</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row pt-3">
							<div class="col-lg-12">
								<div class="row mb-4">
									<div class="col-6">
										<h6 class="d-inline">Date:</h6>
										<span
											v-if=" Object.keys(model_products).length != 0 "
											class="d-inline"
										>{{model_products.receipt.created_at | myDate}}</span>
									</div>
									<div class="col-6">
										<h6 class="d-inline">System User:</h6>
										<span
											v-if=" Object.keys(model_products).length != 0 "
											class="d-inline"
										>{{model_products.receipt.user.name}}</span>
									</div>
									<div class="col-6">
										<h6 class="d-inline">Grand Total:</h6>
										<span
											v-if=" Object.keys(model_products).length != 0 "
											class="d-inline"
										>{{model_products.receipt.total | currency}}</span>
									</div>
									<div class="col-6">
										<h6 class="d-inline">Overall Discount:</h6>
										<span
											v-if=" Object.keys(model_products).length != 0 "
											class="d-inline"
										>{{model_products.receipt.discount | currency}}</span>
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-bordered table-hover table-condensed mb-4">
										<thead>
											<tr>
												<th>Item #</th>
												<th>Product Name</th>
												<th>Price</th>
												<th>Qty</th>
												<th>Discount</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
											<tr v-for="(product, index) in model_products.products" :key="index">
												<td>{{product.id}}</td>
												<td>{{product.product_name}}</td>
												<td>{{product.price | currency}}</td>
												<td>{{product.quantity}}</td>
												<td>({{product.discount_allowed | currency}})</td>
												<td>{{ Number(product.price) * Number(product.quantity) | currency }}</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- End Cart Model -->
	</div>
</template>

<script>
export default {
	props: ["customer"],
	created() {},
	mounted() {
		this.getReceipts();
	},
	data() {
		return {
			receipts: {},
			show_table_footer: false,

			model_products: {},
		};
	},

	methods: {
		getReceipts: function (page = 1) {
			axios
				.get("/api/customer/" + this.customer.id + "?page=" + page)
				.then((response) => {
					this.receipts = response.data.receipts;

					let per_page = response.data.receipts.per_page;
					let total = response.data.receipts.total;

					if (Number(total) > Number(per_page)) {
						this.show_table_footer = true;
					}
				})
				.catch((error) => {
					console.log(error);
				});
		},
		getReceiptItems: function (id) {
			axios
				.get("/api/receipt/products/" + id)
				.then((response) => {
					this.model_products = response.data;
					setTimeout(() => {
						this.showModal();
					}, 100);
				})
				.catch((error) => {
					console.log(error);
				});
		},
		showModal: function () {
			$("#receiptItemModal").modal("show");
		},
	},
};
</script>
