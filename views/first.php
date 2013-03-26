<!DOCTYPE html>
<html>
<head>
	<title><?= $title; ?></title>
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
</head>
<body>

<h1>Welcome!</h1>

<span id="signinButton">
  <span
    class="g-signin"
    data-clientid="21026368662.apps.googleusercontent.com"
    data-cookiepolicy="single_host_origin"
	data-scope = "https://www.googleapis.com/auth/userinfo.email"
	data-callback="signIn">
  </span>
</span>

<?php
	$loginOut = (!$user) ? "login" : "logout";
	echo "<h3><a href=\"$loginOut\">$loginOut</a></h3>";
?>

<?php
	echo "<hr/><pre>Debug:\n\n";
	var_dump($user); 
	echo "</pre>";	
?>

    <!-- Google signin -->
    <script type="text/javascript">
      (function() {
       var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
       po.src = 'https://apis.google.com/js/client:plusone.js';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
     })();
	 
	 function signIn(resp){
	  if (resp['access_token']) {
		//Login users with google+
		$.post("login/google", 
			{access_token:resp.access_token}, 
			function(r){
				r = JSON.parse(r);
				if (!r.loggedIn) {
					//Sign up users who's not
					$.post("signup/google", 
						{access_token:resp.access_token}, 
						function(re){ 
							re = JSON.parse(re);
							if(re.loggedIn)
								updateButton(re.name);
						}
					);					
				} else {
					console.log(r);
					updateButton(r.name);
				}
			}
		);

	  } else if (resp['error']) {
		console.error("NOT signed in");
		console.log(resp);
		
		// There was an error.
		// Possible error codes:
		//   "access_denied" - User denied access to your app
		//   "immediate_failed" - Could not automatially log in the user
		// console.log('There was an error: ' + authResult['error']);
	  }
	 }
	 
	function updateButton(name) {
		$("#signinButton").empty().html(
			"Logged via Google+, click <a " + 
			"href=\"https://plus.goo" + 
			"gle.com/apps\">here</a> to " +
			"manage app settings."
		);	
	}
    </script>
</body>
</html>
