<?php

function status($status){
  if($status == 1){
    return '<span class="badge badge-success">Active</span>';
  }else{
    return '<span class="badge badge-secondary">Inactive</span>';
  }
}

function showComponent($model){
  $text = '';
  foreach($model as $row){
    $text .= $row->component_name.' '.$row->component_size.', ';
  }

  $text = substr($text, 0, -2);
  return $text;
}

function showInvoiceScanned($file){
  $link = '<span class="badge badge-secondary">Empty</span>';
  if($file != null){
    $link = '<span class="badge badge-primary link-normal"><a href="'.asset('upload/inventory/computer/'.$file).'">Show</a></span>';
  }

  return $link;
}

function softwareSerial($software_name){
  return \App\Models\Software::where('software_name', $software_name)->get();
}