<?php
$dir = __DIR__ . '/resources/views/home';
$files = glob($dir . '/*.blade.php');

foreach($files as $f) {
    $c = file_get_contents($f);
    if(strpos($c, "@include('layouts.livechat')") === false) {
        $c = str_replace('</body>', "\n@include('layouts.livechat')\n</body>", $c);
        file_put_contents($f, $c);
        echo "Updated " . basename($f) . "\n";
    } else {
        echo "Already updated " . basename($f) . "\n";
    }
}
echo "Done.";
