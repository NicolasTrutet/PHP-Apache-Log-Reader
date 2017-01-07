<?php


/* * * * * * * * * * * * * * * * * * * * *
 * ApacheLogReader
 *
 * author TRUTET Nicolas
 */
class ApacheLogReader {


    /**
     * The following method extract informations from a line of Apache log.
     * Set the timestamp argument to true if you want to get the date as a timestamp.
     *
     * @param {String}   $access_log
     * @param {Boolean}  $timestamp
     * @return {Array}
     */
    public static function getInfos($access_log, $timestamp) {

        $log = array(
            "ip" => "",
            "date" => "",
            "http_method" => "",
            "http_resource" => "",
            "http_response" => "",
        );

        /* Get IP */
        if (preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $access_log, $ip)) {
           $log['ip'] = $ip[0];
        } else if (preg_match('{[:]{1,2}[0-9]{1,2}}', $access_log, $ip)) {
            $log['ip'] = $ip[0];
        }

        /* Get date */
        if (preg_match('{[0-9]{2}/[A-z]{3}/[0-9]{4}:[0-9]{2}:[0-9]{2}:[0-9]{2}}', $access_log, $date)) {  
            $log['date'] = $date[0];

            if ($timestamp) {
                $log['date'] = self::turnDateToTimestamp($date[0]);
            }
        }

        /* Get HTTP method */
        if (preg_match('{[\"][A-Z]{3,7}}', $access_log, $httpMethod)) {
            $log['http_method'] = substr($httpMethod[0], 1);
        }

        /* Get HTTP Resource */
        if (preg_match('{\s[\/].*(?=HTTP)}', $access_log, $httpResource)) {
            $log['http_resource'] = $httpResource[0];
        }

        /* Get HTTP Response */
        if (preg_match('{[\"]\s[0-9]{3}}', $access_log, $httpReponse)) {
            $log['http_response'] = substr($httpReponse[0], 2);
        }

        return $log;
    }




    /**
    * Turns a date formated as [01/Jan/2016:06:35:46] to a timestamp.
    *
    * @param {String} $date
    * @return {Integer} 
    */
    private static function turnDateToTimestamp($date) {
        
        try {
            $dateObj = date_create_from_format('d/M/Y:H:i:s', $date);
            return $dateObj->getTimestamp();
            
        } catch(Exception $e) {
            echo $e;
            return 0;
        }
    }

}









/* Read file line by line. */
$file = new SplFileObject("access_log");

while (!$file->eof()) {
    
    $line = $file->fgets();
    $logArray = ApacheLogReader::getInfos($line, true);

    print_r($logArray);
    echo '<hr>';

}
$file = null;




