$(function(){

	//https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/

	$('#btnAddUrl').click(function(){
		var url=prompt("Enter url","http://");
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

	$('#btnEdit').click(function(){
		console.log("edit");
		$('#modalEdit').modal('show');
	});

	$('#btnSave').click(function(){
		console.log("save");

		if(!$('#w_slug').val()){
			alert("Please define slug");
			$('#w_slug').focus();
			return;
		}

		var p={
			'do':'update',
			'w_id':$('#w_id').val(),
			'w_name':$('#w_name').val(),
			'w_slug':$('#w_slug').val(),
			'contents':$('#contents').val(),
		}

		$('.overlay').show();
		$.post('ctrl.php',p,function(json){
			$('.overlay').hide();
			console.log(json);
			if(json.id){
				document.location.reload();
			}
		}).fail(function(e){
			console.error(e.responseText);
		});

		$('#modalEdit').modal('hide');
	});

	$('.overlay').hide();
});