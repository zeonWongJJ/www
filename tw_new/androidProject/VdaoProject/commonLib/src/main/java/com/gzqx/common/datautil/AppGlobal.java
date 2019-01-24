package com.gzqx.common.datautil;


import android.app.Application;
import android.content.Context;
import android.os.Environment;
import android.util.Log;

import java.io.File;

public class AppGlobal {
    public static String sdcardDir;
    public static String FILE_DOWNLOAD_DIR;//下载文件存放的文件夹
    public static String QIDUSTOREDIR;
    public static String HTTP_DATA_CACHE;

    public static String CRASH_LOG;


    public static void initGlobal(Context context) {
        //因为不是放在application里面初始化,所以每次都要重新初始化
        FILE_DOWNLOAD_DIR="FILE_DOWNLOAD/";
        QIDUSTOREDIR="QIDU_DEFAULT_CACHE/";
        CRASH_LOG="qiduCrashLog/";
        HTTP_DATA_CACHE="httpDataCache/";
        String state = Environment.getExternalStorageState();
        AppGlobal.sdcardDir = state.equals(Environment.MEDIA_MOUNTED) ? Environment.getExternalStorageDirectory().getAbsolutePath()+ File.separator+QIDUSTOREDIR: context.getCacheDir().getAbsolutePath()+ File.separator+QIDUSTOREDIR;
        AppGlobal.CRASH_LOG=AppGlobal.sdcardDir+CRASH_LOG;
        AppGlobal.FILE_DOWNLOAD_DIR=AppGlobal.sdcardDir+FILE_DOWNLOAD_DIR;
        HTTP_DATA_CACHE=AppGlobal.sdcardDir+HTTP_DATA_CACHE;
        File directory = new File(AppGlobal.sdcardDir);
        if (!directory.exists()) {
            directory.mkdirs();
        }
        File httpCache = new File(AppGlobal.HTTP_DATA_CACHE);
        if (!httpCache.exists()) {
            httpCache.mkdir();
        }

        File fileDownLoad = new File(AppGlobal.FILE_DOWNLOAD_DIR);
        if (!fileDownLoad.exists()) {
            fileDownLoad.mkdir();
        }
        File fileLog = new File(AppGlobal.CRASH_LOG);
        if (!fileLog.exists()) {
            fileLog.mkdir();
        }

    }
}
