<style>
	.img-thumb-path {
		width: 100px;
		height: 80px;
		object-fit: scale-down;
		object-position: center center;
	}
</style>
<div class="card card-outline card-primary rounded-0 shadow">
	<div class="card-header">
		<h3 class="card-title">List of Products</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary"><span
					class="fas fa-plus"></span> Add New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="30%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="40%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Product Name</th>
						<th>Image</th>
						<th>Price</th>
						<th>Stocks</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * from `products` where delete_flag = 0 order by `name` asc ");
					while ($row = $qry->fetch_assoc()):
						?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class=""><?php echo $row['name'] ?></td>
							<td class="">
								<img src="products/<?php echo $row['id']; ?>.png" alt="Image" width="50" height="50">
							</td>

							<td class=""><?php echo number_format($row['price'], 2) ?></td>
							<td class=""><?php echo $row['stocks'] ?></td>
							<td class="truncate-1"><?php echo $row['description'] ?></td>
							<td align="center">
								<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon"
									data-toggle="dropdown">
									Action
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item edit_data" href="javascript:void(0)"
										data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span>
										Edit</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item delete_data" href="javascript:void(0)"
										data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span>
										Delete</a>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('#create_new').click(function () {
			uni_modal("Add New Product", "products/manage_product.php")
		})
		$('.edit_data').click(function () {
			uni_modal("Update Product Details", "products/manage_product.php?id=" + $(this).attr('data-id'))
		})
		$('.delete_data').click(function () {
			_conf("Are you sure to delete this Product permanently?", "delete_product", [$(this).attr('data-id')])
		})
		$('.table td, .table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
			columnDefs: [
				{ orderable: false, targets: 5 }
			],
		});
	})
	function delete_product($id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_product",
			method: "POST",
			data: { id: $id },
			dataType: "json",
			error: err => {
				console.log(err)
				alert_toast("An error occurred.", 'error');
				end_loader();
			},
			success: function (resp) {
				if (typeof resp == 'object' && resp.status == 'success') {
					location.reload();
				} else {
					alert_toast("An error occurred.", 'error');
					end_loader();
				}
			}
		})
	}
</script>