<?php

namespace App;

class CustomValidator extends \Illuminate\Validation\Validator
{
  /**
  * ふりがなのバリデーション
  *
  * @param $attribute
  * @param $value
  * @param $parameters
  * @return bool
  */
  public function validateKana($attribute, $value, $parameters)
  {
      if (mb_strlen($value) > 100) {
          return false;
      }  

      if (preg_match('/[^ぁ-んー]/u', $value) !== 0) {
          return false;
      }

      return true;
  }
}