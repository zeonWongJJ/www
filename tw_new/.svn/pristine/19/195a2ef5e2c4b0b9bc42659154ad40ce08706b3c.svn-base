package com.app.base.netUtil;


import com.app.base.bean.AbsenceBean;
import com.app.base.bean.BaseListBean;
import com.app.base.bean.Evaluate;
import com.app.base.bean.WorkBean;
import com.app.base.utils.HttpUrl;

import java.util.List;
import java.util.Map;

import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

public class AchievementHttpUtil {
    private static AchievementHttpUtil util;
    public static AchievementHttpUtil getInstance(){
        if(util==null){
            util=new AchievementHttpUtil();
        }
        return util;
    }

    //获取考勤列表
    public Disposable workTimeList(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_work_time_list,map,observer,clazz);
    }

    //绩效统计接口
    public Disposable workStaticsList(Map<String, String> map, DisposableObserver<WorkBean> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_work_statics,map,observer,clazz);
    }

    //获取请假列表
    public Disposable absenceList(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_absence_records,map,observer,clazz);
    }

    //撤销请假
    public Disposable absenceDelete(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_absence_delete,map,observer,clazz);
    }


    //添加请假信息接口
    public Disposable createLeave(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_absence_insert,map,observer,clazz);
    }

    //获取审批列表HttpUrl.api_approval_list 待办审批 HttpUrl.api_todo_approval_list
    public Disposable approvalList(String url,Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(url,map,observer,clazz);
    }
    //待办审批
    /*public Disposable todoApprovalList(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_todo_approval_list,map,observer,clazz);
    }*/

    //审批-驳回-同意
    public Disposable updateAbsence(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_absence_update,map,observer,clazz);
    }
    //获取请假详情
    public Disposable absenceDetails(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_absence_detail,map,observer,clazz);
    }
    public Disposable approvalDetails(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_approval_detail,map,observer,clazz);
    }
    //审批-驳回-同意
    public Disposable updateApproval(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_approval_update,map,observer,clazz);
    }



}
