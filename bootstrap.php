<?php

error_reporting(E_ERROR | E_PARSE);

require_once __DIR__ . '/vendor/autoload.php';

define('VIEW_PATH', __DIR__ . '/views/');


Dotenv\Dotenv::createUnsafeImmutable(__DIR__)->load();

function getAccessTokenFromCookie()
{
    $cookiePattern = sprintf(
        '/CognitoIdentityServiceProvider_%s.+_accessToken/',
        getenv('CLIENT_ID')
    );
    foreach ($_COOKIE as $name => $value) {
        if (preg_match($cookiePattern, $name) !== 0) {
            return $value;
        }
    }

    return null;
}

/**
 * @return \Aws\CognitoIdentityProvider\CognitoIdentityProviderClient
 */
function getClient()
{
    static $client = null;

    if (is_null($client)) {
        $client = new \Aws\CognitoIdentityProvider\CognitoIdentityProviderClient([
            'profile' => 'default',
            'region' => getenv('REGION'),
            'version' => '2016-04-18'
        ]);
    }

    return $client;
}

function getUser($accessToken) {
    return getClient()->getUser([
        'AccessToken' => $accessToken,
    ]);
}
