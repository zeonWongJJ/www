package app.vdaoadmin.qidu.mvp.model;


import com.net.rx_retrofit_network.location.rxandroid.ModelFilterFactory;

import java.util.HashMap;
import java.util.List;

import app.vdaoadmin.qidu.bean.LunchBean;
import app.vdaoadmin.qidu.bean.LunchOrderBean;
import app.vdaoadmin.qidu.bean.MeetingSeatOrderBean;
import app.vdaoadmin.qidu.bean.MeetingSeateBean;
import app.vdaoadmin.qidu.bean.Store;
import app.vdaoadmin.qidu.mvp.apiservice.ApiServcieImpl;
import app.vdaoadmin.qidu.mvp.contract.OrderTabContract;
import app.vdaoadmin.qidu.mvp.contract.StoreContract;
import io.reactivex.Observable;
import okhttp3.MediaType;
import okhttp3.RequestBody;


public class OrderTabModelImpl implements OrderTabContract.Model {
    @Override
    public Observable<LunchBean> lunchOrderList(HashMap<String, String> hashMap) {
        RequestBody description = RequestBody.create(MediaType.parse("multipart/form-data"), "");
        return ModelFilterFactory.compose(ApiServcieImpl.getInstance().lunchOrderList(description,hashMap));
    }

    @Override
    public Observable<MeetingSeateBean> storeMeetingSeatOrderList(HashMap<String, String> hashMap) {
        RequestBody description = RequestBody.create(MediaType.parse("multipart/form-data"), "");
        return ModelFilterFactory.compose(ApiServcieImpl.getInstance().storeMeetingSeatOrderList(description,hashMap));
    }


    @Override
    public Observable<LunchOrderBean> lunchOrderDetail(HashMap<String, String> hashMap) {
        RequestBody description = RequestBody.create(MediaType.parse("multipart/form-data"), "");
        return ModelFilterFactory.compose(ApiServcieImpl.getInstance().lunchOrderDetail(description,hashMap));
    }

    @Override
    public Observable<MeetingSeatOrderBean> seatMeetingOrderDetail(HashMap<String, String> hashMap) {
        RequestBody description = RequestBody.create(MediaType.parse("multipart/form-data"), "");
        return ModelFilterFactory.compose(ApiServcieImpl.getInstance().seatMeetingOrderDetail(description,hashMap));
    }
}
