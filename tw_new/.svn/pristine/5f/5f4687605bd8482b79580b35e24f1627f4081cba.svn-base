FROM yiye-php-nginx

MAINTAINER rusice liruizhao970302@outlook.com

COPY ./ /tw/
COPY ./conf.d/nginx.conf /usr/local/nginx/conf/nginx.conf
COPY ./conf.d/www.conf /usr/local/php/etc/php-fpm.d/www.conf

RUN cd /tw && rm -rf core_encode core.rar Dockerfile

RUN cd / \
    && echo "#! /bin/bash" > /run.sh && \
    echo "function ypn() {" >> /run.sh && \
    echo "cd /www" && \
    echo "    php-fpm start &" >> /run.sh && \
    echo "    nginx" >> /run.sh && \
    echo "}" >> /run.sh && \
    echo "if [ \$1 = 'ypn' ]; then " >> /run.sh && \
    echo "    ypn" >> /run.sh && \
    echo "fi" >> /run.sh && \
    chmod u+rwx /run.sh

ENV MYSQL_USER_NAME 'root'
ENV MYSQL_USER_PWD '123456'
ENV MYSQL_HOST '172.18.0.4:3306'
ENV MYSQL_DB_NAME 'qiqing'
ENV MYSQL_TB_PREFIX 'qq_'
ENV REDIS_HOST '172.18.0.7:6379'
ENV MEMCACHE_HOST '172.18.0.8:11211'
ENV APP_DEBUG 1

CMD ["/run.sh", "ypn"]
