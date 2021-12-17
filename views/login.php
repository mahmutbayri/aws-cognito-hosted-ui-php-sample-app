<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Redirect Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="app.js"></script>
</head>
<body>

<div class="px-4 py-5 my-5 text-center">
    <img class="d-block mx-auto mb-4" src="/aws-cognito-logo.jpg" height="230"/>
    <h1 class="display-5 fw-bold">.: Login Page :.</h1>
    <div class="col-lg-6 mx-auto">
        <p class="lead mb-4">
            Amazon Cognito lets you add user sign-up, sign-in, and access control to your web and mobile apps quickly
            and easily.
            Amazon Cognito scales to millions of users and supports sign-in with social identity providers, such as
            Apple, Facebook, Google, and Amazon, and enterprise identity providers via SAML 2.0 and OpenID Connect.
        </p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a href="index.php" id="loginButton" type="button" class="btn btn-primary btn-lg px-4 gap-3">
                Go to Homepage
            </a>
        </div>
    </div>
</div>

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
    CognitoAuth.configure(config);

</script>

</body>
</html>