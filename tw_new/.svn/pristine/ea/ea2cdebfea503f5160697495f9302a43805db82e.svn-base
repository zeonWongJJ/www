package app.vdaoadmin.qidu.mvp.contract;

import com.mvp.lib.view.IUIView;

import java.util.HashMap;
import java.util.List;

import app.vdaoadmin.qidu.bean.MessageBean;
import app.vdaoadmin.qidu.bean.Store;
import io.reactivex.Observable;


public class StoreContract {
    public interface Presenter {
        void loadData(int pageIndex,String keyWord);
    }

    public interface Model {

        Observable<List<Store>> storeList(HashMap<String, String> treeMap);
    }

    public interface View extends IUIView {
        void showStoreList(int pageIndex, List<Store> list);
        void showStoreListFailure();
    }
}
