<?php
const LOGS_FILE_NAME = 'random.access';

function readLogs($path) : array
{
    $lines = [];
    $handle = fopen($path, 'r');

    while(!feof($handle))
        $lines[] = trim(fgets($handle));

    fclose($handle);

    return $lines;
}

function getStatsOfVisitsLogs() : array
{
    $stats = [
        'codes' => [
            'count' => 0
        ],
        'uniquesVisitors' => 0,
        'directConnections' => 0,
        'nonExistentAddresses' => []
    ];

    $logs = readLogs(LOGS_FILE_NAME);
    $ips = [];
    $nonExistentAddresses = [];

    foreach($logs as $log)
    {
        $regex = '/^(\S*).*\[(.*)\]\s"(\S*)\s(\S*)\s([^"]*)"\s(\S*)\s(\S*)\s"([^"]*)"\s"([^"]*)".*$/';
        preg_match($regex, $log, $logValues);

        $ip = (string) ($logValues[1] ?? '');
        $date = (string) ($logValues[2] ?? '');
        $method = (string) ($logValues[3] ?? '');
        $statusCode = (int) ($logValues[6] ?? 0);
        $path = (string) ($logValues[4] ?? '');
        $referer = (string) trim(str_replace('-', '', ($logValues[8] ?? '')));

        if(count($logValues) > 9)
        {
            @$stats['codes'][$statusCode]++;
            $stats['codes']['count']++;

            if($statusCode == 404)
                $nonExistentAddresses[] = $path;

            if($path == '/' && empty($referer))
                $stats['directConnections']++;

            $ips[] = $ip;
        }
    }

    $stats['uniquesVisitors'] = array_unique($ips);
    $stats['nonExistentAddresses'] = array_unique($nonExistentAddresses);

    return $stats;
}

$stats = getStatsOfVisitsLogs();

echo "Wystąpień status code: {$stats['codes']['count']}\n";
echo "Unikatowych adresów IP (".count($stats['uniquesVisitors'])."): ".implode(', ', $stats['uniquesVisitors'])."\n";
echo "Bezpośrednich wejść na stronę (bez przekierowań): {$stats['directConnections']}\n";
echo "Lista nieistniejących adresów URL (".count($stats['nonExistentAddresses'])."): ".implode(', ', $stats['nonExistentAddresses']);
?>
