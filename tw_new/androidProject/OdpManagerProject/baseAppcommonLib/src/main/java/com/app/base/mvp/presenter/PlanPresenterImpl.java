package com.app.base.mvp.presenter;

import android.text.TextUtils;
import com.app.base.bean.Participant;
import com.app.base.bean.PlanSubBean;
import com.app.base.bean.UserRealm;
import com.app.base.mvp.contract.PlanContract;
import com.app.base.netUtil.MemberHttpUtil;
import com.app.base.netUtil.PlanHttpUtil;
import com.app.base.netUtil.TaskHttpUtil;
import com.app.base.utils.DataUtils;
import com.app.base.utils.GsonUtil;
import com.common.lib.basemvp.presenter.BasePresenter;

import java.util.HashMap;
import java.util.List;

import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 计划
 */

public class PlanPresenterImpl extends BasePresenter<PlanContract.View> implements PlanContract.Presenter{

    @Override
    public void loadData(final int pageIndex) {

    }

    @Override
    public void publishPlan(boolean isEdit,HashMap<String, String> hashMap) {
        Disposable disposable= PlanHttpUtil.getInstance().publishPlan(isEdit,hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String response) {
                mView.publishPlanSuccess();
            }
            @Override
            public void onError(Throwable e) {
                mView.failure(e);
            }
            @Override
            public void onComplete() {

            }
        },String.class);
        mCompositeSubscription.add(disposable);
    }

    @Override
    public void planDetails(String planId) {
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("plan_id",planId);
        Disposable disposable= PlanHttpUtil.getInstance().planDetails(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                PlanSubBean planSubBean=null;
                if(!TextUtils.isEmpty(data)){
                    planSubBean= GsonUtil.getObject(data,PlanSubBean.class);
                }
                mView.planDetails(planSubBean);

            }
            @Override
            public void onError(Throwable e) {
                mView.failure(e);
            }
            @Override
            public void onComplete() {
            }
        },String.class);
        mCompositeSubscription.add(disposable);
    }

    @Override
    public void onCreate() {

    }

    @Override
    public void loadData() {

    }

    @Override
    public void departmentAndMembers(){
        UserRealm.queryAllUserRealm(new UserRealm.QueryDbCallBack<UserRealm>() {
            @Override
            public void querySuccess(List<UserRealm> items, boolean hasMore) {
                if(items.isEmpty()){
                    getDepartmentAndMember();
                }else {
                    List<Participant> participantList = DataUtils.getParticipantGroup(items);
                    mView.showParticipantListSuccess(participantList);
                }
            }
        });

    }

    private void getDepartmentAndMember(){
        HashMap<String, String> hashMap=new HashMap<>();
        Disposable disposable=MemberHttpUtil.getInstance().departmentAndMembers(hashMap, new DisposableObserver<List<Participant>>() {
            @Override
            public void onNext(List<Participant> list) {
                mView.showParticipantListSuccess(list);
            }
            @Override
            public void onError(Throwable e) {

            }

            @Override
            public void onComplete() {

            }
        });
        mCompositeSubscription.add(disposable);
    }

}
