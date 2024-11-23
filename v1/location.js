// Restaurant's coordinates
const restaurantLocation = { lat: 51.5211242, lng: -0.052193 }; // Replace with actual latitude and longitude

// Function to calculate distance using Google Distance Matrix API
function calculateDistance(userLat, userLng) {
    const service = new google.maps.DistanceMatrixService();
    const userLocation = new google.maps.LatLng(userLat, userLng);
    const destination = new google.maps.LatLng(restaurantLocation.lat, restaurantLocation.lng);

    service.getDistanceMatrix(
        {
            origins: [userLocation],
            destinations: [destination],
            travelMode: google.maps.TravelMode.DRIVING,
        },
        (response, status) => {
            if (status === google.maps.DistanceMatrixStatus.OK) {
                const distance = response.rows[0].elements[0].distance.text;
                document.getElementById("distance").textContent = `You are approximately ${distance} away from our restaurant.`;
            } else {
                document.getElementById("distance").textContent = "Could not calculate distance.";
            }
        }
    );
}

// Function to get user's current location
function getUserLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;
                calculateDistance(userLat, userLng);
            },
            () => {
                document.getElementById("distance").textContent = "Location access denied.";
            }
        );
    } else {
        document.getElementById("distance").textContent = "Geolocation is not supported by this browser.";
    }
}

// Initialize distance calculation on page load
document.addEventListener("DOMContentLoaded", getUserLocation);
