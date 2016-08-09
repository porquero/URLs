<?php

/**
 * Manage Urls
 *
 * @author porquero
 */
class Urls {

    /**
     * Create and return url result
     * 
     * @param string $u url url to save
     * 
     * @return void
     */
    public static function m($u = null) {
        if ($u !== null) :
            include_once 'Md.php';

            $u = self::sanitize($u);
            $h = hash('Adler32', $u);

            Md::i($h, $u);

            header('Location: ' . $_SERVER['PHP_SELF'] . '?h=' . $h);
        else :
            $h = $_GET['h'];
            if (strlen($h) == 8) {
                $p = pathinfo($_SERVER['REQUEST_URI']);
                $dirname = $p['dirname'];
                if ($dirname != '/') {
                    $dirname = "{$dirname}/";
                }
                $r = "http://{$_SERVER['SERVER_NAME']}{$dirname}{$h}";
                $res = array(
                    'r' => $r,
                    'u' => $u,
                    'h' => $h
                );
                echo json_encode($res);
            } else {
                header('Location: ./');
            }
        endif;
    }

    /**
     * Find asociated hash for url and return it
     *
     * @param string $h 
     * 
     * @return void
     */
    public static function g($h, $r = true) {
        include_once 'Md.php';

        $o = Md::s($h);

        if ($o === false && $r) {
            header('HTTP/1.0 404 Not Found');
            echo 'Nothing to redirect';
            exit;
        }

        return $o;
    }

    /**
     * Search url from hash and redirect to it if exists
     */
    public static function r() {
        $uri = $_SERVER['REQUEST_URI'];
        $h = substr($uri, -8);

        $u = self::g($h);

        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $u);
    }

    /**
     * Sanitize url
     *
     * @param string $u
     * @return string 
     */
    public static function sanitize($u) {
        if (!preg_match("~^(?:f|ht)tps?://~i", $u)) {
            $u = "http://" . $u;
        }
        return $u;
    }

}
