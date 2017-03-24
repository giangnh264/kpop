var basiczone = true;
var inlistzone = false;
var favzone = false;


$('#inlist-info').live('click',function() {
	$('#inlist-zone').show();
	$('#basic-zone').hide();
	$('#fav-zone').hide();
	var url = $(this).attr('href');
	if(!inlistzone){
		$.ajax({
			  type: "GET",
			  url: url,
			  context: document.body,
			  beforeSend:function(){
			  },
			  success: function(data){

				  $('#inlist-zone').html(data);
				  $('<script>').each(function(){
					  eval(this.innerHTML);
				  });
				  inlistzone = true;
			  },
			  complete:function(){
			  },
			  statusCode: {
				404: function() {
			    	alert('page not found');
			  	}
			  }

			});
	};
	$('li.active').removeClass('active');
	$(this).parent().addClass('active');
	return false;
})

$('#fav-info').live('click',function() {
	$('#fav-zone').show();
	$('#basic-zone').hide();
	$('#inlist-zone').hide();
	var url = $(this).attr('href');
	if(!favzone){
		$.ajax({
			type: "GET",
			url: url,
			context: document.body,
			beforeSend:function(){
			},
			success: function(data){
				$('#fav-zone').html(data);
				favzone = true;
			},
			complete:function(){
			},
			statusCode: {
				404: function() {
					alert('page not found');
				}
			}

		});
	};
	$('li.active').removeClass('active');
	$(this).parent().addClass('active');
	return false;
})

$('#basic-info').live('click',function() {
	$('#fav-zone').hide();
	$('#basic-zone').show();
	$('#inlist-zone').hide();
	$('.global_field').show();
	$('.meta_field').hide();
	$('li.active').removeClass('active');
	$(this).parent().addClass('active');
})

$('#meta-info').live('click',function() {
	$('#fav-zone').hide();
	$('#basic-zone').show();
	$('#inlist-zone').hide();
	$('.global_field').hide();
	$('.meta_field').show();

	$('li.active').removeClass('active');
	$(this).parent().addClass('active');
})


/*Action in list*/
$('.grid-view tbody a').live('click',function() {
	var url = $(this).attr('href');
	$.post(url,function(data){
		if($('#inlist-info').length){
			inlistzone = false;
			$('#inlist-info').click();
		}else{
			window.location.reload(true);
		}
	});
	return false;
})

$('#add-item').live('click',function() {
	var url = $(this).attr('href');
	jQuery.ajax({
		  'onclick':'$("#jobDialog").dialog("open"); return false;',
		  'url':url,
		  'type':'GET',
		  'cache':false,
		  'success':function(html){
		      jQuery('#jobDialog').html(html)
		      }
		});
	return false;
})

$('#reorder').live('click',function() {
	var url = $(this).attr('href');
	$.post(url,$('.adminform').serialize(), function(data){
		//inlistzone = false;
		//$('#inlist-info').click();
		window.location.reload(true);
   });
	return false;
})

$('.reorder').live('click',function() {
	var url = $(this).attr('rel');
	$.post(url,$('.adminform').serialize(), function(data){
    });
	return false;
})

function changeDownloadOption(e) {
	var value = e.options[e.options.selectedIndex].value;
	$("#download_price_row").toggle('clip');
}

function displayPop(action,params){
	  $("#jobDialog").dialog({
	      autoOpen: false,
	      hide: 'fold',
	      show: 'blind'
	  });

	  xhr = jQuery.ajax({
	      'onclick':'$("#jobDialog").dialog("open"); return false;',
	      'url':action,
	      'data':params,
	      'type':'GET',
	      'cache':false,
	      'beforeSend':function(){
	    	  overlayShow();
	      },
	      'success':function(html){
	    	  overlayHide();
	          jQuery('#jobDialog').html(html);
	      },
	      'complete':function(){
	    	  overlayHide();
	      }
	  });
	  return false;
	}