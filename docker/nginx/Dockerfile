FROM nginx:1.27-alpine

WORKDIR /app/public

COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./public/* /app/public/
