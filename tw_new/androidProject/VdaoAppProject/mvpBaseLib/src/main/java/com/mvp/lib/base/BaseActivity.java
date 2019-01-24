package com.mvp.lib.base;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.os.Looper;
import android.os.MessageQueue;
import android.support.annotation.IdRes;
import android.support.annotation.LayoutRes;
import android.support.annotation.NonNull;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentActivity;
import android.support.v4.app.FragmentTransaction;
import android.util.SparseArray;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.common.lib.base.AbsBaseActivity;
import com.mvp.lib.presenter.BasePresenter;
import com.mvp.lib.view.IBaseActivityView;


/**
 * activity的基类
 *
 * @param <T>
 */
public abstract class BaseActivity<T extends BasePresenter> extends AbsBaseActivity
        implements IBaseActivityView {
    protected T mPresenter;
    private SparseArray<View> mViews;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        mViews = new SparseArray<>();
        //创建presenter
        mPresenter = initPresenter();
        //绑定Activity
        mPresenter.onAttch(this);
        //创建ContentView
        View view = initView(LayoutInflater.from(this), savedInstanceState);
        super.setContentView(view);
        //初始化presenter
        mPresenter.onCreate();
        initViewsAndEvents(savedInstanceState);
        //延时加载数据.
        Looper.myQueue().addIdleHandler(new MessageQueue.IdleHandler() {
            @Override
            public boolean queueIdle() {
                mPresenter.loadData();
                return false;
            }
        });
    }

    protected abstract void initViewsAndEvents(Bundle savedInstanceState);

    @Override
    protected void onStart() {
        mPresenter.onStart();
        super.onStart();
    }

    @Override
    protected void onPause() {
        mPresenter.onPause();
        super.onPause();
    }

    @Override
    protected void onRestart() {
        mPresenter.onRestart();
        super.onRestart();
    }

    @Override
    protected void onStop() {
        mPresenter.onStop();
        super.onStop();
    }

    @Override
    protected void onResume() {
        mPresenter.onResume();
        super.onResume();
    }

    @Override
    protected void onDestroy() {
        if (mPresenter != null) {
            mPresenter.onDestroy();
        }
        super.onDestroy();
    }

    @Override
    public void onDetachedFromWindow() {
        mPresenter.onDetach();
        super.onDetachedFromWindow();
    }

    @Override
    protected void onSaveInstanceState(Bundle outState) {
        mPresenter.onSaveInstanceState(outState);
        super.onSaveInstanceState(outState);
    }

    /**
     * '
     * 跳转fragment
     *
     * @param tofragment
     */
    @Override
    public void startFragment(Fragment tofragment) {
        startFragment(tofragment, null);
    }

    /**
     * @param tofragment 跳转的fragment
     * @param tag        fragment的标签
     */
    @Override
    public void startFragment(Fragment tofragment, String tag) {
        FragmentTransaction fragmentTransaction = getSupportFragmentManager().beginTransaction();
        fragmentTransaction.add(android.R.id.content, tofragment, tag);
        fragmentTransaction.addToBackStack(tag);
        fragmentTransaction.commitAllowingStateLoss();
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        mPresenter.onActivityResult(requestCode,resultCode,data);
    }

    /**
     * onBackPressed();
     */
    @Override
    public void onBack() {
        onBackPressed();
    }

    @Override
    public BaseActivity getActivity() {
        return this;
    }

    @Override
    public Context getContext() {
        return this;
    }

    /**
     * 通过viewId获取控件
     *
     * @param viewId 资源id
     * @return
     */
    @Override
    public <V extends View> V findView(@IdRes int viewId) {
        View view = mViews.get(viewId);
        if (view == null) {
            view = super.findViewById(viewId);
            mViews.put(viewId, view);
        }
        return (V) view;
    }

    @Override
    public View findViewById(@IdRes int id) {
        return findView(id);
    }

    @Override
    public void isNightMode(boolean isNight) {

    }


    /**
     * 初始化ContentView
     * 建议不要包含toolbar
     *
     * @param inflater
     * @param savedInstanceState
     * @return
     */
    @NonNull
    protected abstract View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState);

    /**
     * 子类实现Presenter,且必须继承BasePrensenter
     *
     * @return
     */
    protected abstract T initPresenter();

}
