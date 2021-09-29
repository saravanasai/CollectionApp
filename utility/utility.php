<?php

class Util{
    
  public static function validate_is_empty($value)
  {
    if(!empty($value))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  public static function validate_phonenumber_length($phonenumber)
  {
        if(strlen($phonenumber)>10||strlen($phonenumber)<10)
        {
          return false;
        }
        else
        {
          return true;
        }
  }
  public static function validate_isNumeric($value)
  {
      if(!is_numeric($value))
      {
        return false;
      }
      else
      {
        return true;
      }
  }




}

?>