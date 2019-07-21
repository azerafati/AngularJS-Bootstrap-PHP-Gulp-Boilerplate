<?php


class Util {

    /**
     * set response code to 400 and echo any optional message and exit.
     *
     * @param string $msg
     */
    static function badReq($msg = "") {
        header( "HTTP/1.1 400 BADREQUEST" );
        echo $msg;
        exit();
    }

    static function addhttp($url) {
        if (! \preg_match( "~^(?:f|ht)tps?://~i", $url )) {
            $url = "http://" . ltrim( $url, "//" );
        }
        return $url;
    }

    static function fork_call($func, $args) {
        if (pcntl_fork() == 0) {
            call_user_func_array( $func, $args );
        }
    }

    /**
     * common header sets to be used everywhere
     *
     * @param String $type
     *        	(json,text,html)
     */
    static function header($type) {
        switch ($type) {
            case ("json") :
                header( 'Content-type: application/json' );
                break;
            default :
                throw new Exception( "seeting header failed, this type: $type is not defined!!" );
        }
    }

    /**
     * forces only POST requests
     */
    static function PostOnly() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            self::badReq();
        }
    }

    /**
     * wrapper for jdate
     */
    static function persianDate($date) {
        require_once AppRoot . "vendor/jdate/jdatetime.class.php";
        return jDateTime::date( 'l j F Y H:i', strtotime( $date ), false, true );
    }

    static function redirect($url, $permanent = false) {
        if (headers_sent() === false) {
            header( 'Location: ' . $url, true, ($permanent) ? 301 : 302 );
        }

        exit();
    }

    /**
     *
     * @param file $file
     */
    static function streamFile($file) {
        $filesize = filesize( $file );

        $offset = 0;
        $length = $filesize;

        if (isset( $_SERVER['HTTP_RANGE'] )) {
            // if the HTTP_RANGE header is set we're dealing with partial content

            $partialContent = true;

            // find the requested range
            // this might be too simplistic, apparently the client can request
            // multiple ranges, which can become pretty complex, so ignore it for now
            preg_match( '/bytes=(\d+)-(\d+)?/', $_SERVER['HTTP_RANGE'], $matches );

            $offset = intval( $matches[1] );
            $length = intval( $matches[2] ) - $offset;
        } else {
            $partialContent = false;
        }

        $file = fopen( $file, 'r' );

        // seek to the requested offset, this is 0 if it's not a partial content request
        fseek( $file, $offset );

        $data = fread( $file, $length );

        fclose( $file );

        if ($partialContent) {
            // output the right headers for partial content

            header( 'HTTP/1.1 206 Partial Content' );

            header( 'Content-Range: bytes ' . $offset . '-' . ($offset + $length) . '/' . $filesize );
        }

        // output the regular HTTP headers
        header( 'Content-Type: ' . $file->getMimeType() );
        header( 'Content-Length: ' . $filesize );
        //header( 'Content-Disposition: attachment; filename="' . $fileName . '"' );
        header( 'Accept-Ranges: bytes' );

        // don't forget to send the data too
        print ($data) ;
    }

    static function generateRandomId ($length=4){
        $keys = array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));
        $key = '';
        for($i=0; $i < $length; $i++) {
            $key .= $keys[mt_rand(0, count($keys) - 1)];
        }
        return $key;
    }


    static function decentLink($strin){
        return preg_replace('!\s+!', '-', trim($strin));

    }

    public static function boolify(&$is_var) {
        $is_var = filter_var($is_var,FILTER_VALIDATE_BOOLEAN);
        return $is_var;
    }


    public static function base64ToFile($base64_string, $output_file) {
        // open the output file for writing
        $dirname = dirname($output_file);
        if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }
        $ifp = fopen( $output_file, 'wb' );
        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );

        // we could add validation here with ensuring count( $data ) > 1
        if (count($data) > 1) {
            fwrite($ifp, base64_decode($data[1]));
        } else {
            fwrite($ifp, base64_decode($data[0]));
        }

        // clean up the file resource
        fclose( $ifp );

        return $output_file;
    }


}