#!/bin/sh
GAUSSIAN_COMPONENT=$1
ITERATION=$2
FEATURE=$3
FEATURE_PREFIX=$4
NEXT_ITERATION=$((ITERATION+1))

printf '[hmm'${GAUSSIAN_COMPONENT}${ITERATION}' -> hmm'${GAUSSIAN_COMPONENT}${NEXT_ITERATION}'] '

mkdir -p exp/user/hmm$GAUSSIAN_COMPONENT$NEXT_ITERATION

HERest -T 1 \
    -C lib/cfgs/${FEATURE}.cfg \
    -H exp/user/hmm${GAUSSIAN_COMPONENT}${ITERATION}/MMF \
    -M exp/user/hmm${GAUSSIAN_COMPONENT}${NEXT_ITERATION} \
    -I lib/labs/letters_sil.mlf \
    -S lib/flists/train.${FEATURE_PREFIX}.scp \
    lib/lists/letters.list \
    > exp/user/hmm${GAUSSIAN_COMPONENT}${NEXT_ITERATION}/LOG

cat exp/user/hmm${GAUSSIAN_COMPONENT}${NEXT_ITERATION}/LOG | grep 'Reestimation complete'