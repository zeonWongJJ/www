package app.vdao.qidu.service;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.text.TextUtils;

import com.gzqx.common.utils.FileDownloadUtil;

import java.io.File;

/**
 * Created by 7du-28 on 2018/1/16.
 */

public class ApkInstallBroadCastReceiver extends BroadcastReceiver{
    @Override
    public void onReceive(Context context, Intent intent) {
        if (Intent.ACTION_PACKAGE_ADDED.equals(intent.getAction())) {
            deleteApk();
        }

        if (Intent.ACTION_PACKAGE_REMOVED.equals(intent.getAction())) {
            deleteApk();
        }

        if (Intent.ACTION_PACKAGE_REPLACED.equals(intent.getAction())) {
            deleteApk();
        }
    }


    private void deleteApk(){
        String fileKey="vdao.apk";
        String path = FileDownloadUtil.getInstance().getFilePathByKey(FileDownloadUtil.qiduDownLoad,fileKey);
        if(!TextUtils.isEmpty(path)){
            File file = new File(path);
            if (file.isFile() && file.exists()) {
                file.delete();
            }
        }
    }
}
