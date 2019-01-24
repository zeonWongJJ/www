package app.vdaoadmin.qidu.mvp.model;


import app.vdaoadmin.qidu.mvp.contract.LoginContract;
import app.vdaoadmin.qidu.mvp.apiservice.ApiServcieImpl;

import com.app.base.bean.Admin;
import com.app.base.bean.AdminBean;
import com.net.rx_retrofit_network.location.rxandroid.ModelFilterFactory;

import java.util.HashMap;
import java.util.List;

import io.reactivex.Observable;
import okhttp3.MediaType;
import okhttp3.RequestBody;


public class LoginModelImpl implements LoginContract.Model {
    @Override
    public Observable<Admin> login(HashMap<String, String> hashMap) {
        RequestBody description = RequestBody.create(MediaType.parse("multipart/form-data"), "");
        return ModelFilterFactory.compose(ApiServcieImpl.getInstance().login(description,hashMap));
    }
}
