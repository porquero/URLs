<?php

/**
 * Manage url database
 *
 * @author crh
 */
class Md {
    
    /**
     * urls save path
     *
     * @var string
     */
    public static $us = 'urls';

    /**
     * Save url
     *
     * @param string $h
     * @param string $u 
     */
    public static function i($h, $u) {
        $d = self::$us . DIRECTORY_SEPARATOR . self::hs($h);
        if(!is_dir($d)){
            mkdir($d, 0777, true);
            file_put_contents($d . DIRECTORY_SEPARATOR . 'u.f', $u);
        }
    }
    
    /**
     * Make path string for save
     *
     * @param string $h
     * @return string 
     */
    public static function hs($h) {
        $d = chunk_split($h, 2, DIRECTORY_SEPARATOR);
        $d = preg_replace('/\/$/', '', $d);
        $d = preg_replace('/\\\$/', '', $d);
        return $d;
    }

    /**
     * return url from hash
     *
     * @param string $h
     * @return mixed 
     */
    public static function s($h) {
        $f = self::$us . DIRECTORY_SEPARATOR . self::hs($h) . DIRECTORY_SEPARATOR . 'u.f';
        return is_file($f) ? file_get_contents($f) : FALSE;
    }

}
