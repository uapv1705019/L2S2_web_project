<?php
session_start (); //start the session
session_unset (); //destroy session variables
session_destroy (); //destroying the session
header ('location: utilisateurs.php'); //redirect to the main page
?>