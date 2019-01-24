package app.vdaoadmin.qidu.mvp.model;


import com.app.base.bean.AdminBean;
import com.app.base.bean.AppInfo;
import com.app.base.bean.StatisticsBean;
import com.net.rx_retrofit_network.location.rxandroid.ModelFilterFactory;

import java.util.HashMap;

import app.vdaoadmin.qidu.mvp.apiservice.ApiServcieImpl;
import app.vdaoadmin.qidu.mvp.contract.HomeContract;
import app.vdaoadmin.qidu.mvp.contract.LoginContract;
import io.reactivex.Observable;
import okhttp3.MediaType;
import okhttp3.RequestBody;


public class HomeModelImpl implements HomeContract.Model {
    @Override
    public Observable<StatisticsBean> statistics(HashMap<String, String> hashMap) {
        RequestBody description = RequestBody.create(MediaType.parse("multipart/form-data"), "");
        return ModelFilterFactory.compose(ApiServcieImpl.getInstance().statistics(description,hashMap));
    }

    @Override
    public Observable<AppInfo> checkAppVersion() {
        HashMap<String,String> hashMap=new HashMap<String, String>();
        return ModelFilterFactory.compose(ApiServcieImpl.getInstance().checkAppVersion(hashMap));
    }
}
