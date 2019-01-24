package app.vdaoadmin.qidu.mvp.presenter;

import com.app.base.bean.AdminBean;
import com.mvp.lib.presenter.BasePresenter;

import java.util.HashMap;
import java.util.List;

import app.vdaoadmin.qidu.bean.LunchBean;
import app.vdaoadmin.qidu.bean.LunchOrderBean;
import app.vdaoadmin.qidu.bean.MeetingSeatOrderBean;
import app.vdaoadmin.qidu.bean.MeetingSeateBean;
import app.vdaoadmin.qidu.bean.Store;
import app.vdaoadmin.qidu.mvp.contract.HomeContract;
import app.vdaoadmin.qidu.mvp.contract.OrderTabContract;
import app.vdaoadmin.qidu.mvp.model.OrderTabModelImpl;
import io.reactivex.annotations.NonNull;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;


/**
 *  餐饮订单-会议订单-座位订单
 */

public class OrderTabPresenterImpl extends BasePresenter<OrderTabContract.View> implements OrderTabContract.Presenter{
    private OrderTabModelImpl orderTabModel;
//LunchBean
    @Override
    public void onCreate() {
        orderTabModel=new OrderTabModelImpl();
    }

    @Override
    public void loadData() {


    }


    @Override
    public void loadLunchOrderData(int pageIndex,String storeId,String orderState) {
        HashMap<String,String> hasMap=new HashMap<String, String>();
        hasMap.put("pageSize","10");
        hasMap.put("pageNum",pageIndex+"");
        hasMap.put("storeId",storeId+"");
        hasMap.put("orderState",orderState+"");
        AdminBean adminBean=AdminBean.getAdminBean();
        hasMap.put("token",adminBean.getToken()+"");
        Disposable disposable =orderTabModel.lunchOrderList(hasMap)
                .subscribeWith(new DisposableObserver<LunchBean>() {
                    @Override
                    public void onNext(@NonNull LunchBean lunchBean) {
                        mView.showLunchListSuccess(pageIndex,lunchBean);
                    }

                    @Override
                    public void onError(@NonNull Throwable e) {
                        mView.showLunchListFailure();
                    }
                    @Override
                    public void onComplete() {

                    }
                });
        mCompositeSubscription.add(disposable);
    }


    @Override
    public void loadMeetingOrderData(int pageIndex,String storeId,String appointmentState,String appointmentType) {
        HashMap<String,String> hasMap=new HashMap<String, String>();
        hasMap.put("pageSize","10");
        hasMap.put("pageNum",pageIndex+"");
        hasMap.put("storeId",storeId+"");
        hasMap.put("appointmentState",appointmentState+"");
        hasMap.put("appointmentType",appointmentType+"");
        AdminBean adminBean=AdminBean.getAdminBean();
        hasMap.put("token",adminBean.getToken()+"");
        Disposable disposable =orderTabModel.storeMeetingSeatOrderList(hasMap)
                .subscribeWith(new DisposableObserver<MeetingSeateBean>() {
                    @Override
                    public void onNext(@NonNull MeetingSeateBean meetingSeateBean) {
                        mView.showMeetingSeatListSuccess(pageIndex,meetingSeateBean);
                    }

                    @Override
                    public void onError(@NonNull Throwable e) {
                        mView.showLunchListFailure();
                    }
                    @Override
                    public void onComplete() {

                    }
                });
        mCompositeSubscription.add(disposable);
    }

    @Override
    public void lunchOrderDetail(String orderId) {
        HashMap<String,String> hasMap=new HashMap<String, String>();
        hasMap.put("orderId",orderId);
        AdminBean adminBean=AdminBean.getAdminBean();
        hasMap.put("token",adminBean.getToken()+"");
        Disposable disposable =orderTabModel.lunchOrderDetail(hasMap)
                .subscribeWith(new DisposableObserver<LunchOrderBean>() {
                    @Override
                    public void onNext(@NonNull LunchOrderBean lunchOrderBean) {
                        mView.showLunchOrderDetail(lunchOrderBean);
                    }

                    @Override
                    public void onError(@NonNull Throwable e) {
                        mView.showOrderDetailFailure();
                    }
                    @Override
                    public void onComplete() {

                    }
                });
        mCompositeSubscription.add(disposable);
    }

    @Override
    public void meetingSeatOrderDetail(String appointmentId) {
        HashMap<String,String> hasMap=new HashMap<String, String>();
        hasMap.put("appointmentId",appointmentId);
        AdminBean adminBean=AdminBean.getAdminBean();
        hasMap.put("token",adminBean.getToken()+"");
        Disposable disposable =orderTabModel.seatMeetingOrderDetail(hasMap)
                .subscribeWith(new DisposableObserver<MeetingSeatOrderBean>() {
                    @Override
                    public void onNext(@NonNull MeetingSeatOrderBean meetingSeateBean) {
                        mView.showSeatMeetingOrderDetail(meetingSeateBean);
                    }

                    @Override
                    public void onError(@NonNull Throwable e) {
                        mView.showOrderDetailFailure();
                    }
                    @Override
                    public void onComplete() {

                    }
                });
        mCompositeSubscription.add(disposable);
    }


}
