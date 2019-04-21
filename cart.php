<?php
			ini_set('mysql.connect_timeout', 300);
			ini_set('default_socket_timeout', 300);

			//include_once "resource/session.php";
			include 'connect.php';
			include 'class.apriori.php';
			session_start();
			if(!$_SESSION['username']){
				echo "<script> alert('Please login first') </script>";
				header('Location: index.php');
			}
			
			//include 'bsession.php';		
			
			// $servername = "localhost";
			// $username = "root";
			// $password = "";
			// $dbname = "register";
			
			// //$conn = mysql_connect($servername, $username, $password);
			// //mysql_select_db($dbname, $conn);
			// $conn = mysqli_connect($servername, $username, $password, $dbname);
			// if ($conn->connect_error) {
			// 		die("Connection failed: " . $conn->connect_error);
			// 	}
				
			if(isset($_POST["buy"])){
			
					
                if (isset($_SESSION["shopping_cart"])) {
					if($_POST['quantity']!=0){
                    $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
                    if ($_POST['quantity']<=$_POST['hidden_quant']) {
                        if (!in_array($_GET["id"], $item_array_id)) {
                            $count = count($_SESSION["shopping_cart"]);
                            $item_array = array(
                        'item_id' => $_GET["id"],
                        'item_name' => $_POST["hidden_cat"],
                        'item_price' => $_POST["hidden_price"],
						'item_quantity' => $_POST["quantity"],
						'item_seller' => $_POST["hidden_seller"]
                            
			
                        
					);
					//$aparray=array('items'=>$_POST['hidden_cat']);
					//$_SESSION['apri']=$aparray;

                            $_SESSION['it_arr']=$it_arr=array($_GET['id']);

                            //echo $item_array;
                            $_SESSION["shopping_cart"][$count] = $item_array; ?>
					<script  type="text/javascript">
						alert('Items in Cart: '+<?php echo $count + 1; ?>);  

					</script>

			<?php
                        } else {
                            echo '<script>alert("Item Added to Basket")</script>';
                            echo '<script>window.location = "cart.php"</script>';
                        }
                    } else {
                        echo '<script>alert("Item not available")</script>';
					}
				}
				else{echo '<script>alert("Quantity cannot be zero")</script>';}
                }
				
			
				else{
					$item_array = array(
						'item_id' => $_GET["id"],
						'item_name' => $_POST["hidden_cat"],
						'item_price' => $_POST["hidden_price"],
						'item_quantity' => $_POST["quantity"],
						'item_seller' => $_POST["hidden_seller"]
								);
					$_SESSION["shopping_cart"][0] = $item_array;
				}
				//$_SESSION['it_arr']=$item_array['item_id'];
				
			}
			if(isset($_GET["action"])){
			
				if($_GET["action"] == "delete"){
				foreach($_SESSION["shopping_cart"] as $keys => $values){
					if($values["item_id"] == $_GET["id"]){
						unset($_SESSION["shopping_cart"][$keys]);
						echo '<script>alert("item removed")</script>';
						echo  '<script>window.location = "cart.php"</script>';
					
					}
				
				
				}
				}
			
			
			}
			if(isset($_POST["checkout"])){
				if(isset($_SESSION["shopping_cart"])){
						
						//echo  '<script>window.location = "checkout.php"</script>';
						$orderid = uniqid();
						//echo $orderid;
						$redirect = true;
						foreach($_SESSION["shopping_cart"] as $key => $value) {
							$id1 = $value["item_id"];
							//echo $id1;
							 $category1 = $value["item_name"];
							 //echo $category1;
							$quantity1 = $value["item_quantity"];
							//echo $quantity1;
							
							$price1 = $value["item_price"];
							//echo $price1;
							$uname=$_SESSION['username'];
							$seller=$value['item_seller'];
							//echo $uname;
							//$sql = "INSERT INTO order(category, quantity, price, Buyer, productid) VALUES('$category1','$quantity1','$price1','$uname','$id1');";
							// echo $price1;
							// echo $uname;
							// echo "\n==========\n";
							// //$sql = "INSERT INTO order(category, quantity, price, Buyer, productid) VALUES('Palm Oil','3','20000','ketan','1')";
							$sql = "INSERT INTO `orders`(`orderid`,`category`, `quantity`, `price`, `Buyer`, `productid`) VALUES ('$orderid','$category1','$quantity1','$price1','$uname','$id1')";
							$result = mysqli_query($conn, $sql); 
							if($result== False){
								echo 'false';
								echo mysqli_error($conn);
								$redirect = false;
							}	
						  }
						  $items=array();
						  //print_r($_SESSION['shopping_cart']);
						  foreach($_SESSION['shopping_cart'] as $key => $value){
							  $items[]=$value['item_name'];
						  }
						  $it=implode(',',$items);
						  //echo $it;
						  $sql1="INSERT INTO test(products) VALUES ('$it')";
						  $res=mysqli_query($conn,$sql1);
						if($redirect){
							$_SESSION['orderid']=$orderid;
							echo  '<script>window.location = "checkout.php"</script>';	
						}
				}
				else{
				?>
				
							<script type = "text/javascript">
							alert("Nothing in the Cart");
							</script>

							<?php
						
				
				
				}
			
			
			}
			
			
