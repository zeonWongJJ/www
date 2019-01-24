package com.gzqx.common.base.mvp;


import android.os.Bundle;
import android.view.View;

import com.gzqx.common.base.AbsBaseFragment;
import com.gzqx.common.bean.CommonEventEntity;
import com.luck.picture.lib.rxbus2.RxBus;
import com.luck.picture.lib.rxbus2.Subscribe;
import com.luck.picture.lib.rxbus2.ThreadMode;


/**
 */
public abstract class MvpFragment extends AbsBaseFragment {

    @Override
    protected void initViews(View rootView, Bundle savedInstanceState) {
        if (!RxBus.getDefault().isRegistered(this)) {
            RxBus.getDefault().register(this);
        }
    }

    @Subscribe(threadMode = ThreadMode.CURRENT_THREAD)//如果是子线程记得切换ui线程更新ui
    public abstract void eventBus(CommonEventEntity obj);
    @Override
    public void onDestroyView() {
        super.onDestroyView();
        if (RxBus.getDefault().isRegistered(this)) {
            RxBus.getDefault().unregister(this);
        }
    }
}
