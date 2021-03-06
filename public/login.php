<?php

	if (session_status() == PHP_SESSION_NONE) session_start();

	if (isset($_SESSION['gs_user'])){
    header('Location: ./bts/');
    exit;
  }

?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="parkjongwon.com" />
    <meta name="google-signin-client_id" content="434350852164-csop4346dc50mrirrjmpnv8ui0pof4rb.apps.googleusercontent.com">
    <title>The Scroll - DA Student Newspaper</title>
    <!-- <link rel="canonical" href="https://thescroll.com/" /> -->
    <link rel="stylesheet" href="./lib/style/dist/normalize.min.css" />
    <link rel="stylesheet" href="./lib/style/dist/universal.min.css<?php echo "?v=".filemtime("./lib/style/dist/universal.min.css"); ?>" />
    <link rel="stylesheet" href="./lib/style/dist/home.min.css<?php echo "?v=".filemtime("./lib/style/dist/home.min.css"); ?>" />
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:300,400,500,700|Open+Sans:300,400,700,800&display=swap" rel="stylesheet">
    <noscript>
      You need to enable JavaScript to run this app.
    </noscript>
  </head>

  <body>
		<h1>Login Page</h1>

    <div class="g-signin2" data-onsuccess="onSignIn"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script>
    function onSignIn(googleUser) {
      var profile = googleUser.getBasicProfile();
      console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
      console.log('Name: ' + profile.getName());
      console.log('Image URL: ' + profile.getImageUrl());
      console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

      var id_token = googleUser.getAuthResponse().id_token;
      const
        // will need to move to a public url for production
        urlSignin = 'http://localhost/website/TheScroll/private/access/signin.php',
				urlRedirect = './bts/',
        payload = {id_token};

			axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
      axios.post(urlSignin, payload)
        .then(res => {
          console.log(res);
					const {result} = res.data;
					if (result === 'valid-user') window.location.replace(urlRedirect);
        })
        .catch(err => {
          console.log(err);
        });
    }
    </script>
	</body>
</html>
