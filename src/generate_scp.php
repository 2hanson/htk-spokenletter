<?php
define('USERS', 20);
$datasets = array('train', 'test');
$types = array('mfcc', 'plp');
foreach ($datasets as $dataset) {
    $files = scandir('data/wav/'.$dataset);
    $files = array_slice($files, 2); // exlcude . and ..
    foreach ($types as $type) {
        $wav2mfcc = '';
        $script = '';
        foreach ($files as $file) {
            $feature = 'data/'.$type.'/'.$dataset.'/'.basename($file, '.wav').'.'.$type.PHP_EOL;
            $wav2mfcc.='data/wav/'.$dataset.'/'.$file.' '.$feature;
            $script.=$feature;
        }
        // echo $wav2mfcc;
        file_put_contents('lib/flists/'.$dataset.'.wav2'.$type.'.scp', $wav2mfcc);
        file_put_contents('lib/flists/'.$dataset.'.'.$type.'.scp', $script);
    }
}
