<?php
	session_start();
	require_once "./functions/admin.php";
	$title = "Order Status";
	require_once "./template/header.php";
	require_once "./functions/database_functions.php";
	$conn = db_connect();
	$result = getAllOrders($conn);


	if (isset($_GET['id'])) {
		$order_id = $_GET['id'];

		$update_status = "UPDATE `orders` SET `order_status`='delivered' WHERE order_id='$order_id'";
		$update_status_result = mysqli_query($conn, $update_status);
			if(!$update_status_result){
			echo "Insert orders failed " . mysqli_error($conn);
			exit;
		}
	}

?>
	
	<br>
	<table class="table" style="margin-top: 20px">
		<tr>
			<th>Order Id</th>
			<th>Customer Id</th>
			<th>Order Quantity</th>
			<th>Total Amount</th>
			<th>Date</th>
			<th>Status</th>
		</tr>
		<?php while($row = mysqli_fetch_assoc($result)){ ?>
		<tr>
			<td><?php echo $row['order_id']; ?></td>
			<td><?php echo $row['customer_id']; ?></td>
			<td><?php echo $row['order_quantity']; ?></td>
			<td><?php echo $row['amount']; ?></td>
			<td><?php echo $row['date']; ?></td>
			<td><?php echo $row['order_status']; ?></td>
		</tr>
		<?php } ?>
	</table>

<?php
	if(isset($conn)) {mysqli_close($conn);}
	require_once "./template/footer.php";
?>