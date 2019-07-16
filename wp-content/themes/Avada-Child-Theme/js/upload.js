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

	function loadMapIndicator(address, featHtmlArr){
		var data = {
			'geodata': address,
			'action': 'cu_get_geocode_sucursales',
		}
		$.post(ajaxurl, data, function(data){
			let latlng, aditionalInfo;
			if (data){
				data = JSON.parse(data);
				for (var i = 0; i < data.length; i++) {
					latlng = {lat: parseFloat(data[i]['lat']), lng: parseFloat(data[i]['long'])};
					map.setCenter(latlng);

					aditionalInfo = featHtmlArr[data[i]['id']][1] + "<br />" + featHtmlArr[data[i]['id']][0] + "<br />" + featHtmlArr[data[i]['id']][2] + "<br />";
                    aditionalInfo += 'Tel: '+data[i]['telefono'];
					createMarker(latlng, aditionalInfo);
				}
			}
		});
	}

	function createMarker(latlng,html){
	  var marker = new google.maps.Marker({
	    position: latlng,
	    map: map
	  });
		markers.push(marker);

	  google.maps.event.addListener(marker, 'click', function() {
	    infowindow.setContent(html);
	    infowindow.open(map, marker);
	  });

	  google.maps.event.addListener(infowindow, 'closeclick', function() {
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
		$('body').addClass('bk-progress');

		loadUserContentCallback (this, "load_prov", '#sucursales', function(){
			$('body').removeClass('bk-progress');

			let sucursales = $('.nombre_cliente');
			let address = [], featHtmlAddress = [];
			let sucursal, cliente, features, featHtml;
			resetMap();
			for (var i = 0; i < sucursales.length; i++) {
					sucursal = $(sucursales[i]);
					cliente = sucursal.find('span').text();
					features = sucursal.parent().find('.info');
					featHtml = '<div class="info">'+features.html()+'</div>';

					address[i] = sucursal.data('id');
					featHtmlAddress[sucursal.data('id')] = [featHtml, cliente, sucursal.data('address')];
			}
			if (sucursales.length)
				loadMapIndicator(address, featHtmlAddress);
		});
	});

	$(root).on('click', '.locales_img', function(e){
		let category = $(this).data('categoria');
		$('body').addClass('bk-progress');
		loadCatContentCallback (category, "cat_filter", '#sucursales', function(){
			$('body').removeClass('bk-progress');

			let sucursales = $('.nombre_cliente');
			let address = [], featHtmlAddress = [];
			let sucursal, cliente, features, featHtml;
			resetMap();
			for (var i = 0; i < sucursales.length; i++) {
					sucursal = $(sucursales[i]);
					cliente = sucursal.find('span').text();
					features = sucursal.parent().find('.info');
					featHtml = '<div class="info">'+features.html()+'</div>';

					address[i] = sucursal.data('id');
					featHtmlAddress[sucursal.data('id')] = [featHtml, cliente, sucursal.data('address')];
			}
			if (sucursales.length)
				loadMapIndicator(address, featHtmlAddress);
		});
	});

	$('.trescol').on('change', 'input.file-archivo', function(){
		showPreloadFile(this);
	});

})(jQuery);
