# Dockerfile
FROM jenkins/jenkins:lts

USER root
RUN apt-get update && \
    apt-get install -y php-cli git unzip && \
    rm -rf /var/lib/apt/lists/*

USER jenkins
