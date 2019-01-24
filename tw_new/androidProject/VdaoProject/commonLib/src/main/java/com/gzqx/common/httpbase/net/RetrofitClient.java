package com.gzqx.common.httpbase.net;

import android.content.Context;
import android.text.TextUtils;
import android.util.Log;

import com.gzqx.common.base.BaseApplication;
import com.gzqx.common.bean.AppInfo;
import com.gzqx.common.bean.IpResult;
import com.gzqx.common.bean.Store;
import com.gzqx.common.datautil.AppGlobal;
import com.gzqx.common.datautil.SharedPreferencesUtils;
import com.gzqx.common.sysutil.AppUtils;
import com.gzqx.common.utils.CommonKey;

import java.io.File;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.concurrent.TimeUnit;

import io.reactivex.Observable;
import io.reactivex.ObservableSource;
import io.reactivex.ObservableTransformer;
import io.reactivex.Observer;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;
import io.reactivex.functions.Function;
import io.reactivex.observers.DisposableObserver;
import io.reactivex.schedulers.Schedulers;
import okhttp3.Cache;
import okhttp3.ConnectionPool;
import okhttp3.OkHttpClient;
import okhttp3.RequestBody;
import okhttp3.ResponseBody;
import okhttp3.logging.HttpLoggingInterceptor;
import retrofit2.Retrofit;
import retrofit2.adapter.rxjava2.RxJava2CallAdapterFactory;
import retrofit2.converter.gson.GsonConverterFactory;

/**
 * {@link # https://github.com/NeglectedByBoss/RetrofitClient}
 */
public class RetrofitClient {
    private static boolean isHttps=false;
    private static final int DEFAULT_TIMEOUT = 20;
    private BaseApiService apiService;
    private static OkHttpClient okHttpClient;
    public static String baseUrl = BaseApiService.Base_URL;
    private static Context mContext;

    private static Retrofit retrofit;
    private Cache cache = null;
    private File httpCacheDirectory;



    private static Retrofit.Builder builder =
            new Retrofit.Builder()
                    .addConverterFactory(GsonConverterFactory.create())
                    .addCallAdapterFactory(RxJava2CallAdapterFactory.create())
                    .baseUrl(baseUrl);
    private static OkHttpClient.Builder httpClient =
            new OkHttpClient.Builder()
                    .addNetworkInterceptor(
                            new HttpLoggingInterceptor().setLevel(HttpLoggingInterceptor.Level.BODY))
                    .connectTimeout(DEFAULT_TIMEOUT, TimeUnit.SECONDS);


    private static class SingletonHolder {
        private static RetrofitClient INSTANCE = new RetrofitClient(
                mContext);
    }

    public static RetrofitClient getInstance(Context context) {
        if (context != null) {
            mContext = context;
        }
        return SingletonHolder.INSTANCE;
    }

    public static RetrofitClient getInstance(Context context, String url) {
        if (context != null) {
            mContext = context;
        }

        return new RetrofitClient(context, url);
    }

    public static RetrofitClient getInstance(Context context, String url, Map<String, String> headers) {
        if (context != null) {
            mContext = context;
        }
        return new RetrofitClient(context, url, headers);
    }

   private RetrofitClient() {

   }

    private RetrofitClient(Context context) {

        this(context, baseUrl, builderDefaultHeader());
    }

    private RetrofitClient(Context context, String url) {

        this(context, url, builderDefaultHeader());
    }

