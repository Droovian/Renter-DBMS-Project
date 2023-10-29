<?php
session_start();

if (!isset($_SESSION['username'])) {
    // User is not authenticated, redirect to the login page
    header('Location: login.php');
    exit();
}

include("database.php");
function getPropertyListings($conn, $searchLocation = null, $propertyType = null) {
    $sql = "SELECT * FROM property_listings WHERE 1=1"; // Start with a valid SQL query

    $params = [];

    if ($searchLocation !== null) {
        // Split the search string by space or hyphen
        $searchTerms = preg_split("/[\s-]+/", $searchLocation);
        
        // Create an array to hold the conditions
        $conditions = [];

        foreach ($searchTerms as $term) {
            $term = '%' . $term . '%'; // Add % to each term
            $conditions[] = "location LIKE ?";
            $params[] = $term;
        }

        // Combine the conditions using OR
        $sql .= " AND (" . implode(" OR ", $conditions) . ")";
    }

    if ($propertyType !== null && $propertyType !== "") { // Check if property type is not empty
        $sql .= " AND property_type = ?";
        $params[] = $propertyType;
    }

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Error: " . mysqli_error($conn));
    }

    if (!empty($params)) {
        $paramTypes = str_repeat('s', count($params));
        mysqli_stmt_bind_param($stmt, $paramTypes, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $getprops = mysqli_stmt_get_result($stmt);

    if (!$getprops) {
        die("Error: " . mysqli_error($conn));
    }

    return $getprops;
}

$searchLocation = isset($_GET['location']) ? $_GET['location'] : null;
$propertyType = isset($_GET['property_type']) ? $_GET['property_type'] : null;
$getprops = getPropertyListings($conn, $searchLocation, $propertyType);




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renter</title>
    <link rel="icon" href="images/fox-svgrepo-com.svg">
    <link rel="stylesheet" href="output.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    
     <style>
.autocomplete-container input {
  width: 100%;
  height: 100%;
  padding: 10px;
  font-size: 16px;
  border: none; /* Remove the border */
  border-radius: 0.375rem;
}

/* Update the focus styles for the input field */
.autocomplete-container input:focus {
  background-color: #fff; /* White background on focus */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Subtle box shadow on focus */
}

/* Update the autocomplete dropdown styles */
.autocomplete-items {
  position: absolute;
  width: 50%;
  border-radius: 0.375rem;
  z-index: 99;
  top: calc(100% + 2px);
  left: 0;
  right: 0;
  border: none; /* Remove the border */
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Slight box shadow */
  background-color: #fff;
}

/* Update the suggestion item styles */
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.autocomplete-items div:hover {
  background-color: #f0f4f8; 
}

.autocomplete-items .autocomplete-active {
  background-color: #2563eb; 
  color: #fff; 
}

    </style>
</head>
<body class="bg-white font-body">
    <style>
        #map{
            height: 80vh;
            background-color: #f0f0f0;
        }

    </style>
    <div class="flex flex-row">
    <div class="flex flex-row space-x-3 w-full h-auto p-2">
        <div class="text-black p-2">
            <a href="index.php" class="font-bold font-body text-3xl mx-5">Renter</a>
        </div>
    </div>
    <div class="ml-auto my-auto mr-5">
        <button id="sidebarToggle"
        ><img src="images/person.png" alt="person-icon" class="w-10"></button>
    </div>
</div>

<div id="termsModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
  <div class="modal-bg fixed inset-0 bg-black opacity-60"></div>
  <div class="modal-content bg-white w-11/12 max-w-md p-4 rounded-lg relative">
    <span id="closeModal" class="modal-close absolute top-3 right-3 cursor-pointer text-gray-500 hover:text-gray-700 text-2xl">&times;</span>
    <h2 class="text-2xl font-bold mb-4">Terms and Conditions</h2>
    <p class="text-gray-700">This is the content of your terms and conditions.</p>
  </div>
</div>

<style>
    .modal-bg{
        z-index: -1;
    }

    .modal-content{
        z-index: 1;
    }
