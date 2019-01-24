package app.vdao.qidu.activity;

import android.content.Context;
import android.content.ContextWrapper;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.MotionEvent;
import android.view.View;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.ImageView;
import android.widget.TextView;

import com.gzqx.common.datautil.SharedPreferencesUtils;
import com.gzqx.common.utils.CommonKey;
import com.gzqx.common.utils.HttpUrl;
import com.gzqx.common.utils.IntentParams;
import com.jauker.widget.BadgeView;
import com.luck.picture.lib.PictureSelector;
import com.luck.picture.lib.config.PictureConfig;
import com.luck.picture.lib.entity.LocalMedia;

import org.apache.cordova.Config;
import org.json.JSONException;
import org.json.JSONObject;
import app.vdao.qidu.AppApplication;
import app.vdao.qidu.R;
import app.vdao.qidu.common.BounceInterpolator;
import app.vdao.qidu.common.EasingType;
import app.vdao.qidu.service.VersionUpdateManager;
import app.vdao.qidu.widget.PanelView;


//https://www.cnblogs.com/lenkevin/p/7676286.html
public class CordovaHomeActivity extends BasePhotoSelectActivity{


    private PanelView panel;
    public View headerLeftBack;//模拟回退一步
    public View headerLeftTvClose;//关闭页面
    //private String url_path = "http://m.dapu.com/mgallery-promotion-298.html";
    //String test_path = "file:///android_asset/test_test.html";
    ////"http://new.7dugo.com/index";
    //String test_path ="http://new.7dugo.com/index";
    String test_path = "file:///android_asset/test_test.html";

