<?php
session_start();
include("database.php");
?>


<?php

if (!isset($_SESSION['username'])) {
    // User is not authenticated, redirect to the login page
    header('Location: login.php');
    exit();
}


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
    <script src="https://cdn.tailwindcss.com"></script>
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
<body class="bg-gray-100 font-body">
    <style>
        #map{
            height: 80vh;
            background-color: #f0f0f0;
        }

    </style>
    <header class="text-gray-600 body-font">
  <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
    <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
      <span class="ml-3 text-2xl">Renter</span>
    </a>
    <nav class="md:ml-auto md:mr-auto flex flex-wrap items-center text-base justify-center">
      <a href='index.php' class="mr-5 hover:text-gray-900">Home</a>
      <a href="#about-us-page" class="mr-5 hover:text-gray-900">About</a>
      <a href="#contact-me-page" class="mr-5 hover:text-gray-900">Contact</a>
      <a href="#bottom-of-page" class="mr-5 hover:text-gray-900">Maps</a>
    </nav>
    <button id='sidebarToggle' class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">
      <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
        <path d="M5 12h14M12 5l7 7-7 7"></path>
      </svg>
    </button>
  </div>
</header>

<div id="sidebar" class="fixed inset-y-0 right-0 w-64 h-screen bg-white border-l border-gray-300 shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out">
    <!-- Header with user's name (displayed after login) -->
    <div id="sidebarHeader" class="bg-black text-white p-4">
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
            echo '<button type="submit" class="w-60 bg-black text-white font-semibold py-2 px-10 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-red-500 focus:ring-opacity-50">Logout</button>';
            echo '</form>';
            echo '<br>';

            if(isset($_SESSION['tocheckid']) && ($_SESSION['check'])){
            $logged_users_id = $_SESSION['tocheckid'];
            $check_email_db = $_SESSION['check'];

            // echo $logged_users_id . $check_email_db;
        
            $sql = "SELECT * FROM finalusers WHERE id='$logged_users_id' AND Email='$check_email_db'";

            $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    
                    $lister = $row["lister"];
                    // echo $lister;
                }
        }

           if(($lister == NULL) || ($lister === NULL)){
            echo '<form action="become_lister.php" method="post" onsubmit="return confirm(\'Are you sure you want to become a lister?\');">';
            echo '<button type="submit" name="become_lister" class="w-60 bg-black text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-green-500 focus:ring-opacity-50">Become a Lister</button>';
            echo '</form>';
            echo '<br>';
           }
            if($lister == 1){
            echo '
            <button class="w-60 bg-black text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                <a href="../admin/admin.php">List your Property</a>
            </button>
            ';
            }
            echo '<br>';
            echo '<form action="id.php" method="post">';
            echo '<input type="hidden" name="check" value="' . $_SESSION["check"] . '">';
            echo '<button type="submit" name="my_bookings" class="w-60 bg-black text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50">My Bookings</button>';
            echo '</form>';

            if (isset($_SESSION['check'])) {
                $email = $_SESSION['check'];
            
                $checkBookingQuery = "SELECT * FROM bookings WHERE email = ? AND status = 'confirmed'";
                $stmt = mysqli_prepare($conn, $checkBookingQuery);
            
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    mysqli_stmt_close($stmt);
            
                    if (mysqli_num_rows($result) > 0) {
                        // Display the "Reviews" button if there are confirmed bookings
                        echo '<form action="../customer-reviews/reviews.php" method="post">';
                        echo '<button type="submit" name="reviews" class="w-60 mt-4 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-green-500 focus:ring-opacity-50">Reviews</button>';
                        echo '</form>';
                    }
                }
            }
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

