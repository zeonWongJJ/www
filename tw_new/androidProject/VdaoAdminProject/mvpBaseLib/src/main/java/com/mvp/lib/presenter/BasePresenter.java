package com.mvp.lib.presenter;

import android.content.Intent;
import android.os.Bundle;

import com.mvp.lib.view.IBaseView;

import io.reactivex.disposables.CompositeDisposable;


/**
 * @author jlanglang  2016/11/11 15:10
 * @版本 2.0
 * @Change
 */
public abstract class BasePresenter<T extends IBaseView> {

    protected T mView;
    /**
     * 使用CompositeSubscription来持有所有的Subscriptions
     */
    protected CompositeDisposable mCompositeSubscription;

    /**
     * 绑定View
     */
    public void onAttch(T view) {
        //创建管理rx请求生命周期
        this.mView = view;
        mCompositeSubscription = new CompositeDisposable();
    }


    /**
     * 做初始化的操作,需要在view的视图初始化完成之后才能调用
     * 建议只初始化一些对象,而不要去做耗时操作.
     */
    public abstract void onCreate();

    /**
     * 运行在onCreate()之后,可能在onStart()之后调用.
     * 建议加载数据,处理数据刷新页面的操作放在这里
     */
    public abstract void loadData();

    /**
     * 在这里结束异步操作
     */
    public void onDestroy() {
        if (mCompositeSubscription != null) {
            mCompositeSubscription.clear();
        }
    }

    /**
     * 解除绑定
     */
    public void onDetach() {
        mView = null;
    }

    public CompositeDisposable getCompositeSubscription() {
        return mCompositeSubscription;
    }

    public void onActivityResult(int requestCode, int resultCode, Intent data) {

    }

    public void onSaveInstanceState(Bundle outState) {

    }

    public void onStart() {

    }

    public void onResume() {

    }

    public void onRestart() {

    }

    public void onPause() {

    }

    public void onStop() {

    }
}
