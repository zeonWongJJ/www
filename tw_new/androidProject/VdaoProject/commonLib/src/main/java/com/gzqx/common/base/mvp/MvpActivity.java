package com.gzqx.common.base.mvp;

import android.os.Bundle;

import com.gzqx.common.base.AbsBaseActivity;
import com.gzqx.common.bean.CommonEventEntity;
import com.luck.picture.lib.rxbus2.RxBus;
import com.luck.picture.lib.rxbus2.Subscribe;
import com.luck.picture.lib.rxbus2.ThreadMode;


public abstract class MvpActivity extends AbsBaseActivity {


    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        if (!RxBus.getDefault().isRegistered(this)) {
            RxBus.getDefault().register(this);
        }
    }

    @Subscribe(threadMode = ThreadMode.CURRENT_THREAD)//如果是子线程记得切换ui线程更新ui
    public abstract void eventBus(CommonEventEntity obj);

    @Override
    protected void onDestroy() {
        super.onDestroy();
        if (RxBus.getDefault().isRegistered(this)) {
            RxBus.getDefault().unregister(this);
        }
    }
}
