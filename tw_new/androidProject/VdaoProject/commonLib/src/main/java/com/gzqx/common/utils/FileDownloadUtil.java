package com.gzqx.common.utils;

import android.os.Environment;
import android.support.annotation.NonNull;

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

/**
 * Created by 7du-28 on 2017/10/26.
 */

public class FileDownloadUtil {
    public static String qiduDownLoad="qiduDownLoad";
    private static FileDownloadUtil downloadUtil;
    private final OkHttpClient okHttpClient;
    private Call downCall;         //下载的call
    public static FileDownloadUtil getInstance() {
        if (downloadUtil == null) {
            downloadUtil = new FileDownloadUtil();
        }
        return downloadUtil;
    }

    private FileDownloadUtil() {
        okHttpClient = new OkHttpClient();
    }
    /**
     * 创建okhttp
     *
     * @return
     * @throws Exception
     */
    /*private OkHttpClient newOkHttpClient() throws Exception {

        //创建okHttpClient对象
        OkHttpClient mOkHttpClient = new OkHttpClient();

        TrustManager tm = new OkHttpManager.myTrustManager();
        SSLContext sslContext = SSLContext.getInstance("TLS");
        sslContext.init(null, new TrustManager[]{tm}, null);

        mOkHttpClient.setSslSocketFactory(sslContext.getSocketFactory());


        return mOkHttpClient;
    }*/
    /**
     * 取消下载
     */
    public void cancelDown(){
        if(downCall!=null){
            getInstance().downCall.cancel();
        }
    }
    /**
     * @param url 下载连接
     * @param saveDir 储存下载文件的SDCard目录
     * @param listener 下载监听
     */
    //onFailure和onResponse两个方法不是在主线程执行
    public void download(final String url, final String saveDir,final String fileName, final OnDownloadListener listener) {

        Request request = new Request.Builder().addHeader("Accept-Encoding", "identity").url(url).build();
        //request.addHeader("Accept-Encoding", "identity");
        downCall = okHttpClient.newCall(request);

        downCall.enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                // 下载失败
                listener.onDownloadFailed();
            }
            @Override
            public void onResponse(Call call, Response response) throws IOException {
                InputStream is = null;
                //OutputStream outputStream = null;
                byte[] buf = new byte[4096];//2048
                int len = 0;
                OutputStream fos = null;
                // 储存下载文件的目录
                String savePath = isExistDir(saveDir);
                try {
                    is = response.body().byteStream();
                    long total = response.body().contentLength();
                    File file = new File(savePath, fileName);
                    fos = new FileOutputStream(file);
                    long sum = 0;
                    /*while ((len = is.read(buf)) != -1) {
                        fos.write(buf, 0, len);
                        sum += len;
                        int progress = (int) (sum * 1.0f / total * 100);
                        // 下载中
                        listener.onDownloading(progress);
                    }*/
                    while (true) {
                        int read = is.read(buf);
                        if (read == -1) {
                            break;
                        }
                        fos.write(buf, 0, read);
                        sum += read;
                        int progress = (int) (sum * 1.0f / total * 100);
                        // 下载中
                        listener.onDownloading(progress);
                    }
                    fos.flush();
                    // 下载完成
                    listener.onDownloadSuccess();
                } catch (IOException e) {
                    listener.onDownloadFailed();
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
    }

    /**
     * @param saveDir
     * @return
     * @throws IOException
     * 判断下载目录是否存在
     */
    private String isExistDir(String saveDir) throws IOException {
        // 下载位置
        File downloadFile = new File(Environment.getExternalStorageDirectory(), saveDir);
        if (!downloadFile.mkdirs()) {
            downloadFile.createNewFile();
        }
        String savePath = downloadFile.getAbsolutePath();
        return savePath;
    }

    //根据文件名称判断文件是否存在
    public String getFilePathByKey(String saveDir,String fileName){
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
     * @param url
     * @return
     * 从下载连接中解析出文件名
     */
    @NonNull
    public String getNameFromUrl(String url) {
        return url.substring(url.lastIndexOf("/") + 1);
    }

    public interface OnDownloadListener {
        /**
         * 下载成功
         */
        void onDownloadSuccess();

        /**
         * @param progress
         * 下载进度
         */
        void onDownloading(int progress);

        /**
         * 下载失败
         */
        void onDownloadFailed();
    }
}
