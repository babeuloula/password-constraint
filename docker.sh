#!/usr/bin/env bash

set -e

readonly DOCKER_PATH=$(dirname $(realpath $0))
cd ${DOCKER_PATH};

docker build -t babeuloula/password-constraint:latest --build-arg UID=$(id -u) ./docker/
docker run -it --rm --name babeuloula-password-constraint -v "$(pwd)":/var/www/html -w /var/www/html babeuloula/password-constraint bash
