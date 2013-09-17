function updateMarkerStatus(str) {
    $('#marker-status').text(str);
}
function updateMarkerPosition() {
    var latlng = marker_picker.getPosition();
    $('#marker-lat').val(latlng.lat());
    $('#marker-lng').val(latlng.lng());
}
function updateMarkerCircle() {
    circle_picker.setCenter(marker_picker.getPosition());
}
$('#marker-radius').on('change', function (event) {
    var radius = $(this).val();
    circle_picker.setRadius(1000 * radius);
});
$('#marker-radius').on('keypress', function (event) {
    if (event.which == 13) {
        event.preventDefault();
    }
});
function updateAddress() {
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({
        latLng: marker_picker.getPosition()
    }, function (responses) {
        if (responses && responses.length > 0) {
            $('#addr').text(responses[0].formatted_address);
        } else {
            $('#addr').text('Cannot determine address at this location.');
        }
    });
}

