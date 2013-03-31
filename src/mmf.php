<?php
$state = $argv[1];
$model = $argv[2];

$file = file_get_contents('lib/lists/letters.list');
$proto = file_get_contents('exp/user/hmm10/proto'.$state);
$protoFeature = explode(PHP_EOL, file_get_contents('lib/proto/proto'.$state.'.'.$model));
$vFloors = file_get_contents('exp/user/hmm10/vFloors');
$protoLines = explode(PHP_EOL, $proto);
$protoLines = array_slice($protoLines, 4);
$headerLines = array_slice($protoFeature, 0, 3);

$proto = implode(PHP_EOL, $protoLines);
$header = implode(PHP_EOL, $headerLines);
$lines = explode(PHP_EOL, $file);
$out = $header.$vFloors;
foreach ($lines as $line) {
    if (!empty($line)) {
        $out.='~h "'.$line.'"'.PHP_EOL;
        $out.=$proto;
    }
}

file_put_contents('exp/user/hmm10/MMF', $out);