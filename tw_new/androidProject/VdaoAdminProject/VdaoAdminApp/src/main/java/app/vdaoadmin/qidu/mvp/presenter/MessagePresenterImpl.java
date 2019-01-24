package app.vdaoadmin.qidu.mvp.presenter;

import android.util.Log;

import com.app.base.bean.AdminBean;
import com.app.base.bean.StatisticsBean;
import com.mvp.lib.presenter.BasePresenter;
import com.net.rx_retrofit_network.location.ExceptionHandle;

import java.util.HashMap;
import java.util.List;

import app.vdaoadmin.qidu.bean.MessageBean;
import app.vdaoadmin.qidu.mvp.contract.HomeContract;
import app.vdaoadmin.qidu.mvp.contract.MessageContract;
import app.vdaoadmin.qidu.mvp.model.MessageModelImpl;
import io.reactivex.annotations.NonNull;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;


/**
 * 首页
 */

public class MessagePresenterImpl extends BasePresenter<MessageContract.View> implements MessageContract.Presenter{
    private MessageModelImpl messageModel;

    @Override
    public void onCreate() {
        messageModel=new MessageModelImpl();
    }

    @Override
    public void loadData() {

    }


    @Override
    public void loadData(int pageIndex) {
        //通过modle请求接口
        HashMap<String,String> hasMap=new HashMap<String, String>();
        hasMap.put("pageSize","10");
        hasMap.put("pageNum",pageIndex+"");
        AdminBean adminBean=AdminBean.getAdminBean();
        hasMap.put("token",adminBean.getToken()+"");
        Disposable disposable =messageModel.messageList(hasMap)
                .subscribeWith(new DisposableObserver<List<MessageBean>>() {
                    @Override
                    public void onNext(@NonNull List<MessageBean> messageBeans) {
                        mView.showMessageList(pageIndex,messageBeans);
                    }

                    @Override
                    public void onError(@NonNull Throwable e) {
                        mView.showMessageListFailure();
                    }
                    @Override
                    public void onComplete() {

                    }
                });
        mCompositeSubscription.add(disposable);//添加订阅
    }
}
