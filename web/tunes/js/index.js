
$(function(){
	
	$('#platform,#extension,#url,#date').change(function(){
		getTunes();
	});
	
	getTunes();
	
	console.info("tunes");

});

function getTunes(){
	
	var p={
		'do':'search',
		'platform':$('#platform').val(),
		'extension':$('#extension').val(),
		'url':$('#url').val(),
		'date':$('#date').val()
	}
	
	$('#boxResult .overlay').show();
	$.post('ctrl.php',p,function(json){
		console.log(json);
		displayTunes(json.rows);
		$('#boxResult .overlay').hide();
	}).error(function(e){
		console.error(e.responseText);
	});
}



function displayTunes(rows){
	
	console.info('displayTunes');
	
	var htm='<table class="table table-hover table-condensed">';
	htm+='<thead>';
	
	htm+='<th>Platform</th>';
	htm+='<th>Extension</th>';
	htm+='<th>Urls</th>';
	htm+='<th width=100>Date</th>';
	htm+='</thead>';
	
	htm+='<tbody>';
	
	for (var i in rows){
		
		var r=rows[i];
		
		htm+='<tr id="'+r.tid+'">';
		
		htm+='<td>'+r.flag_platform;

		htm+='<td>'+r.flag_extension;
		
		
		htm+='<td>';//urls
		if(r.url_tune1)htm+='<a href="'+r.url_tune1+'">url 1</a> ';//urls
		if(r.url_tune2)htm+='<a href="'+r.url_tune2+'">url 2</a> ';//urls
		//r.url_tune1 + r.url_tune2;
		
		htm+='<td style="text-align:right">'+r.date;
	}
	htm+='</tbody>';
	htm+='</table>';
	htm+='<i class=text-muted>'+rows.length+' result(s)</i>';

	if(rows.length==0){
		htm='<pre>no data</pre>';		
	}

	$('#boxResult .box-body').html(htm);
	//$('table').tablesorter();
}