package app.vdaoadmin.qidu.mvp.contract;

import com.app.base.bean.StatisticsBean;
import com.mvp.lib.view.IUIView;

import java.util.HashMap;
import java.util.List;

import app.vdaoadmin.qidu.bean.MessageBean;
import app.vdaoadmin.qidu.bean.Store;
import io.reactivex.Observable;

/**
 * Created by 7du-28 on 2018/4/18.
 */

public class MessageContract {
    public interface Presenter {
        void loadData(int pageIndex);
    }

    public interface Model {

        Observable<List<MessageBean>> messageList(HashMap<String, String> treeMap);
    }

    public interface View extends IUIView {
        void showMessageList(int pageIndex,List<MessageBean> list);
        void showMessageListFailure();
    }
}
