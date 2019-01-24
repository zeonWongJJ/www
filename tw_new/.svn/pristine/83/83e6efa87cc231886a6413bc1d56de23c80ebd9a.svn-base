package com.app.base.netUtil;


import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.app.Notification;
import android.app.NotificationManager;
import android.content.Context;
import android.content.DialogInterface;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.os.Environment;
import android.os.Looper;
import android.support.v4.app.NotificationCompat;
import android.text.TextUtils;
import android.util.Log;
import android.widget.RemoteViews;

import com.androidnetworking.AndroidNetworking;
import com.androidnetworking.common.Priority;
import com.androidnetworking.error.ANError;
import com.androidnetworking.interfaces.AnalyticsListener;
import com.androidnetworking.interfaces.DownloadListener;
import com.androidnetworking.interfaces.DownloadProgressListener;
import com.androidnetworking.interfaces.JSONObjectRequestListener;
import com.app.base.R;
import com.app.base.bean.AppInfo;
import com.app.base.utils.HttpUrl;
import com.common.lib.global.AppUtils;
import com.google.gson.Gson;
import com.rx2androidnetworking.Rx2AndroidNetworking;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.io.IOException;
import java.text.DecimalFormat;

import io.reactivex.CompletableObserver;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.annotations.NonNull;
import io.reactivex.disposables.Disposable;
import io.reactivex.functions.Consumer;
import io.reactivex.schedulers.Schedulers;
import okhttp3.OkHttpClient;

public class VersionUpdateUtil {
    /***
     * 创建通知栏
     */
    private static NotificationCompat.Builder mBuilder;
    protected static NotificationManager mNotificationManager;
    private static Notification notification;
    protected static RemoteViews views;
    protected static int NOTIFICATION_ID = 9968;


    private static VersionUpdateUtil updateUtil;
    private Activity activity;
    private String fileKey="odp.apk";
    private String fileDirName="upgrade_apk";
    private String newVerName = "";// 新版本名称
    private int newVerCode = -1;// 新版本号
    boolean isForceUpdate=false;//是否强制更新
    public static VersionUpdateUtil getInstance(Activity activity){
        if(updateUtil==null){
            updateUtil=new VersionUpdateUtil(activity);
        }
        return updateUtil;
    }

