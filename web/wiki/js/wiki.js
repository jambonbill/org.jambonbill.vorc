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

	$('#boxUrl tbody>tr').click(function(e){
		console.info('click',e.currentTarget.dataset.id);
		$('#modalUrl').modal('show');
	});


	function saveUrl(){
		console.info('saveUrl()');
	}


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
			if(json.updated){
				document.location.reload();
			}
		}).fail(function(e){
			console.error(e.responseText);
		});

		$('#modalEdit').modal('hide');
	});

	$('#btnDelete').click(function(){
		//console.log("save");
		if(!confirm("Delete this wiki page ?"))return false;
		var p={
			'do':'delete',
			'w_id':$('#w_id').val()
		}

		$('.overlay').show();
		$.post('ctrl.php',p,function(json){
			$('.overlay').hide();
			console.log(json);
			if(json.deleted){
				document.location.href='../wiki_search/';
			}
		}).fail(function(e){
			console.error(e.responseText);
		});

	});

	$('.overlay').hide();
});