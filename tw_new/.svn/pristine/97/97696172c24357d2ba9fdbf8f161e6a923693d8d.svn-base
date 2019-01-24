package app.odp.qidu.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.design.widget.Snackbar;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.helper.ItemTouchHelper;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;

import com.app.base.bean.Store;
import com.app.base.bean.UserRealm;
import com.app.base.utils.RealmUtils;
import com.common.lib.basemvp.base.BaseActivity;
import com.common.lib.utils.RegexUtils;
import com.common.lib.utils.StatusBarUtil;
import com.common.lib.utils.ToastUtils;
import com.luck.picture.lib.immersive.LightStatusBarUtils;
import com.common.lib.basemvp.presenter.BasePresenter;

import app.odp.qidu.MainActivity;
import app.odp.qidu.R;
import app.odp.qidu.mvp.contract.LoginContract;
import app.odp.qidu.mvp.presenter.LoginPresenterImpl;

//登录
public class LoginActivity extends BaseActivity<LoginPresenterImpl> implements LoginContract.View {
    private EditText mobile_num,password;
    private View btn_login,wechat_login;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        //mPresenter.login();

        /*UserRealm userRealm=new UserRealm();
        userRealm.setId(3);
        userRealm.setName("丢你阿星d==========");
        UserRealm.insertUserRealm(this,userRealm);*/
        //UserRealm.updateUserRealm(this,userRealm);

        /*UserRealm.queryAllUserRealm((items, hasMore) -> {
            Log.i("aaaaa","查询消息"+items.size());
        });*/
    }

    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        StatusBarUtil.setStatusBarColor(getActivity(),R.color.white);
        LightStatusBarUtils.setLightStatusBar(getActivity(),true);
        mobile_num=findView(R.id.mobile_num);
        btn_login=findView(R.id.btn_login);
        password=findView(R.id.password);
        wechat_login=findView(R.id.wechat_login);
        TextView register=findView(R.id.register);
        register.setOnClickListener(v -> {
            Intent intent=new Intent(getActivity(),RegisterActivity.class);
            startActivity(intent);
        });
        btn_login.setOnClickListener(v -> {
            if(checkParams()){
                showProgressDialog("正在登录...");
                mPresenter.login(mobile_num.getText().toString().trim(),password.getText().toString());
            }

        });

    }

    private boolean checkParams(){
        String mobile=mobile_num.getText().toString().trim();
        String passwordStr=password.getText().toString();
        if(TextUtils.isEmpty(mobile)){
            ToastUtils.show("账号不能为空");
            return false;
        }
        /*if(!RegexUtils.isMobileExact(mobile)){
            ToastUtils.show("手机号码格式错误");
            return false;
        }*/
        if(TextUtils.isEmpty(passwordStr)){
            ToastUtils.show("密码不能为空");
            return false;
        }

        return true;
    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        View inflate = inflater.inflate(R.layout.activity_login, null);
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
        dismissProgressDialog();
        Intent intent=new Intent(this,MainActivity.class);
        intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK|Intent.FLAG_ACTIVITY_CLEAR_TOP);
        startActivity(intent);
        finish();
    }

    @Override
    public void onError() {
        dismissProgressDialog();
        Snackbar.make(btn_login, "登录失败", Snackbar.LENGTH_LONG)
                .setAction("提示", null).show();
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
