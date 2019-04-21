<?php

	include 'connect.php';		
	session_start();
	if(!$_SESSION['username']){
		echo "<script> alert('Please login first') </script>";
		header('Location: index.php');
	}
	
			
	if ($_SESSION["total"] == 0){
	?>
		<script type = "text/javascript">
		alert("Your Cart is Empty");
		window.location.href = "cart.php";
		</script>

		<?php

	}
	
	if(isset($_POST["orderProduct"])){
	
			$id = $_SESSION["orderid"];
			$fname = $_POST["fname"];
			$lname = $_POST["lname"];
			$mobile = $_POST["mobile"];
			$address = $_POST["address"];
			$near = $_POST["near"];
			$state = $_POST["state"];
			$city = $_POST["city"];
			$payment = 10*$_SESSION["total"]/100 + $_SESSION["total"];
			$itid=$_SESSION['ItemIdd'];
			$itQu=$_SESSION['ItemQuan'];
			$itSel=$_SESSION['ItemSell'];	
			$cou=count($itid);
				
			
			if ($_POST["state"] == "Select State"){
					?>
				<script type = "text/javascript">
				alert("Please Select a State");
				</script>

			<?php
			}else{
				for($i=0;$i<$cou;$i++){
					$sell=$itSel[$i];
					$sql="SELECT * from delivery where `id`='$id' AND `Seller`='$sell' ;";
					
					$res=mysqli_query($conn,$sql);
					//echo $sql;

					$no=mysqli_num_rows($res);
					if($no==0){
						$sql = "INSERT INTO delivery(id, firstname, lastname, mobile, address, city, near, price, state, Seller, products, quantity, status) 
					VALUES('$_SESSION[orderid]', '$fname', '$lname', '$mobile', '$address', '$city', '$near', '$payment',  '$state','$sell','$itid[$i]','$itQu[$i]','PENDING')";
					
					$result = mysqli_query($conn, $sql); 
					//echo $result;
					//if($result){echo 'succ';}
					}
					else{
						$s1="SELECT products,quantity from `delivery` WHERE `id` = '$id' AND `Seller`='$sell';";
						$re1=mysqli_query($conn,$s1);
						//echo $s1;

						$row=mysqli_fetch_array($re1);
						$rowPro=$row['products'];
						$rowQuan=$row['quantity'];

						$resPro=$rowPro.','.$itid[$i];
						$resQuan=$rowQuan.','.$itQu[$i];
						$sql = "UPDATE `delivery` SET `quantity` = '$resQuan',`products`='$resPro' WHERE `id` = '$id' AND `Seller`='$sell' ";
					$result = mysqli_query($conn, $sql); 
					//if($result){echo 'succ';}
					}	
					$productId = $itid[$i];
    				$qty = $itQu[$i];
    				$sql = "UPDATE `products` SET `Quantity` = `Quantity` - $qty WHERE `id` = $productId";
					$res=mysqli_query($conn,$sql);
					//if($res){echo 'sss';}
					}
					
					?>
			 	<script type = "text/javascript">
			 	alert("Successful Order");
			 	window.location.href = "buyerProfile.php";
			 	</script>
			 <?php
				}
			// $payment = 10*$_SESSION["total"]/100 + $_SESSION["total"];
			// $sql = "INSERT INTO delivery(id, firstname, lastname, mobile, address, city, near, price, state, status) 
			// 	VALUES('$_SESSION[orderid]', '$fname', '$lname', '$mobile', '$address', '$city', '$near', '$payment',  '$state','PENDING')";

			
			// $result = mysqli_query($conn, $sql); 
			// 		//echo $sql;
			
			// if ($result){
			// 	$itid=$_SESSION['ItemIdd'];
			// 	$itQu=$_SESSION['ItemQuan'];
				
			// 	$cou=count($itid);
			// 	for($i=0;$i<$cou;$i++){
			// 		//echo $itemQuan[0];
			// 		//echo 'nnnnnn';
			// 		$productId = $itid[$i];
    		// 		$qty = $itQu[$i];
    		// 		$sql = "UPDATE `products` SET `Quantity` = `Quantity` - $qty WHERE `id` = $productId";
			// 		$res=mysqli_query($conn,$sql);
			// 		//if($res){echo 'sss';}
			// 	}
			 	?>
			 	<script type = "text/javascript">
			 	alert("Successful Order");
			 	window.location.href = "buyerProfile.php";
			 	</script>
			 <?php
			// 	}
		//not else{
		// 			echo $sql;
		// 	}

		}

			
			
				
	
	
	

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Farm Basket: Buy and Sell Raw Product Online</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

		
    <!-- Custom CSS -->
    <link href="css/heroic-features.css" rel="stylesheet">

  