</style>
<div id="sidebar" class="fixed inset-y-0 right-0 w-64 bg-white border-l border-gray-300 shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out h-[70vh]">
    <!-- Header with user's name (displayed after login) -->
    <div id="sidebarHeader" class="bg-amber-500 text-white p-4">
        <h2 class="text-2xl font-semibold">Welcome, <span id="userName"><?php echo $_SESSION['username']  ?></span>!</h2>
    </div>
    <!-- Content (Login/Logout buttons) -->
    <div id="sidebarContent" class="flex flex-col items-center justify-center p-4 h-full">
        <!--removed else statement and created a form approach --> 
        <?php if(!isset($_SESSION['username'])){
            echo '<button class="bg-amber-700 hover:bg-amber-500 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            <a href="login.php">Login To Continue</a>
            </button>';
        }
        else
        {
            echo '<form action="logout.php" method="post">';
            echo '<button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-10 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-red-500 focus:ring-opacity-50">Logout</button>';
            echo '</form>';
            echo '<br>';
            echo '
            <button class="bg-red-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                <a href="../admin/admin.php">List your Property</a>
            </button>
            ';
            echo '<br>';
            echo '<form action="id.php" method="post">';
            echo '<input type="hidden" name="check" value="' . $_SESSION["check"] . '">';
            echo '<button type="submit" name="my_bookings" class="bg-red-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50">My Bookings</button>';
            echo '</form>';
        }
        ?>
    </div>
</div>
    
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarHeader = document.getElementById('sidebarHeader');
        const sidebarContent = document.getElementById('sidebarContent');
        const userName = document.getElementById('userName');
        const loginButton = document.getElementById('loginButton');

        function toggleSidebar() {
            sidebar.classList.toggle('translate-x-full');
        }

        sidebar.classList.add('translate-x-full');

        sidebarToggle.addEventListener('click', toggleSidebar);

        sidebar.addEventListener('mouseleave', () => {
            sidebar.classList.add('translate-x-full');
        });
;
    </script>

    
</div>

