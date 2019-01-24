package app.vdao.qidu.mvp.login;

import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.gzqx.common.base.mvp.MvpActivity;
import com.gzqx.common.bean.CommonEventEntity;
import com.luck.picture.lib.rxbus2.RxBus;
import com.luck.picture.lib.rxbus2.Subscribe;
import com.luck.picture.lib.rxbus2.ThreadMode;

import app.vdao.qidu.R;

import app.vdao.qidu.bean.Address;

public class LoginActivity extends MvpActivity{

        private EditText userNameEdit;
        private EditText pwdEdit;

    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        super.initViewsAndEvents(savedInstanceState);
        userNameEdit = (EditText) findViewById(R.id.et_username);
        pwdEdit = (EditText) findViewById(R.id.et_password);
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
    }
    //EventBus 3.0 回调
    @Subscribe(threadMode = ThreadMode.CURRENT_THREAD)//如果是子线程记得切换ui线程更新ui
    public void eventBus(CommonEventEntity obj) {
        switch (obj.what) {
            case 111:
                final Address user= (Address) obj.obj;
                runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        Toast.makeText(LoginActivity.this,""+user.getAddress(),Toast.LENGTH_SHORT).show();
                    }
                });

                break;
        }
    }
    @Override
    protected int getContentViewID() {
        return R.layout.activity_login;
    }

        public void onUserLogin(View v){
            new Thread(){
                @Override
                public void run() {
                    Address user=new Address();
                    user.setAddress("fuck");
                    CommonEventEntity obj = new CommonEventEntity(111,user);
                    RxBus.getDefault().post(obj);

                }
            }.start();

            /*String userName = userNameEdit.getText().toString().trim();

            String password = pwdEdit.getText().toString().trim();
            showProgressDialog();
            mvpPresenter.login(userName, password);// 登录*/
        }

}
