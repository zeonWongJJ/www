package app.odp.qidu.activity;

import android.os.Bundle;

import com.common.lib.base.AbsBaseActivity;
import com.common.lib.utils.StatusBarUtil;
import com.luck.picture.lib.immersive.LightStatusBarUtils;

import app.odp.qidu.R;

/**
 * Created by 7du-28 on 2018/6/9.
 */

public class NoticeHomeActivity extends AbsBaseActivity{

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        StatusBarUtil.setStatusBarColor(getActivity(),R.color.white);
        LightStatusBarUtils.setLightStatusBar(getActivity(),true);
        setContentView(R.layout.activity_notice_home);
    }
}
