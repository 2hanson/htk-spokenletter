#!/bin/sh
DIR=$1
FEATURE=$2
FEATURE_PREFIX=$3
GRAMMAR_SCALE=$4
INSERT_PENALTY=$5
NETWORK=$6
HVite \
    -C lib/cfgs/${FEATURE}.cfg \
    -T 1 \
    -s ${GRAMMAR_SCALE} \
    -p ${INSERT_PENALTY} \
    -t 200 \
    -H exp/user/hmm${DIR}/MMF \
    -i exp/user/hmm${DIR}/test.${FEATURE}.mlf \
    -w lib/nets/${NETWORK}.net \
    -S lib/flists/test.${FEATURE_PREFIX}.scp \
    lib/dicts/letters.dct \
    lib/lists/letters.list
HResults \
    -I lib/labs/letters.mlf \
    lib/lists/letters.list \
    exp/user/hmm${DIR}/test.${FEATURE}.mlf