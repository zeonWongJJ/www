package com.app.base.netUtil;

import android.content.Intent;
import android.text.TextUtils;
import android.util.Log;

import com.androidnetworking.interceptors.HttpLoggingInterceptor;
import com.app.base.R;
import com.app.base.bean.BaseResponse;
import com.app.base.bean.MemberRealm;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.LoginUtil;
import com.common.lib.base.BaseApplication;
import com.common.lib.utils.APIException;
import com.common.lib.utils.ExceptionHandle;
import com.common.lib.utils.ToastUtils;
import com.google.gson.Gson;
import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import com.google.gson.JsonParseException;
import com.google.gson.JsonParser;
import com.rx2androidnetworking.Rx2AndroidNetworking;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import org.json.JSONTokener;

import java.io.IOException;
import java.net.ConnectException;
import java.nio.charset.Charset;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import io.reactivex.Observable;
import io.reactivex.ObservableSource;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;
import io.reactivex.functions.Consumer;
import io.reactivex.functions.Function;
import io.reactivex.observers.DisposableObserver;
import io.reactivex.schedulers.Schedulers;
import io.realm.Realm;
import okhttp3.Interceptor;
import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.Response;
import okhttp3.ResponseBody;
import okio.Buffer;
import okio.BufferedSource;

/**
 * 统一请求处理
 */

