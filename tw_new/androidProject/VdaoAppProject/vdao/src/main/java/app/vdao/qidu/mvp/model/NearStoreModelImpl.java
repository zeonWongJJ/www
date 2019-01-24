package app.vdao.qidu.mvp.model;

import com.amap.api.maps.AMapUtils;
import com.amap.api.maps.model.LatLng;
import com.app.base.bean.Store;
import com.net.rx_retrofit_network.location.rxandroid.ModelFilterFactory;

import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.HashMap;
import java.util.List;

import app.vdao.qidu.mvp.apiservice.ApiServcieImpl;
import app.vdao.qidu.mvp.contract.NearStorePresenterContract;
import io.reactivex.Observable;
import io.reactivex.ObservableEmitter;
import io.reactivex.ObservableOnSubscribe;
import io.reactivex.ObservableSource;
import io.reactivex.Observer;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.functions.Consumer;
import io.reactivex.functions.Function;
import io.reactivex.schedulers.Schedulers;

/**
 * Created by 7du-28 on 2018/3/13.
 */

public class NearStoreModelImpl implements NearStorePresenterContract.Model{


    @Override
    public Observable<List<Store>> getNearStoreList(String url,HashMap<String, String> hashMap) {
        return ModelFilterFactory.compose(ApiServcieImpl.getInstance().getNearStoreList(url,hashMap));
    }

    //附近门店按距离排序
    @Override
    public Observable<List<Store>> getSortStoreListObserver(List<Store> storeList,LatLng locationLatLng) {
        Observable<List<Store>> observable=Observable.create(new ObservableOnSubscribe() {
            @Override
            public void subscribe(ObservableEmitter e) throws Exception {
                List<Store> list=new ArrayList<Store>();
                for(Store item:storeList){
                    //float latitude=Float.parseFloat(item.getStore_latitude());
                    if(!item.getStore_latitude().isEmpty()&&!item.getStore_longitude().isEmpty()){
                        //计算p1、p2两点之间的直线距离，单位：米
                        LatLng storeLatLng=new LatLng(Double.parseDouble(item.getStore_latitude()),Double.parseDouble(item.getStore_longitude()));
                        float distance = AMapUtils.calculateLineDistance(locationLatLng,storeLatLng);
                        item.setDistance(distance);
                        list.add(item);
                    }
                }
                Collections.sort(list,new Comparator<Store>(){
                     /* int compare(Student o1, Student o2) 返回一个基本类型的整型，
                     * 返回负数表示：o1 小于o2，
                     * 返回0 表示：o1和o2相等，
                     * 返回正数表示：o1大于o2。*/
                    public int compare(Store o1, Store o2) {
                        if(o1.getDistance() > o2.getDistance()){
                            return 1;
                        }
                        if(o1.getDistance() == o2.getDistance()){
                            return 0;
                        }
                        return -1;
                    }
                });
                e.onNext(list);
                //e.onNext(storeList);
                e.onComplete();
            }
        });
        return observable;
    }

    //附近门店按距离排序
    public void sortStoreListObserver(List<Store> stores,Observer getObserver){
        Observable.just(stores).flatMap(new Function<List<Store>, ObservableSource<?>>() {
            @Override
            public ObservableSource<?> apply(List<Store> stores) throws Exception {
                return Observable.fromIterable(stores);
            }
        }).subscribeOn(Schedulers.io())
                // Be notified on the main thread
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(getObserver);

    }
}