?>

			
 
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Farmer's Basket: Buy and Sell Raw Product Online</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Font-Awesome Icons -->
	<link href = "assets/css/font-awesome.min.css" rel = "stylesheet">
		
    <!-- Custom CSS -->
    <link href="css/heroic-features.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

	<body>
	
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <p class="navbar-brand"  ><strong>Farmer's Basket</strong></p>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
          			<li>
                        <a href="buyerProfile.php" style= "padding-right: 100px;"><strong>View Profile</strong></a>
                    </li>
					
					<li>
						<a href = "logout.php" style= "padding-right: 391px;">Logout</a>
                   
					<li>
					<?php
						if(!isset($_SESSION["shopping_cart"])){
						$count = 0;
						}
						else{
						$count = count($_SESSION["shopping_cart"]); 
						}
					?>
					<a id = "viewcart"  class = "cart"style = "cursor: pointer; color: #f9a023;"><i class= " fa fa-cart-plus" style ="color:#f9a023; height: 30%; "></i> <strong> <?php echo $count; ?> Item(s)</strong></a>
				</li>
				<li style = "padding-top: 10px;">
					<form method= "post" >
		
					<button name = "checkout" class = "btn" style = "float: right; background: #f9a023;"><strong>Proceed to CheckOut</strong></button>
		
					</form>
				</li>
					
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
	
	<div class = "container">
	<header class="jumbotron hero-spacer"style= "background: url(img/background.jpg); margin-top: 0px; background-size: cover; height: 200px;">
     <h1 align ="center" style = "color: white; margin-bottom: 0px;"><?php if(isset($_SESSION['username'])) echo $_SESSION['username'] ; ?> </h1>
		<?php
		$sql = "SELECT * FROM Users WHERE `username` = '$_SESSION[username]' ";
			$run_user = mysqli_query($conn, $sql);
		
				
				$check_user = mysqli_num_rows($run_user);
				
				if($check_user > 0){
					while($row = mysqli_fetch_array($run_user)){
			
		?>
		
		<h3 align ="center" style = "color: white; margin-top: 0px;"><?php echo $row["email"]; ?></h3>
			<?php
					}
		}
		?>
	 
	 </header>   
	 
	<div class="row text-center">
			<div class = "table-responsive">
			
			<table class = "table table-bordered"  id= "tbl_cart" style = "display: none;">
				<tr>
					<th width = "20%">Item Name</th>
						<th width = "10%">Quantity</th>
					<th width = "20%">Price</th>
					<th width = "15%">Total</th>
					<th width = "5%">Action</th>
				</tr>
				<?php
						
					$total = 0;
					
					
					
					if(!empty($_SESSION["shopping_cart"])){
						
						foreach($_SESSION["shopping_cart"] as $keys => $values){
				
				?>	
					<tr>
						<?php
							$id = $values["item_id"];
							 $category = $values["item_name"];
							$quantity = $values["item_quantity"];
							$price = $values["item_price"];
							
							
							 
						?> 
						<td><?php echo $category; ?></td>
						<td><?php echo $quantity; ?></td>
						<td>₹ <?php echo $price; ?></td>
						<td><?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
						<td><a href = "cart.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class = "text-danger">Remove</span></a></td>
						
					</tr>
					<?php
						$total = $total + ($values["item_quantity"] * $values["item_price"]);
							$_SESSION["total"] = $total;
							
					}
					//echo $_SESSION[username];
					//$sql = "INSERT INTO order(orderid, category, quantity, price, Buyer, productid, status) VALUES 
					//		('$_SESSION[orderid]','$category','$quantity','$price','$_SESSION[username] ','$id', `PENDING`)";
					//$sql = "INSERT INTO order(category, quantity, price, Buyer, productid, status) VALUES 
					//		('$category','$quantity','$price','$_SESSION[username] ','$id', `PENDING`)";
					
					// $result = mysqli_query($conn, $sql);
					
					// if(mysqli_query($conn,$sql)){
					// 	echo "success";}
					// 	//header("Refresh:1; url=cart.php");
					}else{
						$_SESSION["total"] = $total;
					}
					
					
					
					?>

					<p>
						<h3 align = "right"><strong>Bill: ₹<?php  echo  number_format($total, 2) ?></strong></h3>
					</p>
								
			</table>
			
		</div>
		<div style='heigth:1000px'>
		<h3 align ="center"><strong>Frequently Phurchased Together</strong></h3>
		<div>
		<?php
		$aprio = "SELECT * FROM test";
		$run_apri = mysqli_query($conn, $aprio);
		$Apriori = new Apriori();
		$fre = array();
		error_reporting(E_ALL ^ E_WARNING); 
		$Apriori->setMaxScan(20);       //Scan 2, 3, ..
		$Apriori->setMinSup(2);         //Minimum support 1, 2, 3, ...
		$Apriori->setMinConf(75);       //Minimum confidence - Percent 1, 2, ..., 100
		$Apriori->setDelimiter(',');    //Delimiter 
		$names1 = array();
		while($row = mysqli_fetch_array($run_apri))
		{
			$names1[] = $row['products'];
		}
		$Apriori->process($names1);
		$result = array();
		$result = $Apriori->getFreqItemsets();
		//echo $result[0]." and ".$result[1];
		$result = "'" . implode("','",$result) . "'";
		//echo $result;
		//$cc = count($result);
		//$rand = rand(1, $cc-1);
		$sql = "SELECT * FROM products WHERE Category IN ($result) AND Quantity!=0 LIMIT 3; ";
		$run_user = mysqli_query($conn, $sql);
		$count_a=0;
		while($row = mysqli_fetch_array($run_user)){
		//echo $row['Category'];
		$count_a+=1;
		?>
		<div class = "col-md-4" >
			<div class = "thumbnail" align = "center" style='height:500px'>
			<form method = "post" action = "cart.php?page=<?php echo $page; $_SESSION['page']=$page; ?>?action=add&id=<?php echo $row["id"]; ?>">
				
				<img class = "img-responsive"
				<?php
					echo '<img src = "data:image/jpeg;base64,'.base64_encode($row['image']).'">';
				?>
				<div align = "center">
				<h4 class = "text-info"><strong><?php echo $row["Category"]; ?></strong></h4>
				<h4 class = "text-info" ><strong>Seller: </strong><?php echo $row["CompanyName"]; ?></h4>
				<h4 class = "text-info" ><strong>Quantity Available: </strong><?php echo $row["Quantity"]; ?> Units</h4>
				<h4 class = "text-danger">Price: ₹<?php echo $row["Prcie"]; ?></h4>
				<input type = "hidden" name = "hidden_cat" value = "<?php echo $row["Category"]; ?>" />
				<input type = "hidden" name = "hidden_seller" value = "<?php echo $row["CompanyName"]; ?>" />
				<input type = "hidden" name = "hidden_price" value = "<?php echo $row["Prcie"]; ?>" />
				<input type = "hidden" name = "hidden_name" value = "<?php echo $row["CompanyName"]; ?>" />
				<input type = "hidden" name = "hidden_quant" value = "<?php echo $row["Quantity"]; ?>" />
				<input type ="number"  style = "width: 120px;" name = "quantity" class = "form-control" placeholder = "Enter Quantity"/ value='0'></br>
				<input  style =" background: green;" type = "submit" id = "buythis" name = "buy" class="btn btn-primary" value = "Buy now"/> </br>
				</div>
				</div>
				</form>
				
		</div>
		</div>
		<br>
				<?php
					 
			}
			if($count_a==2){ ?>
				<div  align = "center" style='height:500px'>
				</div>
			<?php }
			
			?>
		<br>
		</div>
		<h1 align ="center"><strong>Explore Our Marketplace</strong></h1>
		<?php
			//echo $_SESSION['page'];
			$page = $_GET['page'];
			if($page==NULL){
				$page=1;
			}
			// echo $_GET["page"];
			$count = "SELECT * FROM products";
			$countquery = mysqli_query($conn, $count);
			$c = mysqli_num_rows($countquery);
			$rand = rand(6, $c) - 6;
			
			
			
			if($page == "" || $page == "1"){
			$page1 = 0;			
			}
			else{
				$page1 = ($page*6) - 6;
				//echo $page1;
				//$page1=0;
			}
			
			
			$sql = "SELECT * FROM products WHERE 'id' > '$rand' LIMIT $page1,6 ";
			$run_user = mysqli_query($conn, $sql);
			$check_user = mysqli_num_rows($run_user);
				$count=0;
				if($check_user > 0){
					while($row = mysqli_fetch_array($run_user)){
						$count+=1;
						//echo $count;
				?>
			<div class = "col-md-4">
			<div class = "thumbnail" align = "center" style='height:500px'>
				<form method = "post" action = "cart.php?page=<?php echo $page; $_SESSION['page']=$page; ?>?action=add&id=<?php echo $row["id"]; ?>">
				<img class = "img-responsive"
				<?php
					echo '<img src = "data:image/jpeg;base64,'.base64_encode($row['image']).'">';
				?>
				<div align = "center">
				<h4 class = "text-info"><strong><?php echo $row["Category"]; ?></strong></h4>
				<h4 class = "text-info" ><strong>Seller: </strong><?php echo $row["CompanyName"]; ?></h4>
				<?php 
				if($row["Quantity"]!=0){?>
				<h4 class = "text-info" ><strong>Quantity Available: </strong><?php echo $row["Quantity"]; ?> Units</h4>
				<?php }
				else{ ?>
					<h4 class = "text-info" ><strong>Product Unavilable </strong></h4>
				<?php }?>
				<h4 class = "text-danger">Price: ₹<?php echo $row["Prcie"]; ?></h4>
				<input type = "hidden" name = "hidden_cat" value = "<?php echo $row["Category"]; ?>" />
				<input type = "hidden" name = "hidden_seller" value = "<?php echo $row["CompanyName"]; ?>" />
				<input type = "hidden" name = "hidden_price" value = "<?php echo $row["Prcie"]; ?>" />
				<input type = "hidden" name = "hidden_name" value = "<?php echo $row["CompanyName"]; ?>" />
				<input type = "hidden" name = "hidden_quant" value = "<?php echo $row["Quantity"]; ?>" />
				<?php if($row["Quantity"]!=0){ ?>
				<input type ="number"  style = "width: 120px;" name = "quantity" class = "form-control" placeholder = "Enter Quantity"/ value='0'></br>
				<input  style =" background: green;" type = "submit" id = "buythis" name = "buy" class="btn btn-primary" value = "Buy now"/> </br>
				<?php } else{ ?>
					<p></p>
				
					<?php } ?>
				</div>
				</div>
				</form>
			
			</div>
			</br>
				<?php
					 
			}
			if($count==2 | $count==4){ ?>
				<div  align = "center" style='height:500px'>
				</div>
			<?php }
					//$c=600;
					$no_of_pages = ceil($c/6);
					for($i = 1 ; $i <= $no_of_pages; $i++){
						?><a href = "cart.php?page=<?php echo $i ?>"><?php echo $i." "; ?></a><?php 
					
					}
				}
			
			
			
		
		?>
		
	</div>



			
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/showhide.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

	
	
	</div>
	<div style = "padding: 1em 0 2em 0;">
	
		<footer id="footer" class="container" style ="background: #fff; color: black; width: 100%; ">
										<hr style = "border-top: 1px solid #ccc;"><br/><br/><br/>
										<p align = "center">Farmer's Basket</p>
										
		</footer>
				
	</div>

	
	</body>
</html>