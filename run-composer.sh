#!/usr/bin/env bash

docker run --rm --interactive --tty --volume $PWD/src:/app composer install