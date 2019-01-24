package app.vdao.qidu;

import android.content.Intent;
import android.support.annotation.NonNull;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.TextView;

import app.vdao.qidu.mvp.contract.LoginContract;
import app.vdao.qidu.mvp.presenter.LoginPresenterImpl;

import com.app.base.bean.Store;
import com.mvp.lib.base.BaseActivity;
import com.net.rx_retrofit_network.location.model.BaseResponse;
import com.net.rx_retrofit_network.location.rxandroid.JsonParesTransformer;
import com.net.rx_retrofit_network.location.rxandroid.LoadingTransformer;
import com.net.rx_retrofit_network.location.rxandroid.SimpleObserver;

import java.util.List;

import io.reactivex.Observable;

public class MainActivity extends BaseActivity<LoginPresenterImpl> implements LoginContract.View {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        mPresenter.login();
    }

    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {

    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        View inflate = inflater.inflate(R.layout.activity_main, null);
        return inflate;
    }

    @Override
    protected LoginPresenterImpl initPresenter() {
        return new LoginPresenterImpl();
    }

    @Override
    public void onResume() {
        super.onResume();
    }

    @Override
    public void showViewData(List<Store> s) {
        TextView textView=findView(R.id.test);
        textView.setText(s.size()+"");
        textView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(getApplicationContext(),DownLoadTestActivity.class);
                startActivity(intent);
            }
        });
    }



    private void test(){
        BaseResponse<String> objectBaseResponse = new BaseResponse<>();
        objectBaseResponse.setData(new String());
        objectBaseResponse.setCode(100);
        Observable.just(objectBaseResponse)
                .compose(new JsonParesTransformer<>(BaseResponse.class))
                .subscribe(new SimpleObserver<BaseResponse>(mPresenter.getCompositeSubscription()) {
                    @Override
                    public void call(BaseResponse o) {

                    }
                });

        Observable.just(objectBaseResponse).compose(new LoadingTransformer<BaseResponse>(new LoadingTransformer.LoadingInterface() {
            @Override
            public void onLoading() {
                Log.i("aaaaa","onLoading");
            }

            @Override
            public void onSuccess() {
                Log.i("aaaaa","onSuccess");
            }

            @Override
            public void onError() {
                Log.i("aaaaa","onError");
            }

            @Override
            public void onEmpty() {
                Log.i("aaaaa","onEmpty");
            }
        })).subscribe();
    }
}
