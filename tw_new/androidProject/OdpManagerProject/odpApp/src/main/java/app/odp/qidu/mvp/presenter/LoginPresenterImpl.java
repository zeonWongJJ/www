package app.odp.qidu.mvp.presenter;


import android.util.Log;

import app.odp.qidu.mvp.contract.LoginContract;

import com.app.base.bean.BaseResponse;
import com.app.base.bean.MemberRealm;
import com.app.base.bean.UserRealm;
import com.app.base.netUtil.MemberHttpUtil;
import com.app.base.utils.CommonKey;
import com.app.base.utils.HttpUrl;
import com.common.lib.base.BaseApplication;
import com.common.lib.utils.SharedPreferencesUtils;
import com.common.lib.basemvp.presenter.BasePresenter;
import com.common.lib.utils.ToastUtils;

import java.util.HashMap;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;
import io.realm.Realm;


public class LoginPresenterImpl extends BasePresenter<LoginContract.View> implements LoginContract.Presenter{
    @Override
    public void onCreate(){

    }
    @Override
    public void loadData() {

    }
    @Override
    public void login(String account,String password){
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("member_name",account);
        hashMap.put("password",password);
        Disposable disposable= MemberHttpUtil.getInstance().login(hashMap,new DisposableObserver<MemberRealm>() {
            @Override
            public void onComplete() {

            }
            @Override
            public void onError(Throwable e) {
                ToastUtils.show(e.getMessage());
            }
            @Override
            public void onNext(MemberRealm userRealm) {
                if(userRealm!=null){
                    SharedPreferencesUtils.getInstance(BaseApplication.getInstance()).getData(CommonKey.KEY_IS_LOGIN,true);
                    MemberRealm.insertMemberRealm(userRealm, () ->
                            mView.loginSuccess(), error -> mView.onError());
                }else {
                    mView.onError();
                }
            }
        },MemberRealm.class);
        mCompositeSubscription.add(disposable);
    }
}
