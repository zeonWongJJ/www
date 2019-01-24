package app.vdao.qidu.mvp.model;

import app.vdao.qidu.mvp.contract.DownLoadContract;
import app.vdao.qidu.mvp.apiservice.ApiServcieImpl;
import com.net.rx_retrofit_network.location.rxandroid.ModelFilterFactory;

import io.reactivex.Observable;
import okhttp3.ResponseBody;
import retrofit2.http.Url;

/**
 * Created by 7du-28 on 2018/2/1.
 */

public class DownLoadModelImpl implements DownLoadContract.Model {

    @Override
    public Observable<ResponseBody> downloadFile(@Url String fileUrl) {
        return ModelFilterFactory.composeResponseBody(ApiServcieImpl.getInstance().downloadFile(fileUrl));
    }
}
