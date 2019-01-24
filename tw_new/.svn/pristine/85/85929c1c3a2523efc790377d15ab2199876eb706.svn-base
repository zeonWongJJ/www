'use strict';

/**
 * ajax请求模块定义
 * @author rusice <liruizhao970302@outlook.com>
 */

layui.define(['jquery', 'layer'], function (exports) {
    var $ = layui.jquery,
        layer = layui.layer,
        main = {
            /**
             * 封装用户ajax请求
             * @param uri
             * @param error
             * @param data
             * @param _success
             * @param type
             */
            ajax: function ajax(uri, data, _success, error, type = 'POST') {
                if (0 === uri.indexOf('/')) {
                    uri = window.config.api_prefix + uri + '-admin';
                } else {
                    uri = window.config.root_url + uri;
                }
                $.ajax({
                    url: uri,
                    dataType: 'JSON',
                    type: type,
                    data: data,
                    headers: {
                        'X-Token': this.get_token()
                        , 'X-SOURCE-SIGN': 'admin'
                    },
                    success: function success(rs) {
                        if (typeof rs === 'string') {
                            rs = JSON.parse(rs);
                        }

                        if (rs.error === 1) {
                            layer.msg(rs.msg, {icon: 5});
                            error && error.call(this);
                        } else if (rs.error === 0) {
                            layer.msg(rs.msg[0], {icon: 6});
                            if (_success) {
                                _success(rs.data, rs.error);
                            }
                        }
                    }
                });
            },

            /**
             * 获取用户token
             * @returns {null|string}
             */
            get_token: function get_token() {
                var token = sessionStorage.getItem('user_token');
                if (token) {
                    return token;
                }
                return null;
            }
        };

    exports('fetch', main);
});
