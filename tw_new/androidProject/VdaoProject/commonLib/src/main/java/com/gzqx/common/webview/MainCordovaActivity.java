package com.gzqx.common.webview;

import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

import com.gzqx.com.gzqx.org.common.R;
import com.gzqx.common.utils.IntentParams;

import org.apache.cordova.Config;

//打开新的页面

public class MainCordovaActivity extends CordovaWebActivity {

    public View headerLeftBack;//模拟回退一步
    public View headerLeftTvClose;//关闭页面
    private String url_path = "http://m.dapu.com/mgallery-promotion-298.html";
    private String white="http://www.wangyi120.com/";
    //String test_path = "file:///android_asset/test_test.html";
    ////"http://new.7dugo.com/index";
    String test_path ="http://new.7dugo.com/index";

    //String test_path;
    private String loadUrl;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        super.initViewsAndEvents(savedInstanceState);
        //默认起始页面是读取config.xml里面配置
        String startUrl = Config.getStartUrl();
        loadUrl=getIntent().getStringExtra(IntentParams.KEY_LOAD_URL);
        if(loadUrl==null){
            loadUrl=startUrl;
        }

        headerCenterTv = (TextView) findViewById(R.id.header_text);
        headerLeftBack=findViewById(R.id.header_left_btn_img);
        headerLeftBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                mookKeyBack();
            }
        });
        setupWebView(startUrl,null);
        //AppUtils.share(getActivity(),"");
    }
    @Override
    protected int getContentViewID() {
        return R.layout.activity_cordovaview;
    }
}
