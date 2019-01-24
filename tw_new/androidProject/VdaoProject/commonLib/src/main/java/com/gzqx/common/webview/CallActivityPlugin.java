package com.gzqx.common.webview;

import android.app.Activity;
import android.app.Fragment;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.webkit.WebResourceResponse;
import android.widget.Toast;

import com.gzqx.common.utils.IntentParams;

import org.apache.cordova.CordovaWebView;
import org.apache.cordova.api.CallbackContext;
import org.apache.cordova.api.CordovaInterface;
import org.apache.cordova.api.CordovaPlugin;
import org.apache.cordova.api.PluginResult;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

/**
 * Created by Administrator on 2017/5/12.
 */

public class CallActivityPlugin extends CordovaPlugin {

    private String TAG=this.getClass().getSimpleName();

    public Activity activity;
    public CordovaWebView appView;
    @Override
    public void initialize(CordovaInterface cordova, CordovaWebView webView) {
        super.initialize(cordova, webView);
        /*if (cordova instanceof Activity) {
            this.activity = (Activity) cordova;
        }else if(cordova.getActivity() instanceof Activity){//fragment的时候
            this.activity=cordova.getActivity();
        }*/
        if(cordova.getActivity() instanceof Activity){//fragment的时候
            this.activity=cordova.getActivity();
            this.appView=webView;
        }
    }
    @Override
    public void onDestroy() {
        super.onDestroy();
    }

    @Override
    public boolean execute(String action, JSONArray array, CallbackContext callbackContext) throws JSONException {
        Log.i(TAG,"action:"+action);
        Log.i(TAG,"js返回内容"+array.toString());
        if(action.equals(PluginAction.ACTION_OPEN_NEW_WINDOW)) {
            JSONObject object= (JSONObject) array.get(0);
            String url=object.getString("url");
            Intent intent=new Intent(activity,MainCordovaActivity.class);
            intent.putExtra(IntentParams.KEY_LOAD_URL,url);
            this.activity.startActivity(intent);
        }else if (action.equals(PluginAction.ACTION)) {
            try {
                //下面两句最关键，利用intent启动新的Activity
                /*Intent intent = new Intent().setClass(cordova.getActivity(), Class.forName(array.getString(0)));
                this.cordova.startActivityForResult(this, intent, 1);*/
                //下面三句为cordova插件回调页面的逻辑代码
                //如果直接反复去调用mCallbackContext.success(“device：”+name);或者mCallbackContext.error(“失败”);会报错。
                ///用下面的方法可以反复通知js层，使得js层获得信息
                //PluginResult pluginResult = new PluginResult(PluginResult.Status.OK,"中间消息");
                PluginResult mPlugin = new PluginResult(PluginResult.Status.NO_RESULT);
                mPlugin.setKeepCallback(true);

                callbackContext.sendPluginResult(mPlugin);
                callbackContext.success("success=====");

            } catch (Exception e) {
                e.printStackTrace();
                return false;
            }
        }else if(action.equals(PluginAction.ACTION_LOGIN)){
            Toast.makeText(this.activity,action,Toast.LENGTH_SHORT).show();
            try {
                JSONObject object= (JSONObject) array.get(0);
                Toast.makeText(this.activity,object.getString("nickName"),Toast.LENGTH_SHORT).show();
                PluginResult mPlugin = new PluginResult(PluginResult.Status.NO_RESULT);
                mPlugin.setKeepCallback(true);
                callbackContext.sendPluginResult(mPlugin);
                callbackContext.success("草泥马");
            } catch (JSONException e) {
                e.printStackTrace();
                return false;
            }

        }else if(action.equals(PluginAction.ACTION_FINISH_ACTIVITY)){
            this.activity.finish();
        }/*else if(action.equals(PluginAction.ACTION_BACK_PRESS)){

        }*/else if(action.equals(PluginAction.LOGIN_OUT)){

        }else if(action.equals(PluginAction.ACTION_PUT_DATA_FOR_LAST_PAGE)){
            JSONObject object= (JSONObject) array.get(0);
            Intent intent=new Intent();
            intent.putExtra("test",object.toString());
            this.activity.setResult(Activity.RESULT_OK,intent);
            this.activity.finish();
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
}
