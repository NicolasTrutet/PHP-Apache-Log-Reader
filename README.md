# PHP Apache log reader

This php script allows you to retreive informations from an apache access.log file. <br/>

<pre>
$line = "127.0.0.1 - - [01/Jan/2016:12:31:34 +0000] "GET /index.php HTTP/1.1" 200 19045"
$infos = ApacheLogReader::getInfos($line, true);

/* getInfos() will return the following array. */

[
  "ip" => "127.0.0.1",
  "date" => "1451651503",
  "http_method" => "GET",
  "http_resource" => "/index.php",
  "http_response" => "200",
]
</pre>

## Author

<a href="http://www.nicolastrutet.com/">TRUTET Nicolas</a>
