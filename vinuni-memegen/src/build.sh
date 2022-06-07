#!/bin/bash
docker rm -f vinuni-meme-gen
docker build --tag=vinuni-meme-gen . && \
docker run -p 52145:52145 --restart=on-failure --name=vinuni-meme-gen --detach vinuni-meme-gen
