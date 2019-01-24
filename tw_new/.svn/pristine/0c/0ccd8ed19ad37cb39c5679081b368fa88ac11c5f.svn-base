package com.app.base.netUtil;

import com.app.base.bean.Comment;
import com.app.base.bean.PlanComment;
import com.app.base.utils.HttpUrl;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * Created by 7du-28 on 2018/6/19.
 */

public class PublishCommentHttpUtil {
    private static PublishCommentHttpUtil httpUtil;

    public static PublishCommentHttpUtil getInstance(){
        if(httpUtil==null){
            httpUtil=new PublishCommentHttpUtil();
        }
        return httpUtil;
    }

    //发布任务评论
    public Disposable publishTaskCommentRecord(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_publish_task_comment,map,observer,clazz);
    }
    //发布计划评论
    public Disposable publishPlanCommentRecord(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_publish_plan_comment,map,observer,clazz);
    }
    //发布任务下部门动作记录
    public Disposable publishActionCommentRecord(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_publish_action_comment,map,observer,clazz);
    }

    //任务-记录列表
    public Disposable taskCommentList(String url,Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        //HttpUrl.api_task_comment_list
        return HttpUtil.getInstance().post(url,map,observer,clazz);
    }
    //计划-记录列表
    public Disposable planCommentList(String url, Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        //HttpUrl.api_task_comment_list
        return HttpUtil.getInstance().post(url,map,observer,clazz);
    }

    //动作记录列表
    public Disposable actionCommentList(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_action_comment_list,map,observer,clazz);
    }

    //动态列表
    public Disposable dynamicCommentList(String url,Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(url,map,observer,clazz);
    }

    //发布动态
    public Disposable publishDynamicComment(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_add_dynamic,map,observer,clazz);
    }

    //获取最新动态评论消息数
    public Disposable dynamicCommentCount(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_dynamic_comment_count,map,observer,clazz);
    }

    //获取动态消息列表
    public Disposable dynamicCommentMessage(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_dynamic_notice_list,map,observer,clazz);
    }

    public Disposable dynamicMessageClear(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_dynamic_notice_empty,map,observer,clazz);
    }
}
