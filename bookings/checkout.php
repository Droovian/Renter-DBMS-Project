<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

<div class="w-full min-h-screen flex justify-center items-center">
  <div class="w-full max-w-md p-6 bg-white rounded-md shadow-md">
    <h3 class="text-2xl font-semibold text-center my-4">Checkout Form</h3>
    <form action="payscript.php" method="post">
      <div class="mb-4">
        <label for="fname" class="text-gray-600 font-semibold">
          <i class="fa fa-user"></i> Full Name
        </label>
        <input type="text" id="fname" name="name" placeholder="John M. Doe"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500"
          required>
      </div>
      <div class="mb-4">
        <label for="email" class="text-gray-600 font-semibold">
          <i class="fa fa-envelope"></i> Email
        </label>
        <input type="text" id="email" name="email" placeholder="john@example.com"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500"
          required>
      </div>
      <input type="hidden" value="<?php echo 'OID'.rand(100,1000);?>" name="orderid">
      <input type="hidden" value="<?php echo 1;?>" name="amount">
      <div class="mb-4">
        <label for="mobile" class="text-gray-600 font-semibold">
          <i class="fa fa-mobile"></i> Mobile
        </label>
        <input type="text" id="mobile" name="mobile" placeholder="Mobile Number"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500"
          required>
      </div>
      <div class="mb-4">
        <label for="adr" class="text-gray-600 font-semibold">
          <i class="fa fa-address-card-o"></i> Address
        </label>
        <input type="text" id="adr" name="address" placeholder="542 W. 15th Street"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500"
          required>
      </div>
      <div class="text-center">
        <input type="submit" value="Pay Now"
          class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-amber-500 focus:ring-opacity-50">
      </div>
    </form>
  </div>
</div>

</body>

</html>
