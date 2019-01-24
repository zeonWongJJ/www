package com.printer.receipt.webview;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
import android.view.View;

import cashier.vdao.app.R;


/**
 * 副屏装载的fragment
 */

public class CustomScreenFragment extends CordovaWebFragment{
    private BroadcastReceiver broadcastReceiver=new BroadcastReceiver() {
        @Override
        public void onReceive(Context context, Intent intent) {
            /*String action=intent.getStringExtra("");
            if(action.equals(CommonKey.KEY_RESET_CURRENT_FRAGMENT)){

            }*/
            if(appView!=null){
                appView.reloadPage();
            }
        }
    };
    private String pathUrl;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        Bundle bundle = getArguments();
        pathUrl = bundle.getString("KEY_PATH");
        pathUrl="http://www.baidu.com";
    }
    // 标题栏对象
    public View headerLeftBack;//模拟回退一步
    public View headerLeftTvClose;//关闭页面
    String test_path = "file:///android_asset/test_test.html";

    @Override
    protected void initViews(View rootView, Bundle savedInstanceState) {
        super.initViews(rootView,savedInstanceState);
        IntentFilter filter= new IntentFilter("key_reset_current_fragment");
        getActivity().registerReceiver(broadcastReceiver,filter);
        //isVisible=true;

        /*headerLeftBack=view.findViewById(com.gzqx.com.gzqx.org.common.R.id.header_left_btn_img);
        headerLeftBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                mookKeyBack();
            }
        });*/
        setupWebView(pathUrl,null);
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        getActivity().unregisterReceiver(broadcastReceiver);
    }


    /*private boolean isVisible;
    @Override
    public void setUserVisibleHint(boolean isVisibleToUser) {
        super.setUserVisibleHint(isVisibleToUser);
        if(getUserVisibleHint()&&isVisible) {
            this.appView.reloadPage();
        }
    }*/


    @Override
    protected int getLayoutId() {
        return R.layout.layout_simple_cordovaview;
    }
}
