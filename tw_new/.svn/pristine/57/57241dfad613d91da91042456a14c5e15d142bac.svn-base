package app.vdao.qidu.home;

import android.app.Activity;
import android.app.Instrumentation;
import android.content.ContextWrapper;
import android.content.Intent;
import android.graphics.Bitmap;
import android.net.Uri;
import android.net.http.SslError;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.util.Log;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.webkit.DownloadListener;
import android.webkit.SslErrorHandler;
import android.webkit.ValueCallback;
import android.webkit.WebResourceResponse;
import android.webkit.WebView;
import android.widget.TextView;

import com.gzqx.com.gzqx.org.common.R;
import com.gzqx.common.base.AbsBaseFragment;
import com.gzqx.common.webview.MyCordovaWebView;

import org.apache.cordova.Config;
import org.apache.cordova.CordovaChromeClient;
import org.apache.cordova.CordovaWebViewClient;
import org.apache.cordova.IceCreamCordovaWebViewClient;
import org.apache.cordova.api.CallbackContext;
import org.apache.cordova.api.CordovaInterface;
import org.apache.cordova.api.CordovaPlugin;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.HashMap;
import java.util.Map;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

/**
 * lzh
 */

public abstract class CordovaWebFragment extends AbsBaseFragment implements View.OnKeyListener,CordovaInterface {
    private String TAG="CordovaWebActivity";
    public TextView headerCenterTv;
    protected MyCordovaWebView appView;

    public CallbackContext callbackContext = null;
    // 存储运行时变量
    private Map<String, Object> runtimeVariable = new HashMap<String, Object>();
    // 线程池
    private final ExecutorService threadPool = Executors.newCachedThreadPool();
    private String initCallbackClass;

