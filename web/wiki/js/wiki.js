$(function(){

	//test
	$('#btnAddUrl').click(function(){
		var url=prompt("Enter url","yo");
		if(!url)return;

		$.post('ctrl.php',{'do':'addUrl','w_id':+$('#w_id').val(),'url':url},function(json){
			console.log(json);
			if(json.id){
				document.location.reload();
			}
		}).fail(function(e){
			console.error(e.responseText);
		});
	});

	$('.overlay').hide();
});