package app.vdaoadmin.qidu.mvp.model;


import com.app.base.bean.User;
import com.net.rx_retrofit_network.location.rxandroid.ModelFilterFactory;

import java.util.HashMap;
import java.util.List;

import app.vdaoadmin.qidu.bean.Store;
import app.vdaoadmin.qidu.mvp.apiservice.ApiServcieImpl;
import app.vdaoadmin.qidu.mvp.contract.StoreContract;
import app.vdaoadmin.qidu.mvp.contract.UserContract;
import io.reactivex.Observable;
import okhttp3.MediaType;
import okhttp3.RequestBody;


public class UserModelImpl implements UserContract.Model {
    @Override
    public Observable<List<User>> userList(HashMap<String, String> hashMap) {
        RequestBody description = RequestBody.create(MediaType.parse("multipart/form-data"), "");
        return ModelFilterFactory.compose(ApiServcieImpl.getInstance().userList(description,hashMap));
    }

    @Override
    public Observable<List<User>> searchShopkeeperList(HashMap<String, String> hashMap) {
        RequestBody description = RequestBody.create(MediaType.parse("multipart/form-data"), "");
        return ModelFilterFactory.compose(ApiServcieImpl.getInstance().searchShopkeeperList(description,hashMap));
    }
}
