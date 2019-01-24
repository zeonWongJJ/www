package app.vdaoadmin.qidu.mvp.model;


import com.net.rx_retrofit_network.location.rxandroid.ModelFilterFactory;

import java.util.HashMap;
import java.util.List;

import app.vdaoadmin.qidu.bean.Store;
import app.vdaoadmin.qidu.mvp.apiservice.ApiServcieImpl;
import app.vdaoadmin.qidu.mvp.contract.MessageContract;
import app.vdaoadmin.qidu.mvp.contract.StoreContract;
import io.reactivex.Observable;
import okhttp3.MediaType;
import okhttp3.RequestBody;


public class StoreModelImpl implements StoreContract.Model {
    @Override
    public Observable<List<Store>> storeList(HashMap<String, String> hashMap) {
        RequestBody description = RequestBody.create(MediaType.parse("multipart/form-data"), "");
        return ModelFilterFactory.compose(ApiServcieImpl.getInstance().storeList(description,hashMap));
    }
}
