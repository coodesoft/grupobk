(function($) {

	var geocoder = new google.maps.Geocoder();
	var infowindow = new google.maps.InfoWindow();

  var map;
	var markers = [];
  function initialize() {
     var mapOptions = {
       zoom: 8,
       center: new google.maps.LatLng(-34.609030, -58.373220)
     }
     map = new google.maps.Map(document.getElementById('mapas'), mapOptions);
  }

	function resetMap() {
		for (var i = 0; i < markers.length; i++) {
	  	markers[i].setMap(null);
	  }
		markers = [];
	}

  function codeAddress(address) {
     geocoder.geocode( { 'address': address}, function(results, status) {
       if (status == 'OK') {
         map.setCenter(results[0].geometry.location);
         var marker = new google.maps.Marker({
             map: map,
             position: results[0].geometry.location
         });
       } else {
         alert('Geocode was not successful for the following reason: ' + status);
       }
     });
  }

	function geocodeAddress(location) {
	  geocoder.geocode( { 'address': location[1]}, function(results, status) {
	  //alert(status);
	    if (status == google.maps.GeocoderStatus.OK) {

	      //alert(results[0].geometry.location);
	      map.setCenter(results[0].geometry.location);
	      createMarker(results[0].geometry.location,location[0]+"<br>"+location[1]);
	    }
	    else
	    {
	      alert("some problem in geocode" + status);
	    }
	  });
	}

	function createMarker(latlng,html){
	  var marker = new google.maps.Marker({
	    position: latlng,
	    map: map
	  });
		markers.push(marker);

	  google.maps.event.addListener(marker, 'mouseover', function() {
	    infowindow.setContent(html);
	    infowindow.open(map, marker);
	  });

	  google.maps.event.addListener(marker, 'mouseout', function() {
	    infowindow.close();
	  });
	}


	var loadUserContentCallback = function(form, action, target, callback){
    var data = {
      'user': $(form).serialize(),
      'action': action,
    }
    $.post(ajaxurl, data, function(data){
      $(target).html(data);

      if (callback != undefined)
        callback(data);
    })
  }

	var loadCatContentCallback = function(category, action, target, callback){
		var data = {
			'cat': category,
			'action': action,
		}
		$.post(ajaxurl, data, function(data){
			$(target).html(data);

			if (callback != undefined)
				callback(data);
		})
	}

	let showPreloadFile = function(input){
		//var input = $('input.file-archivo')[0];
		var output = $(input).closest('p').find('input.uploadtextfield');
		console.log(output);
		output.val(input.files.item(0).name);
		console.log(input.files.item(0).name);
	}

  initialize();


	let root = '#body';
	let element = '.nombre_cliente';

	$(root).on('click', '.ciudad', function(){
    $(this).siblings(".sucursal").toggleClass("mostrar", 1000, "easeOutSine");
  });

	$('.trescol').on('click', 'span.uploadtextfield', function(){
		$(this).siblings(".file-archivo").children('.file-archivo').click();
	});

	$(root).on('change', '#provincia select', function(e){
		loadUserContentCallback (this, "load_prov", '#sucursales', function(){

			let sucursales = $('.nombre_cliente');
			let address = [], sucursal, cliente;
			resetMap();
			for (var i = 0; i < sucursales.length; i++) {
				sucursal = $(sucursales[i]);
				cliente = sucursal.find('span').text();
				geocodeAddress([cliente, sucursal.data('address')]);
			}
		});
	});

	$(root).on('click', '.locales_img', function(e){
		let category = $(this).data();
		loadCatContentCallback (category, "cat_filter", '#sucursales');
	});

	$('.trescol').on('change', 'input.file-archivo', function(){
		showPreloadFile(this);
	});

})(jQuery);
