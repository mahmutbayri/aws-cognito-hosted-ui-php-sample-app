<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="app.js"></script>
</head>
<body>

<div class="px-4 py-5 my-5 text-center">
    <img class="d-block mx-auto mb-4" src="/aws-cognito-logo.jpg" height="230"/>
    <h1 class="display-5 fw-bold">Amazon Cognito</h1>
    <div class="col-lg-6 mx-auto">
        <p class="lead mb-4">
            Amazon Cognito lets you add user sign-up, sign-in, and access control to your web and mobile apps quickly
            and easily.
            Amazon Cognito scales to millions of users and supports sign-in with social identity providers, such as
            Apple, Facebook, Google, and Amazon, and enterprise identity providers via SAML 2.0 and OpenID Connect.
        </p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <?php if (is_null($user)): ?>
                <button id="loginButton" type="button" class="btn btn-primary btn-lg px-4 gap-3">Login button (Hosted
                    UI)
                </button>
            <?php else: ?>
                <button id="logoutButton" type="button" class="btn btn-warning btn-lg px-4">Logout button (Hosted UI)
                </button>
            <?php endif; ?>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger mt-5" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (!is_null($user)): ?>
    <div class="container-sm">
        <div class="row">
            <div class="col">
                <h3 class="text-center">Private Content</h3>
                <iframe
                        style="width: 100%; height:300px;display: block;margin: 0 auto;"
                        src="https://www.youtube.com/embed/9ix7TUGVYIo" title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                ></iframe>
            </div>
        </div>
    </div>
<?php endif; ?>
<script>

    const config = {
        oauth: {
            domain: '<?=getenv('DOMAIN')?>',
            scope: ['email', 'openid', 'aws.cognito.signin.user.admin'],
            redirectSignIn: 'http://localhost:9900/login.php',
            redirectSignOut: 'http://localhost:9900/logout.php',
            // returnTo: 'http://localhost:9900/logout.html',
            responseType: 'token' // or 'token', note that REFRESH token will only be generated when the responseType is code
        },
        userPoolId: '<?=getenv('USERPOOL_ID')?>',
        userPoolWebClientId: '<?=getenv('CLIENT_ID')?>',
        cookieStorage: {
            // REQUIRED - Cookie domain (only required if cookieStorage is provided)
            domain: 'localhost',
            // OPTIONAL - Cookie path
            path: '/',
            // OPTIONAL - Cookie expiration in days
            expires: 365,
        },
    };

    const loginPath = 'https://' + config.oauth.domain +
        '/login?client_id=' + config.userPoolWebClientId +
        '&response_type=' + config.oauth.responseType +
        '&scope=' + config.oauth.scope.join('+') +
        '&redirect_uri=' + config.oauth.redirectSignIn +
        '&state=STATE';

    CognitoAuth.configure(config);

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('#loginButton')?.addEventListener('click', function () {
            window.location.assign(loginPath);
        });

        document.querySelector('#logoutButton')?.addEventListener('click', function () {
            CognitoAuth.signOut()
        });

        <?php if ($error): ?>

        setTimeout(function () {
            CognitoAuth.signOut()
        }, 1e3);

        <?php endif; ?>
    })

</script>

</body>
</html>