<section class="hero bg-[url('../dist/images/pano.jpg')] bg-cover text-center py-24">
        <div class="container mx-auto">
            <h1 class="text-4xl font-bold">Find Your Dream Rental</h1>
            <p class="text-xl mt-4">Explore our wide range of rental properties</p>
            <form action="index.php" method="get" class="mt-8 flex items-center justify-center">
                <div class="relative rounded-md shadow-md flex space-x-1">
                    <div class="autocomplete-container" id="autocomplete-container"></div>
                    <div class="autocomplete-container" id="autocomplete-container-city"></div>
                     <!-- <input type="text" name="location" placeholder="Enter Location" autocomplete="off" required class="bg-white rounded-md p-4 pr-12 w-80 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent flex-grow"> -->
                     <select name="property_type" class="bg-white text-gray-400 rounded-md p-4 pr-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                     <option value="">Property Type</option>
                     <option value="Apartment">Apartment</option>
                     <option value="House">House</option>
                     <option value="Condo">Condo</option>
                     </select>
                 <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-amber-500 focus:ring-opacity-50">
                  Search
                </button>
                </div>
            </form>
        </div>
    </section>

    <script>
  function addressAutocomplete(containerElement, callback, options) {

    var inputElement = document.createElement("input");
    inputElement.setAttribute("type", "text");
    inputElement.setAttribute("placeholder", options.placeholder);
    inputElement.setAttribute("id", "location");
    inputElement.setAttribute("class", "location");
    inputElement.setAttribute("name", "location");
    inputElement.setAttribute("autocomplete", "off");
    containerElement.appendChild(inputElement);

  var currentItems;
  var currentPromiseReject;
  var focusedItemIndex;

  inputElement.addEventListener("input", function(e) {
    var currentValue = this.value;

    /* Close any already open dropdown list */
    closeDropDownList();

    // Cancel previous request promise
    if (currentPromiseReject) {
      currentPromiseReject({
        canceled: true
      });
    }

    /* Create a new promise and send geocoding request */
    var promise = new Promise((resolve, reject) => {
      currentPromiseReject = reject;

      var apiKey = "7dacd17594f3471b83275660c476b5bc";
      var url = `https://api.geoapify.com/v1/geocode/autocomplete?text=${encodeURIComponent(currentValue)}&limit=5&apiKey=${apiKey}`;
      
      if (options.type) {
      	url += `&type=${options.type}`;
      }

      fetch(url)
        .then(response => {
          // check if the call was successful
          if (response.ok) {
            response.json().then(data => resolve(data));
          } else {
            response.json().then(data => reject(data));
          }
        });
    });

    promise.then((data) => {
      currentItems = data.features;
       var cityName = currentItems[0].properties.city;
        console.log(cityName);
      var autocompleteItemsElement = document.createElement("div");
      autocompleteItemsElement.setAttribute("class", "autocomplete-items");
      containerElement.appendChild(autocompleteItemsElement);

      data.features.forEach((feature, index) => {
        var itemElement = document.createElement("DIV");
        itemElement.innerHTML = feature.properties.formatted;

        itemElement.addEventListener("click", function(e) {
          inputElement.value = currentItems[index].properties.formatted;

          callback(currentItems[index]);

        
          closeDropDownList();
        });

        autocompleteItemsElement.appendChild(itemElement);
      });
    }, (err) => {
      if (!err.canceled) {
        console.log(err);
      }
    });
  });

  function setActive(items, index) {
    if (!items || !items.length) return false;

    for (var i = 0; i < items.length; i++) {
      items[i].classList.remove("autocomplete-active");
    }

    /* Add class "autocomplete-active" to the active element*/
    items[index].classList.add("autocomplete-active");

    // Change input value and notify
    inputElement.value = currentItems[index].properties.formatted;
    callback(currentItems[index]);
  }

  function closeDropDownList() {
    var autocompleteItemsElement = containerElement.querySelector(".autocomplete-items");
    if (autocompleteItemsElement) {
      containerElement.removeChild(autocompleteItemsElement);
    }

    focusedItemIndex = -1;
  }
  document.addEventListener("click", function(e) {
    if (e.target !== inputElement) {
      closeDropDownList();
    } else if (!containerElement.querySelector(".autocomplete-items")) {
      // open dropdown list again
      var event = document.createEvent('Event');
      event.initEvent('input', true, true);
      inputElement.dispatchEvent(event);
    }
  });

}


addressAutocomplete(document.getElementById("autocomplete-container-city"), (data) => {
  console.log("Selected city: ");
  console.log(data);
}, {
	placeholder: "Enter a location",
  type: "city"
});
    </script>
<?php
if (mysqli_num_rows($getprops) > 0) {
    echo "<main class='mt-14 mx-10'>";
    echo "<div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6'>";

    while ($property_data = mysqli_fetch_assoc($getprops)) {
        $propertyID = $property_data['id'];
        $name = $property_data['property_name'];
        $location = $property_data['location'];
        $description = $property_data["description"];
        $imagepath = $property_data['image_path'];
        $rent_amount = $property_data['rent_amount'];
        
        echo "
        <div class='bg-white rounded-lg shadow-md relative'>
            <img src='$imagepath' alt='Property Image' class='rounded-t-lg w-full h-64  object-cover'>
            <div class='p-4'>
                <p class='text-xl font-semibold'>$name</p>
                <p class='text-gray-600'>$location</p>
                <p class='text-sm mt-2'>$description</p>
                <p class='text-xl font-bold mt-4'>₹$rent_amount per night</p>
            </div>
            <button class='absolute bottom-4 right-4 bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-amber-500 focus:ring-opacity-50'>
            <a href='../bookings/booking.php?property_id=$propertyID'>Rent</a>
    </button>
        </div>";
    }
    echo "</div>";
    echo "</main>";
} else {
    echo '<div class="flex flex-col items-center justify-center h-96">';
    echo '<h1 class="text-4xl font-bold text-center mb-4">No Properties Found</h1>';
    echo '<p class="text-lg text-gray-600 text-center">Sorry, we couldn\'t find any properties for the location you entered.</p>';
    echo '</div>';
}
mysqli_close($conn);
?>

