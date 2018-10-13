<?php
	session_start();
	require_once "./functions/database_functions.php";
	$conn = db_connect();
	$_SESSION['err'] = 1;
	foreach($_POST as $key => $value){
		if(trim($value) == ''){
			$_SESSION['err'] = 0;
		}
		break;
	}

	if($_SESSION['err'] == 0){
		header("Location: checkout.php");
	} else {
		unset($_SESSION['err']);
	}

	// if (isset($_POST['submit'])) {
	// 	echo "hjjkd";
	// 	$name = trim($_POST['name']);
	// 	$name = mysqli_real_escape_string($conn, $name);

	// 	echo $name;

	// 	$address = trim($_POST['address']);
	// 	$address = mysqli_real_escape_string($conn, $address);
	// 	echo $address;

	// 	$city = trim($_POST['city']);
	// 	$city = mysqli_real_escape_string($conn, $city);
	// 	echo $city;

	// 	$zip_code = trim($_POST['zip_code']);
	// 	$zip_code = mysqli_real_escape_string($conn, $zip_code);

	// 	$country = trim($_POST['country']);
	// 	$country = mysqli_real_escape_string($conn, $country);
	// 	echo $country;

	// 	$insert_customer_query = "INSERT INTO `users`(`name`,`address`, `city`, `zip_code`, `country`, `user_type`) VALUES ('$name','$address','$city','$zip_code','$country','customer')";

	// 	$result = mysqli_query($conn, $insert_customer_query);
	// 	$_SESSION['insert_customer'] = $result;
	// }


	$_SESSION['ship'] = array();
	foreach($_POST as $key => $value){
		if($key != "submit"){
			$_SESSION['ship'][$key] = $value;
		}
	}
	// print out header here
	$title = "Purchase";
	require "./template/header.php";
	// connect database
	if(isset($_SESSION['cart']) && (array_count_values($_SESSION['cart']))){
?>
	<table class="table">
		<tr>
			<th>Item</th>
			<th>Price</th>
	    	<th>Quantity</th>
	    	<th>Total</th>
	    </tr>
	    	<?php
			    foreach($_SESSION['cart'] as $isbn => $qty){
					$conn = db_connect();
					$book = mysqli_fetch_assoc(getBookByIsbn($conn, $isbn));
			?>
		<tr>
			<td><?php echo $book['book_title'] . " by " . $book['book_author']; ?></td>
			<td><?php echo "$" . $book['book_price']; ?></td>
			<td><?php echo $qty; ?></td>
			<td><?php echo "$" . $qty * $book['book_price']; ?></td>
		</tr>
		<?php } ?>
		<tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th><?php echo $_SESSION['total_items']; ?></th>
			<th><?php echo "$" . $_SESSION['total_price']; ?></th>
		</tr>
		<tr>
			<td>Shipping</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>20.00</td>
		</tr>
		<tr>
			<th>Total Including Shipping</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th><?php echo "$" . ($_SESSION['total_price'] + 20); ?></th>
		</tr>
	</table>
	<form method="post" action="process.php" class="form-horizontal">
		 <h5> <strong> Payment Method</strong></h5>
        	<div class="radio">
			  <label><input type="radio" name="optradio" checked>Cash On Delivery</label>
			</div>
			<div class="radio">
			  <label><input type="radio" name="optradio">Credit Card</label>
			</div>
        <div class="form-group">
            <div class="col-lg-10">
              	<button type="reset" class="btn btn-default" style="margin-top: 50px;">Cancel</button>
              	<button type="submit" class="btn btn-primary" style="margin-top: 50px;">Purchase</button>
            </div>
        </div>
    </form> <br>
	<p class="lead">Please press Purchase to confirm your purchase, or Continue Shopping to add or remove items.</p>
<?php
	} else {
		echo "<p class=\"text-warning\">Your cart is empty! Please make sure you add some books in it!</p>";
	}
	if(isset($conn)){ mysqli_close($conn); }
	require_once "./template/footer.php";
?>