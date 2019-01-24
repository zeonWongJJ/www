package app.vdaoadmin.qidu.mvp.presenter;

import com.app.base.bean.AdminBean;
import com.mvp.lib.presenter.BasePresenter;

import java.util.HashMap;
import java.util.List;

import app.vdaoadmin.qidu.bean.Store;
import app.vdaoadmin.qidu.mvp.contract.StoreContract;
import app.vdaoadmin.qidu.mvp.model.StoreModelImpl;
import io.reactivex.annotations.NonNull;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;


/**
 * 首页
 */

public class StorePresenterImpl extends BasePresenter<StoreContract.View> implements StoreContract.Presenter{
    private StoreModelImpl storeModel;

    @Override
    public void onCreate() {
        storeModel=new StoreModelImpl();
    }

    @Override
    public void loadData() {

    }


    @Override
    public void loadData(int pageIndex,String keyWord) {
        //通过modle请求接口
        HashMap<String,String> hasMap=new HashMap<String, String>();
        hasMap.put("pageSize","10");
        hasMap.put("pageNum",pageIndex+"");
        hasMap.put("keywords",keyWord);
        AdminBean adminBean=AdminBean.getAdminBean();
        hasMap.put("token",adminBean.getToken()+"");
        Disposable disposable =storeModel.storeList(hasMap)
                .subscribeWith(new DisposableObserver<List<Store>>() {
                    @Override
                    public void onNext(@NonNull List<Store> storeList) {
                        mView.showStoreList(pageIndex,storeList);
                    }

                    @Override
                    public void onError(@NonNull Throwable e) {
                        mView.showStoreListFailure();
                    }
                    @Override
                    public void onComplete() {

                    }
                });
        mCompositeSubscription.add(disposable);//添加订阅
    }
}
