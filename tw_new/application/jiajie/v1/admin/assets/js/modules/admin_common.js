layui.define(['layer', 'fetch', 'form', 'utils'], function (exports) {
    var layer = parent.layer || layui.layer
        , fetch = layui.fetch
        , utils = layui.utils
        , form = layui.form
        , roleBtn = ''
        , admin = {
        render_role_list: function (callback) {
            fetch.ajax('/auth.role.count', {}, function (res) {
                fetch.ajax('/auth.role.list', {
                    rows: res._count
                }, function (res) {
                    $.each(res, function (index, element) {
                        roleBtn += '<a href="javascript:void(0);" class="grid_action" data-type="select_role" data-roleid="' + element.id + '">' + element.role_name + '</a>';
                    });
                    $('#addRoleLevel').html(roleBtn);
                    callback && callback.call(this);
                })
            });
        }
        , render_position_img: function() {
            return '<img class="adminChoice" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABMAAAAUCAMAAABYi/ZGAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA39pVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo0YjA0NGQzZS0yMDQ4LTU1NDItYTQ0Ny1lMGRjYmExMDE3YWEiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QTVBM0QzM0ZBQ0Q3MTFFNzlCOEFBQkMxNkY4MEE0RjIiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QTVBM0QzM0VBQ0Q3MTFFNzlCOEFBQkMxNkY4MEE0RjIiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjAyNjM0NDI4LTA4NGEtNTc0NC1hOWY0LWM0MDkyYzMzMzBjOCIgc3RSZWY6ZG9jdW1lbnRJRD0iYWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOjg3MDY4NTk0LTgzZmEtMTFlNy1hNWI3LWYxZGI4NGEwNTJlYSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PtbBZmMAAAGbUExURUS13////0S03kO03UGt1TucwPr8/kGs1TqbwFu+4zqbv/n8/ki24On0+6Ha7/j8/ke24EOz3/f7/SOGuyCEuR+DuEGu1rzk8/7+/z2p3vz+/pzS8Tun3ki23pDH6nK76V2q2kKx3z+v3SaLzEGw3jai2kGs1Fyy6N/z+vD5/Ojz+lmw5pLJ7GGs2yaIvFqp29Pq+D2jyGGs3Ob1+z+oz6XW8Oz3/DGY2onO6DKSxU6n31C64Tqn3Z3Y7o/L70+54dXu+CyU1/X7/UCq0UKs4GKv4Pj7/sPn9WTC5fL6/Um34Ei34M/s98Ln9fX6/fP6/Tmf1GTB5Dik3Oj2+/r9/m7G5mq15G6454fP6tTu+CmKvt7y+UWw4keh22Ou3dLt90Su4kep5yeMwbnj84TO6un1/GSu3u/5/GXC5SyMv0q34Giy4Gu46W6769/w+2ay4lGq4l6s3r/m9LDX72bD5WHB5KfT76rd8C+OwZPU7T+r31Wt5Eqk3dfv+DOQtabS7l684PX6/nrK6Fm947Ph8ujz+y+a0+j0+////2HtB9kAAACJdFJOU/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8A0YG4uAAAARBJREFUeNpk0EVzw1AMBOCVKXbqJmnDZWZmTpmZmZmZGd/P7rPHdQ7dg0bzzeigBfsfmDPUM6t59q/u5qLWegkr7xOWBfv/CItriaYN6jat5h4ftXBzf9jUWbhFb4dlYDc23T/EEsWkVoPtAnHhpHQgfGrQzGgdRjiNF13XZjU1/HCari9/xQKQnUL00vb4RdR9cqtKychDxpJCRBcFRPFde7Ik6uiD8H1gIKezeVkSoIFpYtX6toFKaYlB2ARrFiTVW6HQ5LLXJAyB5UdEh9OXNlzsU03qDfHfNsDRn+l3OgwaeDI7cHGUn9UckZN+bnUVbBQDHQGDtBW70x3XGL/zTH26oz3ztFfWJFjrrwADAHy9VSUOMSPvAAAAAElFTkSuQmCC" alt="">';
        }
    };

    // admin.render_role_list();

    $(function () {
        utils.initPage({
            grid_active: {
                select_role: function () {
                    var curent_select = $('input[name=user_role]').val()
                        , now_select = $(this).data('roleid');

                    if (curent_select == now_select) {
                        return;
                    }

                    if (curent_select) {
                        $(this).parents('#addRoleLevel').find('a[data-roleid=' + curent_select + ']').find('img.adminChoice').remove();
                    }
                    $(this).append(
                        admin.render_position_img()
                    );
                    $('input[name=role_id]').val(now_select);
                }
            }
        });
    });

    exports('admin_common', admin);
});