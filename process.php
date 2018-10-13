<?php
	session_start();

	$_SESSION['err'] = 1;
	foreach($_POST as $key => $value){
		if(trim($value) == ''){
			$_SESSION['err'] = 0;
		}
		break;
	}

	if($_SESSION['err'] == 0){
		header("Location: purchase.php");
	} else {
		unset($_SESSION['err']);
	}

	require_once "./functions/database_functions.php";
	// print out header here
	$title = "Purchase Process";
	require "./template/header.php";
	// connect database
	$conn = db_connect();
	extract($_SESSION['ship']);

	// find customer
	// $_SESSION['insert_customer'];
	$customerid = getCustomerId($name, $address, $city, $zip_code, $country);
	if($customerid == null) {
		// insert customer into database and return customerid
		$customerid = setCustomerId($name, $address, $city, $zip_code, $country);
	}
	$date = date("Y-m-d H:i:s");
	$query = insertIntoOrder($conn, $customerid, $_SESSION['total_items'], $_SESSION['total_price'], $date);
	echo $query;

	// take orderid from order to insert order items
	$orderid = getOrderId($conn, $customerid);
	$_GET['order_id'] = $orderid;
	foreach($_SESSION['cart'] as $isbn => $qty){
		$bookprice = getbookprice($isbn);
		$insert_order_query = "INSERT INTO `order_items`(`order_id`, `order_items`, `order_price`, `order_quantity`) VALUES ('$orderid','$isbn','$bookprice','$qty')";
		$result = mysqli_query($conn, $insert_order_query);
		if(!$result){
			echo "Insert value false!" . mysqli_error($conn);
			exit;
		}
	}

	session_unset();
?>
	<p class="lead text-success">Your order has been processed sucessfully. Please check your email to get your order confirmation and shipping detail!. 
	Your cart has been empty.</p>

<?php
	if(isset($conn)){
		mysqli_close($conn);
	}
	require_once "./template/footer.php";
?>