    private RetrofitClient(Context context, String url, Map<String, String> headers) {

        if (TextUtils.isEmpty(url)) {
            url = baseUrl;
        }

        if ( httpCacheDirectory == null) {
            httpCacheDirectory = new File(AppGlobal.HTTP_DATA_CACHE);
            if (!httpCacheDirectory.exists()) {
                httpCacheDirectory.mkdirs();
            }
        }
        try {
            if (cache == null) {
                cache = new Cache(httpCacheDirectory, 10 * 1024 * 1024);
            }
        } catch (Exception e) {
            Log.e("OKHttp", "Could not create http cache", e);
        }
        okHttpClient = new OkHttpClient.Builder()
                .addNetworkInterceptor(
                        new HttpLoggingInterceptor().setLevel(HttpLoggingInterceptor.Level.BODY))
                .cookieJar(new NovateCookieManger(context))
                .cache(cache)
                .addInterceptor(new BaseInterceptor(headers))
                .addInterceptor(new CaheInterceptor(context))
                .addNetworkInterceptor(new CaheInterceptor(context))
                .connectTimeout(DEFAULT_TIMEOUT, TimeUnit.SECONDS)
                .writeTimeout(DEFAULT_TIMEOUT, TimeUnit.SECONDS)
                .connectionPool(new ConnectionPool(8, 15, TimeUnit.SECONDS))
                // 这里你可以根据自己的机型设置同时连接的个数和时间，我这里8个，和每个保持时间为10s
                .build();
        /*if(isHttps){
            okHttpClient.socketFactory(HttpsKeyStoreUtil.getSSLSocketFactory(context, certificates));
            okHttpClient.hostnameVerifier(HttpsKeyStoreUtil.getHostnameVerifier(hosts));
        }*/
        retrofit = new Retrofit.Builder()
                .client(okHttpClient)
                .addConverterFactory(GsonConverterFactory.create())
                .addCallAdapterFactory(RxJava2CallAdapterFactory.create())
                .baseUrl(url)
                .build();

    }

    public static Map<String, String> builderDefaultHeader(){
        double latitude= (double) SharedPreferencesUtils.getInstance().getData(CommonKey.KEY_LATITUDE,0.00000d);
        double longitude= (double) SharedPreferencesUtils.getInstance().getData(CommonKey.KEY_LONGITUDE,0.00000d);
        Map<String, String> headerValue=new HashMap<>();
        headerValue.put("versionNum", AppUtils.getAppVersionCode(BaseApplication.getInstance())+"");

        if(latitude!=0.00000d&&longitude!=0.00000d) {
            headerValue.put("longitude", latitude+"");
            headerValue.put("latitude", longitude+"");
        }
        return headerValue;

    }
    /**
     * ApiBaseUrl
     *
     * @param newApiBaseUrl
     */
    public static void changeApiBaseUrl(String newApiBaseUrl) {
        baseUrl = newApiBaseUrl;
        builder = new Retrofit.Builder()
                .addConverterFactory(GsonConverterFactory.create())
                .baseUrl(baseUrl);
    }

    /**
     *addcookieJar
     */
    public static void addCookie() {
        okHttpClient.newBuilder().cookieJar(new NovateCookieManger(mContext)).build();
        retrofit = builder.client(okHttpClient).build();
    }

    /**
     * ApiBaseUrl
     *
     * @param newApiHeaders
     */
    public static void changeApiHeader(Map<String, String> newApiHeaders) {

        okHttpClient.newBuilder().addInterceptor(new BaseInterceptor(newApiHeaders)).build();
        builder.client(httpClient.build()).build();
    }

    /**
     * create BaseApi  defalte ApiManager
     * @return ApiManager
     */
    public RetrofitClient createBaseApi() {
        apiService = create(BaseApiService.class);
        return this;
    }

    /**
     * create you ApiService
     * Create an implementation of the API endpoints defined by the {@code com.gzqx.org.service} interface.
     */
    public  <T> T create(final Class<T> service) {
        if (service == null) {
            throw new RuntimeException("Api com.gzqx.org.service is null!");
        }
        return retrofit.create(service);
    }


    public void getData(DisposableObserver<IpResult> subscriber, String ip) {
        apiService.getData(ip)
                .compose(schedulersTransformer())
                .compose(transformer())
                .subscribe(subscriber);
    }
    public  Disposable get(String url, Map parameters, DisposableObserver<List<Store>> observer) {

        return (Disposable) apiService.executeGet(url, parameters)
                .compose(schedulersTransformer())
                .compose(transformer())
                .subscribeWith(observer);
    }

    public  Disposable getAppInfo(String url, Map parameters, DisposableObserver<AppInfo> observer) {
        return (Disposable) apiService.executeGetAppInfo(url, parameters)
                .compose(schedulersTransformer())
                .compose(transformer())
                .subscribeWith(observer);
    }



    public  Disposable getForWX(String url, Map parameters, DisposableObserver<ResponseBody> observer) {

        return (Disposable) apiService.executeGet(url, parameters)
                .compose(schedulersTransformer())
                .compose(transformer())
                .subscribeWith(observer);
    }

    public Disposable post(String url, Map<String, String> parameters, DisposableObserver<ResponseBody> observer) {
        return (Disposable)apiService.executePost(url, parameters)
                .compose(schedulersTransformer())
                .compose(transformer())
                .subscribeWith(observer);
    }

