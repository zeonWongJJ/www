package app.vdao.qidu.mvp.model;


import app.vdao.qidu.mvp.contract.LoginContract;
import app.vdao.qidu.mvp.apiservice.ApiServcieImpl;

import com.app.base.bean.Store;
import com.net.rx_retrofit_network.location.rxandroid.ModelFilterFactory;

import java.util.HashMap;
import java.util.List;

import io.reactivex.Observable;


public class LoginModelImpl implements LoginContract.Model {
    @Override
    public Observable<List<Store>> login(HashMap<String, String> hashMap) {
        return ModelFilterFactory.compose(ApiServcieImpl.getInstance().login(hashMap));
    }
}
