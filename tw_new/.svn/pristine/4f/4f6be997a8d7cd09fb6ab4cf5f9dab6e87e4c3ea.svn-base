package app.vdao.qidu.mvp.contract;

import android.widget.TextView;

import com.app.base.bean.AppInfo;
import com.mvp.lib.view.IUIView;

import org.apache.cordova.api.CallbackContext;

import java.util.HashMap;
import java.util.List;

import io.reactivex.Observable;
import okhttp3.ResponseBody;
import retrofit2.http.Url;

/**
 * Created by 7du-28 on 2018/3/13.
 */

public class HomeContract {

    public interface Presenter {
        void startLocationCurrentPosition(CallbackContext callbackContext);
        void checkAppVersion(boolean isHomePage);
    }

    public interface Model {

        Observable<AppInfo> checkAppVersion();
        //上传图片
        //Observable<String> uploadFiles(String url,HashMap<String, RequestBody> hashMap);

        //定位相关
        void startLocationCurrentPosition(CallbackContext callbackContext);
        void destroyLocation();


    }

    public interface View extends IUIView {
        void showToast(String message);

        void showLoadingDialog(String message);
        void  dismissLoadingDialog();
    }
}
