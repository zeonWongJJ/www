
package com.qidu.chat.widget;

import android.annotation.SuppressLint;
import android.app.ProgressDialog;
import android.content.Context;
import android.graphics.Bitmap;
import android.util.AttributeSet;
import android.view.MotionEvent;
import android.view.View;
import android.webkit.HttpAuthHandler;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.widget.ScrollView;


public class XWebView extends WebView{
	protected ProgressDialog progressDialog;
	
	private Context mContext;
	private static String UA = "";
	
	public XWebView(Context context) {
		super(context);
		this.mContext = context;
		
		setWebView();
	}
	
	/**
	 * @param context
	 * @param attrs
	 */
	public XWebView(Context context, AttributeSet attrs) {
		super(context, attrs);
		this.mContext = context;
		
		setWebView();
	}
	/**
	 * 获取UA信息<br/>
	 * User-Agent(简称UA)是HTTP请求头部用来标识客户端信息的字符串, 包括操作系统, 浏览器等信息.
	 * 为了建立手机客户端的信息数据库, 需要从手机的http请求中取到这一字符串.
	 * @param context
	 * @return
	 */
	private String getUserAgent(Context context) {
		WebView webview;
		webview = new WebView(context);
		webview.layout(0, 0, 0, 0);
		WebSettings settings = webview.getSettings();
		String ua = settings.getUserAgentString();
		return ua;
	}
	private void setWebView() {
		
		UA = getUserAgent(mContext) + " android_in_app";
        setWebChromeClient(new WebChromeClient());
        setWebViewClient(new WebViewClient());
        setWebSettings();

        //屏蔽掉长按事件 因为webview长按时将会调用系统的复制控件
        setOnLongClickListener(new OnLongClickListener() {
			
			@Override
			public boolean onLongClick(View arg0) {
				return true;
			}
		});
	}
	
	@Override
	public void loadUrl(String url) {
		super.loadUrl(url);
	}

	/**
	 * WebChromeClient会在一些影响浏览器ui交互动作发生时被调用，
	 * 比如WebView关闭和隐藏、页面加载进展、js确认框和警告框、js加载前、js操作超时、webView获得焦点等等
	 * 这里设置了加载时显示进度条
	 */
	public class WebChromeClient extends android.webkit.WebChromeClient {
        @Override
        public void onProgressChanged(WebView view, int newProgress) {
        	if(newProgress == 100) {
//        		if (progressDialog!=null&&progressDialog.isShowing()) {
//        			progressDialog.dismiss();
//        		}
        	} else {
//        		if (progressDialog==null) {
//        			progressDialog=new ProgressDialog(mContext, android.R.style.Theme_Holo_Light_Dialog);
//        			progressDialog.getWindow().setBackgroundDrawableResource(android.R.color.transparent);
//        		}
//        		progressDialog.setMessage("");
//        		progressDialog.show();
        	}
            super.onProgressChanged(view, newProgress);
        }
        
        
        
    }
	
	/**
	 * WebViewClient会在一些影响内容渲染的动作发生时被调用，
	 * 比如表单的错误提交需要重新提交、页面开始加载及加载完成、资源加载中、接收到http认证需要处理、页面键盘响应、页面中的url打开处理等等，
	 */
	public class WebViewClient extends android.webkit.WebViewClient {
		
		@Override
		public void onReceivedHttpAuthRequest(WebView view,
				HttpAuthHandler handler, String host, String realm) {
			super.onReceivedHttpAuthRequest(view, handler, host, realm);
		}

		@SuppressLint("NewApi")
		@Override
		public void onReceivedLoginRequest(WebView view, String realm,
				String account, String args) {
			super.onReceivedLoginRequest(view, realm, account, args);
		}

		//连接在WebView中打开，而不是新开Android的系统browser中响应该链接
		//在这里可以拦截网页发起的请求url
        @Override
		public boolean shouldOverrideUrlLoading(WebView view, String url) {
			view.loadUrl(url);
			return true;
		}

		//页面开始加载
        @Override
		public void onPageStarted(WebView view, String url, Bitmap favicon) {

        	super.onPageStarted(view, url, favicon);
		}
        
        //加载完成
		@Override
		public void onPageFinished(WebView view, String url) {
			super.onPageFinished(view, url);
			
		}

		@Override
		public void onReceivedError(WebView view, int errorCode, String description, String failingUrl) {
			super.onReceivedError(view, errorCode, description, failingUrl);
			if(webLoaderError!=null){
				webLoaderError.error(view,errorCode,description,failingUrl);
			}
		}
        
	}
	
	
	
	/**
	 * 其中包含多项配置。WebSettings用来对WebView的配置进行配置和管理，
	 * 比如是否可以进行文件操作、缓存的设置、页面是否支持放大和缩小、是否允许使用数据库api、
	 * 字体及文字编码设置、是否允许js脚本运行、是否允许图片自动加载、是否允许数据及密码保存等等。
	 */
	@SuppressLint("NewApi")
	public void setWebSettings() {
		WebSettings webSettings = this.getSettings();
		webSettings.setJavaScriptEnabled(true);//设置支持JavaScript
		webSettings.setUseWideViewPort(true);//WebView自适应屏幕大小，并且双击放大或缩小
		webSettings.setLoadWithOverviewMode(true);
		webSettings.setUserAgentString(UA);
//		System.out.println("UA = " + webSettings.getUserAgentString());
		
	}

	private ScrollView scrollView;//可能嵌套webView的scrollView
	private boolean canVerMove = true;//设置包裹webview的scrollview是否可以上下滑动
	
	public boolean isCanVerMove() {
		return canVerMove;
	}

	public void setCanVerMove(boolean canVerMove) {
		this.canVerMove = canVerMove;
	}
	
	public boolean getCanVerMove() {
		return canVerMove;
	}

	public ScrollView getScrollView() {
		return scrollView;
	}

	public void setScrollView(ScrollView scrollView) {
		this.scrollView = scrollView;
	}

	@Override
	public boolean dispatchTouchEvent(MotionEvent event) {
		
//		if(scrollView != null) {
//			scrollView.requestDisallowInterceptTouchEvent(!canVerMove);
//		}
		
		if(getParent() != null) {
			getParent().requestDisallowInterceptTouchEvent(!canVerMove);
		
		}
		return super.dispatchTouchEvent(event);
	}
	
	public void setOnBackListener(OnBackListener back) {
		this.back = back;
	}
	
	public void setWebLoaderError(OnWebLoaderError webLoaderError) {
		this.webLoaderError = webLoaderError;
	}

	private OnBackListener back;
	public interface OnBackListener {
		public void back();
	}
	
	private OnWebLoaderError webLoaderError;
	public interface OnWebLoaderError{
		public void error(WebView view, int errorCode, String description, String failingUrl);
	}
	
}
