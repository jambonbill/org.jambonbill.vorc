<?php

$modal=new LTE\Modal;
$modal->id('modalEdit');
$modal->icon("fa fa-edit");
$modal->title('Edit');

$htm='<div class=row>';

$htm.='<div class=col-sm-6>';
$htm.='<label>Name</label>';
$htm.='<input class="form-control" placeholder=Name id=w_name value="'.$r['w_name'].'">';
$htm.='</div>';

$htm.='<div class=col-sm-6>';
$htm.='<label>Slug</label>';
$htm.='<input class="form-control" placeholder=Slug id=w_slug value="'.$r['w_slug'].'">';
$htm.='</div>';

$htm.='<div class=col-sm-12>';
$htm.='<label>Markdown</label>';
$htm.='<textarea class="form-control" id=contents rows=14>';
$htm.=$r['contents'];
$htm.='</textarea>';
$htm.='</div>';

$htm.='</div>';//endrow

//$modal->width(700);
$modal->body($htm);
$foot=[];
$foot[]='<a href=#btn id=btnSave class="btn btn-primary"><i class="fa fa-save"></i> Save</a>';
$foot[]='<a href=#btn id=btnDelete title="Delete" class="btn btn-secondary"><i class="fa fa-trash"></i></a>';
$foot[]='<button type=button class="btn btn-secondary" data-dismiss=modal><i class="fa fa-times"></i> Cancel</button>';
$modal->footer($foot);
echo $modal;