    //String test_path;
    private ImageView home,chat,found,shoppingCar,dynamicState,userCenter;
    private View bgLayout;
    private float mPosX,mPosY,mCurPosX,mCurPosY;
    private BadgeView badgeViewChat;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        super.initViewsAndEvents(savedInstanceState);
        if(loadUrl==null){
            return;
        }
        bgLayout=findViewById(R.id.bg_color);
        bgLayout.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                switch (event.getAction()) {
                    case MotionEvent.ACTION_DOWN:
                        mPosX = event.getX();
                        mPosY = event.getY();
                        break;
                    case MotionEvent.ACTION_MOVE:
                        mCurPosX = event.getX();
                        mCurPosY = event.getY();
                        break;
                    case MotionEvent.ACTION_UP:
                        if (mCurPosY - mPosY > 0
                                && (Math.abs(mCurPosY - mPosY) > 25)) {
                            //向下滑動

                        } else if (mCurPosY - mPosY < 0
                                && (Math.abs(mCurPosY - mPosY) > 25)) {
                            //向上滑动
                            //collapse();
                            if(panel!=null){
                                if(panel.isOpen()){
                                    panel.setOpen(!panel.isOpen(), false);
                                }
                            }
                        }
                        break;
                }
                return true;
            }
        });
        panel = (PanelView) findViewById(R.id.topPanel);
        panel.setOnPanelListener(panelListener);
        panel.setInterpolator(new BounceInterpolator(EasingType.Type.OUT));
        panel.setOnDownListener(new PanelView.OnDownListener() {
            @Override
            public void onDown() {
                bgLayout.setVisibility(View.VISIBLE);
            }
        });
        chat= (ImageView) findViewById(R.id.chat);
        home= (ImageView) findViewById(R.id.home);
        home.setOnClickListener(listener);
        badgeViewChat = new BadgeView(this);
        badgeViewChat.setTargetView(chat);
        badgeViewChat.setBadgeCount(AppApplication.shoppingCarNum);
        chat.setOnClickListener(listener);
        found= (ImageView) findViewById(R.id.found);
        found.setOnClickListener(listener);
        shoppingCar= (ImageView) findViewById(R.id.shopping_car);
        shoppingCar.setOnClickListener(listener);
        dynamicState= (ImageView) findViewById(R.id.dynamic_state);
        dynamicState.setOnClickListener(listener);
        userCenter= (ImageView) findViewById(R.id.user_center);
        userCenter.setOnClickListener(listener);
        //默认起始页面是读取config.xml里面配置
        String startUrl = Config.getStartUrl();

        headerCenterTv = (TextView) findViewById(R.id.header_text);
        headerLeftBack=findViewById(R.id.header_left_btn_img);
        headerLeftBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                mookKeyBack();
            }
        });
        //loadUrl=test_path;
        appView.loadUrl(loadUrl);//发现一个问题，如果不加载任何链接，按返回键Activity退不出来
        //AppUtils.share(getActivity(),"");
        if(AppApplication.isFirst) {
            new Handler().postDelayed(new Runnable() {
                @Override
                public void run() {
                    Animation shake = AnimationUtils.loadAnimation(getActivity(), R.anim.slight_shake);//加载动画资源文件
                    shake.setAnimationListener(new Animation.AnimationListener() {
                        @Override
                        public void onAnimationStart(Animation animation) {}
                        @Override
                        public void onAnimationEnd(Animation animation) {
                            AppApplication.isFirst = false;
                        }
                        @Override
                        public void onAnimationRepeat(Animation animation) {}
                    });
                    panel.getHandle().startAnimation(shake); //给组件播放动画效果
                }
            }, 500);
            VersionUpdateManager versionUpdateManager=new VersionUpdateManager(getActivity(),true);
            versionUpdateManager.checkAppVersion();
        }
        //Toast.makeText(getActivity(),"bugly生效",Toast.LENGTH_SHORT).show();
    }


    private View.OnClickListener listener=new View.OnClickListener() {
        @Override
        public void onClick(View view) {
            if(panel!=null){
                if(panel.isOpen()){
                    panel.setOpen(!panel.isOpen(), false);
                }
            }
            final int id=view.getId();
            new Handler().postDelayed(new Runnable() {
                @Override
                public void run() {
                    if(id== R.id.home){
                        /*Intent intent=new Intent(getActivity(),NearStoreListActivity.class);
                        startActivity(intent);*/
                        if(appView!=null){
                            appView.loadUrl(HttpUrl.homeUrl);
                        }
                    }else if(id== R.id.found){
                        if(appView!=null){
                            appView.loadUrl(HttpUrl.foundUrl);
                        }
                    }else if(id==R.id.shopping_car){
                        if(appView!=null){
                            appView.loadUrl(HttpUrl.shoppingCarUrl);
                        }
                    }else if(id== R.id.chat){
                        /*Intent intent = new Intent(getActivity(), ChatMainActivity.class);
                        //intent.putExtra("hostname",hostname);
                        intent.putExtra(ChatMainActivity.EXTRA_FINISH_ON_BACK_PRESS, false);
                        //intent.putExtra("isHomePage",false);
                        intent.setFlags(Intent.FLAG_ACTIVITY_REORDER_TO_FRONT | Intent.FLAG_ACTIVITY_CLEAR_TOP);
                        getActivity().startActivity(intent);*/
                    }else if(id==R.id.dynamic_state){
                        if(appView!=null){
                            appView.loadUrl(HttpUrl.showListUrl);
                        }
                    }else if(id==R.id.user_center){
                        if(appView!=null){
                            appView.loadUrl(HttpUrl.userCenterUrl);
                        }
                    }
                }
            },300);

        }
    };

    @Override
    protected int getContentViewID() {
        return R.layout.activity_home_cordovaview;
    }

    private PanelView.OnPanelListener panelListener=new PanelView.OnPanelListener() {
        @Override
        public void onPanelClosed(PanelView panel) {
            String panelName = getResources().getResourceEntryName(panel.getId());
            //Log.d("TestPanels", "Panel [" + panelName + "] closed");
            bgLayout.setVisibility(View.GONE);
        }

        @Override
        public void onPanelOpened(PanelView panel) {
            String panelName = getResources().getResourceEntryName(panel.getId());
            //Log.d("TestPanels", "Panel [" + panelName + "] opened");
            bgLayout.setVisibility(View.VISIBLE);
        }
    };


    @Override
    public void finish() {
        SharedPreferencesUtils.getInstance().saveData(CommonKey.KEY_SELECT_LOCATION_INFO,"");
        super.finish();
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (resultCode == RESULT_OK) {

            if(requestCode==PictureConfig.CHOOSE_REQUEST){
                selectMedia = PictureSelector.obtainMultipleResult(data);
                if(selectMedia.size()>0){
                    photoSelectResult(selectMedia.get(0));
                }
            }

        }else if(requestCode==QRCodeScanActivity.QR_REQUEST_CODE&&resultCode==QRCodeScanActivity.QR_RESULT_CODE){
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
        }else if(requestCode==CredentialsUploadActivity.CREDENTIALS_REQUEST_CODE&&resultCode==CredentialsUploadActivity.CREDENTIALS_RESULT_CODE){
            if(data==null){
                return;
            }
            String result=data.getStringExtra(IntentParams.KEY_CREDENTIALS_URL);
            if(callbackContext!=null){
                callbackContext.success(result);
            }
        }
    }

    protected void photoSelectResult(LocalMedia media){
        if(callbackContext!=null){
            //上传图片，然后回调给js
            String path=media.getCutPath();
            if(path==null){
                path=media.getPath();
            }
            uploadUserPhoto(path);
        }
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
}
