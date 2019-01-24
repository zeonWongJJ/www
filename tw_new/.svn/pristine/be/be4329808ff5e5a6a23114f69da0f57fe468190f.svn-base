package app.odp.qidu.fragment;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.common.lib.base.AbsBaseFragment;

import app.odp.qidu.R;

/**
 * Created by 7du-28 on 2018/5/25.
 */

public class TestFragment extends AbsBaseFragment{
    private String param;
    public static TestFragment getInstance(String param) {
        TestFragment sf = new TestFragment();
        sf.param = param;
        return sf;
    }
    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.activity_test,container,false);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
    }
}
