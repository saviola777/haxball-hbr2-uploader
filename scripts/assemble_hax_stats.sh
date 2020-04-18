#!/bin/bash

FHU_DIRECTORY="/path/to/fhu"

COUNT=`find $FHU_DIRECTORY/files/ -type f | wc -l`
COUNT=$(($COUNT-1))

SIZE=`du -s $FHU_DIRECTORY/files | awk '{print $1}'`
TIME=`date +%s`

echo "{\"count\":$COUNT,\"size\":$SIZE,\"time\":$TIME}" > $FHU_DIRECTORY/stats.json
