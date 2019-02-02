<?php
namespace App\Facades;
 
use Illuminate\Support\Facades\Facade;
 
class BmiCal extends Facade{
  protected static function getFacadeAccessor(){
  return 'bmical';
  }
}