<section class="hero bg-[url('../dist/images/back2.jpg')] h-screen flex bg-cover mx-10 rounded-md text-center py-24" loading='lazy'>
        <div class="container mx-auto flex flex-col justify-center items-center">
            <h1 class="text-4xl font-bold text-white">Find Your Dream Rental</h1>
            <p class="text-2xl mt-4 text-white">Explore our wide range of rental properties</p>
            <div class='flex justify-center items-center'>
            <form action="index.php" method="get" class="mt-8 flex items-center justify-center">
                <div class="relative rounded-md shadow-md flex space-x-1">
                    <div class="autocomplete-container " id="autocomplete-container"></div>
                    <div class="autocomplete-container" id="autocomplete-container-city"></div>
                     <!-- <input type="text" name="location" placeholder="Enter Location" autocomplete="off" required class="bg-white rounded-md p-4 pr-12 w-80 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent flex-grow"> -->
                     <select name="property_type" class="bg-white text-gray-400 rounded-md p-4 pr-2 focus:outline-none focus:border-transparent">
                        <option value="">Property Type</option>
                        <option value="Apartment">Apartment</option>
                        <option value="House">House</option>
                        <option value="Condo">Condo</option>
                     </select>
                 <button type="submit" class="bg-black text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-amber-500 focus:ring-opacity-50">
                  Search
                </button>
                </div>
            </form>
            </div>
        </div>
    </section>

    <section class="body-font" id='about-us-section'>
  <div class="container px-5 py-24 mx-auto my-10">
    <div class="flex flex-wrap w-full mb-20 flex-col items-center text-center">
      <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-gray-900">Your Trusted Property Sellers in Goa</h1>
    </div>
    <div class="flex flex-col">
    <div class="flex justify-center gap-16">
      <div class="xl:w-1/3 md:w-1/2 p-4">
        <div class="border border-gray-200 p-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:shadow-xl hover:-translate-y-1 hover:scale-105 bg-black">
          <h2 class="text-gray-200 text-2xl font-bold title-font mb-3 border-b-2 border-black inline">Property Evaluation</h2>
          <p class="text-gray-400 leading-relaxed text-base mt-2">Expert property evaluation services to determine accurate market value and potential selling price.</p>
        </div>
      </div>
      <div class="xl:w-1/3 md:w-1/2 p-4">
        <div class="border border-gray-200 p-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:shadow-xl hover:-translate-y-1 hover:scale-105 bg-black">
          <h2 class="text-gray-200 text-2xl font-bold title-font mb-3 border-b-2 border-black inline">Real Estate Consultation</h2>
          <p class="text-gray-400 leading-relaxed text-base mt-2">Tailored consultations on buying, selling, and investing in Goa's real estate market. Get to your dream stay quicker.</p>
        </div>
      </div>
      </div>
      <section class="text-gray-600 body-font">
          <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-wrap -m-4 text-center">
              <div class="p-4 sm:w-1/4 w-1/2">
                <h2 class="title-font font-medium sm:text-4xl text-3xl text-gray-900">2.7K</h2>
                <p class="leading-relaxed">Users</p>
              </div>
              <div class="p-4 sm:w-1/4 w-1/2">
                <h2 class="title-font font-medium sm:text-4xl text-3xl text-gray-900">1.8K</h2>
                <p class="leading-relaxed">Happy Customers</p>
              </div>
              <div class="p-4 sm:w-1/4 w-1/2">
                <h2 class="title-font font-medium sm:text-4xl text-3xl text-gray-900">95%</h2>
                <p class="leading-relaxed">Rating</p>
              </div>
              <div class="p-4 sm:w-1/4 w-1/2">
                <h2 class="title-font font-medium sm:text-4xl text-3xl text-gray-900">100+</h2>
                <p class="leading-relaxed">Properties</p>
              </div>
            </div>
          </div>
    </section>
    </div>
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
    <div class='flex justify-center items-center'>
    <h1 class='text-3xl border-b-2 mx-auto border-amber-500 inline font-bold'>View the properties</h1>
    </div>
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
            <img src='$imagepath' alt='Property Image' class='rounded-t-lg w-full h-64  object-cover' loading='lazy'>
            <div class='p-4'>
                <p class='text-xl font-semibold'>$name</p>
                <p class='text-gray-600'>$location</p>
                <p class='text-sm mt-2'>$description</p>
                <p class='text-xl font-bold mt-4'>₹$rent_amount per night</p>
            </div>
            <button class='absolute bottom-4 right-4 bg-black text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-amber-500 focus:ring-opacity-50'>
            <a href='../bookings/booking.php?property_id=$propertyID&property_name=" . urlencode($name) . "'>Rent</a>
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

<section class="text-gray-600 body-font my-10">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-col text-center w-full mb-20">
      <h1 class="text-3xl border-b-2 mx-auto border-amber-500 inline font-bold text-black">Why to choose Renter?</h1>
    </div>
    <div class="flex flex-wrap">
      <div class="xl:w-1/4 lg:w-1/2 md:w-full px-8 py-6 border-l-2 border-gray-200 border-opacity-60">
        <h2 class="text-lg sm:text-xl text-gray-900 font-medium title-font mb-2">Unmatched Property Selection</h2>
        <p class="leading-relaxed text-base mb-4"> Unparalled selection of properties across Goa</p>
        <a class="text-indigo-500 inline-flex items-center">Learn More
          <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
            <path d="M5 12h14M12 5l7 7-7 7"></path>
          </svg>
        </a>
      </div>
      <div class="xl:w-1/4 lg:w-1/2 md:w-full px-8 py-6 border-l-2 border-gray-200 border-opacity-60">
        <h2 class="text-lg sm:text-xl text-gray-900 font-medium title-font mb-2">The Booking Experience</h2>
        <p class="leading-relaxed text-base mb-4">Your journey with Renter begins with a user-friendly, hassle-free booking experience.</p>
        <a class="text-indigo-500 inline-flex items-center">Learn More
          <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
            <path d="M5 12h14M12 5l7 7-7 7"></path>
          </svg>
        </a>
      </div>
      <div class="xl:w-1/4 lg:w-1/2 md:w-full px-8 py-6 border-l-2 border-gray-200 border-opacity-60">
        <h2 class="text-lg sm:text-xl text-gray-900 font-medium title-font mb-2">Customer Support</h2>
        <p class="leading-relaxed text-base mb-4">Our dedicated customer support team is here to assist you every step of the way.</p>
        <a class="text-indigo-500 inline-flex items-center">Learn More
          <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
            <path d="M5 12h14M12 5l7 7-7 7"></path>
          </svg>
        </a>
      </div>
      <div class="xl:w-1/4 lg:w-1/2 md:w-full px-8 py-6 border-l-2 border-gray-200 border-opacity-60">
        <h2 class="text-lg sm:text-xl text-gray-900 font-medium title-font mb-2">Trusted Listings</h2>
        <p class="leading-relaxed text-base mb-4">All listings on Renter are verified to ensure your safety and satisfaction.</p>
        <a class="text-indigo-500 inline-flex items-center">Learn More
          <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
            <path d="M5 12h14M12 5l7 7-7 7"></path>
          </svg>
        </a>
      </div>
    </div>
  </div>
