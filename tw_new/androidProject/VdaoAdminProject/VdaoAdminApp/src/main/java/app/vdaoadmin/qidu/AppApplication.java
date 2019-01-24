package app.vdaoadmin.qidu;

import android.app.Application;
import android.content.Context;

import com.activeandroid.ActiveAndroid;
import com.activeandroid.Configuration;
import com.app.base.bean.AdminBean;
import com.common.lib.base.BaseApplication;

/**
 * Created by 7du-28 on 2018/1/31.
 */

public class AppApplication extends BaseApplication{

    private static Context context;
    public static Context getInstance (){
        return context;
    }

    @Override
    public void onCreate() {
        super.onCreate();
        context=getApplicationContext();
        Configuration.Builder builder = new Configuration.Builder(this);
        //手动的添加模型类
        builder.addModelClasses(AdminBean.class);
        ActiveAndroid.initialize(builder.create());
    }

    @Override
    public void onTerminate() {
        super.onTerminate();
        ActiveAndroid.dispose();
    }
}
