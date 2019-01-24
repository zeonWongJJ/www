;layui.define("jquery", function (e) {
    var $ = layui.$;
    var utils = {
        initPage: function (actions) {
            $('.page_action').click(function () {
                var type = $(this).data('type');
                actions.page_active[type] ? actions.page_active[type].call(this) : '';
            });

            $('body').on('click', '.grid_action', function () {
                var type = $(this).data('type');
                actions.grid_active[type] ? actions.grid_active[type].call(this) : '';
            });
        },
        fmtDate: function (nS) {
            return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/, ' ');
        },
        /**
         * 重复字符串
         * @param str
         * @param n
         * @returns {string}
         */
        repeat: function (str, n) {
            return new Array(n + 1).join(str);
        },
        checkMobile: function (s) {
            var length = s.length;
            if (length == 11 && /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(14[0-9]{1})|)+\d{8})$/.test(s)) {
                return true;
            } else {
                return false;
            }
        }
    };
    e('utils', utils);
});