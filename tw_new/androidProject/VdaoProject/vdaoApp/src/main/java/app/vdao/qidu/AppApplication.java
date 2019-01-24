package app.vdao.qidu;

import android.content.Context;
import android.support.multidex.MultiDex;

import com.qidu.chat.RocketChatApplication;

public class AppApplication extends RocketChatApplication {
    public static int shoppingCarNum=0;//购物车货数量
    public static boolean isFirst=true;
    @Override
    public void onCreate() {
        super.onCreate();

        // 这里实现SDK初始化，appId替换成你的在Bugly平台申请的appId
        // 调试时，将第三个参数改为true
        /*Bugly.setIsDevelopmentDevice(this, true);
        //设置为开发设备
        CrashReport.setIsDevelopmentDevice(this, true);
        Bugly.init(this, "04d8ba9a10", false);
        CrashReport.setUserId(this, "1829081637");*/
    }

    @Override
    protected void attachBaseContext(Context base) {
        super.attachBaseContext(base);
        // you must install multiDex whatever tinker is installed!
        MultiDex.install(base);
        // 安装tinker
        //Beta.installTinker();
    }
}
