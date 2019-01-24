package app.vdao.qidu.activity;

import android.content.Context;
import android.content.ContextWrapper;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.support.annotation.NonNull;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.ImageView;
import android.widget.TextView;


import com.app.base.bean.User;
import com.app.base.utils.CommonKey;
import com.app.base.utils.IntentParams;
import com.app.base.webview.CordovaWebActivity;
import com.common.lib.global.AppUtils;
import com.common.lib.global.PermissionUtils;
import com.common.lib.utils.SharedPreferencesUtils;
import com.common.lib.utils.ToastUtils;
import com.mvp.lib.presenter.BasePresenter;

import org.apache.cordova.Config;
import org.apache.cordova.api.CallbackContext;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import app.vdao.qidu.AppApplication;
import app.vdao.qidu.R;
import app.vdao.qidu.mvp.contract.HomeContract;
import app.vdao.qidu.mvp.presenter.HomePresenterImpl;
import app.vdao.qidu.service.UpdateService;
import app.vdao.qidu.utils.VersionUpdateManager;


//https://www.cnblogs.com/lenkevin/p/7676286.html
public class CordovaHomeActivity extends CordovaWebActivity<HomePresenterImpl> implements HomeContract.View{


    public View headerLeftBack;//模拟回退一步
    public View headerLeftTvClose;//关闭页面
    //private String url_path = "http://m.dapu.com/mgallery-promotion-298.html";
    //String test_path = "file:///android_asset/test_test.html";
    ////"http://new.7dugo.com/index";
    //String test_path ="http://new.7dugo.com/index";
    String test_path = "file:///android_asset/test_test.html";

    private PermissionUtils.PermissionGrant mPermissionGrant = new PermissionUtils.PermissionGrant() {
        @Override
        public void onPermissionGranted(int requestCode) {
            switch (requestCode) {
                case PermissionUtils.CODE_MULTI_PERMISSION:

                    break;
                default:
                    break;
            }
        }
    };
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        String[] requestPermissions = {
                PermissionUtils.PERMISSION_ACCESS_FINE_LOCATION,
                PermissionUtils.PERMISSION_ACCESS_COARSE_LOCATION
        };
        PermissionUtils.requestMultiPermissions(null,this,requestPermissions,mPermissionGrant);
        AppUtils.initGPS(getActivity());
        //int titleType=getIntent().getIntExtra(IntentParams.KEY_TITLE_TYPE,0);
        initWebview();
        /*title_layout=findViewById(R.id.title_layout);
        View parent_title_layout=findViewById(R.id.parent_title_layout);
        if(titleType==0){
            parent_title_layout.setBackgroundColor(getResources().getColor(R.color.white));
            title_layout.setVisibility(View.VISIBLE);
            progressbar.setVisibility(View.VISIBLE);
        }else if(titleType==1){//
            parent_title_layout.setBackgroundColor(getResources().getColor(R.color.white));
            title_layout.setVisibility(View.GONE);
            progressbar.setVisibility(View.GONE);
        }else if(titleType==2){
            parent_title_layout.setBackgroundColor(getResources().getColor(R.color.app_bg));
            title_layout.setVisibility(View.VISIBLE);
        }*/
        if(loadUrl==null){
            return;
        }
        //默认起始页面是读取config.xml里面配置
        //String startUrl = Config.getStartUrl();
        headerCenterTv = (TextView) findViewById(R.id.header_text);
        headerLeftBack=findViewById(R.id.header_left_btn_img);
        headerLeftBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                mookKeyBack();
            }
        });
        //loadUrl=test_path;
        Map<String, String> heads = new HashMap<>();
        //heads.putAll(RetrofitClient.builderDefaultHeader());
        heads.put("client_id", AppUtils.generateDeviceUniqueId());
        appView.loadUrl(loadUrl,heads);//发现一个问题，如果不加载任何链接，按返回键Activity退不出来
        //AppUtils.share(getActivity(),"");
        if(AppApplication.isFirst){
            AppApplication.isFirst=false;
            mPresenter.checkAppVersion(true);
        }

    }



    @Override
    public void finish() {
        SharedPreferencesUtils.getInstance(this).saveData(CommonKey.KEY_SELECT_LOCATION_INFO,"");
        super.finish();
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        /*if(requestCode==QRCodeScanActivity.QR_REQUEST_CODE&&resultCode==QRCodeScanActivity.QR_RESULT_CODE){
            if(data==null){
                return;
            }
            String result=data.getStringExtra(IntentParams.KEY_QR_CODE_SCAN_RESULT_VALUE);
            if(callbackContext!=null){
                JSONObject object=new JSONObject();
                try {
                    object.put("scan_result",result);
                    callbackContext.success(object.toString());
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        }*/
    }

    @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(new ContextWrapper(newBase) {
            @Override
            public Object getSystemService(String name) {
                if (Context.AUDIO_SERVICE.equals(name))
                    return getApplicationContext().getSystemService(name);
                return super.getSystemService(name);
            }
        });
    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        int titleType=getIntent().getIntExtra(IntentParams.KEY_TITLE_TYPE,0);
        View view=null;
        if(titleType==0||titleType==1){
            view = inflater.inflate(R.layout.activity_home_cordovaview, null);
        }else if(titleType==2){
            view = inflater.inflate(R.layout.activity_home_title_cordovaview, null);
            //AutoUtils.auto(inflate);
        }
        return view;
    }

    @Override
    protected HomePresenterImpl initPresenter() {
        return new HomePresenterImpl();
    }

    @Override
    public void showToast(String message) {
        ToastUtils.show(message);
    }

    @Override
    public void showLoadingDialog(String message) {
        showProgressDialog(message);
    }

    @Override
    public void dismissLoadingDialog() {
        dismissProgressDialog();
    }

    public void WXLogin(CallbackContext callbackContext){
        mPresenter.WXLogin(callbackContext);
    }

    public void credentialsUpload(CallbackContext callbackContext,int uploadClickType,String business_license_url,String identity_positive_url,String identity_native_url){
        mPresenter.credentialsUpload(callbackContext,uploadClickType,business_license_url,identity_positive_url,identity_native_url);
    }

    public void tokePhotoByCamera(CallbackContext callbackContext, int type){
        mPresenter.tokePhotoByCamera(callbackContext,type);
    }
    //double latitude;
    //double longitude;
    public void addressLocation(CallbackContext callbackContext,boolean isAddressUseForHomePage,double latitude,double longitude,String cityCode){
        mPresenter.addressLocation(callbackContext,isAddressUseForHomePage,latitude,longitude,cityCode);
    }

    //定位当前位置
    public void startLocation(CallbackContext callbackContext){
        mPresenter.startLocationCurrentPosition(callbackContext);
    }

    //检测新版本
    public void checkAppVersion(boolean isHomePage){
        mPresenter.checkAppVersion(isHomePage);
    }

}
