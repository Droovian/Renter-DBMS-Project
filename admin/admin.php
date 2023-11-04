<?php
session_start();

if(isset($_SESSION['error-messages'])){
    $errors = $_SESSION['error-messages'];

    echo '<div class="text-red-600 font-bold text-center p-2 mb-4">';
    foreach ($errors as $error) {
        echo '<p>' . htmlspecialchars($error) . '</p>';
    }
    echo '</div>';
    unset($_SESSION['error-messages']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../dist/images/fox-svgrepo-com.svg">
    <title>List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
            .autocomplete-container {
  /*the container must be positioned relative:*/
            position: relative;
            
            margin-bottom: 20px;
}

.autocomplete-container input {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #e5e7eb; /* Match the border color with other input fields */
  border-radius: 0.25rem; /* Match the border-radius with other input fields */
  background-color: #fff; /* Match the background color with other input fields */
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

/* Add focus styles for the location input field */
.autocomplete-container input:focus {
  border-color: #2563eb; /* Match the focus border color with other input fields */
  box-shadow: 0 0 0 0.125rem rgba(37, 99, 235, 0.25); /* Match the focus box-shadow with other input fields */
}

.autocomplete-items {
  position: absolute;
  border: 1px solid rgba(0, 0, 0, 0.1);
  box-shadow: 0px 2px 10px 2px rgba(0, 0, 0, 0.1);
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: calc(100% + 2px);
  left: 0;
  right: 0;
  
  background-color: #fff;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
}

.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: rgba(0, 0, 0, 0.1);
}

.autocomplete-items .autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: rgba(0, 0, 0, 0.1);
}

.clear-button {
  color: rgba(0, 0, 0, 0.4);
  cursor: pointer;
  
  position: absolute;
  right: 5px;
  top: 0;

  height: 100%;
  display: none;
  align-items: center;
}

.clear-button.visible {
  display: flex;
}


.clear-button:hover {
  color: rgba(0, 0, 0, 0.6);
}
    </style>
</head>
<body class="bg-gray-100 p-10">

    <p class="text-center text-green-600 text-xl font-bold p-2 mb-4">
        <?php 
        if(isset($_SESSION['success-message'])){
            echo "<script>
             var userConfirmed = confirm('Property has successfully listed with us.\\nYour Property ID is: " . $_SESSION['prop-id'] . "\\n\\nThanks for working with us, Renter Corp');
             
             if(userConfirmed){
                window.location.href = 'map.php';
             }
             else{
                window.location.href = 'admin.php';
                alert('Note: Precise location of your property has not been provided');
             }
          </script>";


            unset($_SESSION['success-message']);
            unset($_SESSION['prop-id']);
        }
        ?>
    </p>

    <div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">

        <!-- Back to Home Button -->
        <a href="../dist/index.php" class="bg-amber-500 text-white py-2 px-4 rounded-md hover:bg-amber-600 focus:outline-none focus:bg-blue-600 absolute top-4 left-4">Back to Home</a>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <img src="../dist/images/fox.jpg" class="w-20" alt="">
                <h2 class="text-2xl font-semibold ml-4">Renter - Property Sale Form</h2>
            </div>
        </div>

        <form action="handlesubmit.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
            <!-- Property Name -->
            <div class="mb-4">
                <label for="property_name" class="block text-gray-600 text-sm font-medium mb-2">Property Name</label>
                <input type="text" id="property_name" name="property_name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <!-- Property Type -->
            <div class="mb-4">
                <label for="property_type" class="block text-gray-600 text-sm font-medium mb-2">Property Type</label>
                <select id="property_type" name="property_type" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
                    <option value="apartment">Apartment</option>
                    <option value="house">House</option>
                    <option value="condo">Condo</option>
                    <!-- Add more options as needed -->
                </select>
            </div>

            <!-- Rent Amount -->
            <div class="mb-4">
                <label for="rent_amount" class="block text-gray-600 text-sm font-medium mb-2">Monthly Rent (₹)</label>
                <input type="number" id="rent_amount" name="rent_amount" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-600 text-sm font-medium mb-2">Description</label>
                <textarea id="description" name="description" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" rows="4" required></textarea>
            </div>

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-600 text-sm font-medium mb-2">Name</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-600 text-sm font-medium mb-2">Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" oninput="validateForm()" required>
                <p id="email-message" class="text-red-500 text-xs"></p>
            </div>

            <!-- Contact Number -->
            <div class="mb-4">
                <label for="contact_number" class="block text-gray-600 text-sm font-medium mb-2">Contact Number</label>
                <input type="tel" id="contact_number" name="contact_number" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" oninput="validateForm()" required>
                <p id="phone-message" class="text-red-500 text-xs"></p>
            </div>

            <div class="mb-4">
                 <label for="location" class="block text-gray-600 text-sm font-medium mb-2">Location</label>
                 <div class="autocomplete-container" id="autocomplete-container"></div>
            </div>
    
            <div class="autocomplete-container" id="autocomplete-container-city"></div>
            <div class="mb-4">
                <label for="image" class="block text-gray-600 text-sm font-medium mb-2">Upload Image</label>
                <input type="file" id="image" name="image" class="w-full border rounded-md py-2 px-3 focus:outline-none focus:border-blue-500" accept="image/*"  oninput="validateForm()" required>
                <p id="image-message" class="text-red-500 text-xs"></p>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-amber-500 text-white py-2 px-4 rounded-md hover:bg-amber-600 focus:outline-none focus:bg-amber-600">Submit</button>
            </div>
        </form>
    </div>

    <script>
  function addressAutocomplete(containerElement, callback, options) {
  // create input element
    var inputElement = document.createElement("input");
    inputElement.setAttribute("type", "text");
    inputElement.setAttribute("placeholder", options.placeholder);
    inputElement.setAttribute("id", "location");
    inputElement.setAttribute("class", "location");
    inputElement.setAttribute("name", "location");
    containerElement.appendChild(inputElement);

  // add input field clear button
  var clearButton = document.createElement("div");
  clearButton.classList.add("clear-button");
  addIcon(clearButton);
  clearButton.addEventListener("click", (e) => {
    e.stopPropagation();
    inputElement.value = '';
    callback(null);
    clearButton.classList.remove("visible");
    closeDropDownList();
  });
  containerElement.appendChild(clearButton);

  /* Current autocomplete items data (GeoJSON.Feature) */
  var currentItems;

  /* Active request promise reject function. To be able to cancel the promise when a new request comes */
  var currentPromiseReject;

  /* Focused item in the autocomplete list. This variable is used to navigate with buttons */
  var focusedItemIndex;

  /* Execute a function when someone writes in the text field: */
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

    if (!currentValue) {
      clearButton.classList.remove("visible");
      return false;
    }

    // Show clearButton when there is a text
    clearButton.classList.add("visible");

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

  function addIcon(buttonElement) {
    var svgElement = document.createElementNS("http://www.w3.org/2000/svg", 'svg');
    svgElement.setAttribute('viewBox', "0 0 24 24");
    svgElement.setAttribute('height', "24");

    var iconElement = document.createElementNS("http://www.w3.org/2000/svg", 'path');
    iconElement.setAttribute("d", "M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z");
    iconElement.setAttribute('fill', 'currentColor');
    svgElement.appendChild(iconElement);
    buttonElement.appendChild(svgElement);
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
	placeholder: "Enter a city name here",
  type: "city"
});

  function validateEmail(email) {
        if (email === '') {
            return ''; // No feedback when the input is empty
        }

        const emailPattern = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
        return emailPattern.test(email) ? '' : 'invalid';
    }

    function validatePhoneNumber(phoneNumber) {
        if (phoneNumber === '') {
            return ''; // No feedback when the input is empty
        }

        const phonePattern = /^\d{10}$/;
        return phonePattern.test(phoneNumber) ? '' : 'invalid';
    }

    function validateForm() {
        const emailInput = document.querySelector('input[name="email"]');
        const email = emailInput.value.trim();
        const emailMessage = document.querySelector('#email-message');

        const phoneInput = document.querySelector('input[name="contact_number"]');
        const phoneNumber = phoneInput.value.trim();
        const phoneMessage = document.querySelector('#phone-message');

        // Email validation
        const emailValidation = validateEmail(email);
        if (emailValidation === 'invalid') {
            emailMessage.textContent = 'Email is invalid';
            emailMessage.style.color = 'red';
            return false; // Prevent form submission
        } else {
            emailMessage.textContent = ''; // No feedback when the input is empty or valid
        }

        // Phone number validation
        const phoneValidation = validatePhoneNumber(phoneNumber);
        if (phoneValidation === 'invalid') {
            phoneMessage.textContent = 'Phone number is invalid';
            phoneMessage.style.color = 'red';
            return false; // Prevent form submission
        } else {
            phoneMessage.textContent = ''; // No feedback when the input is empty or valid
        }

        const imageInput = document.querySelector('input[name="image"]');
        const image = imageInput.files[0];
        const imageMessage = document.querySelector('#image-message');
        if (image) {
        const imageSizeInMB = image.size / (1024 * 1024); // Convert bytes to megabytes
        if (imageSizeInMB > 5) {
            imageMessage.textContent = 'Image size must be less than or equal to 5MB';
            imageMessage.style.color = 'red';
            return false; // Prevent form submission
        } 
        else {
            imageMessage.textContent = ''; // No feedback when the image size is within the limit
        }
    }

        return true; // Allow form submission if all validations pass
    }
</script>

</body>

<footer class="flex justify-between mt-10 border-black fixed bottom-0 bg-transparent w-screen">
    <div class="flex flex-row space-x-3 h-12 px-10 items-center">
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1 underline">Renter Corp™️</a>
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1  underline">Privacy</a>
    </div>
    
</footer>

</html>