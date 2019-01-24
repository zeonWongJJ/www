package com.app.base.mvp.presenter;

import com.app.base.bean.Participant;
import com.app.base.bean.Task;
import com.app.base.bean.UserRealm;
import com.app.base.mvp.contract.TaskContract;
import com.app.base.netUtil.HttpUtil;
import com.app.base.netUtil.MemberHttpUtil;
import com.app.base.netUtil.ProjectHttpUtil;
import com.app.base.netUtil.TaskHttpUtil;
import com.app.base.rxandroid.LoadingTransformer;
import com.app.base.utils.DataUtils;
import com.app.base.utils.HttpUrl;
import com.common.lib.basemvp.presenter.BasePresenter;

import java.util.HashMap;
import java.util.List;

import io.reactivex.Observable;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;
import io.reactivex.schedulers.Schedulers;

/**
 * Created by 7du-28 on 2018/5/21.
 */

public class TaskPresenterImpl extends BasePresenter<TaskContract.View> implements TaskContract.Presenter{

    @Override
    public void loadData(final int pageIndex) {

    }

    @Override
    public void publishTask(boolean isEdit,HashMap<String, String> hashMap) {
        String url;
        if(isEdit){
            url= HttpUrl.api_edit_task;
        }else {
            url=HttpUrl.api_publish_task;
        }
        Observable<String> observable= HttpUtil.getInstance().postObject(url,hashMap,String.class);
        Disposable disposable=observable.subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .compose(new LoadingTransformer<String>(mView)).subscribeWith(new DisposableObserver<String>() {
                    @Override
                    public void onNext(String response) {
                        mView.publishTaskSuccess();
                    }
                    @Override
                    public void onError(Throwable e) {
                        mView.failure();
                    }
                    @Override
                    public void onComplete() {

                    }
                });
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

    @Override
    public void getTaskDetails(HashMap<String, String> hashMap) {
        Disposable disposable=TaskHttpUtil.getInstance().taskDetails(hashMap, new DisposableObserver<Task>() {
            @Override
            public void onNext(Task task) {
                mView.getTaskDetails(task);
            }
            @Override
            public void onError(Throwable e) {

            }
            @Override
            public void onComplete() {

            }
        },Task.class);
        mCompositeSubscription.add(disposable);
    }



}
