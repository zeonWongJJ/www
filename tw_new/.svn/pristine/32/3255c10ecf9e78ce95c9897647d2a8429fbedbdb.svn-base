package app.vdao.qidu.plugin;

import android.app.Activity;
import android.app.Dialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.app.base.bean.User;
import com.app.base.utils.CommonKey;
import com.app.base.utils.IntentParams;
import com.app.base.utils.WXShareUtil;
import com.app.base.webview.PluginAction;
import com.bigkoo.pickerview.TimePickerView;
import com.common.lib.base.BaseApplication;
import com.common.lib.global.AppUtils;
import com.common.lib.utils.SharedPreferencesUtils;

import org.apache.cordova.CordovaWebView;
import org.apache.cordova.api.CallbackContext;
import org.apache.cordova.api.CordovaInterface;
import org.apache.cordova.api.CordovaPlugin;
import org.apache.cordova.api.PluginResult;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import app.vdao.qidu.R;
import app.vdao.qidu.activity.CordovaHomeActivity;
import app.vdao.qidu.activity.NearStoreListActivity;
import app.vdao.qidu.activity.StoreLocationActivity;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;
import java.util.TimeZone;


public class MainCordovaActivityPlugin extends CordovaPlugin {
    //
    private String TAG=this.getClass().getSimpleName();
    public Activity activity;
    private CordovaHomeActivity mainCordovaActivity;
    public CordovaWebView appView;
    @Override
    public void initialize(CordovaInterface cordova, CordovaWebView webView) {
        super.initialize(cordova, webView);
        /*if (cordova instanceof Activity) {
            this.activity = (Activity) cordova;
        }else if(cordova.getActivity() instanceof Activity){//fragment的时候
            this.activity=cordova.getActivity();
        }*/
        if(cordova.getActivity() instanceof Activity){
            this.activity= cordova.getActivity();
        }
        if(cordova.getActivity() instanceof CordovaHomeActivity){
            this.mainCordovaActivity= (CordovaHomeActivity) cordova.getActivity();
        }
        this.appView=webView;
    }
    @Override
    public void onDestroy() {
        super.onDestroy();
    }

