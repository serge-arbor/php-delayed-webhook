FROM nginx:alpine

COPY docker/prod/api/nginx/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /app

COPY public public
