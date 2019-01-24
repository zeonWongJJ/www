package app.vdao.qidu.service;

import android.app.IntentService;
import android.app.Notification;
import android.app.NotificationManager;
import android.app.Service;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.net.Network;
import android.net.Uri;
import android.os.Environment;
import android.os.Handler;
import android.os.IBinder;
import android.os.Looper;
import android.support.annotation.Nullable;
import android.support.v4.app.NotificationCompat;
import android.util.Log;
import android.widget.RemoteViews;
import android.widget.Toast;

import com.app.base.utils.HttpUrl;
import com.common.lib.global.AppUtils;
import com.net.rx_retrofit_network.location.callback.CallBack;
import com.net.rx_retrofit_network.location.download.DownSubscriber;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;

import app.vdao.qidu.R;
import app.vdao.qidu.mvp.apiservice.APIService;
import app.vdao.qidu.mvp.apiservice.ApiServcieImpl;
import app.vdao.qidu.mvp.model.DownLoadModelImpl;
import io.reactivex.disposables.CompositeDisposable;
import io.reactivex.disposables.Disposable;
import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.Response;

/**
 * Created by 7du-28 on 2018/1/16.
 */

public class UpdateService extends IntentService {

    private int newVerCode=0;
    private Handler postHandler=new Handler();

    @Override
    public IBinder onBind(Intent arg0) {
        return null;
    }
    public UpdateService() {
        super("DownLoadAppService");
    }
    @Override
    protected void onHandleIntent(@Nullable Intent intent) {
        if (intent != null) {
            /*app_name = intent.getStringExtra("app_name");
            down_url = intent.getStringExtra("downurl");*/
            newVerCode = intent.getIntExtra("newVerCode",0);
            // 开始下载
            downloadUpdateFile(HttpUrl.apkUrl);
        }
    }

    protected CompositeDisposable mCompositeSubscription;
    @Override
    public void onCreate() {
        super.onCreate();
        mCompositeSubscription = new CompositeDisposable();
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
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
            views = new RemoteViews(this.getPackageName(), R.layout.notification_update_app_view);
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
    private String isExistDir(String saveDir) throws IOException {
        // 下载位置
        File downloadFile = new File(Environment.getExternalStorageDirectory(), saveDir);
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
        int currentCode= AppUtils.getAppVersionCode(this);
        final String fileKey="vdao.apk";
        final String saveDir = getApplicationContext().getExternalFilesDir(null) + File.separator;
        String path =getFilePathByKey(saveDir,fileKey);
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


    private int progress = 0;
    public void downloadFile(String url,final String fileKey){
        initNotification();
        /*DownLoadModelImpl downLoadModelImpl=new DownLoadModelImpl();
        Disposable disposable =downLoadModelImpl.downloadFile(url).subscribeWith(new DownSubscriber<ResponseBody>(getApplicationContext(),new CallBack() {
            @Override
            public void onError(Throwable e) {

                *//*Toast.makeText(getApplicationContext(), "失败"+e.getMessage(), Toast.LENGTH_SHORT).show();
                mNotificationManager.cancel(NOTIFICATION_ID);*//*
                *//*final String fileKey="vdao.apk";
                String path = FileDownloadUtil.getInstance().getFilePathByKey(FileDownloadUtil.qiduDownLoad,fileKey);
                File file = new File(path);
                if (file.isFile() && file.exists()) {
                    file.delete();
                }*//*
            }

            @Override
            public void onProgress(long fileSizeDownloaded, long fileSize) {
                //Toast.makeText(getActivity(),fileSizeDownloaded+"", Toast.LENGTH_SHORT).show();

                int progress= (int) ((fileSizeDownloaded/fileSize)*100);
                Log.i("aaaaa",progress+"进度"+fileSizeDownloaded+"---"+fileSize);
                *//*if((progress%5)==0&&currentProcess!=progress){
                    currentProcess=progress;
                    postHandler.post(new Runnable() {
                        @Override
                        public void run() {
                            views.setTextViewText(R.id.notificationTitle, "正在下载");
                            views.setTextViewText(R.id.notificationPercent, "已下载" + progress + "%");
                            views.setProgressBar(R.id.notificationProgress, 100, progress, false);
                            mNotificationManager.notify(NOTIFICATION_ID,notification);
                        }
                    });
                }*//*
            }

            @Override
            public void onSuccess(String path, String name, long fileSize) {
                *//*mNotificationManager.cancel(NOTIFICATION_ID);
                installApk(new File(path),UpdateService.this);*//*
            }
        }));
        mCompositeSubscription.add(disposable);//添加订阅*/






        //Call<ResponseBody> call = Network.getInstance().getApi().downloadFileWithDynamicUrlSync(url);

        Call<ResponseBody> call= ApiServcieImpl.getInstance().downloadFileWithDynamicUrlSync(url);
        try {
            Response<ResponseBody> response = call.execute();
            if (response.isSuccessful()) {
                boolean writtenToDisk = writeResponseBodyToDisk(response.body());
                cancel();
                if (writtenToDisk) {
                    String apkName="vdao.apk";
                    File apkfile = new File(getExternalFilesDir(null) + File.separator, apkName);
                    if (!apkfile.exists()) {
                        return;
                    }
                    installApk(apkfile,UpdateService.this);
                } else {
                    new Handler(Looper.getMainLooper()).post(new Runnable() {
                        @Override
                        public void run() {
                            Toast.makeText(UpdateService.this, "下载更新失败", Toast.LENGTH_LONG).show();
                        }
                    });
                }
            } else {
                cancel();
                new Handler(Looper.getMainLooper()).post(new Runnable() {
                    @Override
                    public void run() {
                        Toast.makeText(UpdateService.this, "下载更新失败", Toast.LENGTH_LONG).show();
                    }
                });
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    private void cancel(){
        mNotificationManager.cancel(NOTIFICATION_ID);
    }
    private void updateProgress(int notificationId, int progress){
        views.setTextViewText(R.id.notificationTitle, "正在下载");
        views.setTextViewText(R.id.notificationPercent, "已下载" + progress + "%");
        views.setProgressBar(R.id.notificationProgress, 100, progress, false);
        mNotificationManager.notify(NOTIFICATION_ID,notification);
    }
    /**
     * 写入
     *
     * @param body
     * @return
     */
    private boolean writeResponseBodyToDisk(ResponseBody body) {
        try {
            String apkName="vdao.apk";
            // todo change the file location/name according to your needs
            File futureStudioIconFile = new File(getExternalFilesDir(null) + File.separator + apkName);
            InputStream inputStream = null;
            OutputStream outputStream = null;
            try {
                byte[] fileReader = new byte[4096];
                long fileSize = body.contentLength();
                long fileSizeDownloaded = 0;
                inputStream = body.byteStream();
                outputStream = new FileOutputStream(futureStudioIconFile);
                while (true) {
                    int read = inputStream.read(fileReader);
                    if (read == -1) {
                        break;
                    }
                    outputStream.write(fileReader, 0, read);
                    fileSizeDownloaded += read;
                    int pro = (int) (fileSizeDownloaded * 100 / fileSize);
                    if (pro > progress) {
                        progress = pro;
                        updateProgress(NOTIFICATION_ID, pro);
                    }
                }
                outputStream.flush();
                return true;
            } catch (IOException e) {
                return false;
            } finally {
                if (inputStream != null) {
                    inputStream.close();
                }
            }
        } catch (IOException e) {
            return false;
        }
    }
    @Override
    public void onDestroy() {
        super.onDestroy();
        if(mCompositeSubscription!=null){
            mCompositeSubscription.clear();
        }
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
