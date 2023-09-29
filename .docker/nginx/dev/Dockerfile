FROM nginx:1.21-alpine

COPY nginx.conf  /etc/nginx/
COPY ../conf.d /etc/nginx/conf.d/
RUN echo "upstream php-upstream { server php.dev:9000; }" > /etc/nginx/conf.d/upstream.conf

EXPOSE 80
EXPOSE 443
