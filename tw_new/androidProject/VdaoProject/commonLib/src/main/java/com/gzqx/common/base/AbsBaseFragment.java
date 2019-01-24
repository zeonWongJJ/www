package com.gzqx.common.base;

import android.app.Activity;
import android.content.Context;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import butterknife.ButterKnife;
import butterknife.Unbinder;


/**
 * Created by Anthony on 2016/2/25.
 * Class Note:
 * <p/>
 * Base Fragment for all the Fragment defined in the project
 * 1 extended from {@link AbsBaseFragment} to do
 * some base operation.
 * 2 do operation in {@link #initViews(View, Bundle)}
 */
public abstract class AbsBaseFragment extends Fragment {
    /**
     * Log tag
     */
    protected static String TAG_LOG = null;
    /**
     * activity context of fragment
     */
    protected Context mContext;
    protected Activity mActivity;
    private Unbinder mUnBinder;



    @Override
    public void onAttach(Context context) {
        //set a context from current activity
        mActivity = (Activity) context;
        mContext = context;
        super.onAttach(context);
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        //set Timber as log com.gzqx.org.util
        TAG_LOG = this.getClass().getSimpleName();
        if (getArguments() != null) {
            /*mUrl = getArguments().getString(EXTRA_URL);
            mTitle = getArguments().getString(EXTRA_TITLE);*/
        }
    }


    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        if (getLayoutView() != null) {
            return getLayoutView();
        }
        if (getLayoutId() != 0) {
            return inflater.inflate(getLayoutId(), container,false);
        } else {
            return super.onCreateView(inflater, container, savedInstanceState);
        }
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        //设置状态栏透明
//        setStatusBarColor();
        super.onViewCreated(view, savedInstanceState);
        //bind The View returned by {@link #onCreateView(LayoutInflater, ViewGroup, Bundle)}.
        mUnBinder = ButterKnife.bind(this, view);
        //init views events here so we can use ButterKnife
        initViews(view, savedInstanceState);

    }

    @Override
    public void onDestroy() {
        super.onDestroy();
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        //ButterKnife unbind
        if (mUnBinder != null) {
            mUnBinder.unbind();
            mUnBinder = null;
        }
    }

    /**
     * Every fragment has to inflate a layout in the onCreateView method.
     * We have added this method to avoid duplicate all the inflate code in every fragment.
     * You only have to return the layout to inflate in this method when extends AbsBaseFragment.
     */
    protected abstract int getLayoutId();

    public View getLayoutView() {
        return null;
    }

    protected abstract void initViews(View rootView, Bundle savedInstanceState);

}

