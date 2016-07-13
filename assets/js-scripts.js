$( document ).ready(function(){
	url_ = window.location.href;
	if ( url_.indexOf( "logged.php" ) == -1 ) {
		// Initialize register form
		initRegisterForm();
		// Initialize login form
		initLoginForm();
	} else { initLogoutButton(); }
});

// Initialize register form
function initRegisterForm() {
	$( "#register-box #register-button" ).on("click", function(){
		nickname = $( "#register-box #nickname" ).val().trim();
		email = $( "#register-box #email" ).val().trim();
		password = $( "#register-box #password" ).val().trim();

		flag = 0;

		if ( nickname === undefined || nickname == "" ) {
			flag = 1;
			alert( "Set your username." );
		}

		if ( email === undefined || email == "" ) {
			flag = 1;
			alert( "Set your email." );
		}

		if ( !isValidEmailAddress( email ) ) {
			flag = 1;
			alert( "Enter valid email." );
		}

		if ( password === undefined || password == "" ) {
			flag = 1;
			alert( "Set your password." );
		}

		if ( flag == 0 ) {
			args = {
				nickname: nickname,
				email: email,
				password: password
			}
			register_handler = make_ajax( "assets/ajax-handlers/register.php", "POST", "text", args );
			register_handler.onreadystatechange = function() {
				if ( register_handler.readyState == 4 && register_handler.status == 200 ) {
					if ( register_handler.responseText == "READY" ) { alert( "You've been registered!" ); window.location.reload( true ); }
					else { alert( register_handler.responseText ); }
				}
			}
		}
	});
}

// Initialize login form
function initLoginForm() {
	$( "#login-box #login-button" ).on("click", function(){
		email = $( "#login-box #email" ).val().trim();
		password = $( "#login-box #password" ).val().trim();

		flag = 0;

		if ( email === undefined || email == "" ) {
			flag = 1;
			alert( "Enter your email." );
		}

		if ( password === undefined || password == "" ) {
			flag = 1;
			alert( "Enter your password." );
		}

		if ( flag == 0 ) {
			args = {
				email: email,
				password: password
			}
			login_handler = make_ajax( "assets/ajax-handlers/login.php", "POST", "text", args );
			login_handler.onreadystatechange = function() {
				if ( login_handler.readyState == 4 && login_handler.status == 200 ) {
					if ( login_handler.responseText == "READY" ) { window.location = "logged.php"; }
					else { alert( login_handler.responseText ); }
				}
			}
		}
	});
}

// Initialize logout functionallity
function initLogoutButton() {
	$( "#user-box #logout-button" ).on("click", function(){
		args = {};
		logout_handler = make_ajax( "assets/ajax-handlers/logout.php", "POST", "text", args );
		logout_handler.onreadystatechange = function() {
			if ( logout_handler.readyState == 4 && logout_handler.status == 200 ) {
				if ( logout_handler.responseText == "READY" ) { window.location = "index.php"; }
				else { console.log( logout_handler.responseText ); }
			}
		}
	});
}


// Is valid E-mail
function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
	return pattern.test(emailAddress);
};


//AJAX Caller
function make_ajax( path, type, resultType, variables ) {
	var requestType;	
	//Send request
	if (window.XMLHttpRequest) {
		requestType = new XMLHttpRequest();
	} else {
		requestType = new ActiveXObject("Microsoft.XMLHTTP");
	}

	requestType.open(type, path, true);

	varCount = 0;

	buildVarStructure = "";
	for ( var key in variables ) {
		if ( variables.hasOwnProperty( key ) ) {
			varName = key;
			varValue = variables[key];

			buildVarStructure += varName +"="+ varValue +"&";
		}
	}

	requestType.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	requestType.send( buildVarStructure );

	return requestType;
}