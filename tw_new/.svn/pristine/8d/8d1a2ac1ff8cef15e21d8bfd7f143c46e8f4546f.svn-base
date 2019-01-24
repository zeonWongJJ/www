+(function ($) {
    $(function () {
        $.ajax({
            url: window.config.api_prefix + 'timeline.count'
            , type: 'POST'
            , dataType: 'JSON'
            , data: {
                condition: {
                    'time_line_is_show': 1
                }
            }
            , success: function (res) {
                // noinspection EqualityComparisonWithCoercionJS
                if (res.error == 0) {
                    $.ajax({
                        url: window.config.api_prefix + 'timeline.list'
                        , type: 'POST'
                        , dataType: 'JSON'
                        , data: {
                            condition: {
                                'a.time_line_is_show': 1
                            }
                            , rows: res.data._count
                        }
                        , success: function (data) {
                            var template = '';
                            // noinspection EqualityComparisonWithCoercionJS
                            if (data.error != 0) {
                                alert('请求时间轴失败!');
                            } else {
                                var timeLines = data.data;
                                $.each(timeLines, function (index, item) {
                                    var cdClass = index == 0 ? 'cd-picture' : 'cd-movie';
                                    template += '<div class="cd-timeline-block">\n' +
                                        '                <div class="cd-timeline-img '+cdClass+'">\n' +
                                        '                    <img src="assets/img/icon_06.png" alt="Picture">\n' +
                                        '                </div>\n' +
                                        '                <div class="cd-timeline-content">\n' +
                                        '                    <h2>' + item.time_line_title + '</h2>\n' +
                                        '                    <p>' + item.time_line_connect + '</p>\n' +
                                        '                    <!--<a href="#" class="cd-read-more">阅读更多</a>-->\n' +
                                        '                    <span class="cd-date">' + item.time_line_at + '</span>\n' +
                                        '                </div>\n' +
                                        '            </div>';
                                });
                                $('#cd-timeline').html(template);
                            }
                        }
                    })
                }
            }
        });
    })
})(jQuery);
