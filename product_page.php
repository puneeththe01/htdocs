<!DOCTYPE html>
<html>

<head>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" />
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <style>
          body {
               background: #eee;
          }

          .ratings i {
               font-size: 16px;
               color: red;
          }

          .strike-text {
               color: red;
               text-decoration: line-through;
          }

          .product-image {
               width: 100%;
          }

          .dot {
               height: 7px;
               width: 7px;
               margin-left: 6px;
               margin-right: 6px;
               margin-top: 3px;
               background-color: blue;
               border-radius: 50%;
               display: inline-block
          }

          .spec-1 {
               color: #938787;
               font-size: 15px;
          }

          h5 {
               font-weight: 400;
          }

          .para {
               font-size: 16px;
          }
     </style>
</head>

<body>
     <?php
     // Replace these credentials with your database details
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "test";

     // Create connection
     $conn = new mysqli($servername, $username, $password, $dbname);

     // Check connection
     if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
     }

     // Define the query to fetch products from the database
     $query = "SELECT * FROM products";
     $result = $conn->query($query);

     // Check if there are rows in the result
     if ($result->num_rows > 0) {
          // Fetch each row and store it in the $products array
          $products = [];
          while ($row = $result->fetch_assoc()) {
               $products[] = [
                    'name' => $row['product_name'],
                    'image' => $row['product_image'],
                    'price' => $row['product_price'],
                    'discountedPrice' => $row['discounted_price'],
                    'ratings' => $row['product_ratings'],
                    'details' => $row['product_details']
               ];
          }
     } else {
          // No products found
          $products = [];
     }

     // Close the database connection
     $conn->close();
     ?>

     <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="home_page.php">&leftarrow; back</a>
          <div class="collapse navbar-collapse" id="navbarNav">
               <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                         <a class="nav-link" href="home_page.php">Home</span></a>
                    </li>
                    <li class="nav-item active">
                         <a class="nav-link" href="product_page.php">Products <span class="sr-only">(current)</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link" href="cart.php">Cart</span></a>
                    </li>
               </ul>
          </div>
     </nav>

     <!-- Now use the $products array to generate the HTML content -->

     <div class="container mt-5 mb-5">
          <div class="d-flex justify-content-center row">
               <div class="col-md-10">
                    <?php foreach ($products as $product) : ?>
                         <div class="row p-2 bg-white border rounded mt-2">
                              <div class="col-md-3 mt-1">
                                   <img class="img-fluid img-responsive rounded product-image" src="<?php echo $product['image']; ?>">
                              </div>
                              <div class="col-md-6 mt-1">
                                   <h5><?php echo $product['name']; ?></h5>
                                   <div class="d-flex flex-row">
                                        <div class="ratings mr-2">
                                             <?php for ($i = 0; $i < 4; $i++) : ?>
                                                  <i class="fa fa-star"></i>
                                             <?php endfor; ?>
                                        </div>
                                        <span><?php echo $product['ratings']; ?></span>
                                   </div>
                                   <div class="mt-1 mb-1 spec-1">
                                        <span><?php echo $product['details']; ?></span>
                                   </div>
                              </div>
                              <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                                   <div class="d-flex flex-row align-items-center">
                                        <h4 class="mr-1">$<?php echo $product['price']; ?></h4>$<span class="strike-text"><?php echo $product['discountedPrice']; ?></span>
                                   </div>
                                   <h6 class="text-success">Free shipping</h6>
                                   <div class="d-flex flex-column mt-4">
                                        <!-- Form for adding products to the cart -->
                                        <form action="cart.php" method="post">
                                             <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                                             <button class="btn btn-outline-primary btn-sm mt-2" type="submit">Add to cart</button>
                                        </form>
                                   </div>
                              </div>
                         </div>
                    <?php endforeach; ?>
               </div>
          </div>
     </div>

</body>

</html>
