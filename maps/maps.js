// Declare the marker variable
const termsButton = document.getElementById('termsButton');
const termsModal = document.getElementById('termsModal');
const closeModal = document.getElementById('closeModal');

termsButton.addEventListener('click', function() {
  termsModal.classList.remove('hidden');
});

closeModal.addEventListener('click', function() {
  termsModal.classList.add('hidden');
});

window.addEventListener('click', function(event) {
  if (event.target === termsModal) {
    termsModal.classList.add('hidden');
  }
});

let marker;

// Initialize the map
const map = L.map('map').setView([15.496777, 73.827827], 13);

// Add OpenStreetMap tiles
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

// Initialize variables for markers
let currentLocationMarker, userAddedMarkers = [];

// Function to show loading indicator
function showLoadingIndicator() {
    const loadingElement = document.getElementById('loading-indicator');
    if (loadingElement) {
        loadingElement.style.display = 'block';
    }
}

// Function to hide loading indicator
function hideLoadingIndicator() {
    const loadingElement = document.getElementById('loading-indicator');
    if (loadingElement) {
        loadingElement.style.display = 'none';
    }
}

// Function to handle geolocation success
async function handleGeolocationSuccess(pos) {
    showLoadingIndicator();

    const { latitude: lat, longitude: long, accuracy } = pos.coords;

    // Remove existing current location marker
    if (currentLocationMarker) {
        map.removeLayer(currentLocationMarker);
    }

    // Create a marker for the user's current location
    currentLocationMarker = L.marker([lat, long]).addTo(map);

    // Set the map view to the user's location
    map.setView([lat, long]);

    hideLoadingIndicator();
}

// Function to handle geolocation error
function handleGeolocationError(err) {
    hideLoadingIndicator();

    let errorMessage = '';

    if (err.code === 1) {
        errorMessage = 'Please allow geolocation access.';
    } else {
        errorMessage = 'Cannot get the current location.';
    }

    // Display the error message on the webpage
    const errorElement = document.getElementById('error-message');
    if (errorElement) {
        errorElement.textContent = errorMessage;
    } else {
        alert(errorMessage); // Fallback in case the error element doesn't exist
    }
}


// Function to handle map click event for adding a marker
function handleMapClick(event) {

    if(marker){
        marker.remove();
    }

    const { lat, lng } = event.latlng;

    const apiKey = '7dacd17594f3471b83275660c476b5bc'; // Replace with your Geoapify API key

    fetch(`https://api.geoapify.com/v1/geocode/reverse?lat=${lat}&lon=${lng}&apiKey=${apiKey}`)
    .then((response) => response.json())
    .then(data => {
        if (data.features.length === 0) {
            console.log("The address is not found");
            return;
        }
        console.log(data);
        const foundAddress = data.features[0];
        const city = data.features[0].properties.city;

        alert(`You chose ${city}`);
        console.log(city);
        console.log(foundAddress);
        marker = L.marker(new L.LatLng(foundAddress.properties.lat, foundAddress.properties.lon)).addTo(map);
    })
    
}

// Add a click event listener to the map to handle adding markers
map.on('click', handleMapClick);

// Use navigator.geolocation to watch the user's position when the page loads
document.addEventListener('DOMContentLoaded', () => {
    navigator.geolocation.watchPosition(handleGeolocationSuccess, handleGeolocationError);
});
