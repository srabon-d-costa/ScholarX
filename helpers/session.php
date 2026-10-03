<?php

/*
|--------------------------------------------------------------------------
| ScholarX Secure Session Configuration
|--------------------------------------------------------------------------
*/

// Only configure the session if it has NOT started yet
if (session_status() === PHP_SESSION_NONE)
{
    // Use cookies only for sessions
    ini_set('session.use_only_cookies', '1');

    // Reject uninitialized session IDs
    ini_set('session.use_strict_mode', '1');

    // Never allow session IDs to be propagated through URLs
    ini_set('session.use_trans_sid', '0');

    // Configure secure session cookie
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',

        // HTTPS = true, localhost HTTP = false
        'secure' => (
            isset($_SERVER['HTTPS']) &&
            $_SERVER['HTTPS'] !== 'off'
        ),

        // JavaScript cannot access session cookie
        'httponly' => true,

        // Helps protect against CSRF
        'samesite' => 'Lax'
    ]);

    // Start session
    session_start();
}

?>