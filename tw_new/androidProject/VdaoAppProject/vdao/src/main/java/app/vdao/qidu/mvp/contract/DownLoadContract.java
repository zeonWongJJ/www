package app.vdao.qidu.mvp.contract;

import com.mvp.lib.view.IUIView;

import io.reactivex.Observable;
import okhttp3.ResponseBody;
import retrofit2.http.Url;

/**
 * Created by 7du-28 on 2018/2/1.
 */

public class DownLoadContract {
    public interface Model {
        Observable<ResponseBody> downloadFile(@Url String fileUrl);
    }

    public interface Presenter{
        void downloadFile(String url);
    }

    public interface View extends IUIView {
        void downloadFileSuccess();
    }
}
