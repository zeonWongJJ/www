package app.vdaoadmin.qidu.mvp.contract;

import com.app.base.bean.User;
import com.mvp.lib.view.IUIView;

import java.util.HashMap;
import java.util.List;

import app.vdaoadmin.qidu.bean.Store;
import io.reactivex.Observable;


public class UserContract {
    public interface Presenter {
        void loadData(int pageIndex,String keyWord);
        //搜索移动店主
        void loadShopKeeperData(int pageIndex,String keyWord,String shopkeeperState);
    }

    public interface Model {

        Observable<List<User>> userList(HashMap<String, String> treeMap);

        Observable<List<User>> searchShopkeeperList(HashMap<String, String> treeMap);
    }

    public interface View extends IUIView {
        void showUserList(int pageIndex, List<User> list);
        void showUserListFailure();
    }
}
