package com.printer.receipt.webview;

import android.os.Bundle;
import android.view.View;

import com.printer.receipt.utils.HttpUrl;
import com.printer.receipt.utils.IntentParams;

import org.apache.cordova.Config;

//打开新的页面

public abstract class MainCordovaActivity extends CordovaWebActivity {

    public View headerLeftBack;//模拟回退一步
    public View headerLeftTvClose;//关闭页面
    private String url_path = "http://m.dapu.com/mgallery-promotion-298.html";
    private String white="http://www.wangyi120.com/";
    //String test_path = "file:///android_asset/test_test.html";
    ////"http://new.7dugo.com/index";
    String test_path = "file:///android_asset/test_test.html";

    //String test_path;
    private String loadUrl;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }

    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        super.initViewsAndEvents(savedInstanceState);
        //默认起始页面是读取config.xml里面配置
        String startUrl = Config.getStartUrl();
        loadUrl=getIntent().getStringExtra(IntentParams.KEY_LOAD_URL);
        loadUrl= HttpUrl.homeUrl;
        //loadUrl="file:///android_asset/test_test.html";
        if(loadUrl==null){
            loadUrl=startUrl;
        }

        /*headerCenterTv = (TextView) findViewById(R.id.header_text);
        headerLeftBack=findViewById(R.id.header_left_btn_img);
        headerLeftBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                mookKeyBack();
            }
        });*/
        //setupWebView(startUrl,null);
        appView.loadUrl(loadUrl);
        //AppUtils.share(getActivity(),"");


        /*SoftKeyBoardListener.setListener(this, new SoftKeyBoardListener.OnSoftKeyBoardChangeListener() {
            @Override
            public void keyBoardShow(int height) {
                //Toast.makeText(AdjustResizeActivity.this, "键盘显示 高度" + height, Toast.LENGTH_SHORT).show();
            }
            @Override
            public void keyBoardHide(int height) {
                //Toast.makeText(getActivity(), "键盘隐藏 高度" + height, Toast.LENGTH_SHORT).show();
                *//*if(appView!=null){
                    appView.scrollTo(0,0);
                }*//*

            }
        });*/
    }

}
