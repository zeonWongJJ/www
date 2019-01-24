package com.app.base.mvp.presenter;

import com.app.base.mvp.contract.PublishCommentContract;
import com.app.base.netUtil.PublishCommentHttpUtil;
import com.common.lib.basemvp.presenter.BasePresenter;

import java.util.HashMap;

import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * Created by 7du-28 on 2018/5/21.
 */

public class PublishCommentPresenterImpl extends BasePresenter<PublishCommentContract.View> implements PublishCommentContract.Presenter{


    @Override
    public void onCreate() {

    }

    @Override
    public void loadData() {

    }
    //发布任务评论
    @Override
    public void publishTaskCommentRecord(HashMap<String, String> hashMap) {
        Disposable disposable= PublishCommentHttpUtil.getInstance().publishTaskCommentRecord(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String s) {
                mView.publishCommentSuccess(s);
            }
            @Override
            public void onError(Throwable e) {
                mView.publishCommentFailure(e.getMessage());
            }
            @Override
            public void onComplete() {

            }
        },String.class);
        mCompositeSubscription.add(disposable);
    }
    //发布计划评论
    @Override
    public void publishPlanCommentRecord(HashMap<String, String> hashMap) {
        Disposable disposable= PublishCommentHttpUtil.getInstance().publishPlanCommentRecord(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String s) {
                mView.publishCommentSuccess(s);
            }

            @Override
            public void onError(Throwable e) {
                mView.publishCommentFailure(e.getMessage());
            }

            @Override
            public void onComplete() {

            }
        },String.class);
        mCompositeSubscription.add(disposable);
    }

    @Override
    public void publishActionCommentRecord(HashMap<String, String> hashMap) {
        Disposable disposable= PublishCommentHttpUtil.getInstance().publishActionCommentRecord(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String s) {
                mView.publishCommentSuccess(s);
            }

            @Override
            public void onError(Throwable e) {
                mView.publishCommentFailure(e.getMessage());
            }

            @Override
            public void onComplete() {

            }
        },String.class);
        mCompositeSubscription.add(disposable);
    }
}