</head>

<body style = "padding-top: 30px;">
   
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><strong>Farm Connect</strong></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    
					<li>
                        <a href="logout.php"><strong>Logout</strong></a>
                    </li>
					
                </ul>
            </div>
        </div>
    </nav>
	</br>
	
</br>	
</br>





<div class = "container">

		<div class="row text-center" style = "border: outset; ">
		<div style = "padding: 20px;">
		<h1 align= "left" >Checkout</h1>
		
		<div style = "border-top: ridge; border-bottom: ridge;  width: 95%; ">
			<div style = "border-bottom: ridge;">
			<h3 align= "left" style = "color: purple;">Add Delivery Address   <b style = "color: #ffbe58;">(Pay On Delivery)</b></h3>
			<!--<p style = "float: right; color: grey;"><i>Your delivery address determines delivery charges</i> </p><br/>
			--></div>
		
		<br/>
		<div style = "width: 65%; padding-left: 30px; ">
		<form method = "post">
		<div class="form-group ">
		   <input type="text" class="form-control" minlength="3" placeholder="Firstname" name ="fname" required>
		   <i class="fa fa-user"></i>
		 </div>
		<div class="form-group ">
		   <input type="text" class="form-control" minlength="6" placeholder="Lastname"name ="lname" required>
		   <i class="fa fa-user"></i>
		 </div>
		<div class="form-group ">
		   <input type="text" class="form-control" minlength="11" placeholder="Mobile Number" name ="mobile" required>
		   <i class="fa fa-user"></i>
		 </div>
		<div class="form-group ">
		   <input type="text" class="form-control" minlength="10" placeholder= "Street Address"  name ="address" required>
		   <i class="fa fa-user"></i>
		 </div>
		<div class="form-group ">
		   <input type="text" class="form-control" minlength="5" placeholder="City"  name ="city" required>
		   <i class="fa fa-user"></i>
		 </div>
		<div class="form-group ">
		   <input type="text" class="form-control" minlength="10" placeholder="Opposite, Next to, Near By..." name ="near" required>
		   <i class="fa fa-user"></i>
		 </div>
		
		
		
		
		 <div class="form-group ">
				<select name = "state" style = "width: 100%;" required>
				<option value="">Select State</option>
