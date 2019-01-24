package com.app.base.netUtil;

import com.app.base.bean.Task;
import com.app.base.rxandroid.LoadingTransformer;
import com.app.base.utils.HttpUrl;
import com.rx2androidnetworking.Rx2AndroidNetworking;

import java.util.List;
import java.util.Map;

import io.reactivex.Observable;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;
import io.reactivex.schedulers.Schedulers;

/**
 * 任务相关
 */

public class TaskHttpUtil {

    private static TaskHttpUtil util;
    public static TaskHttpUtil getInstance(){
        if(util==null){
            util=new TaskHttpUtil();
        }
        return util;
    }

    //获取任务列表
    public Disposable taskList(Map<String, String> map, DisposableObserver<List<Task>> observer){
        Observable<List<Task>> observable=HttpUtil.getInstance().postList(HttpUrl.api_task_list,map,Task.class);
        return observable.subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribeWith(observer);
    }


    //获取任务详情
    public Disposable taskDetails(Map<String, String> map, DisposableObserver<Task> observer,Class clazz){

        return HttpUtil.getInstance().post(HttpUrl.api_task_detail,map,observer,clazz);
    }

    //
    public Disposable handleTaskByActionUrl(String url,Map<String, String> map, DisposableObserver<String> observer,Class clazz){
        return HttpUtil.getInstance().post(url,map,observer,clazz);
    }
    /*//任务领取流程
    public Disposable taskReceive(Map<String, String> map, DisposableObserver<String> observer,Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_task_receive,map,observer,clazz);
    }

    //任务放弃
    public Disposable taskGiveUp(Map<String, String> map, DisposableObserver<String> observer,Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_task_giveup,map,observer,clazz);
    }

    //任务指派
    public Disposable taskAssign(Map<String, String> map, DisposableObserver<String> observer,Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_task_assign,map,observer,clazz);
    }
    //流程取消
    public Disposable taskUnwanted(Map<String, String> map, DisposableObserver<String> observer,Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_task_unwanted,map,observer,clazz);
    }
    //流程恢复
    public Disposable taskRecovery(Map<String, String> map, DisposableObserver<String> observer,Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_task_recovery,map,observer,clazz);
    }
    //任务进度
    public Disposable taskProgress(Map<String, String> map, DisposableObserver<String> observer,Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_task_progress,map,observer,clazz);
    }*/

    public Disposable addToMyPlan(Map<String, String> map, DisposableObserver<String> observer,Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_add_task_to_my_plan,map,observer,clazz);
    }


    public Disposable deleteTask(Map<String, String> map, DisposableObserver<String> observer,Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_task_delete,map,observer,clazz);
    }

    //流程评分
    public Disposable procedureScore(Map<String, String> map, DisposableObserver<String> observer,Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_task_procedure_score,map,observer,clazz);
    }
}
