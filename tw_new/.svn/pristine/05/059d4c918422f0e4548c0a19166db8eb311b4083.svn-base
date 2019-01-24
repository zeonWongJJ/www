package app.vdaoadmin.qidu.mvp.presenter;

import android.util.Log;
import android.widget.Toast;

import app.vdaoadmin.qidu.mvp.contract.DownLoadContract;
import app.vdaoadmin.qidu.mvp.model.DownLoadModelImpl;
import com.net.rx_retrofit_network.location.callback.CallBack;
import com.net.rx_retrofit_network.location.download.DownSubscriber;
import com.mvp.lib.presenter.BasePresenter;

import io.reactivex.disposables.Disposable;
import okhttp3.ResponseBody;

/**
 * Created by 7du-28 on 2018/2/1.
 */

public class DownLoadPresenterImpl extends BasePresenter<DownLoadContract.View> implements DownLoadContract.Presenter{
    public DownLoadModelImpl downLoadModelImpl;
    @Override
    public void onCreate() {
        downLoadModelImpl=new DownLoadModelImpl();
    }
    @Override
    public void downloadFile(String url) {
        Disposable disposable =downLoadModelImpl.downloadFile(url).subscribeWith(new DownSubscriber<ResponseBody>(mView.getActivity(),new CallBack() {
            @Override
            public void onError(Throwable e) {
                Toast.makeText(mView.getActivity(), "失败"+e.getMessage(), Toast.LENGTH_SHORT).show();
            }

            @Override
            public void onProgress(long fileSizeDownloaded, long fileSize) {
                //Toast.makeText(getActivity(),fileSizeDownloaded+"", Toast.LENGTH_SHORT).show();
                Log.i("aaaaa","进度"+fileSizeDownloaded);
            }

            @Override
            public void onSuccess(String path, String name, long fileSize) {
                mView.downloadFileSuccess();

            }
        }));
        mCompositeSubscription.add(disposable);//添加订阅
    }


    @Override
    public void loadData() {

    }
}
