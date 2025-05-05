<style>
	#cashStatement .buttons {
		margin-top: -5px;
	}

	.account-section {
		display: flex;
		border: none;
		border-radius: 5px;
		overflow: hidden;
		margin-bottom: 20px;
	}

	.account-section h3 {
		margin: 10px 0;
		padding: 0;
	}

	.account-section h4 {
		margin: 0;
		margin-top: 3px;
	}

	.account-section .col1 {
		background-color: #82a253;
		color: white;
		flex: 1;
		text-align: center;
		padding: 10px;
	}

	.account-section .col2 {
		background-color: #edf3e2;
		flex: 2;
		padding: 10px;
		align-items: center;
		text-align: center;
	}
</style>
<div id="cashStatement">
	<div class="row" style="border-bottom: 1px solid #ccc;">
		<div class="col-md-12">
			<form action="" class="form-inline" @submit.prevent="getStatements">
				<div class="form-group">
					<label for="">Date from</label>
					<input type="date" class="form-control" v-model="filter.dateFrom">
				</div>

				<div class="form-group">
					<label for="">to</label>
					<input type="date" class="form-control" v-model="filter.dateTo">
				</div>

				<div class="form-group buttons">
					<input type="submit" value="Search">
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" style="padding-top:15px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
	</div>

	<div id="printContent">
		<div class="row" style="padding-top:10px;">
			<div class="col-md-6 col-md-offset-3">
				<!-- Sales -->
				<table class="table table-bordered table-condensed">
					<tr>
                        <td style="text-align: left;width: 50%;">Total Sale Amount</td>
                        <td style="width: 5%;">:</td>
                        <td style="width: 45%;text-align:right;">0</td>
                    </tr>
					<tr>
                        <td style="text-align: left;width: 50%;">Cash Amount</td>
                        <td style="width: 5%;">:</td>
                        <td style="width: 45%;text-align:right;">0</td>
                    </tr>
					<tr>
                        <td style="text-align: left;width: 50%;">Bank Amount</td>
                        <td style="width: 5%;">:</td>
                        <td style="width: 45%;text-align:right;">0</td>
                    </tr>
					<tr>
                        <td style="text-align: left;width: 50%;">Return Amount</td>
                        <td style="width: 5%;">:</td>
                        <td style="width: 45%;text-align:right;">0</td>
                    </tr>
					<tr>
                        <td style="text-align: left;width: 50%;">Exchange Amount</td>
                        <td style="width: 5%;">:</td>
                        <td style="width: 45%;text-align:right;">0</td>
                    </tr>
					<tr>
                        <td style="text-align: left;font-weight:700;width: 50%;">Close Balance</td>
                        <td style="width: 5%;">:</td>
                        <td style="width: 45%;font-weight:700;text-align:right;">0</td>
                    </tr>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
	new Vue({
		el: '#cashStatement',
		data() {
			return {
				filter: {
					dateFrom: moment().format('YYYY-MM-DD'),
					dateTo: moment().format('YYYY-MM-DD'),
                    employeeId: ''
				},
                selectedEmployee: null,
				sales: []
			}
		},
		filters: {
			decimal(value) {
				return value == null ? 0.00 : parseFloat(value).toFixed(2);
			}
		},
		created() {
			this.getStatements();
		},
		methods: {
			getStatements() {
                this.filter.employeeId = this.selectedEmployee.Employee_SlNo ?? '';
				this.getSales();
			},

			getSales() {
				axios.post('/get_sales', this.filter)
					.then(res => {
						this.sales = res.data.sales;
					})
			},
			getSaleReturn() {
				axios.post('/get_sale_returns', this.filter)
					.then(res => {
						this.saleReturns = res.data
					})
			},

			async print() {
				let printContent = `
					<div class="container">
						<h4 style="text-align:center">Cash Statements</h4 style="text-align:center">
						<div class="row">
							<div class="col-xs-12 text-center">
								<strong>Statement from</strong> ${this.filter.dateFrom} <strong>to</strong> ${this.filter.dateTo}
							</div>
						</div>
					</div>
					<div class="container">
						${document.querySelector('#printContent').innerHTML}
					</div>
				`;

				var printWindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}`);
				printWindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php'); ?>
				`);

				printWindow.document.body.innerHTML += printContent;
				printWindow.document.head.innerHTML += `
					<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
					<style>
						th{
							text-align: center;
						}
						.account-section{
							display: flex;
							border: none;
							border-radius: 5px;
							overflow:hidden;
							margin-bottom: 20px;
						}

						.account-section h3{
							margin: 10px 0;
							padding: 0;
						}

						.account-section h4{
							margin: 0;
							margin-top: 3px;
						}

						.account-section .col1{
							background-color: #82a253;
							color: white;
							flex: 1;
							text-align: center;
							padding: 10px;
						}
						.account-section .col2{
							background-color: #edf3e2;
							flex: 2;
							padding: 10px;
							align-items: center; 
							text-align:center;
						}
					</style>
				`;

				printWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				printWindow.print();
				printWindow.close();
			}
		}
	})
</script>