    protected CordovaPlugin activityResultCallback = null;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        Config.init(getActivity());
        if (savedInstanceState != null) {
            initCallbackClass = savedInstanceState.getString("callbackClass");
        }
        //getActivity().getWindow().requestFeature(Window.FEATURE_NO_TITLE);
        super.onCreate(savedInstanceState);
        /*Bundle bundle = getArguments();
        String orderstatus = bundle.getString(Constant.INTENT_DATA);*/
    }
    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        LayoutInflater localInflater = inflater.cloneInContext(new CordovaContext(getActivity(), this));
        return super.onCreateView(localInflater, container, savedInstanceState);
    }

    @Override
    protected void initViews(View view,Bundle savedInstanceState) {
        initWebview(view);
    }
    private String white="http://new.7dugo.com/index";
    private String path="http://www.wangyi120.com/";

    @Override
    public void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
        if (this.activityResultCallback != null) {
            String cClass = this.activityResultCallback.getClass().getName();
            outState.putString("callbackClass", cClass);
        }
    }
    @Override
    public void onStop() {
        super.onStop();
    }

    @Override
    public void onResume() {
        super.onResume();
        if (this.appView == null) {
            return;
        }
        this.appView.handleResume(true, true);
    }

    @Override
    /**
     * Called when the system is about to start resuming a previous activity.
     */
    public void onPause() {
        super.onPause();
        if (this.appView == null) {
            return;
        }
        this.appView.handlePause(true);
    }

    public boolean shouldOverrideUrlLoading(WebView view, String url) {
        return false;
    }
    public void initWebview(View view) {

        // 创建webview
        final MyCordovaWebView webView = (MyCordovaWebView)view.findViewById(R.id.appView);
        //http://www.jianshu.com/p/a6f9d4046985
        /*webView.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                //获取y轴坐标
                float y = motionEvent.getRawY();
                switch (motionEvent.getAction()) {
                    case MotionEvent.ACTION_DOWN:
                        getHTMLPosition();
                        if (null != mPagerDesc) {
                            int top = mPagerDesc.top;
                            int bottom = top + (mPagerDesc.bottom - mPagerDesc.top);
                            //将css像素转换为android设备像素并考虑通知栏高度
                            top = (int) (top * metric.density) + height
                            bottom = (int) (bottom * metric.density) + height
                            //如果触摸点的坐标在轮播区域内，则由webview来处理事件，否则由viewpager来处理
                            if (y > top && y < bottom) {
                                webview.requestDisallowInterceptTouchEvent(true);
                            } else {
                                webview.requestDisallowInterceptTouchEvent(false);
                            }
                        }
                        break;
                    case MotionEvent.ACTION_UP:
                        break;
                    case MotionEvent.ACTION_MOVE:
                        break;
                }
                return false;
            }
        });*/
        webView.setHorizontalScrollBarEnabled(false);//水平不显示
        webView.setVerticalScrollBarEnabled(false); //垂直不显示
        // 创建CordovaWebViewClient
        CordovaWebViewClient webViewClient;
        if (android.os.Build.VERSION.SDK_INT < android.os.Build.VERSION_CODES.HONEYCOMB) {
            webViewClient = new CordovaWebViewClient(this, webView) {
                /*@Override
                public boolean shouldOverrideUrlLoading(WebView view, String url) {

                    boolean isOverride = CordovaWebFragment.this.shouldOverrideUrlLoading(view, url);
                    if (!isOverride) {
                        return super.shouldOverrideUrlLoading(view, url);
                    }
                    return isOverride;
                }*/

                @Override
                public void onPageStarted(WebView view, String url, Bitmap favicon) {
                    super.onPageStarted(view, url, favicon);
                    if (android.os.Build.VERSION.SDK_INT < 17) {
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
                            return new WebResourceResponse("application/javascript","utf-8",getActivity().getBaseContext().getAssets().open("www/js/cordova.js"));
                        } catch (IOException e) {
                            e.printStackTrace();
                        }
                    }
                    if(url.contains("qiduvdaolink.js")){//加载指定.js时 引导服务端加载本地Assets/www文件夹下的cordova.js
                        try {
                            return new WebResourceResponse("application/javascript","utf-8",getActivity().getBaseContext().getAssets().open("www/js/qiduvdaolink.js"));
                        } catch (IOException e) {
                            e.printStackTrace();
                        }
                    }
                    return super.shouldInterceptRequest(view, url);
                }
            };
        } else {
            webViewClient = new IceCreamCordovaWebViewClient(this, webView) {
                /*@Override
                public boolean shouldOverrideUrlLoading(WebView view, String url) {
                    boolean isOverride = CordovaWebFragment.this.shouldOverrideUrlLoading(view, url);
                    if (!isOverride) {
                        return super.shouldOverrideUrlLoading(view, url);
                    }
                    return isOverride;
                }*/
                @Override
                public void onPageStarted(WebView view, String url, Bitmap favicon) {
                    Log.i("aaaa","onPageStarted"+"   "+url);
                    super.onPageStarted(view, url, favicon);
                    if (android.os.Build.VERSION.SDK_INT < 17) {
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
                            return new WebResourceResponse("application/javascript","utf-8",getActivity().getBaseContext().getAssets().open("www/js/cordova.js"));
                        } catch (IOException e) {
                            e.printStackTrace();
                        }
                    }
                    if(url.contains("qiduvdaolink.js")){//加载指定.js时 引导服务端加载本地Assets/www文件夹下的cordova.js
                        try {
                            return new WebResourceResponse("application/javascript","utf-8",getActivity().getBaseContext().getAssets().open("www/js/qiduvdaolink.js"));
                        } catch (IOException e) {
                            e.printStackTrace();
                        }
                    }
                    return super.shouldInterceptRequest(view, url);
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
//                Log.i("aaaa","onReceivedTitle"+"   "+title);
                //appView.sendJavascript("java_call()");//Android 调用js示例
                //wx.fsga.gov.cn/fsweixin/jmt/jmt/form/toFtkrh.do?servCode=177&businessId=2E01DA497AE64BBD86767F6C7B972E8E
                if (!title.equals("")&& !view.getUrl().contains(title)&&!title.startsWith("http")&&!title.startsWith("file:///android_asset")&&!title.startsWith("loading")&&!title.contains(".jsp")&&!title.contains(".html")) {
                    // 获取到html页面的title后更新标题栏
                    if(headerCenterTv!=null) {
                        headerCenterTv.setText(title);
                    }
                }
            }

        };
        //通过浏览器下载webview的资源
        webView.setDownloadListener(new MyWebViewDownLoadListener());
        webView.getSettings().setJavaScriptEnabled(true);
        //String userAgent = webView.getSettings().getUserAgentString();//找到webview的useragent
        //webView.getSettings().setUserAgentString(userAgent.replace("Android", "APP_WEBVIEW Android"));//在useragent上添加APP_WEBVIEW 标识符,服务器会获取该标识符进行判断
        //webView.getSettings().setJavaScriptCanOpenWindowsAutomatically(true);//支持通过JS打开新窗口
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
        this.appView.setOnKeyListener(this);

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
    public void onActivityResult(int requestCode, int resultCode,
                                    Intent intent) {
        super.onActivityResult(requestCode, resultCode, intent);
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


    public void postMessage(String id, Object data) {
        if (this.appView != null) {
            this.appView.postMessage(id, data);
        }
    }


    /*@Override
    public void onDestroyView() {
        if (this.appView != null) {
            //appView.handleDestroy();
            //appView=null;
        }
        super.onDestroyView();
    }*/


    @Override
    public boolean onKey(View v, int keyCode, KeyEvent event) {
        if (event.getAction() == KeyEvent.ACTION_UP&&keyCode == KeyEvent.KEYCODE_BACK && event.getRepeatCount() == 0) {
            if (this.appView != null && this.appView.canGoBack()) {
                this.appView.goBack();
            }
            return true;
        }
        return  false;
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
    public Object onMessage(String id, Object data) {//这里接收，postMessage发送
        Log.i("onMessage","id--"+id+"----data---"+data);
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
            getActivity().finish();
        }
        return null;
    }
    // 接收到错误的地址后的处理
    public void onReceivedError(final int errorCode, final String description,
                                final String failingUrl) {
        //onReceivedErrordata---{"errorCode":-2,"description":"net::ERR_NAME_NOT_RESOLVED","url":"http:\/\/www.wangyi1201.com\/"}//网址错误，找不到服务
        /*getActivity().runOnUiThread(new Runnable() {
            public void run() {

//                String data = "Page NO FOUND！";
//                appView.loadUrl("javascript:document.body.innerHTML=\"" + data + "\"");
                appView.loadError();
//
            }
        });*/
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


    private class CordovaContext extends ContextWrapper implements CordovaInterface {

        CordovaInterface cordova;
        Activity activity;
        public CordovaContext(Activity base, CordovaInterface cordova) {
            super(base);
            this.activity=base;
            this.cordova = cordova;
        }
        @Override
        public void startActivityForResult(CordovaPlugin command, Intent intent, int requestCode) {
            cordova.startActivityForResult(command, intent, requestCode);
        }
        @Override
        public void setActivityResultCallback(CordovaPlugin plugin) {
            cordova.setActivityResultCallback(plugin);
        }
        @Override
        public Activity getActivity() {
            return this.activity;
        }
        @Override
        public Object onMessage(String id, Object data) {
            return cordova.onMessage(id, data);
        }
        @Override
        public ExecutorService getThreadPool() {
            return cordova.getThreadPool();
        }
    }
}
