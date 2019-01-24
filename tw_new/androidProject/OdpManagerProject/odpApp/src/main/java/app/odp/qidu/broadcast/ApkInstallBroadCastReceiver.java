package app.odp.qidu.broadcast;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;

import java.io.File;

/**
 * Created by 7du-28 on 2018/1/16.
 */

public class ApkInstallBroadCastReceiver extends BroadcastReceiver{
    private String fileDirName="upgrade_apk";
    @Override
    public void onReceive(Context context, Intent intent) {
        if (Intent.ACTION_PACKAGE_ADDED.equals(intent.getAction())) {
            deleteApk(context);
        }

        if (Intent.ACTION_PACKAGE_REMOVED.equals(intent.getAction())) {
            deleteApk(context);
        }

        if (Intent.ACTION_PACKAGE_REPLACED.equals(intent.getAction())) {
            deleteApk(context);
        }
    }


    private void deleteApk(Context context){
        String fileKey="odp.apk";
        final String saveDir = context.getApplicationContext().getExternalFilesDir(fileDirName) + File.separator;
        File file = new File(saveDir, fileKey);
        if (file.isFile() && file.exists()) {
            file.delete();
        }
    }
}
