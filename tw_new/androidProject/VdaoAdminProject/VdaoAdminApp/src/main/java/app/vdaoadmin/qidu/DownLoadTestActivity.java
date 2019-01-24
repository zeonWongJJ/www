package app.vdaoadmin.qidu;

import android.os.Bundle;
import android.support.annotation.NonNull;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Toast;

import app.vdaoadmin.qidu.mvp.contract.DownLoadContract;
import app.vdaoadmin.qidu.mvp.presenter.DownLoadPresenterImpl;
import com.mvp.lib.base.BaseActivity;

public class DownLoadTestActivity extends BaseActivity<DownLoadPresenterImpl> implements DownLoadContract.View {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        mPresenter.downloadFile("http://hengdawb-app.oss-cn-hangzhou.aliyuncs.com/app-debug.apk");
    }

    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {

    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        View inflate = inflater.inflate(R.layout.activity_test, null);
        return inflate;
    }


    @Override
    protected DownLoadPresenterImpl initPresenter() {
        return new DownLoadPresenterImpl();
    }

    @Override
    public void onResume() {
        super.onResume();
    }

    @Override
    public void downloadFileSuccess() {
        Toast.makeText(getActivity(),"下载成功", Toast.LENGTH_SHORT).show();
    }
}
