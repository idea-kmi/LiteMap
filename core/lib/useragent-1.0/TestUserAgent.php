<?php

	require_once('userAgent.class.php');

    //create an object $userAgent
    $userAgent = new UserAgent();

    echo"<h1>PHP User Agent</h1>";

    echo"<b>Browser Name</b>     : " . $userAgent->getBrowserName(). ' <br/> ';
    echo"<b>Browser Version</b>  : " . $userAgent->getBrowserVersion(). ' <br/> ';
    echo"<b>Operating System</b> : " . $userAgent->getOperatingSystem(). ' <br/> ';
    echo"<b>Engine</b>           : " . $userAgent->getEngine(). ' <br/> ';

    $isNotRealWebUser = $userAgent->isUnknown();
    if ($isNotRealWebUser === TRUE) {
    	echo "<b>Engine</b> : "."Is NOT Real user";
    } else {
    	echo "<b>Engine</b> : "."Is real user";
    }

?>