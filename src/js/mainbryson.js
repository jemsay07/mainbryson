window.addEventListener("load", function() {

	// store tabs variables
	var tabs = document.querySelectorAll("ul.nav-tabs > li");

	for (var i = 0; i < tabs.length; i++) {
		tabs[i].addEventListener("click", switchTab);
	}

	function switchTab(event) {
		event.preventDefault();

		document.querySelector("ul.nav-tabs li.active").classList.remove("active");
		document.querySelector(".tab-pane.active").classList.remove("active");

		var clickedTab = event.currentTarget;
		var anchor = event.target;
		var activePaneID = anchor.getAttribute("href");

		clickedTab.classList.add("active");
		document.querySelector(activePaneID).classList.add("active");
		
	}
	
});

window.addEventListener('change', function () {
	var mb_type_rich = document.getElementById('mb_type_rich');
	var mb_type_url = document.getElementById('mb_type_url');

	if (mb_type_rich.checked) {
		document.getElementById('mb_type_elem_rich').style.display = 'block';
	} else {
		document.getElementById('mb_type_elem_rich').style.display = 'none';
	}
	if (mb_type_url.checked) {
		document.getElementById('mb_type_elem_url').style.display = 'block';
	} else {
		document.getElementById('mb_type_elem_url').style.display = 'none';
	}

});

jQuery(document).ready(function ($) {
	$('.meta-collapse-header').on('click', function(e){
		e.preventDefault();
		$('#meta-collapse-body').slideToggle();
		$(this).toggleClass('active');
	});
});

/*jQuery(document).ready(function( $ ){
	$(document).on('click', '.js-image-upload', function(e){
		e.preventDefault();

		var btn = $(this),
		file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select or Upload an Image',
			library: {
				type: 'image'
			},
			button:{
				text: 'Select Image'
			},
			multiple: false
		});
		file_frame.on('select', function(){
			var attachment = file_frame.state().get('selection').first().toJSON();
			btn.siblings('.image-upload').val(attachment.url);
		});
		file_frame.open();
	});
});*/