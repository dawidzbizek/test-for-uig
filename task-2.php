<?php
const MAX_ELEMENTS_OF_VERSION = 4;

function decodeHumanVersion(string $humanVersion) : int
{
    $version = [];
    $decodedVersion = explode('.', str_replace(['a', 'b'], '', $humanVersion));

    for($i = 0; $i < MAX_ELEMENTS_OF_VERSION; $i++)
    {
        $rawValue = $decodedVersion[$i] ?? '0';
        $tmpValue = str_split($rawValue);
        $value = [];

        for($j = 0; $j < 3; $j++)
            $value[] = $tmpValue[$j] ?? '0';

        $version[] = implode('', $value);
    }

    if(substr($humanVersion, -1) == 'a')
        $version[3] = 1;
    elseif(substr($humanVersion, -1) == 'b')
        $version[3] = 2;
    else
        $version[3] = 3;

    return (int) implode('', $version);
}

function compareVersions(string $a = '0', string $b = '0') : string
{
    $decodedA = decodeHumanVersion($a);
    $decodedB = decodeHumanVersion($b);

    if($decodedA == $decodedB)
        return 'same';
    elseif($decodedA > $decodedB)
        return "$a is bigger";
    else
        return "$b is bigger";
}

echo compareVersions('5.3', '5.3.4a');
?>
