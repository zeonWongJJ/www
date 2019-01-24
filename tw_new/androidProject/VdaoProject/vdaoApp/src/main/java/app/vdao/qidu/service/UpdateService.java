package app.vdao.qidu.service;

import android.app.Notification;
import android.app.NotificationManager;
import android.app.Service;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.net.Uri;
import android.os.Handler;
import android.os.IBinder;
import android.support.v4.app.NotificationCompat;
import android.util.Log;
import android.widget.RemoteViews;

import com.gzqx.common.sysutil.AppUtils;
import com.gzqx.common.utils.FileDownloadUtil;
import com.gzqx.common.utils.HttpUrl;


import java.io.File;

/**
 * Created by 7du-28 on 2018/1/16.
 */

public class UpdateService extends Service {

    private int newVerCode=0;
    private Handler postHandler=new Handler();

    @Override
    public IBinder onBind(Intent arg0) {
        return null;
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        if (intent != null) {
            /*app_name = intent.getStringExtra("app_name");
            down_url = intent.getStringExtra("downurl");*/
            newVerCode = intent.getIntExtra("newVerCode",0);
            // 开始下载
            downloadUpdateFile(HttpUrl.apkUrl);
        }
        return super.onStartCommand(intent, flags, startId);
    }



    /***
     * 创建通知栏
     */
    private static NotificationCompat.Builder mBuilder;
    protected static NotificationManager mNotificationManager;
    private static Notification notification;
    protected static RemoteViews views;
    protected static int NOTIFICATION_ID = 9968;

    protected void initNotification() {
        if (mNotificationManager == null) {
            mBuilder = new NotificationCompat.Builder(
                    this).setSmallIcon(android.R.drawable.stat_sys_download)
                    .setWhen(System.currentTimeMillis())
                    .setTicker("更新");
            views = new RemoteViews(this.getPackageName(), com.gzqx.com.gzqx.org.common.R.layout.notification_update_app_view);
            mBuilder.setContent(views);
            mNotificationManager = (NotificationManager) this.getSystemService(Context.NOTIFICATION_SERVICE);
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
    private int currentProcess=0;
    /**
     * 下载apk
     */
    public void downloadUpdateFile(final String url) {
        int currentCode= AppUtils.getAppVersionCode(this);
        final String fileKey="vdao.apk";
        String path = FileDownloadUtil.getInstance().getFilePathByKey(FileDownloadUtil.qiduDownLoad,fileKey);
        if (path != null&&getUninatllApkInfo(this,path)) {
            PackageManager packageManager = getPackageManager();
            PackageInfo packageInfo = packageManager.getPackageArchiveInfo(path, PackageManager.GET_ACTIVITIES);
            //Log.i("aaaaaaa",packageInfo.versionCode+"==versionCode==="+packageInfo.versionName+"===newVerCode"+newVerCode);
            if(packageInfo.versionCode==newVerCode&&packageInfo.versionCode!=currentCode){//本地缓存的版本等于服务端的版本
                installApk(new File(path),this);
            }else {
                File file = new File(path);
                if (file.isFile() && file.exists()) {
                    file.delete();
                }
                if(newVerCode>currentCode) {
                    downloadFile(url, fileKey);
                }
            }
        }else {
            //NetworkUtil.isWifiEnabled()
            downloadFile(url,fileKey);
        }
    }

    public void downloadFile(String url,final String fileKey){
        initNotification();
        FileDownloadUtil.getInstance().cancelDown();
        FileDownloadUtil.getInstance().download(url, FileDownloadUtil.qiduDownLoad, fileKey, new FileDownloadUtil.OnDownloadListener() {
            @Override
            public void onDownloadSuccess() {
                final String path = FileDownloadUtil.getInstance().getFilePathByKey(FileDownloadUtil.qiduDownLoad, fileKey);
                postHandler.post(new Runnable() {
                    @Override
                    public void run() {
                        mNotificationManager.cancel(NOTIFICATION_ID);
                        installApk(new File(path),UpdateService.this);
                    }
                });

            }

            @Override
            public void onDownloading(final int progress) {
                if((progress%5)==0&&currentProcess!=progress){
                    currentProcess=progress;
                    postHandler.post(new Runnable() {
                        @Override
                        public void run() {
                            views.setTextViewText(com.gzqx.com.gzqx.org.common.R.id.notificationTitle, "正在下载");
                            views.setTextViewText(com.gzqx.com.gzqx.org.common.R.id.notificationPercent, "已下载" + progress + "%");
                            views.setProgressBar(com.gzqx.com.gzqx.org.common.R.id.notificationProgress, 100, progress, false);
                            mNotificationManager.notify(NOTIFICATION_ID,notification);
                        }
                    });
                }

            }

            @Override
            public void onDownloadFailed() {
                postHandler.post(new Runnable() {
                    @Override
                    public void run() {
                        mNotificationManager.cancel(NOTIFICATION_ID);
                        final String fileKey="vdao.apk";
                        String path = FileDownloadUtil.getInstance().getFilePathByKey(FileDownloadUtil.qiduDownLoad,fileKey);
                        File file = new File(path);
                        if (file.isFile() && file.exists()) {
                            file.delete();
                        }
                    }
                });
            }
        });
    }


    // 下载完成后打开安装apk界面
    public static void installApk(File file, Context context) {
        //L.i("msg", "版本更新获取sd卡的安装包的路径=" + file.getAbsolutePath());
        Intent openFile = getFileIntent(file);
        context.startActivity(openFile);

        Intent stopIntent = new Intent(context, UpdateService.class);
        context.stopService(stopIntent);
    }

    public static Intent getFileIntent(File file) {
        Uri uri = Uri.fromFile(file);
        String type = getMIMEType(file);
        Intent intent = new Intent("android.intent.action.VIEW");
        intent.addCategory("android.intent.category.DEFAULT");
        intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
        intent.setDataAndType(uri, type);
        return intent;
    }
    public static String getMIMEType(File f) {
        String type = "";
        String fName = f.getName();
        // 取得扩展名
        String end = fName
                .substring(fName.lastIndexOf(".") + 1, fName.length());
        if (end.equals("apk")) {
            type = "application/vnd.android.package-archive";
        } else {
            // /*如果无法直接打开，就跳出软件列表给用户选择 */
            type = "*/*";
        }
        return type;
    }

}
