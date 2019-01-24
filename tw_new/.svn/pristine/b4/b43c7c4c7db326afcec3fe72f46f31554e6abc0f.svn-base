package app.vdao.qidu.mvp.contract;

import com.mvp.lib.view.IUIView;

import org.apache.cordova.api.CallbackContext;


/**
 * Created by 7du-28 on 2018/3/13.
 */

public class CredentialsUploadContract {
    public interface Presenter {
        void takePhotoPicker();
        void showTipDialog(int uploadType);
    }

    public interface Model {


    }

    public interface View extends IUIView {
        void showToast(String message);
        void uploadSuccess(String path,String url);

        void showLoadingDialog(String message);
        void  dismissLoadingDialog();
    }
}
