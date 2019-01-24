package com.app.base.netUtil;

import com.app.base.bean.AnnouncementBean;
import com.app.base.bean.Notice;
import com.app.base.bean.SystemNotice;
import com.app.base.utils.HttpUrl;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * Created by 7du-28 on 2018/6/23.
 */

public class NoticeHttpUtil {
    private static NoticeHttpUtil util;
    public static NoticeHttpUtil getInstance(){
        if(util==null){
            util=new NoticeHttpUtil();
        }
        return util;
    }
    //发布通知
    public Disposable publishNotice(boolean isEdit,Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        String url="";
        if(isEdit){
            url=HttpUrl.api_bulletin_update;
        }else {
            url=HttpUrl.api_bulletin_add;
        }
        return HttpUtil.getInstance().post(url,map,observer,clazz);
    }

    //获取收到或者发起的通知
    public Disposable noticeReceivedOrPublishList(String url, Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(url,map,observer,clazz);
    }

    //删除我发起的通知
    public Disposable deleteMineNotice(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_bulletin_delete,map,observer,clazz);
    }

    //获取通知详情
    public Disposable getNoticeDetails(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_bulletin_get,map,observer,clazz);
    }


    //获取系统通知列表
    public Disposable systemNoticeList(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_system_notice_list,map,observer,clazz);
    }
    //获取系统通知详情
    public Disposable systemNoticeDetails(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_system_notice_get,map,observer,clazz);
    }


    //获取系统通知详情
    public Disposable initPublicNoticeUnRead(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_bulletin_count,map,observer,clazz);
    }
}
