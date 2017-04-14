<?php
// src/AppBundle/Tools.php
namespace AppBundle;

Class Tools {

    public static function changeFormatMusicDuration($duration) {
      $duration = strrev($duration);
      for ($i = 0; $i < strlen($duration); $i++)
      {
        if (!is_numeric($duration[$i]))
        {
          $tmpLetter = $duration[$i];
          $array[$tmpLetter] = "";
        }
        else
          $array[$tmpLetter] = $duration[$i] . $array[$tmpLetter];
      }

      $result = 0;
      if (isset($array["H"]))
        $result += $array["H"] * 3600;
      if (isset($array["M"]))
        $result += $array["M"] * 60;
      if (isset($array["S"]))
        $result += $array["S"];
      return $result;
    }
}
