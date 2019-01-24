package com.gzqx.common;

import android.app.Activity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.TextView;

import com.gzqx.com.gzqx.org.common.R;
import com.gzqx.common.sysutil.AppUtils;
import com.gzqx.common.webview.CordovaWebActivity;

import org.apache.cordova.Config;

public class TestActivity extends CordovaWebActivity {

    public View headerLeftBack;//模拟回退一步
    public View headerLeftTvClose;//关闭页面
    private String url_path = "http://m.dapu.com/mgallery-promotion-298.html";
    private String white="http://www.wangyi120.com/";
    //String test_path = "file:///android_asset/test_test.html";
    ////"http://new.7dugo.com/index";
    //String test_path ="http://new.7dugo.com/index";
    String test_path = "file:///android_asset/test_test.html";
    //String test_path;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        super.initViewsAndEvents(savedInstanceState);
        //默认起始页面是读取config.xml里面配置
        String startUrl = Config.getStartUrl();
        if(test_path!=null){
            startUrl=test_path;
        }
        headerCenterTv = (TextView) findViewById(R.id.header_text);
        headerLeftBack=findViewById(R.id.header_left_btn_img);
        headerLeftBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                mookKeyBack();
            }
        });
        appView.loadUrl(startUrl);
        //AppUtils.share(getActivity(),"");
    }
    @Override
    protected int getContentViewID() {
        return R.layout.activity_cordovaview;
    }
}
