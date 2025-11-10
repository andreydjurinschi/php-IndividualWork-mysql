#!/bin/bash
# tests/docker_test.sh

set -e  # Прерывать скрипт при любой ошибке

IMAGE_NAME="php-individualwork-test"

echo "Сборка Docker образа..."
docker build -t $IMAGE_NAME .

echo "Запуск контейнера из образа..."
docker run --rm $IMAGE_NAME php -v

echo "Docker контейнер успешно запускается ✅"
