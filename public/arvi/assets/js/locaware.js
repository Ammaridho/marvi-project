let locNow = null;
let locConstraint = false;
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition,showError);
    } else {
        alert('Geolocation is not supported by this browser');
        //x.innerHTML = "Geolocation is not supported by this browser.";
    }
}
function showPosition(position) {
    locNow = position;
    //x.innerHTML = "Latitude: " + position.coords.latitude +
    //    "<br>Longitude: " + position.coords.longitude;
}
function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            //x.innerHTML = "User denied the request for Geolocation."
            alert('We need your permission for your location to continue with the order');
            $('#fullpage').hide();
            break;
        case error.POSITION_UNAVAILABLE:
            //x.innerHTML = "Location information is unavailable."
            alert("We're unable to know where you are to continue with the order");
            $('#fullpage').hide();
            break;
        case error.TIMEOUT:
            //x.innerHTML = "The request to get user location timed out."
            alert('We need your permission for your location to continue with the order (Timeout)');
            $('#fullpage').hide();
            break;
        case error.UNKNOWN_ERROR:
            //x.innerHTML = "An unknown error occurred."
            alert("We're unable to know where you are to continue with the order (E)");
            $('#fullpage').hide();
            break;
    }
}

if (locMAware) {
    getLocation();
}
