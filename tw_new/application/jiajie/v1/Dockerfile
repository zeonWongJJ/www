FROM tw/framework

MAINTAINER rusice liruizhao970302@outlook.com

ENV APP_DEBUG 1
ENV SERVER_DOMAIN 'http://jiajie-server.7dugo.com'
ENV SERVER_ROOT '/www/server/web'
ENV TOUCH_DOMAIN 'http://jiajie-touch.7dugo.com'
ENV TOUCH_ROOT '/www/touch'
ENV ADMIN_DOMAIN 'http://jiajie-admin.7dugo.com'
ENV ADMIN_ROOT '/www/admin'
ENV PC_DOMAIN 'http://jiajie-pc.7dugo.com'
ENV PC_ROOT '/www/pc'
ENV SERVER_PORT 19001
ENV TOUCH_PORT 19002
ENV ADMIN_PORT 19003
ENV PC_PORT 19004

COPY build /tmp/build/
COPY ./ /www
COPY build/nginx.conf /usr/local/nginx/conf/nginx.conf

RUN echo '127.0.0.1  jiajie-server.7dugo.com' >> /etc/hosts \
    && echo '127.0.0.1  jiajie-admin.7dugo.com' >> /etc/hosts \
    && echo '127.0.0.1  jiajie-pc.7dugo.com' >> /etc/hosts \
    && echo '127.0.0.1  jiajie-touch.7dugo.com' >> /etc/hosts \
    && chmod -R 777 /www/server/web/uploadfile \
    && rm -rf .idea docker-compose.yml Dockerfile \
    && echo "#! /bin/bash" > /run.sh && \
    echo "function ypn() {" >> /run.sh && \
    echo "/usr/local/php/bin/php /tmp/build/init_nginx_vhost.php" >> /run.sh && \
    echo "/usr/local/php/bin/php /tmp/build/init_touch.php" >> /run.sh && \
    echo "    php-fpm start &" >> /run.sh && \
    echo "    nginx" >> /run.sh && \
    echo "}" >> /run.sh && \
    echo "if [ \$1 = 'ypn' ]; then " >> /run.sh && \
    echo "    ypn" >> /run.sh && \
    echo "fi" >> /run.sh && \
    chmod u+rwx /run.sh


CMD ["/run.sh", "ypn"]

EXPOSE 80 19001 19002 19003 19004