    public Disposable json(String url, RequestBody jsonStr, DisposableObserver<BaseResponse> observer) {

        return (Disposable)apiService.json(url, jsonStr)
                .compose(schedulersTransformer())
                .compose(transformer())
                .subscribeWith(observer);
    }

    public Disposable upload(String url, RequestBody requestBody, DisposableObserver<ResponseBody> observer) {
        return (Disposable)apiService.upLoadFile(url, requestBody)
                .compose(schedulersTransformer())
                .compose(transformer())
                .subscribeWith(observer);
    }

    public Disposable uploads(String url, Map<String, String> headers,String description,Map<String, RequestBody> requestBodys, DisposableObserver<BaseResponse> observer) {
        return (Disposable)apiService.uploadFiles(url,description, requestBodys)
                .compose(schedulersTransformer())
                .compose(transformer())
                .subscribeWith(observer);
    }

    public Disposable download(String url, final CallBack callBack) {
        return (Disposable)apiService.downloadFile(url)
                .compose(schedulersTransformer())
                //.compose(transformer())
                .subscribeWith(new DownSubscriber<ResponseBody>(callBack));
    }

    ObservableTransformer schedulersTransformer() {
        return new ObservableTransformer() {

            @Override
            public ObservableSource apply(Observable upstream) {
                return upstream.subscribeOn(Schedulers.io())
                        .unsubscribeOn(Schedulers.io())
                        .observeOn(AndroidSchedulers.mainThread());
            }
        };
    }


    <T> ObservableTransformer<T, T> applySchedulers() {
        return (ObservableTransformer<T, T>) schedulersTransformer();
    }

    public <T> ObservableTransformer<BaseResponse<T>, T> transformer() {

        return new ObservableTransformer() {

            @Override
            public ObservableSource apply(Observable upstream) {
                return ((Observable) upstream).map(new HandleFuc<T>()).onErrorResumeNext(new HttpResponseFunc<T>());
            }

        };
    }

    public <T> Observable<T> switchSchedulers(Observable<T> observable) {
        return observable.subscribeOn(Schedulers.io())
                .unsubscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread());
    }

    private static class HttpResponseFunc<T> implements Function<Throwable, Observable<T>> {
        @Override
        public Observable<T> apply(Throwable throwable) throws Exception {
            return Observable.error(ExceptionHandle.handleException(throwable));
        }
    }


    private class HandleFuc<T> implements Function<BaseResponse<T>, T> {

        @Override
        public T apply(BaseResponse<T> tBaseResponse) throws Exception {
            if (!tBaseResponse.isOk()) throw new RuntimeException(tBaseResponse.getCode() + "" + tBaseResponse.getMsg() != null ? tBaseResponse.getMsg(): "");
            return tBaseResponse.getData();
        }
    }


    /**
     * /**
     * execute your customer API
     * For example:
     *  MyApiService com.gzqx.org.service =
     *      RetrofitClient.getInstance(ChatMainActivity.this).create(MyApiService.class);
     *
     *  RetrofitClient.getInstance(ChatMainActivity.this)
     *      .execute(com.gzqx.org.service.lgon("name", "password"), subscriber)
     *     * @param subscriber
     */

    public static <T> T execute(Observable<T> observable , DisposableObserver<T> subscriber) {
        observable.subscribeOn(Schedulers.io())
                .unsubscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(subscriber);

        return null;
    }


    /**
     * DownSubscriber
     * @param <ResponseBody>
     */
    class DownSubscriber<ResponseBody> extends DisposableObserver<ResponseBody> {
        CallBack callBack;

        public DownSubscriber(CallBack callBack) {
            this.callBack = callBack;
        }

        @Override
        public void onStart() {
            super.onStart();
            if (callBack != null) {
                callBack.onStart();
            }
        }


        @Override
        public void onError(Throwable e) {
            if (callBack != null) {
                callBack.onError(e);
            }
        }

        @Override
        public void onComplete() {
            if (callBack != null) {
                callBack.onCompleted();
            }
        }

        @Override
        public void onNext(ResponseBody responseBody) {
            DownLoadManager.getInstance(callBack).writeResponseBodyToDisk(mContext, (okhttp3.ResponseBody) responseBody);

        }
    }

}
