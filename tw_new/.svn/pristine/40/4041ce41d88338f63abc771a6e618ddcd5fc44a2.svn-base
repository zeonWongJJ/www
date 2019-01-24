package app.odp.qidu.activity;

import android.os.Bundle;
import android.support.annotation.NonNull;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.TextView;

import com.app.base.bean.Store;
import com.app.base.bean.UserRealm;
import com.common.lib.basemvp.base.BaseActivity;
import com.common.lib.widget.CodeButton;


import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.mvp.contract.LoginContract;
import app.odp.qidu.mvp.presenter.LoginPresenterImpl;

//注册
public class RegisterActivity extends BaseActivity<LoginPresenterImpl> implements LoginContract.View {
    private CodeButton code_bth;


    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        UserRealm.queryAllUserRealm((items, hasMore) -> {
            Log.i("aaaaa","查询消息"+items.size());
        });



    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        View inflate = inflater.inflate(R.layout.activity_register, null);
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
    protected void onDestroy() {
        super.onDestroy();
    }

    @Override
    public void loginSuccess() {

    }

    @Override
    public void onError() {

    }

    /*private void test(){
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
    }*/
}
