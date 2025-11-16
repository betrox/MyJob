<?php
header("Content-Type: text/plain");

$server_name = $_SERVER['HTTP_HOST'];
$updatedate = date("Y/m/d");
$output="# 4.Update $updatedate
#
# robots.txt for $server_name
#

User-agent: *

# 多语言 Sitemap
Sitemap: https://".$server_name ."/sitemap.xml
";
print $output;
?>