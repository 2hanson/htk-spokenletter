#!/bin/sh
mkdir data/mfcc
mkdir data/mfcc/train
mkdir data/mfcc/test
mkdir data/plp
mkdir data/plp/train
mkdir data/plp/test
php src/generate_scp.php
HCopy -C lib/cfgs/mfcc_e_extract.cfg -S lib/flists/train.wav2mfcc.scp
HCopy -C lib/cfgs/mfcc_e_extract.cfg -S lib/flists/test.wav2mfcc.scp
HCopy -C lib/cfgs/plp_e_extract.cfg -S lib/flists/train.wav2plp.scp
HCopy -C lib/cfgs/plp_e_extract.cfg -S lib/flists/test.wav2plp.scp