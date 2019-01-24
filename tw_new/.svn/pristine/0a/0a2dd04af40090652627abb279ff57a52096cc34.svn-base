package app.vdao.qidu;

import android.app.ActivityManager;
import android.content.Context;
import android.content.Intent;

import com.androidnetworking.AndroidNetworking;
import com.common.lib.base.BaseApplication;
import com.common.lib.global.AppUtils;
import com.common.lib.utils.BaseAppManager;

import java.util.List;

/**
 * Created by 7du-28 on 2018/1/31.
 */

public class AppApplication extends BaseApplication{
    public static boolean isFirst=true;
    private static AppApplication context;
    public static AppApplication getInstance (){
        return context;
    }

    @Override
    public void onCreate() {
        super.onCreate();
        /*if(isUIProcess()){
            isFirst=false;
        }*/
        context=this;
        AndroidNetworking.initialize(getApplicationContext());
        //http://blog.csdn.net/spareyaya/article/details/51714873
        /*Configuration.Builder builder = new Configuration.Builder(this);
        //手动的添加模型类
        builder.addModelClasses(User.class);
        ActiveAndroid.initialize(builder.create());*/
    }
    /**
     * 判断是否在主进程,这个方法判断进程名或者pid都可以,如果进程名一样那pid肯定也一样
     * @return true:当前进程是主进程 false:当前进程不是主进程
     */
    public boolean isUIProcess() {
        ActivityManager am = ((ActivityManager) getSystemService(Context.ACTIVITY_SERVICE));
        List<ActivityManager.RunningAppProcessInfo> processInfos = am.getRunningAppProcesses();
        String mainProcessName = getPackageName();
        int myPid = android.os.Process.myPid();
        for (ActivityManager.RunningAppProcessInfo info : processInfos) {
            if (info.pid == myPid && mainProcessName.equals(info.processName)) {
                return true;
            }
        }
        return false;
    }
    @Override
    public void onTerminate() {
        super.onTerminate();
        //ActiveAndroid.dispose();
    }

    @Override
    public void onTrimMemory(int level) {
        super.onTrimMemory(level);
        if (level == TRIM_MEMORY_UI_HIDDEN) {
            isFirst=false;
        }
    }

    public void exit() {
        Intent intent = new Intent(APP_EXIT_ACTION);
        ((android.app.NotificationManager) getSystemService(Context.NOTIFICATION_SERVICE)).cancelAll();
        sendBroadcast(intent);
        BaseAppManager.getInstance().AppExit(this);
    }
}
