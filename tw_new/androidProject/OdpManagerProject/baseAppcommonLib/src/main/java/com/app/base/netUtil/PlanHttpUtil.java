package com.app.base.netUtil;

import com.app.base.bean.Plan;
import com.app.base.bean.PlanSubBean;
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
 * 计划相关
 */

public class PlanHttpUtil {

    private static PlanHttpUtil util;
    public static PlanHttpUtil getInstance(){
        if(util==null){
            util=new PlanHttpUtil();
        }
        return util;
    }

    //获取周计划列表
    public Disposable plansWeekList(Map<String, String> map, DisposableObserver<List<Plan>> observer){
        Observable<List<Plan>> observable=HttpUtil.getInstance().postList(HttpUrl.api_plans_week_list,map,Plan.class);
        return observable.subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribeWith(observer);
    }


    //获取子计划列表
    public Disposable plansSelectList(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_plans_select_list,map,observer,clazz);
    }

    //发布计划
    public Disposable publishPlan(boolean isEdit,Map<String, String> map, DisposableObserver<String> observer,Class clazz){
        String url;
        if(isEdit){
            url=HttpUrl.api_edit_plan;
        }else {
            url=HttpUrl.api_publish_plan;
        }
        return HttpUtil.getInstance().post(url,map,observer,clazz);
    }

    //获取计划详情
    public Disposable planDetails(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_plan_detail,map,observer,clazz);
    }


    //计划评分
    public Disposable planScore(Map<String, String> map, DisposableObserver<String> observer,Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_plan_score,map,observer,clazz);
    }
    //将计划标记为是否已经读了
    public Disposable changePlanReadStatus(Map<String, String> map, DisposableObserver<String> observer,Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_read_status,map,observer,clazz);
    }

    //把任务从子计划中移除
    public Disposable removeTaskFromPlan(Map<String, String> map, DisposableObserver<String> observer,Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_remove_task_from_plan,map,observer,clazz);
    }

    //移除子计划
    public Disposable deleteChildrenPlan(Map<String, String> map, DisposableObserver<String> observer,Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_delete_plan_children,map,observer,clazz);
    }
}
