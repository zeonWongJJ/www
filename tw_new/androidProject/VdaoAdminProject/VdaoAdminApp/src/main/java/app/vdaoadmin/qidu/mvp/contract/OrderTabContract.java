package app.vdaoadmin.qidu.mvp.contract;

import com.mvp.lib.view.IUIView;

import java.util.HashMap;
import java.util.List;

import app.vdaoadmin.qidu.bean.LunchBean;
import app.vdaoadmin.qidu.bean.LunchOrderBean;
import app.vdaoadmin.qidu.bean.MeetingSeatOrderBean;
import app.vdaoadmin.qidu.bean.MeetingSeateBean;
import io.reactivex.Observable;

/**
 * Created by 7du-28 on 2018/4/18.
 */

public class OrderTabContract {
    public interface Presenter {
        void loadLunchOrderData(int pageIndex,String storeId,String orderState);
        void loadMeetingOrderData(int pageIndex,String storeId,String appointmentState,String appointmentType);

        //餐饮订单详情
        void lunchOrderDetail(String orderId);
        void meetingSeatOrderDetail(String appointmentId);
    }

    public interface Model {
        Observable<LunchBean> lunchOrderList(HashMap<String, String> treeMap);
        //会议和座位订单
        Observable<MeetingSeateBean> storeMeetingSeatOrderList(HashMap<String, String> treeMap);

        //餐饮订单详情
        Observable<LunchOrderBean> lunchOrderDetail(HashMap<String, String> hashMap);
        //会议/座位订单详情
        Observable<MeetingSeatOrderBean> seatMeetingOrderDetail(HashMap<String, String> hashMap);
    }

    public interface View extends IUIView {
        //餐饮
        void showLunchListSuccess(int pageIndex,LunchBean lunchBean);
        void showLunchListFailure();

        //会议和座位订单
        void showMeetingSeatListSuccess(int pageIndex,MeetingSeateBean lunchBean);


        void showLunchOrderDetail(LunchOrderBean orderBean);
        void showOrderDetailFailure();

        void showSeatMeetingOrderDetail(MeetingSeatOrderBean orderBean);
    }
}
