package com.app.base.netUtil;

import com.app.base.bean.StructureBean;
import com.app.base.bean.Task;
import com.app.base.utils.HttpUrl;

import java.util.List;
import java.util.Map;

import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 结构
 */

public class StructureHttpUtil {
    private static StructureHttpUtil util;
    public static StructureHttpUtil getInstance(){
        if(util==null){
            util=new StructureHttpUtil();
        }
        return util;
    }


    //获取父节点下的所有子节点
    public Disposable structureAllNode(Map<String, String> map, DisposableObserver<List<StructureBean>> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_structure_all_node,map,observer,clazz);
    }

    //获取父节点的下一级节点
    public Disposable structureNextNode(Map<String, String> map, DisposableObserver<List<StructureBean>> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_structure_children_node,map,observer,clazz);
    }

    //为父节点的下一级节点
    public Disposable structureAddChildrenNode(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_structure_insert,map,observer,clazz);
    }

    //删除单个节点
    public Disposable deleteSubNode(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_structure_delete,map,observer,clazz);
    }


    //查看节点相关的任务
    public Disposable taskListSubNode(Map<String, String> map, DisposableObserver<List<Task>> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_structure_tasks,map,observer,clazz);
    }


    public Disposable editSubNode(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_structure_update,map,observer,clazz);
    }
}
