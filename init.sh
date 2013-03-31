#!/bin/sh
STATES=$1
FEATURE=$2
FEATURE_PREFIX=$3
mkdir -p exp/user/hmm10
HCompV \
    -C lib/cfgs/${FEATURE}.cfg \
    -m \
    -f 0.01 \
    -M exp/user/hmm10 \
    -S lib/flists/train.${FEATURE_PREFIX}.scp \
    lib/proto/proto${STATES}.${FEATURE}