package app.vdaoadmin.qidu.mvp.presenter;

import android.util.Log;

import com.app.base.bean.AdminBean;
import com.app.base.bean.User;
import com.mvp.lib.presenter.BasePresenter;

import java.util.HashMap;
import java.util.List;

import app.vdaoadmin.qidu.bean.Store;
import app.vdaoadmin.qidu.mvp.contract.StoreContract;
import app.vdaoadmin.qidu.mvp.contract.UserContract;
import app.vdaoadmin.qidu.mvp.model.StoreModelImpl;
import app.vdaoadmin.qidu.mvp.model.UserModelImpl;
import io.reactivex.annotations.NonNull;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;


/**
 * 首页
 */

public class UserPresenterImpl extends BasePresenter<UserContract.View> implements UserContract.Presenter{
    private UserModelImpl userModel;

    @Override
    public void onCreate() {
        userModel=new UserModelImpl();
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
        Disposable disposable =userModel.userList(hasMap)
                .subscribeWith(new DisposableObserver<List<User>>() {
                    @Override
                    public void onNext(@NonNull List<User> userList) {
                        mView.showUserList(pageIndex,userList);
                    }

                    @Override
                    public void onError(@NonNull Throwable e) {
                        mView.showUserListFailure();
                    }
                    @Override
                    public void onComplete() {

                    }
                });
        mCompositeSubscription.add(disposable);//添加订阅
    }

    @Override
    public void loadShopKeeperData(int pageIndex, String keyWord, String shopkeeperState) {
        //通过modle请求接口
        HashMap<String,String> hasMap=new HashMap<String, String>();
        hasMap.put("pageSize","10");
        hasMap.put("pageNum",pageIndex+"");
        hasMap.put("keywords",keyWord);
        hasMap.put("shopkeeperState",shopkeeperState);
        AdminBean adminBean=AdminBean.getAdminBean();
        hasMap.put("token",adminBean.getToken()+"");
        Disposable disposable =userModel.searchShopkeeperList(hasMap)
                .subscribeWith(new DisposableObserver<List<User>>() {
                    @Override
                    public void onNext(@NonNull List<User> userList) {
                        mView.showUserList(pageIndex,userList);
                    }

                    @Override
                    public void onError(@NonNull Throwable e) {
                        mView.showUserListFailure();
                    }
                    @Override
                    public void onComplete() {

                    }
                });
        mCompositeSubscription.add(disposable);//添加订阅
    }
}
