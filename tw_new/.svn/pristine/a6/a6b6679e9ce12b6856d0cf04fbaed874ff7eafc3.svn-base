package app.vdao.qidu.activity;

import android.app.Activity;
import android.app.Instrumentation;
import android.content.Intent;
import android.graphics.Bitmap;
import android.net.Uri;
import android.net.http.SslError;
import android.os.Build;
import android.os.Bundle;
import android.util.Log;
import android.view.KeyEvent;
import android.view.Window;
import android.webkit.DownloadListener;
import android.webkit.SslErrorHandler;
import android.webkit.ValueCallback;
import android.webkit.WebResourceRequest;
import android.webkit.WebResourceResponse;
import android.webkit.WebView;
import android.widget.TextView;

import com.gzqx.common.webview.MyCordovaWebView;
import com.qidu.chat.activity.ChatMainActivity;

import org.apache.cordova.Config;
import org.apache.cordova.CordovaChromeClient;
import org.apache.cordova.CordovaWebViewClient;
import org.apache.cordova.IceCreamCordovaWebViewClient;
import org.apache.cordova.api.CallbackContext;
import org.apache.cordova.api.CordovaInterface;
import org.apache.cordova.api.CordovaPlugin;
import org.apache.cordova.api.LOG;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.HashMap;
import java.util.Map;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

/**
 *lzh
 */

public abstract class CordovaWeBasebActivity extends ChatMainActivity implements CordovaInterface {
    private String TAG="CordovaWebActivity";
    public TextView headerCenterTv;
    public MyCordovaWebView appView;

    public CallbackContext callbackContext = null;
    // 存储运行时变量
    private Map<String, Object> runtimeVariable = new HashMap<String, Object>();
    // 线程池
    private final ExecutorService threadPool = Executors.newCachedThreadPool();
    private String initCallbackClass;
    //private ProgressBar progressbar;

