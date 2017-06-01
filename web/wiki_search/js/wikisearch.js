$(function(){


	var pages=[];
	function search(){

		var p={
			'do':'search',
			'search':$('#search').val(),
			'category':$('#category').val(),
			'platform':$('#platform').val(),
		}
		console.info('search()',p);
		$('.overlay').show();
		$.post('ctrl.php',p,function(json){
			$('.overlay').hide();
			console.log(json);
			pages=json.pages;
			display();

		}).fail(function(e){
			$('.overlay').hide();
			console.error(e.responseText);
		});
	}

	function display(){

		console.info('display()',pages);

		var htm='<table class="table table-sm table-hover" style="cursor:pointer">';
		htm+='<thead>';
		htm+='<th width=30>#</th>';
		htm+='<th>Slug</th>';
		htm+='<th>Name</th>';
		htm+='<th width=150>Updated</th>';
		htm+='</thead>';
		htm+='<tbody>';
		var num=0;
		for(var i in pages){
			var o=pages[i];
			//console.log(page);
			htm+='<tr data-id="'+o.w_id+'">';
			htm+='<td><i class="text-muted">'+o.w_id;
			htm+='<td><i class="text-muted">';
			if(o.w_slug)htm+=o.w_slug;
			else htm+='-</i>';
			htm+='<td>'+o.w_name;
			htm+='<td style="text-align:right">'+o.w_updated;
			num++;
		}
		htm+='</tbody>';
		htm+='</table>';

		if(num==0){
			htm+='<pre><i class="fa fa-warning"></i> no data!</pre>';
		}

		$('#boxResults .box-body').html(htm);
		$('#boxResults tbody>tr').click(function(e){
			$('.overlay').show();
			console.log(e.currentTarget.dataset.id);
			document.location.href='../wiki/?id='+e.currentTarget.dataset.id;
		});
		$('table').tablesorter();
	}

	$('input#search').change(function(){
		search();
	});

	$('select').change(function(){
		search();
	});

	$('.overlay').hide();
});