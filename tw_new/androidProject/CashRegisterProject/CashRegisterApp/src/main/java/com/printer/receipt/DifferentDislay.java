/*
package com.printer.demo;

import android.app.Presentation;
import android.content.Context;
import android.os.Bundle;
import android.view.Display;

import com.printer.demo.webview.MyCordovaWebView;

import cashier.vdao.app.R;

*/
/**
 * Created by 7du-28 on 2017/12/6.
 *//*


public class DifferentDislay extends Presentation {

    public DifferentDislay(Context outerContext, Display display) {
        super(outerContext,display);

    }
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_send_screen);
        MyCordovaWebView webView= (MyCordovaWebView)findViewById(R.id.appView);

        */
/*WebView webView=new WebView(getContext());
        LinearLayout.LayoutParams params=new LinearLayout.LayoutParams(ViewGroup.LayoutParams.MATCH_PARENT, ViewGroup.LayoutParams.MATCH_PARENT);
        addContentView(webView,params);*//*

		webView.loadUrl("https://www.baidu.com/");
			*/
/*Bundle args = new Bundle();
			args.putString("KEY_PATH", "https://www.baidu.com/");
			CustomScreenFragment fragment = new CustomScreenFragment();
			fragment.setArguments(args);
			getSupportFragmentManager().beginTransaction()
					.replace(R.id.fragment_layout_container,fragment)
					.commit();*//*

    }

    @Override
    protected void onStart() {
        super.onStart();
    }

    @Override
    protected void onStop() {
        super.onStop();
    }
}
*/
