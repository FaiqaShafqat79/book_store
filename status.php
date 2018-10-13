<?php
	session_start();
	require_once "./functions/admin.php";
	$title = "Order Status";
	require_once "./template/header.php";
	require_once "./functions/database_functions.php";
	$conn = db_connect();
	$result = getAllOrders($conn);

	

// 	if (isset($_POST['formSubmit'])) {
// 		echo " 
// 		<script type=\"text/javascript\">
// 		$("input[type='checkbox']").on("click", function () {
//     if ($(this).is(':checked')) {
//         var id = $(this).closest('tr').attr('id');
//         alert(id);
//     }
// });
// 	</script>
// 		";
// 	}

// if(isset($_POST['amount_recieve']) && 
//    $_POST['amount_recieve'] == 'Yes') 
// {
// 	// $row = mysqli_fetch_assoc($result);
//  //    echo $row['order_id'];
// 	// }



// }
?>	

	<br>
	<table class="table" style="margin-top: 20px">
		<tr>
			<th>Order Id</th>
			<th>Customer Id</th>
			<th>Order Quantity</th>
			<th>Total Amount</th>
			<th>Date</th>
			<th>Amount Recieved</th>
		</tr>
		<?php while($row = mysqli_fetch_assoc($result)){ ?>
		<tr>
			<td><?php echo $row['order_id']; ?></td>
			<td><?php echo $row['customer_id']; ?></td>
			<td><?php echo $row['order_quantity']; ?></td>
			<td><?php echo $row['amount']; ?></td>
			<td><?php echo $row['date']; ?></td>
			<td>
    	<input type="checkbox" name="amount_recieve" value="Yes" />
    	<a href="admin_order_status.php?id=<?php echo $row['order_id'] ?>">Submit</a>
			</td>
		</tr>
		<?php } ?>
	</table>

<?php
	if(isset($conn)) {mysqli_close($conn);}
	require_once "./template/footer.php";
?>