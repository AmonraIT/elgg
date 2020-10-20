// convert Google Maps into an AMD module
define([
    'https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false'
], function () {
    return window.google.maps;
});


