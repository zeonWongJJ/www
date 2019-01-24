package com.qidu.chat.activity;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.widget.TextView;

import com.qidu.chat.R;
import com.qidu.chat.widget.XWebView;


/**
 * 打开网页的Activity
 */
public class WebActivity extends AppCompatActivity {

    TextView titleCenter;
    XWebView webview;

    public static final String TITLE = "title";
    public static final String URL = "url";

    private String title;
    private String url;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_web);

        title = getIntent().getStringExtra(TITLE);
        url = getIntent().getStringExtra(URL);
        titleCenter= (TextView) findViewById(R.id.title_center);
        webview= (XWebView) findViewById(R.id.webview);
        if(title != null) {
            titleCenter.setText(title);
        }

        if(url != null) {
            webview.loadUrl(url);
        }

    }
}
