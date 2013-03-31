#!/bin/sh
COUNT_OLD=$1
COUNT_NEW=$2
MAX_REESTIMATE=$3
echo '[hmm'${COUNT_OLD}${MAX_REESTIMATE}' -> hmm'${COUNT_NEW}'0]'
mkdir -p exp/user/hmm${COUNT_NEW}0
HHEd -T 1 -H exp/user/hmm${COUNT_OLD}${MAX_REESTIMATE}/MMF -M exp/user/hmm${COUNT_NEW}0 lib/edfiles/${COUNT_NEW}.hed lib/lists/letters.list > /dev/null
