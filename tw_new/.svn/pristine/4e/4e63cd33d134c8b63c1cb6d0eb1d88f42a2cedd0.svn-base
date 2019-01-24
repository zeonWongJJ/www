package choose.lm.com.fileselector.base;

import android.app.Activity;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

/**
 * Created by zk on 2017/6/1.
 * Description:
 */

public abstract class BaseFileFragment extends Fragment  {

    /**
     * Fragment根视图
     */
    protected View mFragmentRootView;
    protected Activity aty;


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        mFragmentRootView = inflaterView(inflater, container, savedInstanceState);
        aty = getActivity();
        return mFragmentRootView;
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        initView(savedInstanceState);
    }

    /**
     * 加载View
     *
     * @param inflater  LayoutInflater
     * @param container ViewGroup
     * @param bundle    Bundle
     * @return
     */
    protected View inflaterView(LayoutInflater inflater, ViewGroup container, Bundle bundle) {
        return inflater.inflate(getLayoutId(),container,false);
    }
    protected abstract int getLayoutId();


    protected void initView(Bundle savedInstanceState) {

    }




}
