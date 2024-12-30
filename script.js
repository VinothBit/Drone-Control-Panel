function sendDroneData(action) {
    let lat = document.getElementById("latitude").value;
    let lon = document.getElementById("longitude").value;

    if (isValidCoordinate(lat, lon) || action === 'land') {
        fetch('control.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'latitude': lat,
                'longitude': lon,
                'action': action
            })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message); 
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to communicate with the backend.');
        });
    } else {
        alert("Please enter valid latitude and longitude.");
    }
}

function isValidCoordinate(lat, lon) {
    let latitude = parseFloat(lat);
    let longitude = parseFloat(lon);
    
    return !isNaN(latitude) && !isNaN(longitude) &&
           latitude >= -90 && latitude <= 90 &&
           longitude >= -180 && longitude <= 180;
}

document.getElementById("launch-btn").addEventListener("click", function() {
    sendDroneData('launch');
});

document.getElementById("land-btn").addEventListener("click", function() {
    sendDroneData('land');
});

function updateStatus() {
    document.getElementById("gps-coordinates").innerText = "GPS Coordinates: 40.7128 N, 74.0060 W"; // Example
    document.getElementById("battery-status").innerText = "Battery: 70%";
    document.getElementById("flight-efficiency").innerText = "Flight Efficiency: Moderate";
    document.getElementById("obstacle-alerts").innerText = "No obstacles detected.";
}

// Call this function every 5 seconds to update status (simulating real-time status update)
setInterval(updateStatus, 5000);
