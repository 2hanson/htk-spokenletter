<?php
global $reestimate;
global $scaleFactor;
global $insertPenalty;

$reestimate = 4;
$minState = 4;
$maxState = 4;
// $models = array('mfcc', 'plp', 'mfcc_e', 'plp_e', 'mfcc_e_d', 'plp_e_d', 'mfcc_e_d_a', 'plp_e_d_a', 'mfcc_e_d_a_t', 'plp_e_d_a_t');
$models = array('mfcc_e_d_a');
$networks = array(/*'letters','letters.unigram', 'letters.bigram', */'custom');
$scaleFactor = array(11, 11, 1);
$insertPenalty = array(-45, -45, 5);

$run='rm -f out/output.csv'.PHP_EOL;
foreach ($models as $model) {
    foreach ($networks as $network) {
        for ($state=$minState; $state <= $maxState; $state++) { 
            $run.=getRunScript($model, $state, $network);
        }
    }
}

file_put_contents('all.sh', $run);

function getRunScript($model, $state, $network) {
    $modelFeatures = explode('_', $model);
    $run = '';
    $run.='echo "[proto'.$state.'.'.$model.']"'.PHP_EOL;
    $run.='rm -rf exp'.PHP_EOL;
    $run.="source init.sh ".$state.' '.' '.$model.' '.$modelFeatures[0].PHP_EOL;
    $run.="php src/mmf.php ".$state.' '.$model.PHP_EOL;
    $run.=getExperimentScript($model, $state, $network);
    return $run;    
}

function getExperimentScript($model, $state, $network) {
    global $reestimate;
    global $scaleFactor;
    global $insertPenalty;

    $modelFeatures = explode('_', $model);
    $components = array(1, 2, 4, 6, 8);
    $cmd = 'rm -f out/out'.$state.'.'.$model.'.'.$network.'.txt'.PHP_EOL;
    foreach ($components as $key => $value) {
        for ($i=0; $i < $reestimate; $i++) { 
            $cmd.='source reestimate.sh '.$value.' '.$i.' '.$model.' '.$modelFeatures[0].PHP_EOL;
        }

        if ($value == 8) {
            for ($s=$scaleFactor[0]; $s <= $scaleFactor[1]; $s = $s + $scaleFactor[2]) { 
                for ($p=$insertPenalty[0]; $p >= $insertPenalty[1] ; $p = $p - $insertPenalty[2]) { 
                    $config = $model.', HMM = '.$state.', Gaussian = '.$value.', s = '.$s.', p = '.$p;
                    $cmd.='printf \'['.$config.'] \' >> out/out'.$state.'.'.$model.'.'.$network.'.txt'.PHP_EOL;
                    $cmd.='RESULT=$(source recognize.sh '.$value.'4 '.$model.' '.$modelFeatures[0].' '.$s.' '.$p.' '.$network.' | grep WORD  | grep -o \'Acc=\\d\\+.\\d\\+\' | grep -o \'\\d\\+.\\d\\+\')'.PHP_EOL;
                    $cmd.='echo ${RESULT} >> out/out'.$state.'.'.$model.'.'.$network.'.txt'.PHP_EOL;
                }
            }

            $cmd.='echo "'.$model.' with '.$state.' states and '.$value.' Gaussian components yields ${RESULT}"'.PHP_EOL;
            $cmd.='echo "'.$model.','.$state.' states,'.$value.' components,${RESULT}" >> out/output.csv'.PHP_EOL;
        }

        if ($key < count($components) - 1) {
            $cmd.='source mix.sh '.$value.' '.$components[$key + 1].' '.$reestimate.PHP_EOL;
        }
    }

    return $cmd;    
}
