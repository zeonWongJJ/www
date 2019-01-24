package app.vdaoadmin.qidu.mvp.contract;


import com.app.base.bean.Admin;
import com.mvp.lib.view.IUIView;

import java.util.HashMap;
import java.util.List;

import io.reactivex.Observable;


/**
 * Created by 7du-28 on 2018/1/31.
 */

public class LoginContract {
    public interface Model {
        /**
         * 获取登陆数据
         * @return Observable<LoginData>
         */
        Observable<Admin> login(HashMap<String, String> treeMap);
    }
    //prensent接口省略
    public interface Presenter{
        void login(String admin_name,String admin_password);
    }

    public interface View extends IUIView {
        void loginSuccess(Admin adminBean);
        void loginFailure(Throwable e);
    }
}


