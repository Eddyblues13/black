<?php

$viewsDir = __DIR__ . '/resources/views/new';
$pagesDir = __DIR__ . '/resources/views/new/pages';
$homeDir = __DIR__ . '/resources/views/home';

function processFile($filePath, $homeDir) {
    $content = file_get_contents($filePath);
    
    // Replace assets paths safely
    $content = preg_replace('/(href|src)="assets\/([^"]+)"/i', '$1="{{ asset(\'assets/$2\') }}"', $content);
    $content = preg_replace('/(href|src)=\'assets\/([^\']+)\'/i', '$1="{{ asset(\'assets/$2\') }}"', $content);
    $content = preg_replace('/(href|src)="external-embedding\/([^"]+)"/i', '$1="{{ asset(\'external-embedding/$2\') }}"', $content);
    
    // background-image: url('assets/...')
    $content = preg_replace('/url\([\'"]?assets\/([^\'"]+)[\'"]?\)/i', 'url(\'{{ asset(\'assets/$1\') }}\')', $content);
    
    // Replace routes mapping
    $routesMap = [
        'index.html' => '{{ route(\'home\') }}',
        'index-2.html' => '{{ route(\'home\') }}',
        'index-3.html' => '{{ route(\'home\') }}',
        'index-4.html' => '{{ route(\'home\') }}',
        'about.html' => '{{ route(\'about\') }}',
        'contact.html' => '{{ route(\'contact\') }}',
        'pricing.html' => '{{ route(\'pricing\') }}',
        'faq.html' => '{{ route(\'faq\') }}',
        'terms.html' => '{{ route(\'terms\') }}',
        'privacy.html' => '{{ route(\'privacy\') }}',
        'software.html' => '{{ url(\'software\') }}',
        'insight.html' => '{{ url(\'insight\') }}',
        'oil-and-gas.html' => '{{ url(\'oil-and-gas\') }}',
        'option-trading.html' => '{{ url(\'option-trading\') }}',
        'option-trading-2.html' => '{{ url(\'option-trading-2\') }}',
        'futures.html' => '{{ url(\'futures\') }}',
        'futures-2.html' => '{{ url(\'futures-2\') }}',
        'swing-trading.html' => '{{ url(\'swing-trading\') }}',
        'swing-trading-2.html' => '{{ url(\'swing-trading-2\') }}',
        'live-trading.html' => '{{ url(\'live-trading\') }}',
        'live-trading-2.html' => '{{ url(\'live-trading-2\') }}',
        'option-copy-trading.html' => '{{ url(\'option-copy-trading\') }}',
        'advance-trading.html' => '{{ url(\'advance-trading\') }}',
        'advance-trading-2.html' => '{{ url(\'advance-trading-2\') }}',
    ];
    
    foreach ($routesMap as $html => $route) {
        $content = str_replace('href="' . $html . '"', 'href="' . $route . '"', $content);
        $content = str_replace("href='" . $html . "'", "href='" . $route . "'", $content);
    }
    
    $content = str_replace('https://trade.trustwavedigitalasset.org/login', '{{ route(\'login\') }}', $content);
    $content = str_replace('https://trade.trustwavedigitalasset.org/register', '{{ route(\'register\') }}', $content);
    
    $filename = basename($filePath, '.html');
    if (strpos($filename, 'index') === 0) {
        if ($filename !== 'index') {
            return; 
        }
    }
    
    $outPath = $homeDir . '/' . $filename . '.blade.php';
    file_put_contents($outPath, $content);
    echo "Converted $filename.html to blade.\n";
}

$files = glob($viewsDir . '/*.html');
foreach ($files as $f) {
    processFile($f, $homeDir);
}

$filesPages = glob($pagesDir . '/*.html');
foreach ($filesPages as $f) {
    processFile($f, $homeDir);
}

echo "Done transforming files.\n";
