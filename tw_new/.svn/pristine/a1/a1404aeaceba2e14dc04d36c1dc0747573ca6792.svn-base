package app.vdaoadmin.qidu.mvp.model;


import android.util.Log;

import com.app.base.bean.AdminBean;
import com.net.rx_retrofit_network.location.rxandroid.ModelFilterFactory;

import java.util.HashMap;
import java.util.List;

import app.vdaoadmin.qidu.bean.MessageBean;
import app.vdaoadmin.qidu.mvp.apiservice.ApiServcieImpl;
import app.vdaoadmin.qidu.mvp.contract.MessageContract;
import io.reactivex.Observable;
import okhttp3.MediaType;
import okhttp3.RequestBody;


public class MessageModelImpl implements MessageContract.Model {
    @Override
    public Observable<List<MessageBean>> messageList(HashMap<String, String> hashMap) {
        RequestBody description = RequestBody.create(MediaType.parse("multipart/form-data"), "");
        return ModelFilterFactory.compose(ApiServcieImpl.getInstance().messageList(description,hashMap));
    }
}