    protected CordovaPlugin activityResultCallback = null;
    protected String loadUrl;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        loadUrl=getIntent().getStringExtra("loadUrl");
        Config.init(this);
        if (savedInstanceState != null) {
            initCallbackClass = savedInstanceState.getString("callbackClass");
        }
        getWindow().requestFeature(Window.FEATURE_NO_TITLE);
        super.onCreate(savedInstanceState);
    }


    protected void initViewsAndEvents(Bundle savedInstanceState) {
        initWebview();
    }

    protected void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
        if (this.activityResultCallback != null) {
            String cClass = this.activityResultCallback.getClass().getName();
            outState.putString("callbackClass", cClass);
        }
    }
    @Override
    protected void onStop() {
        super.onStop();
    }

    @Override
    protected void onResume() {
        super.onResume();
        LOG.d(TAG, "Resuming the App");
        if (this.appView == null) {
            return;
        }
        this.appView.handleResume(true, true);
    }

    @Override
    /**
     * Called when the system is about to start resuming a previous activity.
     */
    protected void onPause() {
        super.onPause();
        if (this.appView == null) {
            return;
        }
        this.appView.handlePause(true);
    }
    @Override
    public void onDestroy() {
        super.onDestroy();
        if (this.appView != null) {
            appView.handleDestroy();
        } else {
            finish();
        }
    }
    @Override
    protected void onNewIntent(Intent intent) {
        super.onNewIntent(intent);
        // 交给插件处理
        if (this.appView != null)
            this.appView.onNewIntent(intent);
    }

    public boolean shouldOverrideUrlLoading(WebView view, String url) {
        return false;
    }
    public void initWebview() {

        // 创建webview
        final MyCordovaWebView webView = (MyCordovaWebView)findViewById(com.gzqx.com.gzqx.org.common.R.id.appView);
        webView.setHorizontalScrollBarEnabled(false);//水平不显示
        webView.setVerticalScrollBarEnabled(true); //垂直不显示
        // 创建CordovaWebViewClient
        CordovaWebViewClient webViewClient;
        if (Build.VERSION.SDK_INT < Build.VERSION_CODES.HONEYCOMB) {
            webViewClient = new CordovaWebViewClient(this, webView) {
                /*@Override
                public boolean shouldOverrideUrlLoading(WebView view, String url) {

                    boolean isOverride = CordovaWebActivity.this.shouldOverrideUrlLoading(view, url);
                    if (!isOverride) {
                        return super.shouldOverrideUrlLoading(view, url);
                    }
                    return isOverride;
                }*/

                @Override
                public void onPageStarted(WebView view, String url, Bitmap favicon) {
                    super.onPageStarted(view, url, favicon);
                    if (Build.VERSION.SDK_INT < 17) {
                        // 在 h5开始加载时动态给js注入Native对象和call方法,模拟addJavascriptInterface
                        //接口给js注入Native对象
                        //动态注入的好处就是不影响线上的h5数据,不影响ios使用
                        //在onPageStarted方法中注入是因为在h5的onload方法中有与本地交互的处理
                        //prompt()方法是js弹出的可输入的提示框
                        view.loadUrl("javascript:if(window.Native == undefined){window.Native={call:function(arg0,arg1){prompt('{\"methodName\":' + arg0 + ',\"jsonValue\":' +arg1 + '}')}}};");
                    }
                }

                @Override
                public void onReceivedSslError(WebView view, SslErrorHandler handler, SslError error) {
                    // 忽略SSL认证错误
                    handler.proceed();
                }

                @Override
                public WebResourceResponse shouldInterceptRequest(WebView view, String url) {
                    if(url.contains("cordova.js")){//加载指定.js时 引导服务端加载本地Assets/www文件夹下的cordova.js
                        try {
                            return new WebResourceResponse("application/javascript","utf-8",getBaseContext().getAssets().open("www/js/cordova.js"));
                        } catch (IOException e) {
                            e.printStackTrace();
                        }
                    }
                    if(url.contains("qiduvdaolink.js")){//加载指定.js时 引导服务端加载本地Assets/www文件夹下的cordova.js
                        try {
                            return new WebResourceResponse("application/javascript","utf-8",getBaseContext().getAssets().open("www/js/qidugoulink.js"));
                        } catch (IOException e) {
                            e.printStackTrace();
                        }
                    }
                    return super.shouldInterceptRequest(view, url);
                }
                @Override
                public void onPageFinished(WebView view, String url) {
                    if (!error) {
                        onPageLoaded(view, url);
                    }

                }
            };
        } else {
            webViewClient = new IceCreamCordovaWebViewClient(this, webView) {
                /*@Override
                public boolean shouldOverrideUrlLoading(WebView view, String url) {
                    boolean isOverride = CordovaWebActivity.this.shouldOverrideUrlLoading(view, url);
                    if (!isOverride) {
                        return super.shouldOverrideUrlLoading(view, url);
                    }
                    return isOverride;
                }*/

                /*@Override
                public boolean shouldOverrideUrlLoading(WebView view, String url) {
                    Log.i("aaaaa",url);
                    return super.shouldOverrideUrlLoading(view, url);
                }*/

                @Override
                public void onPageStarted(WebView view, String url, Bitmap favicon) {
                    super.onPageStarted(view, url, favicon);
                    Log.i("bbbbb","onPageStarted=============="+url);
                    if (Build.VERSION.SDK_INT < 17) {
                        // 在 h5开始加载时动态给js注入Native对象和call方法,模拟addJavascriptInterface
                        //接口给js注入Native对象
                        //动态注入的好处就是不影响线上的h5数据,不影响ios使用
                        //在onPageStarted方法中注入是因为在h5的onload方法中有与本地交互的处理
                        //prompt()方法是js弹出的可输入的提示框
                        view.loadUrl("javascript:if(window.Native == undefined){window.Native={call:function(arg0,arg1){prompt('{\"methodName\":' + arg0 + ',\"jsonValue\":' +arg1 + '}')}}};");
                    }
                }
                @Override
                public void onReceivedSslError(WebView view, SslErrorHandler handler, SslError error) {
                    // 忽略SSL认证错误
                    handler.proceed();
                }

                @Override
                public void onReceivedError(WebView view, int errorCode, String description, String failingUrl) {
                    super.onReceivedError(view, errorCode, description, failingUrl);
                }

                @Override
                public WebResourceResponse shouldInterceptRequest(WebView view, String url) {
                    Log.i("bbbbb","到这里=============="+url);
                    if(url.contains("cordova.js")){//加载指定.js时 引导服务端加载本地Assets/www文件夹下的cordova.js
                        try {
                            return new WebResourceResponse("application/javascript","utf-8",getBaseContext().getAssets().open("www/js/cordova.js"));
                        } catch (IOException e) {
                            e.printStackTrace();
                        }
                    }
                    if(url.contains("qiduvdaolink.js")){//加载指定.js时 引导服务端加载本地Assets/www文件夹下的cordova.js
                        Log.i("bbbbb","到这里"+url);
                        try {
                            return new WebResourceResponse("application/javascript","utf-8",getBaseContext().getAssets().open("www/js/qidugoulink.js"));
                        } catch (IOException e) {
                            e.printStackTrace();
                        }
                    }
                    return super.shouldInterceptRequest(view, url);
                }

                @Override
                public void onPageFinished(WebView view, String url) {
                    if (!error) {
                        onPageLoaded(view, url);
                    }

                }
                @Override
                public WebResourceResponse shouldInterceptRequest(WebView view, WebResourceRequest request) {
                    if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
                        Log.i("bbbbb","shouldInterceptRequest哈哈"+request.getUrl());

                    }
                    return super.shouldInterceptRequest(view, request);
                }
            };
        }

        // 创建CordovaChromeClient
        CordovaChromeClient webChromeClient = new CordovaChromeClient(this,
                webView) {

            @Override
            public void onProgressChanged(WebView view, int newProgress) {
                if (newProgress == 100) {
                    //progressbar.setVisibility(View.GONE);
                } else {
                    /*if (progressbar.getVisibility() == View.GONE)
                        progressbar.setVisibility(View.VISIBLE);
                    progressbar.setProgress(newProgress);*/
                }
                super.onProgressChanged(view, newProgress);
            }

            @Override
            public void onReceivedTitle(WebView view, String title) {
                super.onReceivedTitle(view, title);
                //appView.sendJavascript("java_call(\"fuck you\")");//Android 调用js示例
                //appView.loadUrl("javascript:java_call(\"fuck\")");
                //wx.fsga.gov.cn/fsweixin/jmt/jmt/form/toFtkrh.do?servCode=177&businessId=2E01DA497AE64BBD86767F6C7B972E8E
                if (!title.equals("")&& !view.getUrl().contains(title)&&!title.startsWith("http")&&!title.startsWith("file:///android_asset")&&!title.startsWith("loading")&&!title.contains(".jsp")&&!title.contains(".html")) {
                    // 获取到html页面的title后更新标题栏
                    if(headerCenterTv!=null){
                        headerCenterTv.setText(title);
                    }
                }
            }

        };
        String userAgent = webView.getSettings().getUserAgentString();//找到webview的useragent
        webView.getSettings().setUserAgentString(userAgent.replace("Android", "APP_WEBVIEW Android"));
        //通过浏览器下载webview的资源
        webView.setDownloadListener(new MyWebViewDownLoadListener());
        /*webView.getSettings().setAllowFileAccess(true);
        webView.getSettings().setDomStorageEnabled(true);*/
        webView.getSettings().setJavaScriptEnabled(true);
        //webView.getSettings().setJavaScriptCanOpenWindowsAutomatically(true);//支持通过JS打开浏览器新窗口
        //支持放大缩小
        webView.getSettings().setSupportZoom(true);
        webView.getSettings().setUseWideViewPort(true);
        webView.getSettings().setLoadWithOverviewMode(true);
        //设置放大缩小
        webView.getSettings().setBuiltInZoomControls(true);
        //隐藏放大缩小的控件
        webView.getSettings().setDisplayZoomControls(false);
        webView.removeJavascriptInterface("searchBoxJavaBridge_");
        webView.removeJavascriptInterface("accessibility");
        webView.removeJavascriptInterface("accessibilityTraversal");
        this.appView = webView;
        this.appView.setWebViewClient(webViewClient);
        this.appView.setWebChromeClient(webChromeClient);
        //this.appView.setVisibility(View.INVISIBLE);

        webViewClient.setWebView(this.appView);
        webChromeClient.setWebView(this.appView);
    }
    public void setupWebView(String startUrl, JSONObject params) {
        Map<String, String> heads = new HashMap<>();
        //heads.putAll(RetrofitClient.builderDefaultHeader());
        heads.put("client_id","android");
        appView.loadUrl(startUrl, heads);
        // 将外部传入的参数放在运行时变量里面
        this.setRuntimeVariable("PageParams", params);

    }
    /*private int getRespStatus(String url) {
        int status = -1;
        try {
            HttpHead head = new HttpHead(url);
            HttpClient client = new DefaultHttpClient();
            HttpResponse resp = client.execute(head);
            status = resp.getStatusLine().getStatusCode();
        } catch (IOException e) {}
        return status;
    }*/
    // 获取运行时变量
    public Object getRuntimeVariable(String key, Object defaultValue) {
        if (this.runtimeVariable.containsKey(key)) {
            return this.runtimeVariable.get(key);
        }
        return defaultValue;
    }

    // 设置运行时变量
    public void setRuntimeVariable(String key, Object value) {
        this.runtimeVariable.put(key, value);
    }
    @Override
    public void startActivityForResult(CordovaPlugin cordovaPlugin, Intent intent, int requestCode) {
        this.activityResultCallback = cordovaPlugin;
        super.startActivityForResult(intent, requestCode);
    }

    @Override
    public void setActivityResultCallback(CordovaPlugin cordovaPlugin) {
        this.activityResultCallback = cordovaPlugin;
    }
    @Override
    protected void onActivityResult(int requestCode, int resultCode,
                                    Intent intent) {
        LOG.d(TAG, "Incoming Result");
        super.onActivityResult(requestCode, resultCode, intent);
        Log.d(TAG, "Request code = " + requestCode);
        ValueCallback<Uri> mUploadMessage = this.appView.getWebChromeClient()
                .getValueCallback();
        if (requestCode == CordovaChromeClient.FILECHOOSER_RESULTCODE) {
            if (null == mUploadMessage)
                return;
            Uri result = intent == null || resultCode != Activity.RESULT_OK ? null
                    : intent.getData();
            Log.d(TAG, "result = " + result);
            mUploadMessage.onReceiveValue(result);
            mUploadMessage = null;
        }
        CordovaPlugin callback = this.activityResultCallback;
        if (callback == null) {
            if (initCallbackClass != null) {
                this.activityResultCallback = appView.pluginManager
                        .getPlugin(initCallbackClass);
                callback = activityResultCallback;
                callback.onActivityResult(requestCode, resultCode, intent);
            }
        } else {
            callback.onActivityResult(requestCode, resultCode, intent);
        }
    }

    @Override
    public Activity getActivity() {
        return this;
    }

    public void postMessage(String id, Object data) {
        if (this.appView != null) {
            this.appView.postMessage(id, data);
        }
    }

    @Override
    public Object onMessage(String id, Object data) {//这里接收，postMessage发送
        Log.i("onMessage","id--"+id+"data---"+data);
        if ("onPageFinished".equals(id)) {
            // 给appView加上淡入的动画效果
            /*Animation viewIn = AnimationUtils.loadAnimation(this,
                    R.anim.view_in);
            this.appView.setAnimation(viewIn);
            this.appView.setVisibility(View.VISIBLE);*/
            //this.hiddenDialogLoading();
        } else if ("onReceivedError".equals(id)) {

            JSONObject d = (JSONObject) data;
            try {
                this.onReceivedError(d.getInt("errorCode"),
                        d.getString("description"), d.getString("url"));
            } catch (JSONException e) {
                e.printStackTrace();
            }
        } else if ("exit".equals(id)) {
            finish();
        }
        return null;
    }
    // 接收到错误的地址后的处理
    public void onReceivedError(final int errorCode, final String description,
                                final String failingUrl) {
        runOnUiThread(new Runnable() {
            public void run() {
                //appView.loadError();
//				try {
//					AlertDialog.Builder dlg = new AlertDialog.Builder(me);
//					dlg.setMessage("访问出错了,请稍后再试!");
//					dlg.setTitle("温馨提示");
//					dlg.setCancelable(false);
//					dlg.setPositiveButton("确定",
//							new AlertDialog.OnClickListener() {
//						public void onClick(DialogInterface dialog,
//								int which) {
//							dialog.dismiss();
//							endActivity();
//						}
//					});
//					dlg.create();
//					dlg.show();
//				} catch (Exception e) {
//					e.printStackTrace();
//					endActivity();
//				}
                //appView.loadError();
            }
        });
    }
    @Override
    public ExecutorService getThreadPool() {
        return threadPool;
    }


    private class MyWebViewDownLoadListener implements DownloadListener {
        @Override
        public void onDownloadStart(String url, String userAgent, String contentDisposition, String mimetype,
                                    long contentLength) {
            Log.i("tag", "url=" + url);
            Log.i("tag", "userAgent=" + userAgent);
            Log.i("tag", "contentDisposition=" + contentDisposition);
            Log.i("tag", "mimetype=" + mimetype);
            Log.i("tag", "contentLength=" + contentLength);
            Uri uri = Uri.parse(url);
            Intent intent = new Intent(Intent.ACTION_VIEW, uri);
            startActivity(intent);
        }
    }



    // 模拟点击回退键盘
    public void mookKeyBack() {
        new Thread() {
            public void run() {
                try {
                    Instrumentation inst = new Instrumentation();
                    inst.sendKeyDownUpSync(KeyEvent.KEYCODE_BACK);
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
        }.start();
    }
    @Override
    public boolean onKeyUp(int keyCode, KeyEvent event) {
        if (appView.isCustomViewShowing() && (keyCode == KeyEvent.KEYCODE_BACK || keyCode == KeyEvent.KEYCODE_MENU)) {
            return appView.onKeyUp(keyCode, event);
        }
        return super.onKeyUp(keyCode, event);
    }

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        Log.i("tag", "onKeyDown  keyCode=" + keyCode);
        if (keyCode == KeyEvent.KEYCODE_BACK || keyCode == KeyEvent.KEYCODE_MENU) {
            /*if (isIndividuationLB) {
                appView.post(new Runnable() {
                    @Override
                    public void run() {
                        appView.loadUrl("javascript:individuationAppBack();");
                    }
                });
                return false;
            } else {
                if (appView.canGoBack()) {
                    appView.goBack();
                    return true;
                }
                return super.onKeyDown(keyCode, event);
            }*/
            if (appView.canGoBack()) {
                appView.goBack();
                return true;
            }
            return super.onKeyDown(keyCode, event);
        }
        return super.onKeyDown(keyCode, event);
    }







    //以下所有和IM登录有关
    private boolean error;
    protected void onPageLoaded(WebView webview, String url) {
    }
}