<section class="additional-content bg-gray-100 py-20">
        <div class="container mx-auto p-5">
            <h2 class="text-2xl font-bold mb-5">Why Choose Renter?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-5 rounded-md shadow-md">
                    <h3 class="text-lg font-semibold">Variety of Properties</h3>
                    <p class="text-gray-600">Explore a wide range of rental properties, from cozy apartments to luxurious villas.</p>
                </div>
                <div class="bg-white p-5 rounded-md shadow-md">
                    <h3 class="text-lg font-semibold">User-Friendly Interface</h3>
                    <p class="text-gray-600">Our website is designed to make your property search easy and efficient.</p>
                </div>
                <div class="bg-white p-5 rounded-md shadow-md">
                    <h3 class="text-lg font-semibold">Trusted Listings</h3>
                    <p class="text-gray-600">All listings on Renter are verified to ensure your safety and satisfaction.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="customer-reviews bg-gray-200 py-20 mb-10">
    <div class="container mx-auto p-5">
        <h2 class="text-2xl font-bold mb-5">Customer Reviews</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-gray-100 p-5 rounded-md shadow-md">
                <div class="flex items-center space-x-4">
                    <img src="../dist/images/userfinal.svg" alt="Customer Image" class="h-16 w-16 rounded-full">

                    <div>
                        <h3 class="text-lg font-semibold">John Doe</h3>
                        <p class="text-gray-600">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod diam at bibendum."</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-100 p-5 rounded-md shadow-md">
                <div class="flex items-center space-x-4">
                    <img src="../dist/images/userfinal.svg" alt="Customer Image" class="h-16 w-16 rounded-full">
                    <div>
                        <h3 class="text-lg font-semibold">Jane Smith</h3>
                        <p class="text-gray-600">"Sed ullamcorper tellus vel finibus. Nunc nec eleifend velit."</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-100 p-5 rounded-md shadow-md">
                <div class="flex items-center space-x-4">
                    <img src="../dist/images/userfinal.svg" alt="Customer Image" class="h-16 w-16 rounded-full">
                    <div>
                        <h3 class="text-lg font-semibold">Sarah Johnson</h3>
                        <p class="text-gray-600">"Vestibulum vehicula lacus nec nunc hendrerit, ac volutpat tellus laoreet."</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 p-5 rounded-md shadow-md">
                <div class="flex items-center space-x-4">
                    <img src="../dist/images/userfinal.svg" alt="Customer Image" class="h-16 w-16 rounded-full">
                    <div>
                        <h3 class="text-lg font-semibold">Walden</h3>
                        <p class="text-gray-600">"Sed ullamcorper tellus vel finibus. Nunc nec eleifend velit."</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 p-5 rounded-md shadow-md">
                <div class="flex items-center space-x-4">
                    <img src="../dist/images/userfinal.svg" alt="Customer Image" class="h-16 w-16 rounded-full">
                    <div>
                        <h3 class="text-lg font-semibold">Emily Anderson</h3>
                        <p class="text-gray-600">"Lorem, ipsum dolor sit amet consectetur adipisicing elit..."</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 p-5 rounded-md shadow-md">
                <div class="flex items-center space-x-4">
                    <img src="../dist/images/userfinal.svg" alt="Customer Image" class="h-16 w-16 rounded-full">
                    <div>
                        <h3 class="text-lg font-semibold">Marques Joe</h3>
                        <p class="text-gray-600">"Sed ullamcorper tellus vel finibus. Nunc nec eleifend velit."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id='map-section' class="bg-gray-200 w-screen">
    <div id="map">

    </div>
</section>
<footer class="flex justify-between border-black fixed bottom-0 bg-white w-screen">
    <div class="flex flex-row space-x-3 h-12 px-10 items-center">
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1 underline">Renter Corp™️</a>
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1  underline">Privacy</a>
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1  underline">Jobs</a>
        <button id="termsButton" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1  underline">Terms</button>
    </div>
    <div class="flex flex-row items-center space-x-4 px-10">
        <img src="images/reshot-icon-globe-PL5973EKAD.svg" class="w-5" alt="the-globe">
        
    </div>
</footer>


<script src="../maps/maps.js" defer></script>
</body>

</html>