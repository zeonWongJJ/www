package app.vdao.qidu.activity;


import android.app.NotificationManager;
import android.os.Bundle;
import android.support.v4.app.NotificationCompat;
import android.text.TextUtils;
import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.widget.RemoteViews;
import android.widget.Toast;

import com.google.gson.Gson;
import com.gzqx.common.base.AbsBaseActivity;
import com.gzqx.common.datautil.SharedPreferencesUtils;
import com.gzqx.common.httpbase.net.BaseDisposableObserver;
import com.gzqx.common.httpbase.net.BaseResponse;
import com.gzqx.common.httpbase.net.CallBack;
import com.gzqx.common.httpbase.net.ExceptionHandle;
import com.gzqx.common.httpbase.net.RetrofitClient;

import app.vdao.qidu.R;
import app.vdao.qidu.util.PopupWindowFactory;

import java.io.File;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import io.reactivex.disposables.Disposable;
import okhttp3.MediaType;
import okhttp3.RequestBody;
import okhttp3.ResponseBody;

public class HttpTestActivity extends AbsBaseActivity{
    private View btn, btn_get, btn_post, btn_json, btn_download, btn_upload, btn_myApi, btn_changeHostApi;
    //private final CompositeDisposable disposables = new CompositeDisposable();

    private void uploadFiles(List<String> pathList){
        RequestBody tokenBody = RequestBody.create(
                MediaType.parse("multipart/form-data"), "token");
        HashMap<String, RequestBody> map = new HashMap<>();
        map.put("token", tokenBody);
        for (int i = 0; i < pathList.size(); i++) {
            File file = new File(pathList.get(i));//filePath 图片地址
            RequestBody imageBody = RequestBody.create(MediaType.parse("multipart/form-data"), file);
            map.put("image\"; filename=\""+file.getName()+"",imageBody);//requestBodyMap.put("file\"; filename=\"" + file.getName(), fileRequestBody);
            /*下面这里没有为什么，在不带进度的上传接口（使用@Multipart）调试成功后，用fiddler抓包获取request的正确格式 Content-Disposition: form-data; name="file"; filename="avatar1.jpg" */
            //fileKey += "\"; filename=\"" + mUploadedFile.getName();
        }
        RetrofitClient.getInstance(getActivity()).uploads("url", null, "多个文件上传",map , new BaseDisposableObserver<BaseResponse>(getActivity()) {
            @Override
            public void onError(ExceptionHandle.ResponseThrowable e) {

            }

            @Override
            public void onNext(BaseResponse responseBody) {

            }
        });

    }
    /*
    * String number = et.getText().toString();
                boolean judge = isMobile(number);
                if (judge == true) {
                    tv.setText("手机号合法");
                } else {
                    tv.setText("手机号不合法");
                }
    * */
    /**
     * 验证手机格式
     */
    public static boolean isMobile(String number) {
    /*
    移动：134、135、136、137、138、139、150、151、157(TD)、158、159、187、188
    联通：130、131、132、152、155、156、185、186
    电信：133、153、180、189、（1349卫通）
    总结起来就是第一位必定为1，第二位必定为3或5或8，其他位置的可以为0-9
    */
        String num = "[1][358]\\d{9}";//"[1]"代表第1位为数字1，"[358]"代表第二位可以为3、5、8中的一个，"\\d{9}"代表后面是可以是0～9的数字，有9位。
        if (TextUtils.isEmpty(number)) {
            return false;
        } else {
            //matches():字符串是否在给定的正则表达式匹配
            return number.matches(num);
        }
    }
    private void showDialog(View v) {
        //PopupWindow的布局文件
        final View view = View.inflate(this, R.layout.layout_dialog_phone, null);
        PopupWindowFactory mPop = new PopupWindowFactory(this, view);
        //PopupWindow布局文件里面的控件
        mPop.showAtLocation(v, Gravity.CENTER,0,0);
    }
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        btn = findViewById(R.id.bt_getdata);
        SharedPreferencesUtils.getInstance().saveData("OperaDB","test");
        String test= (String) SharedPreferencesUtils.getInstance().getData("OperaDB","");
        Toast.makeText(this,test,Toast.LENGTH_SHORT).show();
        btn_get = findViewById(R.id.bt_get);
        btn_post = findViewById(R.id.bt_post);
        btn_json = findViewById(R.id.bt_json);
        btn_download = findViewById(R.id.bt_download);
        btn_upload = findViewById(R.id.bt_upload);
        btn_myApi = findViewById(R.id.bt_my_api);
        btn_changeHostApi = findViewById(R.id.bt_changeHostApi);

        btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                showDialog(v);

