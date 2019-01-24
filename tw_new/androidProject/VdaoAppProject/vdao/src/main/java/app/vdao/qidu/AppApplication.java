package app.vdao.qidu;

import android.app.Application;
import android.content.Context;
import android.content.Intent;

import com.activeandroid.ActiveAndroid;
import com.activeandroid.Configuration;
import com.app.base.bean.User;
import com.common.lib.base.BaseApplication;
import com.common.lib.utils.BaseAppManager;

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
        context=this;

        //http://blog.csdn.net/spareyaya/article/details/51714873
        Configuration.Builder builder = new Configuration.Builder(this);
        //手动的添加模型类
        builder.addModelClasses(User.class);
        ActiveAndroid.initialize(builder.create());
    }

    @Override
    public void onTerminate() {
        super.onTerminate();
        ActiveAndroid.dispose();
    }


    public void exit() {
        Intent intent = new Intent(APP_EXIT_ACTION);
        ((android.app.NotificationManager) getSystemService(Context.NOTIFICATION_SERVICE)).cancelAll();
        sendBroadcast(intent);
        BaseAppManager.getInstance().AppExit(this);
    }
}