<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
<option value="Andhra Pradesh">Andhra Pradesh</option>
<option value="Arunachal Pradesh">Arunachal Pradesh</option>
<option value="Assam">Assam</option>
<option value="Bihar">Bihar</option>
<option value="Chandigarh">Chandigarh</option>
<option value="Chhattisgarh">Chhattisgarh</option>
<option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
<option value="Daman and Diu">Daman and Diu</option>
<option value="Delhi">Delhi</option>
<option value="Goa">Goa</option>
<option value="Gujarat">Gujarat</option>
<option value="Haryana">Haryana</option>
<option value="Himachal Pradesh">Himachal Pradesh</option>
<option value="Jammu and Kashmir">Jammu and Kashmir</option>
<option value="Jharkhand">Jharkhand</option>
<option value="Karnataka">Karnataka</option>
<option value="Kerala">Kerala</option>
<option value="Lakshadweep">Lakshadweep</option>
<option value="Madhya Pradesh">Madhya Pradesh</option>
<option value="Maharashtra">Maharashtra</option>
<option value="Manipur">Manipur</option>
<option value="Meghalaya">Meghalaya</option>
<option value="Mizoram">Mizoram</option>
<option value="Nagaland">Nagaland</option>
<option value="Orissa">Orissa</option>
<option value="Pondicherry">Pondicherry</option>
<option value="Punjab">Punjab</option>
<option value="Rajasthan">Rajasthan</option>
<option value="Sikkim">Sikkim</option>
<option value="Tamil Nadu">Tamil Nadu</option>
<option value="Tripura">Tripura</option>
<option value="Uttaranchal">Uttaranchal</option>
<option value="Uttar Pradesh">Uttar Pradesh</option>
<option value="West Bengal">West Bengal</option>
			</select>
		   <i class="fa fa-user"></i>
		 </div>
		 
		</div>
	
		</div>
		 
		</div>
		
		
		
		
				<div class = "table-responsive" id= "tbl_cart" style= "width : 75% ;padding: 30px;" >
			<h1 align = "left">Items In Cart</h1>
			<table class = "table table-bordered">
				<tr>
					<th width = "10%">Item</th>
					<th width = "20%">Item Name</th>
					<th width = "5%">Quantity</th>
					<th width = "20%">Price</th>
					<th width = "10%">Seller</th>
					
				</tr>
		<?php
		
		$sql =	"SELECT orders.category, orders.quantity, orders.price, products.image, products.CompanyName,products.id FROM `orders`, `products` WHERE orders.Buyer = '$_SESSION[username]' AND orders.orderid =  '$_SESSION[orderid]' AND products.id = orders.productid; ";
			$run_user = mysqli_query($conn, $sql);
		
				$check_user = mysqli_num_rows($run_user);
				$itemidd=[];
				$itemQuan = [];
				$itemSell=[];
				if($check_user > 0){
					while($row = mysqli_fetch_array($run_user)){
						// $itemQuan=array(
						// 	'itemId'=>$row['id'],
						// 	'itemquan'=>$row['quantity']
						// );

						// $_SESSION['ItemQuan']=$itemQuan;
						array_push($itemidd,$row['id']);
						array_push($itemQuan,$row['quantity']);
						array_push($itemSell,$row['CompanyName']);
		?>
				
				
				
				<tr>
					<th width = "10%"><?php echo '<img  style = " border-radius: 10px;height: 45px; width: 45px;"src = "data:image/jpeg;base64,'.base64_encode($row["image"]).'">'; ?></th>
					<th width = "20%"><?php echo $row["category"]; ?></th>
					<th width = "5%"><?php echo $row["quantity"]; ?></th>
					<th width = "20%"><?php echo $row["price"]; ?></th>
					<th width = "20%" style = "color: purple;"><?php echo $row["CompanyName"]; ?></th>
					
				</tr>
		<?php	
					}
					//echo implode(',',$itemidd);
					//echo implode(',',$itemQuan);
					// for($i=0;$i<2;$i++){
					// 	echo $itemidd[$i];
					// }
					$_SESSION['ItemIdd']=$itemidd;
					$_SESSION['ItemQuan']=$itemQuan;
					$_SESSION['ItemSell']=$itemSell;
		}
		?>
			
			
			
			
			
			
			
			</table>
			</div>
		
		</div>
		<br/>
		<br/>

 <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

	
	







</div>
		<div class = "order" style = " height: 200px; background: #333; opacity: 0.7; filter:alpha (opacity =70); padding-left: 50px; padding-right: 50px; padding-top: 20px;">
		   <div style ="float: left; width: 40%; border: 2px solid #fff; border-radius: 5px; padding-left: 10px;padding-right: 10px;  margin-bottom: 20px;" >
		   <h3 style = "color: #ff8400;">Order Summary</h3>
			<p style= "color: #fff;">Purchase Bill:  ₹<?php echo number_format($_SESSION["total"], 2);?><br/>
			Delivery Charges:   ₹<?php $d = 10*$_SESSION["total"]/100; echo number_format($d, 2); ?><br/><br/>
			TOTAL:  ₹<?php  echo number_format($d + $_SESSION["total"], 2)?>
			
			</p>
		   
		   </div>
		   <div style ="float: right; color: #fff; width: 50%;" align = "right">
		   <p>
		   <h3 style= "color: #ff8400;"><strong>₹<?php echo number_format($d + $_SESSION["total"], 2)?></strong></h3>
		   <button name = "orderProduct" type="submit" class="btn btn-primary" style= "text-shadow: none;height: 50px; color: #fff; font-size:20px; border-radius:5px; background: #333;">Order Now</button> 
			
			</p></div>
		</div>
	
	</form>
	 
	<div style = "padding: 1em 0 2em 0;">
	
		<footer id="footer" class="container" style ="background: #fff; color: black; width: 100%; ">
										<hr style = "border-top: 1px solid #ccc;"><br/><br/><br/>
										<p align = "center">Farmer's Basket</p>
								
		</footer>
				
</div>


</body>
</html>