public class HttpUtil {
    private static HttpUtil util;
    public static HttpUtil getInstance(){
        if(util==null){
            util=new HttpUtil();
        }
        return util;
    }
    private Charset UTF8 = Charset.forName("UTF-8");
    private Gson gson = new Gson();
    HttpLoggingInterceptor loggingInterceptor = new HttpLoggingInterceptor(new HttpLoggingInterceptor.Logger() {
        @Override
        public void log(String message) {
            Log.i("RxJava", message);
        }
    });
    private Interceptor tokenInterceptor=new Interceptor() {
        @Override
        public Response intercept(Chain chain) throws IOException {
            Request request = chain.request();
            // try the request
            Response originalResponse = chain.proceed(request);
            ResponseBody responseBody = originalResponse.body();
            BufferedSource source = responseBody.source();
            source.request(Long.MAX_VALUE); // Buffer the entire body.
            Buffer buffer = source.buffer();
            Charset charset = UTF8;
            MediaType contentType = responseBody.contentType();
            if (contentType != null) {
                charset = contentType.charset(UTF8);
            }

            String bodyString = buffer.clone().readString(charset);
            if(isGoodJson(bodyString)){
                try {
                    JSONObject object=new JSONObject(bodyString);
                    if(object.getInt("error")==401){
                        MemberRealm.deleteAllAsync(new Realm.Transaction.OnSuccess() {
                            @Override
                            public void onSuccess() {

                            }
                        }, new Realm.Transaction.OnError() {
                            @Override
                            public void onError(Throwable error) {

                            }
                        });
                        Intent intent=new Intent("com.odp.qidu.activity.LoginActivity");
                        intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK|Intent.FLAG_ACTIVITY_CLEAR_TOP);
                        BaseApplication.getInstance().startActivity(intent);
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
            return originalResponse;
        }
    };

    /*针对php没有数据的时候 data返回"" */
    /*区分list 和object主要是解决rxjava中使用map 不能返回null的问题The mapper function returned a null value.*/
    /* T 只能是list*/
    public <T> Observable<T> postList(String url, Map<String, String> map,final Class clazz){
        //post(url,map).compose(new JsonParesTransformer(MemberRealm.class));
        return post(url,map).map(new Function<String, T>() {
            @Override
            public T apply(String response) throws Exception {
                Log.i("response---",response);
                JsonElement json =new JsonParser().parse(response);
                if (json.isJsonObject()) {
                    T t;
                    if(clazz==String.class){
                        t= (T) new String();
                    }else {
                        t=(T) new ArrayList<>();
                    }
                    JsonObject asJsonObject = json.getAsJsonObject();
                    JsonElement data = asJsonObject.get("data");
                    JsonElement code = asJsonObject.get("error");
                    JsonElement msg = asJsonObject.get("msg");
                    /*baseResponse.setError(code.getAsInt());
                    baseResponse.setMsg(msg.getAsString() == null ? "" : msg.getAsString());*/
                    if(code.getAsInt()==BaseResponse.STATUS_SUCCESS){
                        if (data != null) {
                            if (data.isJsonObject()) {
                                String s = gson.toJson(data);
                                t=(T)GsonUtil.getObject(s,clazz);
                            }else if(data.isJsonArray()){
                                String s = gson.toJson(data);
                                t=(T)GsonUtil.getObjectList(s,clazz);
                            }/*else if (data.isJsonNull()&&clazz!=String.class) {
                                return t;
                            }*/else if(clazz==String.class){
                                t= (T) data.getAsString();
                            }
                        }
                        return t;
                    }
                    throw new APIException(code.getAsInt(),msg.getAsString());
                }
                return null;
            }
        }).onErrorResumeNext(new Function<Throwable, ObservableSource<? extends T>>() {
            @Override
            public ObservableSource<? extends T> apply(Throwable throwable) throws Exception {
                return Observable.error(ExceptionHandle.handleException(throwable));
            }
        });
    }
    /* T 只能是object*/
    public <T> Observable<T> postObject(String url, Map<String, String> map,final Class clazz){
        return post(url,map).map(new Function<String, T>() {
            @Override
            public T apply(String response) throws Exception {
                Log.i("response---",response);
                JsonElement json =new JsonParser().parse(response);
                if (json.isJsonObject()) {
                    T t;
                    if(clazz==String.class){
                        t= (T) new String();
                    }else {
                        t= (T) new Object();
                    }
                    JsonObject asJsonObject = json.getAsJsonObject();
                    JsonElement data = asJsonObject.get("data");
                    JsonElement code = asJsonObject.get("error");
                    JsonElement msg = asJsonObject.get("msg");
                    /*baseResponse.setError(code.getAsInt());
                    baseResponse.setMsg(msg.getAsString() == null ? "" : msg.getAsString());*/
                    if(code.getAsInt()==BaseResponse.STATUS_SUCCESS){
                        if (data != null) {
                            if (data.isJsonObject()) {
                                String s = gson.toJson(data);
                                t=(T)GsonUtil.getObject(s,clazz);
                            }else if(data.isJsonArray()){
                                String s = gson.toJson(data);
                                t=(T)GsonUtil.getObjectList(s,clazz);
                            }/*else if (data.isJsonNull()&&clazz!=String.class) {
                                return t;
                            }*/else if(clazz==String.class){
                                t= (T) data.getAsString();
                            }
                        }
                        return t;
                    }
                    throw new APIException(code.getAsInt(),msg.getAsString());
                }
                return null;
            }
        }).onErrorResumeNext(new Function<Throwable, ObservableSource<? extends T>>() {
            @Override
            public ObservableSource<? extends T> apply(Throwable throwable) throws Exception {
                return Observable.error(ExceptionHandle.handleException(throwable));
            }
        });
    }
    //保留链式调用
    public <T> Observable<T> post(String url, Map<String, String> map,final Class clazz){
        return post(url,map).map(new Function<String, T>() {
            @Override
            public T apply(String response) throws Exception {
                Log.i("response---",response);
                JsonElement json =new JsonParser().parse(response);
                if (json.isJsonObject()) {
                    JsonObject asJsonObject = json.getAsJsonObject();
                    JsonElement data = asJsonObject.get("data");
                    JsonElement code = asJsonObject.get("error");
                    JsonElement msg = asJsonObject.get("msg");
                    /*baseResponse.setError(code.getAsInt());
                    baseResponse.setMsg(msg.getAsString() == null ? "" : msg.getAsString());*/
                    if(code.getAsInt()==BaseResponse.STATUS_SUCCESS){
                        T t=null;
                        if (data != null) {
                            if (data.isJsonObject()) {
                                String s = gson.toJson(data);
                                t=(T)GsonUtil.getObject(s,clazz);
                            }else if(data.isJsonArray()){
                                String s = gson.toJson(data);
                                t=(T)GsonUtil.getObjectList(s,clazz);
                            }/*else if (data.isJsonNull()&&clazz!=String.class) {

                            }*/else if(clazz==String.class){
                                t= (T) data.getAsString();
                            }
                        }
                        return t;
                    }
                    throw new APIException(code.getAsInt(),msg.getAsString());
                }
                return null;
            }
        }).onErrorResumeNext(new Function<Throwable, ObservableSource<? extends T>>() {
            @Override
            public ObservableSource<? extends T> apply(Throwable throwable) throws Exception {
                return Observable.error(ExceptionHandle.handleException(throwable));
            }
        });
    }

    public Observable<String> post(String url, Map<String, String> map){
        //Log.i("http---isLogin",LoginUtil.getInstance().isLogin()+"===="+LoginUtil.getInstance().getLoginUser().getToken());
        Log.i("url---",url+"");
        String token="";
        if(LoginUtil.getInstance().getLoginUser()!=null){
            Log.i("token---",LoginUtil.getInstance().getLoginUser().getToken()+"");
            token=LoginUtil.getInstance().getLoginUser().getToken();
            map.put("token",token);
        }
        Observable<String> observable=Rx2AndroidNetworking.post(url)
                .addHeaders("x-token",token)
                .addBodyParameter(map)
                .setOkHttpClient(okHttpClient)
                .build()
                .getStringObservable();
        return observable;
    }
    private OkHttpClient okHttpClient = new OkHttpClient().newBuilder()
            .addInterceptor(tokenInterceptor)
            .addNetworkInterceptor(loggingInterceptor)
            .build();
    public <T> Disposable post(String url, Map<String, String> map, DisposableObserver<T> observer, final Class clazz){
        Disposable disposable=post(url,map).flatMap(new Function<String, ObservableSource<T>>() {
                    @Override
                    public ObservableSource<T> apply(String response) throws Exception {
                        if(response==null){
                            return Observable.error(new Throwable(BaseApplication.getInstance().getString(R.string.default_http_error)));
                        }
                        if(!isGoodJson(response)){
                            return Observable.error(new Throwable(BaseApplication.getInstance().getString(R.string.http_connect_error)));
                        }
                        Log.i("response---",response);

                        JSONObject jsonObject =new JSONObject(response);
                        if(jsonObject.getInt("error")==BaseResponse.STATUS_SUCCESS){
                            if(!jsonObject.has("data")){
                                if(jsonObject.has("msg")){
                                    return Observable.just((T)jsonObject.getString("msg"));
                                }
                                return Observable.empty();
                            }
                            if(clazz==String.class&&TextUtils.isEmpty(jsonObject.getString("data"))){//处理php返回 data为空的情况
                                //T t = null;
                                return Observable.just((T)jsonObject.getString("msg"));
                            }else if(clazz==String.class){
                                return Observable.just((T)jsonObject.getString("data"));
                            }
                            Object listArray = new JSONTokener(jsonObject.getString("data")).nextValue();
                            if (listArray instanceof JSONArray&&clazz!=String.class){
                                return Observable.just((T) GsonUtil.getObjectList(jsonObject.getString("data"),clazz));
                            }else if (listArray instanceof JSONObject&&clazz!=String.class) {
                                return Observable.just((T)GsonUtil.getObject(jsonObject.getString("data"),clazz));
                            }else {
                                return Observable.empty();
                            }
                        }if(jsonObject.getInt("error")==BaseResponse.STATUS_LOGIN_TIMEOUT){
                            APIException apiException=new APIException(jsonObject.getInt("error"),"token过期,请重新登录");
                            throw apiException;
                            //return Observable.error(new Throwable("token过期,请重新登录"));
                        }
                        return Observable.error(new Throwable(jsonObject.getString("msg")));
                    }
                })
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribeWith(observer);
        return disposable;
    }


    public static boolean isGoodJson(String json) {
        try {
            new JsonParser().parse(json);
            return true;
        } catch (JsonParseException e) {
            System.out.println("bad json: " + json);
            return false;
        }
    }
}
