package app.odp.qidu.mvp.contract;


import com.common.lib.basemvp.view.IUIView;

/**
 * Created by 7du-28 on 2018/1/31.
 */

public class LoginContract {

    //prensent接口省略
    public interface Presenter{
        void login(String account,String password);
    }

    public interface View extends IUIView {
        void loginSuccess();
        void onError();
    }
}


