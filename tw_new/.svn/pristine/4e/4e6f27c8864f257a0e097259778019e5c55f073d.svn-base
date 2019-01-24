package com.app.base.httpUtil;


import android.app.Activity;
import android.content.Context;
import android.util.Log;

import com.androidnetworking.AndroidNetworking;
import com.androidnetworking.common.Priority;
import com.androidnetworking.error.ANError;
import com.androidnetworking.interfaces.JSONObjectRequestListener;
import com.app.base.bean.AppInfo;
import com.app.base.utils.HttpUrl;
import com.google.gson.Gson;

import org.json.JSONException;
import org.json.JSONObject;

public class HttpUtil {

    private static HttpUtil util;
    public static HttpUtil getInstance(){
        if(util==null){
            util=new HttpUtil();
        }
        return util;
    }


    public void checkVersion(final Activity context){
        AndroidNetworking.get(HttpUrl.api_version_check)
                .setTag("checkVersion")
                .setPriority(Priority.LOW)
                .build()
                .getAsJSONObject(new JSONObjectRequestListener() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            if(response!=null){
                                Log.i("response",response.toString());
                                int code=response.getInt("code");
                                if(code==200){
                                    Gson gson=new Gson();
                                    AppInfo appInfo=gson.fromJson(response.getString("data"),AppInfo.class);
                                    VersionUpdateUtil.getInstance(context).updateVersion(appInfo);
                                }
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                            Log.i("aaaaaaa",e.getMessage());
                        }
                    }
                    @Override
                    public void onError(ANError anError) {

                    }
                });
    }
}
