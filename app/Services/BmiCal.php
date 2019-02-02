<?php

namespace App\Services;
 
class BmiCal{
 
  /*
  * BMI計算関数
  */
  public function cal($height,$weight){
 
  #cmをmに変換
  $height = $height/100;
  #BMI計算
  $bmi = $weight/($height * $height);
  #小数点以下を四捨五入
  $bmi = round($bmi);
  return "$bmi";
  }
 
  /*
  * BMI判定関数
  */
  public function hantei($height,$weight){
  #cmをmに変換
  $height = $height/100;
  #BMI計算
  $bmi = $weight/($height * $height);
  #小数点以下を四捨五入
  $bmi = round($bmi,1);
 
  #BMI判定
  if($bmi < 18.5){
  $result = "低体重(やせ)";
 
  }else if($bmi < 25){
  $result = "標準";
 
  }else if($bmi < 30){
  $result = "肥満1度";
 
  }else if($bmi < 35){
  $result = "肥満2度";
 
  }else if($bmi < 40){ $result = "肥満3度"; }else if($bmi >= 40){
  $result = "肥満4度";
  }
 
  return "$result";
  }
 
}