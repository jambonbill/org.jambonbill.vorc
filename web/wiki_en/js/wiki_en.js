$(function(){
	
	$('#category').change(function(){
		$.cookie('category',$('#category').val());
	});

	$('#platform').change(function(){
		$.cookie('platform',$('#platform').val());
	});


	$('#search,#category,#platform,#user,#date').change(function(){
		console.log('change');
		searchWiki();
	});

	var searchWiki=function(){

		var p={
			'do':'search',
			'search':$('#search').val(),
			'category':$('#category').val(),
			'platform':$('#platform').val(),
			'user':$('#user').val(),
			'date':$('#date').val()
		}
		$('#boxResult .box-body').load('ctl.php',p,function(){

		});
	}
	
	// Set initial state //
	if($.cookie('category')){
		$('#category').val($.cookie('category'));
	}
	if($.cookie('platform')){
		$('#platform').val($.cookie('platform'));
	}
	searchWiki();
});