#!/bin/bash

docker container rm --force $(docker container ls -q -a)
docker-compose up --build --force-recreate