                //"http://ip.taobao.com/service/getIpInfo.php?ip=21.22.11.33";
                /*RetrofitClient.getInstance(getActivity()).createBaseApi().getData(new BaseDisposableObserver<IpResult>(getActivity()) {

                    @Override
                    public void onError(ExceptionHandle.ResponseThrowable e) {
                        Toast.makeText(getActivity(), e.message, Toast.LENGTH_LONG).show();
                    }

                    @Override
                    public void onNext(IpResult responseBody) {
                        Toast.makeText(getActivity(), responseBody.toString(), Toast.LENGTH_LONG).show();
                    }
                }, "21.22.11.33");*/

            }
        });
        btn_get.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                Map<String, String> maps = new HashMap<String, String>();
                maps.put("ip", "21.22.11.33");

                //"http://ip.taobao.com/service/getIpInfo.php?ip=21.22.11.33";
                /*Disposable observable=RetrofitClient.getInstance(getActivity()).createBaseApi().get("service/getIpInfo.php"
                        , maps, new BaseDisposableObserver<IpResult>(getActivity()) {


                            @Override
                            public void onError(ExceptionHandle.ResponseThrowable e) {
                                //reDisposable(observable);
                                Log.e("Lyk", e.getMessage());
                                Toast.makeText(getActivity(), e.getMessage(), Toast.LENGTH_LONG).show();

                            }

                            @Override
                            public void onNext(IpResult responseBody) {
                                Toast.makeText(getActivity(), responseBody.toString(), Toast.LENGTH_LONG).show();
                            }
                        });
                addDisposable(observable);*/
            }
        });


        btn_post.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                Map<String, String> maps = new HashMap<String, String>();

                maps.put("ip", "21.22.11.33");
                //"http://ip.taobao.com/service/getIpInfo.php?ip=21.22.11.33";
                Disposable observable=RetrofitClient.getInstance(getActivity()).createBaseApi().post("service/getIpInfo.php"
                        , maps, new BaseDisposableObserver<ResponseBody>(getActivity()) {

                            @Override
                            public void onError(ExceptionHandle.ResponseThrowable e) {
                                Log.e("Lyk", e.getMessage());
                                Toast.makeText(getActivity(), e.getMessage(), Toast.LENGTH_LONG).show();

                            }

                            @Override
                            public void onNext(ResponseBody responseBody) {
                                Toast.makeText(getActivity(), responseBody.toString(), Toast.LENGTH_LONG).show();
                            }
                        });
                addDisposable(observable);
            }
        });

        btn_json.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                Map<String, String> maps = new HashMap<String, String>();

                maps.put("ip", "21.22.11.33");
                //"http://ip.taobao.com/service/getIpInfo.php?ip=21.22.11.33";

                RequestBody body = RequestBody.create(okhttp3.MediaType.parse("application/json; charset=utf-8"), new Gson().toJson(maps));

                Disposable observable=RetrofitClient.getInstance(getActivity()).createBaseApi().json("service/getIpInfo.php"
                        , body, new BaseDisposableObserver<BaseResponse>(getActivity()) {


                            @Override
                            public void onNext(BaseResponse baseResponse) {
                                Toast.makeText(getActivity(), baseResponse.toString(), Toast.LENGTH_LONG).show();
                            }

                            @Override
                            public void onError(ExceptionHandle.ResponseThrowable e) {


                                Log.e("Lyk", e.getMessage());
                                Toast.makeText(getActivity(), e.getMessage(), Toast.LENGTH_LONG).show();

                            }

                        });
                //observable.isDisposed();
                addDisposable(observable);
            }
        });

        btn_upload.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });

        btn_download.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                if (upLoadDisposable!=null) {
                    upLoadDisposable.dispose();
                } else
                    upLoadDisposable = RetrofitClient.getInstance(getActivity()).createBaseApi().download("http://hengdawb-app.oss-cn-hangzhou.aliyuncs.com/app-debug.apk", new CallBack() {
                                @Override
                                public void onError(Throwable e) {
                                    Toast.makeText(getActivity(), "失败"+e.getMessage(), Toast.LENGTH_SHORT).show();
                                }

                                @Override
                                public void onProgress(long fileSizeDownloaded, long fileSize) {
                                    //Toast.makeText(getActivity(),fileSizeDownloaded+"", Toast.LENGTH_SHORT).show();
                                }

                                @Override
                                public void onSuccess(String path, String name, long fileSize) {
                                    Toast.makeText(getActivity(),path+"name"+name, Toast.LENGTH_SHORT).show();

                                }
                            }
                    );
            }
        });


        btn_myApi.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {


            }
        });


        btn_changeHostApi.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });

    }
    Disposable upLoadDisposable;
    @Override
    protected int getContentViewID() {
        return R.layout.activity_http_test;
    }


    NotificationCompat.Builder mBuilder;
    NotificationManager mNotificationManager;
    protected static RemoteViews views;
    /*private void test(){

        mBuilder = new NotificationCompat.Builder(
                BaseApplication.getInstance()).setSmallIcon(android.R.drawable.stat_sys_download)
                .setWhen(System.currentTimeMillis())
                .setTicker("");
        views = new RemoteViews(BaseApplication.getInstance().getPackageName(), com.gzqx.com.gzqx.org.common.R.layout.notification_update_app_view);
        mBuilder.setContent(views);
        mNotificationManager = (NotificationManager) BaseApplication.getInstance().getSystemService(Context.NOTIFICATION_SERVICE);
         NotificationTarget target=new NotificationTarget(getActivity(),views,R.id.notificationImage,mBuilder.build(),111);
        Glide.with(mContext).load("http://nuuneoi.com/uploads/source/playstore/cover.jpg").asBitmap().into(target);

    }*/

}
