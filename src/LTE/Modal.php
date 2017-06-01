<?php
/**
 * AdminLte2 Modal V4
 * https://almsaeedstudio.com/themes/AdminLTE/pages/UI/modals.html
 * to pop the modal -> $("#modalwindow").modal('show');
 * to update the title -> $("#modalwindow .modal-title").html('html');
 * to update the body -> $("#modalwindow .modal-body").html('html');
 * to bind to 'shown' -> $('#myModal').on('shown.bs.modal',function(){});
 */

namespace LTE;

Class Modal
{
    private $id ='myModal';
    private $type ='default';
    private $icon ='fa fa-times';
    private $title='';
    private $body ='';
    private $style ='';
    private $width=0;
    private $footer ='';

    public function __construct ($title = '', $body = '', $footer='')
    {
        if($title)$this->title($title);
        if($body)$this->body($body);
        if($footer)$this->footer($footer);
    }

    public function id($str = ''){
        if ($str) {
          $this->id=$str;
        }
        return $this->id;
    }

    //ex : width:720px
    public function style($str='')
    {
        if ($str) {
          $this->style=$str;
        }
        return $this->style;
    }

    public function width($width=0){
        if($width>0){
            $this->width=$width;
        }
        return $this->width;
    }

    public function type($str = ''){
        if ($str) {
          $this->type=$str;
        }
        return $this->type;
    }

    public function title($str = ''){
        if ($str) {
          $this->title=$str;
        }
        return $this->title;
    }

    public function body($str = ''){
        if ($str) {
          if(is_array($str))$str=implode('',$str);
          $this->body=$str;
        }
        return $this->body;
    }

    public function footer($str = ''){
        if ($str) {
          if(is_array($str))$str=implode('',$str);
          $this->footer=$str;
        }
        return $this->footer;
    }

    public function icon($str = ''){
        if ($str) {
          $this->icon=$str;
        }
        return $this->icon;
    }

    public function html()
    {
        $HTML=[];

        $HTML[]='<div class="modal modal-'.$this->type().'" id="'.$this->id.'">';

        if($this->style){
            $htm[]='<div class="modal-dialog" style="'.$this->style.'">';
        }else{
            $htm[]='<div class="modal-dialog">';
        }

        $HTML[]='<div class="modal-dialog">';

        if ($this->width>0) {
            $HTML[]='<div class="modal-content" style="width:'.$this->width.'px">';
        } else {
            $HTML[]='<div class="modal-content">';
        }

        $HTML[]='<div class="modal-header">';

        $HTML[]='<h4 class="modal-title">';
        if($this->icon)$HTML[]='<i class="'.$this->icon().'"></i> ';
        $HTML[]=$this->title().'</h4>';
        $HTML[]='<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>';
        $HTML[]='</div>';

        $HTML[]='<div class="modal-body">'.$this->body().'</div>';

        $HTML[]='<div class="modal-footer">'.$this->footer().'</div>';

        $HTML[]='</div>';//<!-- /.modal-content -->
        $HTML[]='</div>';//<!-- /.modal-dialog -->
        $HTML[]='</div>';//<!-- /.modal -->

        return implode('',$HTML);
    }

    public function __toString()
    {
        return $this->html();
    }
}
