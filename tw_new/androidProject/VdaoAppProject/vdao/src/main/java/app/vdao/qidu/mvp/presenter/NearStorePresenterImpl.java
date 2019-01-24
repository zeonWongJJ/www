package app.vdao.qidu.mvp.presenter;

import android.os.Handler;
import android.util.Log;

import com.amap.api.maps.CameraUpdateFactory;
import com.amap.api.maps.model.LatLng;
import com.app.base.bean.Store;
import com.common.lib.base.BaseApplication;
import com.common.lib.utils.SharedPreferencesUtils;
import com.google.gson.Gson;
import com.mvp.lib.presenter.BasePresenter;
import com.net.rx_retrofit_network.location.retrofit.RetrofitUtil;

import org.apache.cordova.api.CallbackContext;

import java.util.HashMap;
import java.util.List;

import app.vdao.qidu.mvp.contract.NearStorePresenterContract;
import app.vdao.qidu.mvp.model.NearStoreModelImpl;
import io.reactivex.Observable;
import io.reactivex.ObservableSource;
import io.reactivex.Observer;
import io.reactivex.Single;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.annotations.NonNull;
import io.reactivex.disposables.Disposable;
import io.reactivex.functions.Function;
import io.reactivex.observers.DisposableObserver;
import io.reactivex.schedulers.Schedulers;

/**
 * Created by 7du-28 on 2018/3/13.
 */

public class NearStorePresenterImpl extends BasePresenter<NearStorePresenterContract.View> implements NearStorePresenterContract.Presenter{

    private NearStoreModelImpl nearStoreModel;
    @Override
    public void onCreate() {
        nearStoreModel=new NearStoreModelImpl();
    }

    @Override
    public void loadData() {

    }

    @Override
    public void getNearStoreList(String cityCode,LatLng locationLatLng) {
        HashMap<String,String> hasMap=new HashMap<String, String>();
        Disposable disposable =nearStoreModel.getNearStoreList("/store_api-"+cityCode,hasMap).subscribeWith(new DisposableObserver<List<Store>>() {
            @Override
            public void onNext(@NonNull List<Store> storeList) {
                sortStoreListObserver(storeList,locationLatLng);
            }

            @Override
            public void onError(@NonNull Throwable e) {

            }
            @Override
            public void onComplete() {

            }
        });
        mCompositeSubscription.add(disposable);//添加订阅
    }



    private void sortStoreListObserver(List<Store> storeList,LatLng locationLatLng){
        Disposable disposable =nearStoreModel.getSortStoreListObserver(storeList,locationLatLng).subscribeOn(Schedulers.io()).unsubscribeOn(Schedulers.io()).observeOn(AndroidSchedulers.mainThread()).subscribeWith(new DisposableObserver<List<Store>>() {

            @Override
            public void onError(Throwable e) {
                //reDisposable(observable);
            }

            @Override
            public void onComplete() {

            }

            @Override
            public void onNext(List<Store> list) {
                Gson gson=new Gson();
                String str=gson.toJson(list);
                SharedPreferencesUtils.getInstance(BaseApplication.getInstance()).saveData("storeListJson",str);
                mView.showNearStoreList(list);
            }
        });
        mCompositeSubscription.add(disposable);
    }




}
