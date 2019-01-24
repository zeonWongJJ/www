package app.vdaoadmin.qidu.utils;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.os.Handler;
import android.os.Looper;
import android.util.Log;

import com.app.base.bean.AppInfo;
import com.app.base.utils.HttpUrl;
import com.common.lib.fileutils.FileUtils;
import com.common.lib.global.AppUtils;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.Response;



public class VersionUpdateManager {

    private Activity activity;

    private String newVerName = "";// 新版本名称
    private int newVerCode = -1;// 新版本号
    boolean isForceUpdate=false;//是否强制更新
    public VersionUpdateManager(Activity activity) {
        this.activity = activity;
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
            }
        }else {
            //强制更新
            if (newVerCode > verCode) {
                downloadUpdateFile(HttpUrl.apkUrl);
            }
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



    /**
     * 下载apk
     */
    public void downloadUpdateFile(final String url) {
        int currentCode= AppUtils.getAppVersionCode(activity);
        //File file = new File(FileUtils.getAppFilesDir(activity), fileKey);
        final String fileKey="vdaoAdmin.apk";
        final File saveDir = FileUtils.getDiskCacheDir(activity);
        String path=null;
        File fileRoot = new File(saveDir, fileKey);
        if(fileRoot.exists()){
            path=fileRoot.getPath();
        }
        if (path != null&& AppUtils.getUninatllApkInfo(activity,path)) {
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
                    downloadFile(url, fileKey);
                }
            }
        }else {
            //NetworkUtil.isWifiEnabled()
            downloadFile(url,fileKey);
        }
    }

    private OkHttpClient okHttpClient;
    private Call downCall;
    /**
     * 取消下载
     */
    public void cancelDown(){
        if(downCall!=null){
            downCall.cancel();
        }
    }
    private int currentProcess=0;
    private ProgressDialog dialog;
    public void downloadFile(String url,final String fileKey){
        currentProcess=0;
        //Call<ResponseBody> call = Network.getInstance().getApi().downloadFileWithDynamicUrlSync(url);
//监听下载进度
        dialog = new ProgressDialog(activity);
        //dialog.getWindow().setType(WindowManager.LayoutParams.TYPE_SYSTEM_ALERT);
        dialog.setProgressNumberFormat("%1d/%2d");
        dialog.setTitle("下载");
        dialog.setMessage("正在下载，请稍后...");
        dialog.setProgressStyle(ProgressDialog.STYLE_HORIZONTAL);
        dialog.setMax(100);
        dialog.setCancelable(true);
        dialog.setCanceledOnTouchOutside(false);// 设置在点击Dialog外是否取消Dialog进度条
        dialog.setOnDismissListener(new DialogInterface.OnDismissListener() {
            @Override
            public void onDismiss(DialogInterface dialog) {
                cancelDown();
            }
        });
        //dialog.getWindow().setType(WindowManager.LayoutParams.TYPE_SYSTEM_ALERT);
        dialog.show();

        File appFile = new File(FileUtils.getDiskCacheDir(activity), fileKey);
        if (appFile.isFile() && appFile.exists()) {
            appFile.delete();
        }
        //Call<ResponseBody> call= ApiServcieImpl.getInstance().downloadFileWithDynamicUrlSync(url);
        okHttpClient = new OkHttpClient();
        Request request = new Request.Builder().addHeader("Accept-Encoding", "identity").url(url).build();
        //request.addHeader("Accept-Encoding", "identity");
        downCall = okHttpClient.newCall(request);
        downCall.enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                // 下载失败
                /*listener.onDownloadFailed();*/
                new Handler(Looper.getMainLooper()).post(new Runnable() {
                    @Override
                    public void run() {
                        if(dialog!=null){
                            dialog.dismiss();
                            dialog=null;
                        }
                    }
                });
            }
            @Override
            public void onResponse(Call call, Response response) throws IOException {
                InputStream is = null;
                //OutputStream outputStream = null;
                byte[] buf = new byte[4096];//2048
                int len = 0;
                OutputStream fos = null;
                // 储存下载文件的目录
                //String savePath = FileUtils.isExistDir(activity,saveDir);
                try {
                    is = response.body().byteStream();
                    long total = response.body().contentLength();
                    //File file = new File(savePath, fileKey);
                    File file = new File(FileUtils.getDiskCacheDir(activity), fileKey);
                    fos = new FileOutputStream(file);
                    long sum = 0;
                    while (true) {
                        int read = is.read(buf);
                        if (read == -1) {
                            break;
                        }
                        fos.write(buf, 0, read);
                        sum += read;
                        int progress = (int) (sum * 1.0f / total * 100);
                        // 下载中
                        //listener.onDownloading(progress);
                        if(/*(progress%5)==0&&*/currentProcess!=progress){
                            currentProcess=progress;
                            new Handler(Looper.getMainLooper()).post(new Runnable() {
                                @Override
                                public void run() {
                                    dialog.setProgress(progress);
                                    //Toast.makeText(activity, "下载更新失败", Toast.LENGTH_LONG).show();
                                }
                            });
                        }

                    }
                    fos.flush();
                    // 下载完成
                    //listener.onDownloadSuccess();
                    new Handler(Looper.getMainLooper()).post(new Runnable() {
                        @Override
                        public void run() {
                            /*String fileKey="vdao.apk";
                            String saveDir = FileUtils.getAppFilesDir(activity);
                            String path=null;
                            File fileRoot = new File(saveDir, fileKey);*/
                            if(file.exists()){
                                Log.i("aaaaaaaaaaaaaaa",file.getPath()+"====="+file.getAbsolutePath());
                                AppUtils.installApk(file,activity);
                            }
                            if(dialog!=null){
                                dialog.dismiss();
                                dialog=null;
                            }
                        }
                    });
                } catch (IOException e) {
                    //listener.onDownloadFailed();
                } finally {
                    try {
                        if (is != null)
                            is.close();
                    } catch (IOException e) {

                    }
                    try {
                        if (fos != null)
                            fos.close();
                    } catch (IOException e) {

                    }
                    response.close();
                }
            }
        });
        /*ProgressHelper.setProgressHandler(new DownloadProgressHandler() {
            @Override
            protected void onProgress(long bytesRead, long contentLength, boolean done) {
                Log.e("是否在主线程中运行", String.valueOf(Looper.getMainLooper() == Looper.myLooper()));
                Log.e("onProgress",String.format("%d%% done\n",(100 * bytesRead) / contentLength));
                Log.e("done","--->" + String.valueOf(done));
                dialog.setMax((int) (contentLength/1024));
                dialog.setProgress((int) (bytesRead/1024));

                if(done){
                    dialog.dismiss();
                }
            }
        });*/
        /*call.enqueue(new Callback<ResponseBody>() {
            @Override
            public void onResponse(Call<ResponseBody> call, Response<ResponseBody> response) {
                Log.e("aaaaaaaaaaa", String.valueOf(Looper.getMainLooper() == Looper.myLooper()));

                try {
                    InputStream is = response.body().byteStream();
                    File file = new File(Environment.getExternalStorageDirectory(), "12345.apk");
                    FileOutputStream fos = new FileOutputStream(file);
                    BufferedInputStream bis = new BufferedInputStream(is);
                    byte[] buffer = new byte[1024];
                    int len;
                    while ((len = bis.read(buffer)) != -1) {
                        Log.e("onProgress","len===="+len);
                        fos.write(buffer, 0, len);
                        fos.flush();
                    }
                    fos.close();
                    bis.close();
                    is.close();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
            @Override
            public void onFailure(Call<ResponseBody> call, Throwable t) {

            }
        });*/
    }
}
