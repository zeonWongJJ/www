package choose.lm.com.fileselector.base;

import android.app.Activity;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.FragmentActivity;

/**
 * Created by zk on 2017/6/1.
 * Description:
 */

public abstract class BaseFileActivity extends FragmentActivity {

    protected Activity aty;

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        aty = this;
        setContentView(getLayoutId());
        initView(savedInstanceState);
        initEvent();

    }

    protected abstract int getLayoutId();


    protected void initEvent() {

    }

    protected void initView(Bundle savedInstanceState) {

    }


}
