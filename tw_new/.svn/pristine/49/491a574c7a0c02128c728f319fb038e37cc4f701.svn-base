package app.vdao.qidu.home;

import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import com.gzqx.common.utils.PayUtil;
import com.luck.picture.lib.rxbus2.Subscribe;
import com.luck.picture.lib.rxbus2.ThreadMode;
import com.qidu.chat.activity.LoginActivity;
import com.qidu.chat.fragment.sidebar.UserRocketChatFragment;

import app.vdao.qidu.R;

import bean.DefaultEventEntity;
import common.Constants;

/**
 * 我的
 */

public class MineFragment extends UserRocketChatFragment {

    protected TextView test;

    /*@TargetApi(19)
    private void setTranslucentStatus(boolean on) {
        Window win = getActivity().getWindow();
        WindowManager.LayoutParams winParams = win.getAttributes();
        final int bits = WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS;
        if (on) {
            winParams.flags |= bits;
        } else {
            winParams.flags &= ~bits;
        }
        win.setAttributes(winParams);
    }*/

    @Subscribe(threadMode = ThreadMode.MAIN)//如果是子线程记得切换ui线程更新ui
    public void eventBus(DefaultEventEntity obj) {
        if(obj.what==Constants.IM_LOGIN_OUT){
            //reFreshUI();
            dismissProgressDialog();
            /*Intent intent = new Intent(getActivity(), MainActivity.class);
            intent.putExtra(MainActivity.EXTRA_FINISH_ON_BACK_PRESS, true);
            intent.setFlags(Intent.FLAG_ACTIVITY_REORDER_TO_FRONT | Intent.FLAG_ACTIVITY_CLEAR_TOP);
            getActivity().startActivity(intent);*/
            rootView.findViewById(R.id.user_info_container).setVisibility(View.GONE);
            //closeUserActionContainer();
        }

    }
    @Override
    public void onCreate(@Nullable Bundle savedInstanceState) {
        hostname = getArguments().getString(HOSTNAME);
        super.onCreate(savedInstanceState);
    }

    @Override
    protected void onSetupView() {
        super.onSetupView();
        test=rootView.findViewById(R.id.test);
        test.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                PayUtil payUtil=new PayUtil(getActivity());
                payUtil.startPrepayTask();
            }
        });
        View btnLogin=rootView.findViewById(R.id.login);
        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(getActivity(), LoginActivity.class);
                intent.putExtra(LoginActivity.KEY_HOSTNAME, hostname);
                getActivity().startActivity(intent);
            }
        });
    }



    protected void loginOut() {
        Toast.makeText(getActivity(),"退出登录",Toast.LENGTH_SHORT).show();
        //LaunchUtil.showLoginActivity(getActivity(),hostname);
        Intent intent = new Intent(getActivity(), LoginActivity.class);
        intent.putExtra(LoginActivity.KEY_HOSTNAME, hostname);
        //intent.setFlags(Intent.FLAG_ACTIVITY_REORDER_TO_FRONT | Intent.FLAG_ACTIVITY_CLEAR_TOP);
        /*intent.setFlags(Intent.FLAG_ACTIVITY_REORDER_TO_FRONT | Intent.FLAG_ACTIVITY_CLEAR_TOP);
        intent.putExtra(LoginActivity.KEY_HOSTNAME, hostname);*/
        getActivity().startActivity(intent);


    }
}