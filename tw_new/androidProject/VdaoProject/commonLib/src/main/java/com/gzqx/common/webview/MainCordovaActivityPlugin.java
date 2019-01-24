package com.gzqx.common.webview;

import android.app.Activity;
import android.app.Dialog;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.gzqx.com.gzqx.org.common.R;
import com.gzqx.common.bean.ActionItem;
import com.gzqx.common.utils.IntentParams;

import org.apache.cordova.CordovaWebView;
import org.apache.cordova.api.CallbackContext;
import org.apache.cordova.api.CordovaInterface;
import org.apache.cordova.api.CordovaPlugin;
import org.apache.cordova.api.PluginResult;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;


public class MainCordovaActivityPlugin extends CordovaPlugin {

    private String TAG=this.getClass().getSimpleName();
    public Activity activity;
    private MainCordovaActivity mainCordovaActivity;
    public CordovaWebView appView;
    @Override
    public void initialize(CordovaInterface cordova, CordovaWebView webView) {
        super.initialize(cordova, webView);

        if(cordova.getActivity() instanceof Activity){
            this.activity= cordova.getActivity();
            this.appView=webView;
        }
        /*if(cordova.getActivity() instanceof MainCordovaActivity){
            this.mainCordovaActivity= (MainCordovaActivity) cordova.getActivity();
            this.appView=webView;
        }*/
    }
    @Override
    public void onDestroy() {
        super.onDestroy();
    }

    @Override
    public boolean execute(String action, JSONArray array, CallbackContext callbackContext) throws JSONException {
        Log.i(TAG,"action:"+action);
        Log.i(TAG,"js返回内容"+array.toString());

        if(action.equals(PluginAction.ACTION_CREATE_NEW_WINDOW)) {
            JSONObject object= (JSONObject) array.get(0);
            String url=object.getString("url");
            Intent intent=new Intent(activity,MainCordovaActivity.class);
            intent.putExtra(IntentParams.KEY_LOAD_URL,url);
            this.activity.startActivity(intent);
        }else if (action.equals(PluginAction.ACTION_SHOW_PHONE_INPUT_EDIT)) {

            try {
                if(this.activity!=null){
                    showPhoneInputDialog(callbackContext);
                    return true;
                }
            } catch (Exception e) {
                e.printStackTrace();
                return false;
            }
        }else if(action.equals(PluginAction.ACTION_LOGIN)){//登陆成功
            //Toast.makeText(this.activity,action,Toast.LENGTH_SHORT).show();

        }else if(action.equals(PluginAction.ACTION_TAKE_LOCAL_USER_LIST)) {
            //返回账号信息给js
            /*List<User> userList=User.getUserList();

            if(userList.size()>0){

                JSONArray jsonArray=new JSONArray();
                for(int i=0;i<userList.size();i++){
                    //Gson gson=new Gson();
                    //String str=gson.toJson()
                    JSONObject object=new JSONObject();
                    object.put("memberId",userList.get(i).getUserId());
                    object.put("equipmentId",userList.get(i).getEquipmentId());
                    object.put("memberName",userList.get(i).getUserName());
                    jsonArray.put(object);
                }

                PluginResult mPlugin = new PluginResult(PluginResult.Status.NO_RESULT);
                mPlugin.setKeepCallback(true);
                callbackContext.sendPluginResult(mPlugin);
                callbackContext.success(jsonArray.toString());
            }else {
                callbackContext.success("");
            }*/
        }else if(action.equals(PluginAction.ACTION_FINISH_ACTIVITY)){
            this.activity.finish();
        }/*else if(action.equals(PluginAction.ACTION_BACK_PRESS)){

        }*/else if(action.equals(PluginAction.LOGIN_OUT)){

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
        }else if(action.equals(PluginAction.ACTION_GET_GENERATE_DEVICE_UNIQUE_ID)){
            /*boolean isExistInLocalUser=User.isExistDeviceId();//判断本地存储的账号中是否存在设备id
            if(isExistInLocalUser){
                callbackContext.success("");//这里用为空表示存在
            }else {
                String deviceId = AppUtils.generateDeviceUniqueId();//参数名id_equipment
                PluginResult mPlugin = new PluginResult(PluginResult.Status.NO_RESULT);
                mPlugin.setKeepCallback(true);
                callbackContext.sendPluginResult(mPlugin);
                callbackContext.success(deviceId);
            }*/
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


    private void showPhoneInputDialog(final CallbackContext callbackContext){
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

    }
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


    private void createActionDialog(){
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
    }
}
