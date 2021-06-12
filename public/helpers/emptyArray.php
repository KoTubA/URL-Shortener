<?php

  function emptyArray($array) {
    $empty = TRUE;
    if (is_array($array)) {
      foreach ($array as $value) {
        if (!emptyArray($value)) {
          $empty = FALSE;
        }
      }
    }
    elseif (!empty($array)) {
      $empty = FALSE;
    }
    return $empty;
  }