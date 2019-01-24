package com.printer.receipt;

import android.os.Bundle;
import android.os.Handler;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;

import cashier.vdao.app.R;

/**
 * Created by 7du-28 on 2017/12/12.
 */

public class TestActivity extends BaseActivity{
    private WebView webView;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_send_screen);
        webView= (WebView) this.findViewById(R.id.web_view);
        WebSettings webSettings = webView.getSettings();
        webSettings.setJavaScriptEnabled(true);
        webSettings.setJavaScriptCanOpenWindowsAutomatically(true);
        webSettings.setAllowFileAccess(true);// 设置允许访问文件数据
        webSettings.setSupportZoom(true);
        webSettings.setBuiltInZoomControls(true);
        webSettings.setJavaScriptCanOpenWindowsAutomatically(true);
        webSettings.setCacheMode(WebSettings.LOAD_CACHE_ELSE_NETWORK);
        webSettings.setDomStorageEnabled(true);
        webSettings.setDatabaseEnabled(true);
        webView.setWebViewClient(new WebViewClient(){
            @Override
            public boolean shouldOverrideUrlLoading(WebView view, String url) {
                view.loadUrl(url);
                return true;
            }

            @Override
            public void onPageFinished(WebView view, String url) {
                super.onPageFinished(view, url);
                new Handler().post(new Runnable() {

                    public void run() {
                        webView.loadUrl("javascript:onAlert()");
                    }

                });
            }
        });
        webView.setWebChromeClient(new WebChromeClient(){
            /*@Override
				public boolean onJsAlert(WebView view, String url, String message, JsResult result) {
					Toast.makeText(getOwnerActivity(), message, Toast.LENGTH_SHORT).show();
					new AlertDialog.Builder(getOwnerActivity())
							.setTitle("标题")
							.setMessage("内容")
							.setNegativeButton("取消", new DialogInterface.OnClickListener() {
								@Override
								public void onClick(DialogInterface dialog, int which) {
								}
							})
							.setPositiveButton("确定", new DialogInterface.OnClickListener() {
								@Override
								public void onClick(DialogInterface dialog, int which) {
								}
							})
							.create().show();
					return super.onJsAlert(view, url, message, result);
				}*/
        });
        webView.loadUrl("file:///android_asset/test_alert.html");


    }
}
