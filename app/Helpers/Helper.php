<?php

function status($status){
  if($status == 1){
    return '<span class="badge badge-success">Active</span>';
  }else{
    return '<span class="badge badge-secondary">Inactive</span>';
  }
}