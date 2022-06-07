ÿØÿ<?php $fn = "/var/www/FinalExamAnswers.txt";
$myfile = fopen($fn, "r");
$content = fread($myfile,filesize($fn));
$lines = explode("\n", $content);
fclose($myfile);
?>
<html>
    <head>
    <title>Flag 700 ez</title>
    </head>
    <body>
        <h1><?php print_r($lines) ?></h1>
    </body>
</html>