    public void checkVersion(){
        Rx2AndroidNetworking.get(HttpUrl.api_version_check)
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
                                    updateVersion(appInfo);
                                }
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                    @Override
                    public void onError(ANError anError) {

                    }
                });
    }
    private VersionUpdateUtil(Activity activity) {
        this.activity = activity;
    }
    protected void initNotification() {
        if (mNotificationManager == null) {
            mBuilder = new NotificationCompat.Builder(
                    activity).setSmallIcon(android.R.drawable.stat_sys_download)
                    .setWhen(System.currentTimeMillis())
                    .setTicker("更新");
            views = new RemoteViews(activity.getPackageName(), R.layout.notification_update_app_view);
            mBuilder.setContent(views);
            mNotificationManager = (NotificationManager) activity.getSystemService(Context.NOTIFICATION_SERVICE);
            notification=mBuilder.build();
            mNotificationManager.notify(NOTIFICATION_ID,notification);
        }
    }
    public boolean getUninatllApkInfo(Context context,String filePath) {
        boolean result = false;
        try {
            PackageManager pm = context.getPackageManager();
            Log.e("archiveFilePath", filePath);
            PackageInfo info = pm.getPackageArchiveInfo(filePath,PackageManager.GET_ACTIVITIES);
            if (info != null) {
                result = true;//完整
            }
        } catch (Exception e) {
            result = false;//不完整

            File file = new File(filePath);
            if (file.isFile() && file.exists()) {
                file.delete();
            }
        }
        return result;
    }

    private String isExistDir(String saveDir) throws IOException {
        // 下载位置
        File downloadFile = new File(saveDir);
        if (!downloadFile.mkdirs()) {
            downloadFile.createNewFile();
        }
        String savePath = downloadFile.getAbsolutePath();
        return savePath;
    }
    private String getFilePathByKey(String saveDir,String fileName){
        String savePath = null;
        try {
            savePath = isExistDir(saveDir);
            File file = new File(savePath, fileName);
            if(file.exists()){
                return file.getPath();
            }
        } catch (IOException e) {
            e.printStackTrace();
            return null;
        }

        return null;
    }
    /**
     * 下载apk
     */
    public void downloadUpdateFile(final String url) {
        int currentCode= AppUtils.getAppVersionCode(activity);
        final String saveDir = activity.getApplicationContext().getExternalFilesDir(fileDirName) + File.separator;
        String path =getFilePathByKey(saveDir,fileKey);
        Log.i("aaaaaaa","path==="+path);
        if (path != null&&getUninatllApkInfo(activity,path)) {
            PackageManager packageManager = activity.getPackageManager();
            PackageInfo packageInfo = packageManager.getPackageArchiveInfo(path, PackageManager.GET_ACTIVITIES);
            //Log.i("aaaaaaa",packageInfo.versionCode+"==versionCode==="+packageInfo.versionName+"===newVerCode"+newVerCode);
            if(packageInfo.versionCode==newVerCode&&packageInfo.versionCode!=currentCode){//本地缓存的版本等于服务端的版本
                AppUtils.installApk(new File(path),activity);
            }else {
                File file = new File(path);
                if (file.isFile() && file.exists()) {
                    file.delete();
                }
                if(newVerCode>currentCode) {
                    downloadFile(url,saveDir, fileKey);
                }
            }
        }else {
            //NetworkUtil.isWifiEnabled()
            if(path!=null){
                File file = new File(path);
                if (file.isFile() && file.exists()) {
                    file.delete();
                }
            }
            downloadFile(url,saveDir,fileKey);
        }
    }

    public void downloadFile(String url,final String dirPath,final String fileName) {
        initNotification();
        Rx2AndroidNetworking.download(url,dirPath,fileName)
                .addHeaders("Accept-Encoding", "identity")
                .build()
                /*.setAnalyticsListener(new AnalyticsListener() {
                    @Override
                    public void onReceived(long timeTakenInMillis, long bytesSent, long bytesReceived, boolean isFromCache) {
                        *//*Log.d(TAG, " timeTakenInMillis : " + timeTakenInMillis);
                        Log.d(TAG, " bytesSent : " + bytesSent);
                        Log.d(TAG, " bytesReceived : " + bytesReceived);
                        Log.d(TAG, " isFromCache : " + isFromCache);*//*
                    }
                })*/
                .setDownloadProgressListener(new DownloadProgressListener() {
                    @Override
                    public void onProgress(long bytesDownloaded, long totalBytes) {
                        double percent = (double)bytesDownloaded / totalBytes;
                        DecimalFormat format = new DecimalFormat("0%");
                        String progressStr = format.format(percent);
                        int progress=Integer.parseInt(progressStr.replace("%",""));
                        if(progress%5==0){
                            views.setTextViewText(R.id.notificationTitle, "正在下载");
                            views.setTextViewText(R.id.notificationPercent, "已下载" + progress + "%");
                            views.setProgressBar(R.id.notificationProgress, 100, progress, false);
                            mNotificationManager.notify(NOTIFICATION_ID,notification);
                        }
                    }
                })
                .getDownloadObservable()
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(new Consumer<String>() {
                    @Override
                    public void accept(String s) throws Exception {
                        mNotificationManager.cancel(NOTIFICATION_ID);
                        AppUtils.installApk(new File(dirPath+fileName),activity);
                    }
                }, new Consumer<Throwable>() {
                    @Override
                    public void accept(Throwable throwable) throws Exception {
                        mNotificationManager.cancel(NOTIFICATION_ID);
                        String saveDir = activity.getApplicationContext().getExternalFilesDir(fileDirName) + File.separator;
                        String path =getFilePathByKey(saveDir,fileKey);
                        if(!TextUtils.isEmpty(path)){
                            File file = new File(path);
                            if (file.isFile() && file.exists()) {
                                file.delete();
                            }
                        }
                    }
                });
    }
    // 判断是否更新版本
    public void updateVersion(AppInfo appInfo) {
        isForceUpdate=appInfo.isIsForceUpdate();
        newVerName=appInfo.getVersionName();
        newVerCode=appInfo.getVersionCode();
        int verCode = AppUtils.getAppVersionCode(activity);
            if(!isForceUpdate){
                if (newVerCode > verCode) {
                    doNewVersionUpdate();// 更新版本
                }/*else {
                    notNewVersionUpdate();
                }*/
            }else {
                //强制更新
                if (newVerCode > verCode) {
                    downloadUpdateFile(HttpUrl.apkUrl);
                }/*else {
                    notNewVersionUpdate();
                }*/
            }
    }



    /**
     * 更新版本
     */
    public void doNewVersionUpdate() {
        //int verCode =AppUtils.getAppVersionCode(activity);
        //String verName =AppUtils.getAppVersionName(activity);
        StringBuffer sb = new StringBuffer();
        /*sb.append("当前版本：");
        sb.append(verName);
        sb.append(" Code:");
        sb.append(verCode);*/
        sb.append("发现版本：");
        sb.append(newVerName);
        /*sb.append(" Code:");
        sb.append(newVerCode);*/
        //sb.append(",是否更新");
        Dialog dialog = new AlertDialog.Builder(activity)
                .setTitle("软件更新")
                .setMessage(sb.toString())
                .setPositiveButton("更新", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        // 开始下载
                        downloadUpdateFile(HttpUrl.apkUrl);
                    }
                })
                .setNegativeButton("暂不更新",
                        new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog,
                                                int which) {
                                dialog.dismiss();
                            }
                        }).create();
        // 显示更新框
        dialog.show();
    }


    /**
     * 不更新版本
     */
    public void notNewVersionUpdate() {
        //int verCode = AppUtils.getAppVersionCode(activity);
        String verName = AppUtils.getAppVersionName(activity);
        StringBuffer sb = new StringBuffer();
        sb.append("当前版本：");
        sb.append(verName);
        sb.append("\n已是最新版本，无需更新");
        Dialog dialog = new AlertDialog.Builder(activity).setTitle("软件更新")
                .setMessage(sb.toString())
                .setPositiveButton("确定", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        dialog.dismiss();
                    }
                }).create();
        dialog.show();
    }
}
