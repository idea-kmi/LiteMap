<?php
    require_once('userAgent.class.php');
    $userAgent = new UserAgent(); 
    echo"<h1>PHP User Agent</h1>";
    echo"<h3>Browser Detection in PHP5</h3>";
    echo"<b>Browser Name</b>     : " . $userAgent->getBrowserName(). ' <br/> ';
    echo"<b>Browser Version</b>  : " . $userAgent->getBrowserVersion(). ' <br/> ';
    echo"<b>Operating System</b> : " . $userAgent->getOperatingSystem(). ' <br/> ';
    echo"<b>Engine</b>           : " . $userAgent->getEngine();
?>