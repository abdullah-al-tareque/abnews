<?php
// First of all send css header
header("Content-type: text/css");


// Array of css files
$css = array(
'bootstrap.min.css',
'font-awesome.min.css',
'jquery.mCustomScrollbar.css',
'styles/style.css',
'styles/skin-lblue.css',
'custom.css',
'custom-style.css',
'custom-media.css'
);

// Prevent a notice
$css_content = '';

// Loop the css Array
foreach ($css as $css_file) {
    $css_content .= file_get_contents($css_file);
}

echo $css_content;