    @Override
    public boolean execute(String action,final JSONArray array, final CallbackContext callbackContext) throws JSONException {
        Log.i(TAG,"action:"+action);
        Log.i("bbbbbbb","js返回内容"+array.toString());

        if(action.equals(PluginAction.ACTION_CREATE_NEW_WINDOW)) {
            JSONObject object= (JSONObject) array.get(0);
            String url=object.getString("url");
            int showTitleType=object.getInt("showTitleType");
            //int showTitleType=0;//目前0,是默认打开包括标题栏布局显示，1 标题栏布局不显示，2 标题栏布局显示，但根布局是frameLayout --用于客服页面打开
            Intent intent = new Intent(activity, CordovaHomeActivity.class);
            intent.putExtra(IntentParams.KEY_TITLE_TYPE,showTitleType);
            intent.putExtra(IntentParams.KEY_LOAD_URL,url);
            this.activity.startActivity(intent);//
        }/*else if(action.equals(PluginAction.ACTION_TITLE_BAR_LAYOUT_IS_VISIBLE)){
            JSONObject object= (JSONObject) array.get(0);
            this.appView.postMessage(PluginAction.ACTION_TITLE_BAR_LAYOUT_IS_VISIBLE,object);
        }*/else if(action.equals(PluginAction.ACTION_IS_ARROW_WINDOW_FINISH)){//直接不让webview后退，点击返回键直接关闭activity
            JSONObject object= (JSONObject) array.get(0);
            boolean isArrowFinish=object.getBoolean("isArrowFinish");
            this.mainCordovaActivity.setIsFinish(isArrowFinish);
        }else if (action.equals(PluginAction.ACTION_RELOAD_LAST_PAGE)) {
            if(this.mainCordovaActivity!=null){
                mainCordovaActivity.reloadPage();
            }
        }else if(action.equals(PluginAction.ACTION_LOGIN)){//登陆成功
            //Toast.makeText(this.activity,action,Toast.LENGTH_SHORT).show();
            //字段 issave 0不保存 1保存
            try {
                JSONObject object= (JSONObject) array.get(0);
                //Log.i("aaaaaaaaaaaaaaaaa",object.toString());
                //Toast.makeText(this.activity,object.toString(),Toast.LENGTH_SHORT).show();
                SharedPreferencesUtils.getInstance(BaseApplication.getInstance()).saveData(CommonKey.KEY_LOGIN_USER_INFO,object.toString());
                String userId=null;
                String userName=null;
                String passWord=null;
                String issave="0";
                if (object.has("user_id")) {
                    userId=object.getString("user_id");
                }
                if (object.has("user_name")) {
                    userName=object.getString("user_name");
                }
                if (object.has("user_password")) {
                    passWord=object.getString("user_password");
                }

                if (object.has("issave")) {
                    issave=object.getString("issave");
                }
                /*if(!User.isExistUserByUserId(userId)&&issave.equals("1")){
                    User user=new User();
                    user.setUserId(userId);
                    user.setUserName(userName);
                    user.setPassword(passWord);
                    user.save();
                }*/
                if(issave.equals("1")){
                    if(User.isExistUserByUserId(userId)){
                        User.deleteUser(userId);
                    }
                    User user=new User();
                    user.setUserId(userId);
                    user.setUserName(userName);
                    user.setPassword(passWord);
                    user.setNeedLogin(true);
                    user.setSaveTime(System.currentTimeMillis());
                    user.save();
                }else if(issave.equals("0")){
                    if(User.isExistUserByUserId(userId)){
                        //User.deleteUser(userId);
                        User user=User.getUser(userId);
                        //Log.i("aaaaaaaaa",user.getSaveTime()+"");
                        user.setUserId(userId);
                        user.setUserName(userName);
                        user.setPassword("");
                        user.setSaveTime(System.currentTimeMillis());
                        user.setNeedLogin(false);
                        user.save();
                    }else {
                        User user=new User();
                        user.setUserId(userId);
                        user.setUserName(userName);
                        user.setPassword("");
                        user.setSaveTime(System.currentTimeMillis());
                        user.setNeedLogin(false);
                        user.save();
                    }
                }
            } catch (JSONException e) {
                e.printStackTrace();
                return false;
            }

        }else if(action.equals(PluginAction.ACTION_TAKE_LOCAL_USER_LIST)) {
            //返回账号信息给js
            List<User> userList=User.getUserList();
            JSONArray jsonArray=new JSONArray();
            if(userList.size()>0){
                for(int i=0;i<userList.size();i++){
                    JSONObject object=new JSONObject();
                    object.put("user_id",userList.get(i).getUserId());
                    object.put("user_name",userList.get(i).getUserName());
                    object.put("user_password",userList.get(i).getPassword());
                    object.put("save_time",userList.get(i).getSaveTime());
                    object.put("is_need_login",userList.get(i).isNeedLogin());
                    jsonArray.put(object);
                }
                callbackContext.success(jsonArray.toString());
            }else {
                callbackContext.success(jsonArray.toString());
            }
        }else if(action.equals(PluginAction.ACTION_DELETE_USER_ACCOUNT_BY_ID)){
            JSONObject object= (JSONObject) array.get(0);
            String userId=object.getString("user_id");
            User.deleteUser(userId);
        }else if(action.equals(PluginAction.ACTION_FINISH_ACTIVITY)){
            this.activity.finish();
        }else if(action.equals(PluginAction.ACTION_INIT_SYSTEM_PARAMS)){//一些共同的参数参数设置
            //JSONObject jsonObject= (JSONObject) array.get(0);
            JSONObject object=new JSONObject();
            object.put("client_id",AppUtils.generateDeviceUniqueId());
            callbackContext.success(object.toString());
        }else if(action.equals(PluginAction.LOGIN_OUT)){
            JSONObject object= (JSONObject) array.get(0);
            String userId=object.getString("user_id");
            if(User.isExistUserByUserId(userId)){
                User user=User.getUser(userId);
                user.setSaveTime(System.currentTimeMillis());
                user.setNeedLogin(false);
                user.save();
            }
        }else if(action.equals(PluginAction.ACTION_PUT_DATA_FOR_LAST_PAGE)){
            try {
                JSONObject object= (JSONObject) array.get(0);
                Intent intent=new Intent();
                intent.putExtra("test",object.toString());
                this.activity.setResult(Activity.RESULT_OK,intent);
                this.activity.finish();
            } catch (JSONException e) {
                e.printStackTrace();
                return false;
            }
        }else if(action.equals(PluginAction.ACTION_QR_CODE_SCAN)){
            JSONObject jsonObject= (JSONObject) array.get(0);
            int qrCodeType=jsonObject.getInt("qrCodeType");//0二维码条形码,1 二维码,2 条形码
            //this.mainCordovaActivity.qrCodeScan(callbackContext,qrCodeType);
        }else if(action.equals(PluginAction.ACTION_WX_AUTHORIZATION_LOGIN)){
            //微信登录
            this.mainCordovaActivity.WXLogin(callbackContext);
        }else if(action.equals(PluginAction.ACTION_SHARE_TO_THIRD_APP)){//第三方分享
            /*if(Looper.getMainLooper() != Looper.myLooper()){}*/
            new Handler(Looper.getMainLooper()).post(new Runnable() {
                @Override
                public void run() {
                    try {
                        JSONObject jsonObject= (JSONObject) array.get(0);
                        if(jsonObject.has("whatTypeShare")){
                            if(jsonObject.getString("whatTypeShare").equals("wx")){
                                if(jsonObject.getString("shareType").equals("url")){
                                    String title=jsonObject.getString("title");
                                    String content=jsonObject.getString("content");
                                    if(title==null){
                                        title="";
                                    }
                                    if(TextUtils.isEmpty(content)){
                                        content="";
                                    }
                                    String imgUrl= null;
                                    try {
                                        imgUrl = jsonObject.getString("imgurl");
                                    } catch (JSONException e) {
                                        e.printStackTrace();
                                    }
                                    WXShareUtil.ShareContentWebpage shareWeb=new WXShareUtil.ShareContentWebpage(title,content,jsonObject.getString("shareContent"), R.drawable.icon_app,imgUrl);
                                    //发给朋友 WXShareUtil.WEIXIN_SHARE_TYPE_TALK 分享到朋友圈 WEIXIN_SHARE_TYPE_FRENDS
                                    if(jsonObject.getString("whoToShare").equals("talk")){
                                        WXShareUtil.getInstance(activity).shareByWeixin(shareWeb,WXShareUtil.WEIXIN_SHARE_TYPE_TALK);
                                    }else if(jsonObject.getString("whoToShare").equals("friends")){
                                        WXShareUtil.getInstance(activity).shareByWeixin(shareWeb,WXShareUtil.WEIXIN_SHARE_TYPE_FRENDS);
                                    }
                                }else if(jsonObject.getString("shareType").equals("text")){
                                    WXShareUtil.ShareContentText shareText=new WXShareUtil.ShareContentText(jsonObject.getString("shareContent"));
                                    if(jsonObject.getString("whoToShare").equals("talk")){
                                        WXShareUtil.getInstance(activity).shareByWeixin(shareText,WXShareUtil.WEIXIN_SHARE_TYPE_TALK);
                                    }else if(jsonObject.getString("whoToShare").equals("friends")){
                                        WXShareUtil.getInstance(activity).shareByWeixin(shareText,WXShareUtil.WEIXIN_SHARE_TYPE_FRENDS);
                                    }
                                }else if(jsonObject.getString("shareType").equals("pic")){
                                    WXShareUtil.ShareContentPic sharePic;
                                    if(!jsonObject.getString("shareContent").isEmpty()){
                                        sharePic=new WXShareUtil.ShareContentPic(jsonObject.getString("shareContent"));
                                    }else {
                                        sharePic=new WXShareUtil.ShareContentPic(R.drawable.icon_app);
                                    }
                                    if(jsonObject.getString("whoToShare").equals("talk")){
                                        WXShareUtil.getInstance(activity).shareByWeixin(sharePic,WXShareUtil.WEIXIN_SHARE_TYPE_TALK);
                                    }else if(jsonObject.getString("whoToShare").equals("friends")){
                                        WXShareUtil.getInstance(activity).shareByWeixin(sharePic,WXShareUtil.WEIXIN_SHARE_TYPE_FRENDS);
                                    }
                                }

                            }
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }

                    //WXShareUtil.ShareContentWebpage shareText=new WXShareUtil.ShareContentWebpage("链接标题","分享内容","http://www.baidu.com",R.drawable.icon_app);
                    //发给朋友 WXShareUtil.WEIXIN_SHARE_TYPE_TALK 分享到朋友圈 WEIXIN_SHARE_TYPE_FRENDS
                    //WXShareUtil.getInstance(activity).shareByWeixin(shareWeb,WXShareUtil.WEIXIN_SHARE_TYPE_FRENDS);
                }
            });

        }else if(action.equals(PluginAction.ACTION_OPEN_NEAR_STORE_LIST)){
            Intent intent=new Intent(activity, NearStoreListActivity.class);
            activity.startActivity(intent);
        }else if(action.equals(PluginAction.ACTION_OPEN_CAMERA_TAKE_PHOTO)){
            //打开相机拍照
            this.mainCordovaActivity.tokePhotoByCamera(callbackContext,1);
        }else if(action.equals(PluginAction.ACTION_OPEN_PHOTO_TAKE_PHOTO)){
            //打开相册
            this.mainCordovaActivity.tokePhotoByCamera(callbackContext,2);
        }else if(action.equals(PluginAction.ACTION_ADDRESS_LOCATION)){
            JSONObject object= (JSONObject) array.get(0);
            boolean isAddressUseForHomePage=object.getBoolean("isAddressUseForHomePage");//作为是否在首页中使用的标记
            double latitude = 0;
            double longitude = 0;
            String cityCode=null;
            if(object.has("latln")){
                latitude=object.getDouble("latln");
            }
            if(object.has("lonln")){
                longitude=object.getDouble("lonln");
            }
            if(object.has("cityCode")){
                cityCode=object.getString("cityCode");
            }
            this.mainCordovaActivity.addressLocation(callbackContext,isAddressUseForHomePage,latitude,longitude,cityCode);
        }else if(action.equals(PluginAction.ACTION_BACK_PRESS)){
            this.mainCordovaActivity.mookKeyBack();
        }else if(action.equals(PluginAction.ACTION_LOCATION_CURRENT_POSITION)){
            this.mainCordovaActivity.startLocation(callbackContext);//启动高德地图定位
        }else if(action.equals(PluginAction.ACTION_OPEN_STORE_LOCATION)){
            JSONObject object= (JSONObject) array.get(0);
            double latitude=object.getDouble("latitude");
            double longitude=object.getDouble("longitude");
            Intent intent=new Intent(this.mainCordovaActivity, StoreLocationActivity.class);
            intent.putExtra(IntentParams.KEY_LATITUDE,latitude);
            intent.putExtra(IntentParams.KEY_LONGITUDE,longitude);
            this.mainCordovaActivity.startActivity(intent);
        }else if(action.equals(PluginAction.ACTION_SHOW_TIME_PICKER)){
            this.mainCordovaActivity.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    showTimePicker(callbackContext);
                }
            });
        }else if(action.equals(PluginAction.ACTION_CREDENTIALS_UPLOAD)){
            JSONObject object= (JSONObject) array.get(0);
            int uploadClickType=object.getInt("uploadClickType");
            String business_license_url="";
            String identity_positive_url="";
            String identity_native_url="";
            if(object.has("business_license_url")){
                business_license_url=object.getString("business_license_url");
            }
            if(object.has("identity_positive_url")){
                identity_positive_url=object.getString("identity_positive_url");
            }
            if(object.has("identity_native_url")){
                identity_native_url=object.getString("identity_native_url");
            }
            this.mainCordovaActivity.credentialsUpload(callbackContext,uploadClickType,business_license_url,identity_positive_url,identity_native_url);
        }else if(action.equals(PluginAction.ACTION_CHECK_APP_VERSION)){
            this.mainCordovaActivity.checkAppVersion(false);

        }else if(action.equals(PluginAction.ACTION_COPY_TO_CLIPBOARD)){
            //复制文本到剪切板
            JSONObject object= (JSONObject) array.get(0);
            final String content=object.getString("content");
            this.mainCordovaActivity.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    AppUtils.copy2clipboard(mainCordovaActivity,content);
                    Toast.makeText(mainCordovaActivity,"已经复制",Toast.LENGTH_SHORT).show();
                }
            });
        }else if(action.equals(PluginAction.ACTION_CLEAR_WEB_VIEW_CACHE)){
            this.mainCordovaActivity.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    appView.clearCache(true);
                    appView.clearFormData();
                    //appView.loadDataWithBaseURL(null, "","text/html", "utf-8",null);
                    /*boolean aa=mainCordovaActivity.deleteDatabase("webview.db");
                    boolean bb =mainCordovaActivity.deleteDatabase("webviewCache.db");*/

                    // 清除cookie即可彻底清除缓存
                    /*CookieSyncManager.createInstance(mainCordovaActivity);
                    CookieManager.getInstance().removeAllCookie();
                    CookieSyncManager.getInstance().startSync();
                    CookieManager.getInstance().removeSessionCookie();*/

                    Toast.makeText(mainCordovaActivity,"清除成功",Toast.LENGTH_SHORT).show();
                }
            });
        }

        return true;
    }
    //onActivityResult为第二个Activity执行完后的回调接收方法
    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent intent){
        switch (resultCode) { //resultCode为回传的标记，我在第二个Activity中回传的是RESULT_OK
            case Activity.RESULT_OK:
                Bundle b=intent.getExtras();  //data为第二个Activity中回传的Intent
                String str=b.getString("change01");//str即为回传的值
                break;
            default:
                break;
        }

    }

    /*private void showPhoneInputDialog(final CallbackContext callbackContext){
        final Dialog dialog = new Dialog(activity, R.style.AlertDialogStyle);
        LayoutInflater inflater = activity.getLayoutInflater();
        View view = inflater.inflate(R.layout.layout_dialog_phone,null);
        final EditText phoneNumber= (EditText) view.findViewById(R.id.phone_number);
        TextView clickToPhone= (TextView) view.findViewById(R.id.click_to_phone);
        ImageView disMissBtn= (ImageView) view.findViewById(R.id.dismiss);
        disMissBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(dialog!=null){
                    dialog.dismiss();
                }
            }
        });
        clickToPhone.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String phone=phoneNumber.getText().toString();
                if(isMobileNO(phone)){
                    PluginResult mPlugin = new PluginResult(PluginResult.Status.NO_RESULT);
                    mPlugin.setKeepCallback(true);
                    callbackContext.sendPluginResult(mPlugin);
                    callbackContext.success(phone);
                    if(dialog!=null){
                        dialog.dismiss();
                    }
                }
            }
        });
        dialog.setContentView(view);
        dialog.setCancelable(false);
        dialog.setCanceledOnTouchOutside(false);
        dialog.show();
        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                if(phoneNumber!=null){
                    //设置可获得焦点
                    phoneNumber.setFocusable(true);
                    phoneNumber.setFocusableInTouchMode(true);
                    //请求获得焦点
                    phoneNumber.requestFocus();
                    //调用系统输入法
                    InputMethodManager inputManager = (InputMethodManager) phoneNumber
                            .getContext().getSystemService(Context.INPUT_METHOD_SERVICE);
                    inputManager.showSoftInput(phoneNumber, 0);
                }
            }
        },300);

    }*/
    /**
     * 验证手机格式
     */
    public boolean isMobileNO(String mobiles) {
        String telRegex = "[1][358]\\d{9}";//"[1]"代表第1位为数字1，"[358]"代表第二位可以为3、5、8中的一个，"\\d{9}"代表后面是可以是0～9的数字，有9位。
        if (TextUtils.isEmpty(mobiles)) {
            Toast.makeText(activity,"请输入手机号码",Toast.LENGTH_SHORT).show();
        }else {
            if(mobiles.matches(telRegex)){
                return true;
            }else {
                Toast.makeText(activity,"输入手机号码格式错误",Toast.LENGTH_SHORT).show();
            }
        }
        return false;
    }

    private TimePickerView pvTime;
    private void showTimePicker(final CallbackContext callbackContext) {
        final Calendar c = Calendar.getInstance();
        c.setTimeZone(TimeZone.getTimeZone("GMT+8:00"));
        int currentYear = c.get(Calendar.YEAR);// 获取当前年份
        int currentMonth = c.get(Calendar.MONTH) + 1;// 获取当前月份

        //控制时间范围(如果不设置范围，则使用默认时间1900-2100年，此段代码可注释)
        //因为系统Calendar的月份是从0-11的,所以如果是调用Calendar的set方法来设置时间,月份的范围也要是从0-11
        Calendar selectedDate = Calendar.getInstance(TimeZone.getTimeZone("GMT+8:00"));
        Calendar startDate = Calendar.getInstance(TimeZone.getTimeZone("GMT+8:00"));
        startDate.set(currentYear-9, 1, 0);//往后推10年
        Calendar endDate = Calendar.getInstance(TimeZone.getTimeZone("GMT+8:00"));

        endDate.set(currentYear, currentMonth, 0);
        //时间选择器
        pvTime = new TimePickerView.Builder(this.mainCordovaActivity, new TimePickerView.OnTimeSelectListener() {
            @Override
            public void onTimeSelect(Date date, View v) {//选中事件回调
                long timeStamp = date.getTime();
                JSONObject object=new JSONObject();
                try {
                    object.put("timeStamp",timeStamp);
                    callbackContext.success(object.toString());
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        })
                //年月日时分秒 的显示与否，不设置则默认全部显示
                .setType(new boolean[]{true, true, false, false, false, false})
                .setLabel("年", "月", "", "", "", "")
                .setTitleText("选择月份")
                .setSubmitColor(Color.RED)
                .setCancelColor(Color.RED)
                .isCenterLabel(false)
                .setDividerColor(Color.RED)
                .setContentSize(21)
                .setDate(selectedDate)
                .setRangDate(startDate, endDate)
                /*.setLayoutRes(R.layout.pickerview_time, new CustomListener() {

                    @Override
                    public void customLayout(View v) {
                        final TextView tvSubmit = (TextView) v.findViewById(R.id.btnCancel);
                        TextView ivCancel = (TextView) v.findViewById(R.id.btnSubmit);
                        tvSubmit.setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View v) {
                                pvTime.returnData();
                                pvTime.dismiss();
                            }
                        });
                        ivCancel.setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View v) {
                                pvTime.dismiss();
                            }
                        });
                    }
                })*/
                .setBackgroundId(0x80000000) //设置外部遮罩颜色  80000000
                .build();
        pvTime.show();
    }

    //
    //
    /*private void createActionDialog(){
        List<ActionItem> list=new ArrayList<>();
        ActionItem item=new ActionItem();
        item.setItemName("确定");
        item.setItemType(1);
        list.add(item);
        new ActionSheetDialog(activity)
                .builder()
                .setTitle("确定要删除...吗")
                .setCancelable(true)
                .setCanceledOnTouchOutside(true)
                .setItemTextColor("#FA4A46")
                .showSelectIcon(false)
                .setOnSheetItemClickListener(new ActionSheetDialog.OnSheetItemClickListener() {
                    @Override
                    public void onItemClick(ActionItem data, int which) {
                        if(data.getItemType()==1){
                            //确定

                        }
                    }
                }).setSheetItems(list).show();
    }*/
}
