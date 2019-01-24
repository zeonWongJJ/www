package app.vdao.qidu.mvp.contract;

import com.amap.api.maps.model.LatLng;
import com.app.base.bean.Store;
import com.mvp.lib.view.IUIView;

import org.apache.cordova.api.CallbackContext;

import java.util.HashMap;
import java.util.List;

import io.reactivex.Observable;

/**
 * Created by 7du-28 on 2018/3/13.
 */

public class NearStorePresenterContract {

    public interface Presenter {
        void getNearStoreList(String cityCode,LatLng locationLatLng);
    }

    public interface Model {
        /**
         * 获取附近店铺数据
         * @return Observable<LoginData>
         */
        Observable<List<Store>> getNearStoreList(String url,HashMap<String, String> hashMap);


        /*店铺按距离排序
        * */
        Observable<List<Store>> getSortStoreListObserver(List<Store> storeList,LatLng locationLatLng);
    }

    public interface View extends IUIView {
        void showNearStoreList(List<Store> storeList);
    }
}
