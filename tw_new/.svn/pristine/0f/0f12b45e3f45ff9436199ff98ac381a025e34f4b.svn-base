package app.vdaoadmin.qidu.mvp.contract;

import com.amap.api.location.AMapLocation;
import com.app.base.bean.AdminBean;
import com.app.base.bean.AppInfo;
import com.app.base.bean.StatisticsBean;
import com.mvp.lib.view.IUIView;

import org.apache.cordova.api.CallbackContext;
import org.json.JSONObject;

import java.util.HashMap;

import io.reactivex.Observable;

/**
 * Created by 7du-28 on 2018/4/18.
 */

public class HomeContract {
    public interface Presenter {

    }

    public interface Model {
        Observable<AppInfo> checkAppVersion();
        Observable<StatisticsBean> statistics(HashMap<String, String> treeMap);
    }

    public interface View extends IUIView {
        //获取统计数据
        void getStatisticsDataSuccess(StatisticsBean statisticsBean);
        void getStatisticsDataFailure();
    }
}
