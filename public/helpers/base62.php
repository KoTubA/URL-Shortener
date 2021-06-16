<?php

    function toBase($num) {
        $_characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $base = 62;
        $string = $_characters[$num % $base];

        while (($num = intval($num / $base)) > 0)
        {
            $string .= $_characters[$num % $base];
        }

        return $string;
    }