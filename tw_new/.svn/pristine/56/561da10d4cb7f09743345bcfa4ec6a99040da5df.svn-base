package app.vdaoadmin.qidu.mvp.presenter;

import android.text.TextUtils;
import android.util.Log;

import com.amap.api.location.AMapLocation;
import com.app.base.bean.AdminBean;
import com.app.base.bean.AppInfo;
import com.app.base.bean.StatisticsBean;
import com.app.base.utils.CommonKey;
import com.common.lib.base.BaseApplication;
import com.common.lib.utils.SharedPreferencesUtils;
import com.mvp.lib.presenter.BasePresenter;

import org.apache.cordova.api.CallbackContext;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;

import app.vdaoadmin.qidu.mvp.contract.HomeContract;
import app.vdaoadmin.qidu.mvp.model.HomeModelImpl;
import app.vdaoadmin.qidu.utils.VersionUpdateManager;
import io.reactivex.annotations.NonNull;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;


/**
 * 首页
 */

public class HomePresenterImpl extends BasePresenter<HomeContract.View> implements HomeContract.Presenter{
    private HomeModelImpl homeModel;

    @Override
    public void onCreate() {
        homeModel=new HomeModelImpl();
    }

    @Override
    public void loadData() {
        //通过modle请求接口
        HashMap<String,String> hasMap=new HashMap<String, String>();
        AdminBean adminBean=AdminBean.getAdminBean();
        hasMap.put("token",adminBean.getToken()+"");
        Disposable disposable =homeModel.statistics(hasMap)
                .subscribeWith(new DisposableObserver<StatisticsBean>() {
                    @Override
                    public void onNext(@NonNull StatisticsBean statisticsBean) {
                        mView.getStatisticsDataSuccess(statisticsBean);
                    }

                    @Override
                    public void onError(@NonNull Throwable e) {
                        mView.getStatisticsDataFailure();
                    }
                    @Override
                    public void onComplete() {

                    }
                });
        mCompositeSubscription.add(disposable);//添加订阅

        checkAppVersion();

    }

    public void checkAppVersion() {
        Disposable disposable =homeModel.checkAppVersion().subscribeWith(new DisposableObserver<AppInfo>() {
            @Override
            public void onNext(@NonNull AppInfo appInfo) {
                VersionUpdateManager versionUpdateManager=new VersionUpdateManager(mView.getActivity());
                versionUpdateManager.updateVersion(appInfo);
            }

            @Override
            public void onError(@NonNull Throwable e) {
                //Log.i("aaaaaaaa","onError"+e.getMessage());
            }
            @Override
            public void onComplete() {

            }
        });
        mCompositeSubscription.add(disposable);
    }
}
