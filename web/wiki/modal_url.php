<?php

$modal=new LTE\Modal;
$modal->id('modalUrl');
$modal->icon("fa fa-edit");
$modal->title('Url');

$htm='<div class=row>';
$htm.='<input type=hidden id=wu_id>';
$htm.='<div class=col-sm-12>';
$htm.='<label>Url</label>';
$htm.='<input class="form-control" placeholder=URL id=wu_url>';
$htm.='</div>';

$htm.='<div class=col-sm-12>';
$htm.='<label>Description</label>';
$htm.='<input class="form-control" placeholder="URL Description" id=wu_description>';
$htm.='</div>';

$htm.='</div>';//endrow

//$modal->width(700);
$modal->body($htm);
$foot=[];
$foot[]='<a href=#btn id=btnSaveUrl class="btn btn-primary"><i class="fa fa-save"></i> Save URL</a>';
$foot[]='<a href=#btn id=btnDeleteUrl title="Delete" class="btn btn-secondary"><i class="fa fa-trash"></i></a>';
$foot[]='<button type=button class="btn btn-secondary" data-dismiss=modal><i class="fa fa-times"></i> Cancel</button>';
$modal->footer($foot);
echo $modal;