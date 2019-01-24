package com.app.base.netUtil;

import com.app.base.bean.Project;
import com.app.base.utils.HttpUrl;
import com.rx2androidnetworking.Rx2AndroidNetworking;

import java.util.List;
import java.util.Map;

import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;
import io.reactivex.schedulers.Schedulers;

/**
 * 项目相关
 */

public class ProjectHttpUtil {

    private static ProjectHttpUtil util;
    public static ProjectHttpUtil getInstance(){
        if(util==null){
            util=new ProjectHttpUtil();
        }
        return util;
    }

    //获取项目列表
    public Disposable projectList(Map<String, String> map, DisposableObserver<String> observer,Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_projects_list,map,observer,clazz);
    }
}
