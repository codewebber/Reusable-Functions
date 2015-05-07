<?php 
/**
*change the color of red button to green when the distance between current location and the destination is less than $size
*params $latitude,$longitude,$size
*$latitude is the current location latitude
*$longitude is the current ocation longitude
*$size is the radius 
*/
?>
<script type="text/javascript">
	//Script to get the current browser location and calculate the distance
	window.onload = function() {
		var startPos;
		var finalDistance;
		var size = "<?php echo $size;?>";
		if (navigator.geolocation) {
			var static_location_lat = <?php echo $latitude;?>;
			var static_location_lon = <?php echo $longitude;?>;	
			navigator.geolocation.watchPosition(function(position) {
				unit = 'K';
				finalDistance = calculateDistance(static_location_lat, static_location_lon,position.coords.latitude, position.coords.longitude, unit);
				if(finalDistance > size){
					$('#cant').css("background","red");
				}else{
					$('#cant').css("background","green");
				}
			});
		}
	};
	//Calculating the distance between two locations
	function calculateDistance(lat1, lon1, lat2, lon2, unit) {
		var radlat1 = Math.PI * lat1/180
		var radlat2 = Math.PI * lat2/180
		var radlon1 = Math.PI * lon1/180
		var radlon2 = Math.PI * lon2/180
		var theta = lon1-lon2
		var radtheta = Math.PI * theta/180
		var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
		dist = Math.acos(dist)
		dist = dist * 180/Math.PI
		dist = dist * 60 * 1.1515
		if (unit=="K") { dist = dist * 1.609344 * 1000}
		if (unit=="N") { dist = dist * 0.8684 }
		return dist
	}     
</script>
<button id="cant" class="btn btn-primary btn-lg" type="button"> AT Location </button>
