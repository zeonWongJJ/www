package com.printer.receipt.webview;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.widget.Toast;

import com.printer.receipt.CashHomeActivity;
import com.printer.receipt.utils.CommonKey;
import com.printer.receipt.utils.IntentParams;
import com.printer.receipt.utils.SharedPreferencesUtils;

import org.apache.cordova.CordovaWebView;
import org.apache.cordova.api.CallbackContext;
import org.apache.cordova.api.CordovaInterface;
import org.apache.cordova.api.CordovaPlugin;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;


public class MainCordovaActivityPlugin extends CordovaPlugin {

    private String TAG=this.getClass().getSimpleName();
    public Activity activity;
    private CashHomeActivity mainCordovaActivity;
    public CordovaWebView appView;
    @Override
    public void initialize(CordovaInterface cordova, CordovaWebView webView) {
        super.initialize(cordova, webView);

        if(cordova.getActivity() instanceof Activity){
            this.activity= cordova.getActivity();
            this.appView=webView;
        }
        if(cordova.getActivity() instanceof CashHomeActivity){
            this.mainCordovaActivity= (CashHomeActivity) cordova.getActivity();
            this.appView=webView;
        }
    }
    @Override
    public void onDestroy() {
        super.onDestroy();
    }

    @Override
    public boolean execute(String action,final JSONArray array, CallbackContext callbackContext) throws JSONException {
        Log.i(TAG,"action:"+action);
        Log.i(TAG,"js返回内容"+array.toString());

        if(action.equals(PluginAction.ACTION_CREATE_NEW_WINDOW)) {
            this.activity.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    try {
                        JSONObject object= (JSONObject) array.get(0);
                        String url=object.getString("url");
                        Intent intent=new Intent(activity,MainCordovaActivity.class);
                        activity.startActivity(intent);
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            });
        }else if (action.equals(PluginAction.ACTION_PRINT_CONTEXT_LINE_BAR_CODE_BY_THERMOSENSITIVE_DRY_GLUE_MACHINE)) {
            this.activity.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    //热敏干胶机打印 打印文本，直线，条码
                    //Toast.makeText(activity,"点击了",Toast.LENGTH_SHORT).show();
                    mainCordovaActivity.printContextLineBarCodeByThermosensitiveDryGlueMachine(IntentParams.TYPE_CONTEXT_LINE_BAR_CODE);
                }
            });
        }else if(action.equals(PluginAction.ACTION_PRINT_CONTEXT_BY_THERMOSENSITIVE_DRY_GLUE_MACHINE)){
            mainCordovaActivity.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    //Toast.makeText(activity,"热敏打印标签",Toast.LENGTH_SHORT).show();
                    JSONObject object= null;
                    try {
                        object = (JSONObject) array.get(0);
                        //Toast.makeText(activity,""+object.toString(),Toast.LENGTH_SHORT).show();
                        /*此策略主要是为了使得热敏不干胶机打印的序列号和小票机序列号保持一致
                        int seriesNumber=(Integer) SharedPreferencesUtils.getInstance(activity).getData(CommonKey.LAST_SERIES_NUMBER,100);
                        SharedPreferencesUtils.getInstance(mainCordovaActivity).saveData(CommonKey.LAST_SERIES_NUMBER_HOT_MACHINE,seriesNumber);*/
                        //打印热敏干胶机纯文本标签
                        mainCordovaActivity.printContextByThermosensitiveDryGlueMachine(IntentParams.TYPE_CONTEXT_LABEL,object);
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            });
        }else if(action.equals(PluginAction.ACTION_PRINT_BARCODE_BY_THERMOSENSITIVE_DRY_GLUE_MACHINE)){
            mainCordovaActivity.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    //打印热敏干胶机纯条形码
                    mainCordovaActivity.printBarcodeByThermosensitiveDryGlueMachine(IntentParams.TYPE_PRINT_BAR_CODE);
                }
            });
        }else if (action.equals(PluginAction.ACTION_LOAD_VICE_SCREEN_PAGE_BY_URL)) {//加载副屏

            mainCordovaActivity.runOnUiThread(new Runnable() {
                @Override
                public void run() {

                    String url= null;
                    try {
                        JSONObject object= (JSONObject) array.get(0);
                        //Toast.makeText(mainCordovaActivity,"副屏"+object.toString(),Toast.LENGTH_SHORT).show();
                        url = object.getString("url");
                        mainCordovaActivity.loadViceScreenPageByUrl(url);
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            });
        }else if(action.equals(PluginAction.ACTION_PRINT_TEXT_BY_SMALL_PAPER_MONEY_MACHINE)){
            mainCordovaActivity.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    //Toast.makeText(activity,"小票机文本打印",Toast.LENGTH_SHORT).show();
                    JSONObject object= null;
                    try {
                        object = (JSONObject) array.get(0);
                        /*此策略主要是为了使得热敏不干胶机打印的序列号和小票机序列号保持一致
                        int seriesNumber=(Integer) SharedPreferencesUtils.getInstance(activity).getData(CommonKey.LAST_SERIES_NUMBER,100);
                        SharedPreferencesUtils.getInstance(mainCordovaActivity).saveData(CommonKey.LAST_SERIES_NUMBER_HOT_MACHINE,seriesNumber);*/
                        //小票机文本打印
                        mainCordovaActivity.printTextBySmallPaperMoneyMachine(object);
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            });
        }else if(action.equals(PluginAction.ACTION_PRINT_LABEL_TEXT_BY_SMALL_PAPER_MONEY_MACHINE)){
            mainCordovaActivity.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    //小票机打印可以设置大小的字体文本标签
                    mainCordovaActivity.printLabelTextBySmallPaperMoneyMachine();
                }
            });
        }else if(action.equals(PluginAction.ACTION_OPEN_CASH_MACHINE)){
            mainCordovaActivity.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    //Toast.makeText(activity,"打开钱箱",Toast.LENGTH_SHORT).show();
                    mainCordovaActivity.openCashBoxMachine();
                }
            });

        }else if(action.equals(PluginAction.ACTION_EXIT_APP)){
            mainCordovaActivity.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    mainCordovaActivity.finish();
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

}
