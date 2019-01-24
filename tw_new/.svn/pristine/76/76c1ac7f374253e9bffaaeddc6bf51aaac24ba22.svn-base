package app.vdaoadmin.qidu.activity;

import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;

import com.app.base.bean.Admin;
import com.app.base.bean.AdminBean;
import com.common.lib.utils.ScreenUtils;
import com.common.lib.utils.ToastUtils;
import com.mvp.lib.base.BaseActivity;

import java.util.List;

import app.vdaoadmin.qidu.LauncherActivity;
import app.vdaoadmin.qidu.MainActivity;
import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.mvp.contract.LoginContract;
import app.vdaoadmin.qidu.mvp.presenter.LoginPresenterImpl;

/**
 * 登录
 */

public class LoginActivity extends BaseActivity<LoginPresenterImpl> implements LoginContract.View{
    private Button btnLogin;
    private EditText edt_account,edt_password;


    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
            setTranslucentStatus(true);
        }
        edt_account=findView(R.id.edt_account);
        edt_password=findView(R.id.edt_password);
        btnLogin=findView(R.id.btn_login);
        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String admin_name=edt_account.getText().toString();
                String admin_password=edt_password.getText().toString();
                if(TextUtils.isEmpty(admin_name)){
                    ToastUtils.show("请输入账号");
                    return;
                }
                if(TextUtils.isEmpty(admin_password)){
                    ToastUtils.show("请输入密码");
                    return;
                }
                showProgressDialog("正在登录...");
                mPresenter.login(admin_name,admin_password);
            }
        });
    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        View view=inflater.inflate(R.layout.activity_login,null);
        return view;
    }

    @Override
    protected LoginPresenterImpl initPresenter() {
        return new LoginPresenterImpl();
    }

    @Override
    public void loginSuccess(Admin adminBean) {
        dismissProgressDialog();
        Intent intent = new Intent(LoginActivity.this, MainActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_REORDER_TO_FRONT | Intent.FLAG_ACTIVITY_CLEAR_TOP);
        startActivity(intent);
        finish();
    }

    @Override
    public void loginFailure(Throwable e) {
        dismissProgressDialog();
        //Log.i("aaaaaaaaa",e.getMessage());
        ToastUtils.show("登录失败，请重试");
    }
}