</section>

<section class="text-gray-600 body-font mb-3">
  <div class="container px-5 py-24 mx-auto">
    <div class='flex justify-center mb-3'>
      <h1 class="text-3xl border-b-2 border-amber-500 inline font-bold text-black">What our guests have to say....</h1>
    </div>
    <div class="flex flex-wrap -m-4">
      <div class="p-4 md:w-1/2 w-full">
        <div class="h-full bg-gray-100 p-8 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="block w-5 h-5 text-gray-400 mb-4" viewBox="0 0 975.036 975.036">
            <!-- Your SVG code here -->
          </svg>
          <p class="leading-relaxed mb-6">"Absolutely stunning property, amazing location! The view from the balcony was breathtaking. Everything was clean and well-maintained. Highly recommended for a relaxing vacation in Goa."</p>
          <a class="inline-flex items-center">
            <img alt="testimonial" src="images/icons8-male-user-50.png" class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center">
            <span class="flex-grow flex flex-col pl-4">
              <span class="title-font font-medium text-gray-900">Samantha P.</span>
              <span class="text-gray-500 text-sm">Travel Enthusiast</span>
            </span>
          </a>
        </div>
      </div>
      <div class="p-4 md:w-1/2 w-full">
        <div class="h-full bg-gray-100 p-8 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="block w-5 h-5 text-gray-400 mb-4" viewBox="0 0 975.036 975.036">
            <!-- Your SVG code here -->
            
          </svg>
          <p class="leading-relaxed mb-6">"A perfect getaway! The amenities were fantastic, and the staff was incredibly helpful. Our stay here made our trip memorable. Will definitely be coming back!"</p>
          <a class="inline-flex items-center">
            <img alt="testimonial" src="images/icons8-male-user-50.png" class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center">
            <span class="flex-grow flex flex-col pl-4">
              <span class="title-font font-medium text-gray-900">Alex M.</span>
              <span class="text-gray-500 text-sm">Adventure Seeker</span>
            </span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>


<div class='flex justify-center'>
<h2 class='text-2xl border-b-2 border-amber-500 inline mb-4 mx-auto' id='map-finder'>View the Map</h2>
</div>

<section id='maps' class="bg-gray-200 w-1/2 border border-black shadow-md mx-auto">
    <div id="map">
        <?php  include("../maps/maps2.php"); ?>
    </div>
</section>

<footer class="text-gray-600 body-font mt-20" id="contact-page">
  <div class="container px-5 py-5 mx-auto flex items-center sm:flex-row flex-col">
    <a class="flex title-font font-medium items-center md:justify-start justify-center text-gray-900">
      <span class="ml-3 text-xl">Renter</span>
    </a>
    <p class="text-sm text-gray-500 sm:ml-4 sm:pl-4 sm:border-l-2 sm:border-gray-200 sm:py-2 sm:mt-0 mt-4">© 2023 rentercorp —
      <a href="https://twitter.com/dhruvnaique" class="text-gray-600 ml-1" rel="noopener noreferrer" target="_blank">@dhruvnaique</a>
    </p>
    <span class="inline-flex sm:ml-auto sm:mt-0 mt-4 justify-center sm:justify-start">
      <a class="text-gray-500">
        <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
          <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
        </svg>
      </a>
      <a class="ml-3 text-gray-500">
        <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
          <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
        </svg>
      </a>
      <a class="ml-3 text-gray-500">
        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
          <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
          <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
        </svg>
      </a>
      <a class="ml-3 text-gray-500">
        <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="0" class="w-5 h-5" viewBox="0 0 24 24">
          <path stroke="none" d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"></path>
          <circle cx="4" cy="4" r="2" stroke="none"></circle>
        </svg>
      </a>
    </span>
  </div>
</footer>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('a[href="#bottom-of-page"]').addEventListener('click', function(event) {
        event.preventDefault(); 
        const element = document.getElementById("map-finder");
        element.scrollIntoView({ behavior: "smooth" }); 
    });
    document.querySelector('a[href="#contact-me-page"]').addEventListener('click', function(event) {
        event.preventDefault(); 
        const contactElement = document.getElementById("contact-page");
        contactElement.scrollIntoView({ behavior: "smooth" }); 
    });
    document.querySelector('a[href="#about-us-page"]').addEventListener('click', function(event) {
        event.preventDefault(); 
        const aboutElement = document.getElementById("about-us-section");
        aboutElement.scrollIntoView({ behavior: "smooth" }); 
    });
});
</script>



</body>

</html>