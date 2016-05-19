<?php
/**
   * autoload
   *
   * @author Joe Sexton <joe.sexton@bigideas.com>
   * @param  string $class
   * @param  string $dir
   * @return bool
   */
function autoload( $class, $dir = null ) {
    if ( is_null( $dir ) )
        $dir = '../src/';

    foreach ( scandir( $dir ) as $file ) {
        // directory?
        if ( is_dir( $dir.$file ) && substr( $file, 0, 1 ) !== '.' )
            autoload( $class, $dir.$file.'/' );

        // php file?
        if ( substr( $file, 0, 2 ) !== '._' && preg_match( "/.php$/i" , $file ) ) {
            // filename matches class?
            if ( str_replace( '.php', '', $file ) == $class || str_replace( '.class.php', '', $file ) == $class ) {
                include $dir . $file;
            }
        }
    }
}

// usage: $newpassword = generatePassword(12); // for a 12-char password, upper/lower/numbers.
// functions that use rand() or mt_rand() are not secure according to the PHP manual.
function getRandomBytes($nbBytes = 32) {
    $bytes = openssl_random_pseudo_bytes($nbBytes, $strong);
    if (false !== $bytes && true === $strong) {
        return $bytes;
    }
    else {
        throw new \Exception("Unable to generate secure token from OpenSSL.");
    }
}
function generatePassword($length) {
    return substr(preg_replace('#^[a-zA-Z0-9+!*,;?_.-]*$#', "", base64_encode(getRandomBytes($length+1))),0,$length);
    //"/[^a-zA-Z0-9]/"
}
?>
