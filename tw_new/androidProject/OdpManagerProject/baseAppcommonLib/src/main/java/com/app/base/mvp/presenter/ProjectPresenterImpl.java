package com.app.base.mvp.presenter;

import android.text.TextUtils;

import com.app.base.bean.BaseResponse;
import com.app.base.bean.Project;
import com.app.base.mvp.contract.ProjectPresenterContract;
import com.app.base.netUtil.ProjectHttpUtil;
import com.app.base.utils.GsonUtil;
import com.common.lib.basemvp.presenter.BasePresenter;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * Created by 7du-28 on 2018/6/7.
 */

public class ProjectPresenterImpl extends BasePresenter<ProjectPresenterContract.View> implements ProjectPresenterContract.Presenter{


    @Override
    public void onCreate() {

    }

    @Override
    public void loadData() {
        HashMap<String,String> hashMap=new HashMap<>();
        Disposable disposable= ProjectHttpUtil.getInstance().projectList(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                List<Project> projectList=new ArrayList<>();
                if(!TextUtils.isEmpty(data)&&!data.equals("")){
                    projectList= GsonUtil.getObjectList(data,Project.class);
                }
                mView.projectList(projectList);
            }
            @Override
            public void onError(Throwable e) {
                mView.onError();
            }
            @Override
            public void onComplete() {

            }
        },String.class);
        mCompositeSubscription.add(disposable);
    }
}
