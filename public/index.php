<?php

use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;

require_once __DIR__ . '/../bootstrap.php';

$accessToken = getAccessTokenFromCookie();

$user = null;
$error = null;

if (!is_null($accessToken)) {
    try {
        $user = getUser($accessToken);
    } catch (CognitoIdentityProviderException $exception) {
        $error = $exception->getAwsErrorMessage();
    } catch (Exception  $exception) {
        $error = $exception->getMessage();
    }
}

include VIEW_PATH . 'index.php';
