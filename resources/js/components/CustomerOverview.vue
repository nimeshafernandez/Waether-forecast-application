<template>
	<div class="row layout-top-spacing">
		<div class="col-lg-12 mt-3 mb-5">
			<div class="card component-card_1">
				<div class="card-header">
					<div class="row">
						<div class="col">
							<h5 class="card-title">Credit Customer Overview</h5>
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
											<td :class="customer.credit.total > 0 ? 'text-danger' : 'text-success' " >{{customer.credit.total | currency}}</td>
											<td>{{customer.phone}}</td>
											<td>{{customer.nic_no}}</td>
											<td style="text-align:center">
												<i @click="showCustomerProfile(customer.id)" class="fas fa-eye mx-1 text-success" style="cursor:pointer;"></i>
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
	</div>
</template>

<script>
export default {
	created() {
		Fire.$on("searching", () => {
			this.getSearchCustomer();
		});
	},
	mounted() {
		this.getCustomerList();
	},
	data() {
		return {
			customers: {},
			show_table_footer: false,

			search_term: "",
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
			if(this.search_term == "" || this.search_term == null) {
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
		showCustomerProfile: function (id) {
			window.location.href = "/customer/" + id;
		}
	},
};
</script>
