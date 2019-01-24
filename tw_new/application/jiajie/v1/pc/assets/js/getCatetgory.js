+(function ($) {
    $.ajax({
        url: window.config.api_prefix + 'category.list'
        , type: 'POST'
        , data: {
            'data-set': 'tree'
        }
        , success: function (data) {
            // noinspection EqualityComparisonWithCoercionJS
            if (data.error != 0) {
                alert('分类接口异常!');
            } else {
                var dataList = data.data
                    , i = 0
                    , name
                    , dom = ''
                    , nameWithBr = '';
                $.each(dataList, function (_i, e) {
                    if (i <= 5) {
                        name = e['cat_name'].split('');
                        nameWithBr = name.shift() + name.shift() + '<br/>' + name.join('');

                        dom += '<dl><dt>' + nameWithBr + '</dt><dd>';

                        if (e['children']) {
                            dom += '<ul>';
                            $.each(e['children'], function (index, element) {
                                dom += '<li><a href="">' + element['cat_name'] + '</a></li>';
                            });
                            dom += '</ul>';
                        }

                        dom += '</dd></dl>';
                        i++;
                    }
                });
                $('#service_category_box').html(dom);
            }
        }
    })
})(jQuery);