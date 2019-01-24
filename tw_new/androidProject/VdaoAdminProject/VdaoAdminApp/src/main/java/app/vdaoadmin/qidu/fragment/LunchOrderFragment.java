package app.vdaoadmin.qidu.fragment;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.anthony.rvhelper.divider.DividerItemDecoration;
import com.app.base.base.AbsListFragment;
import com.common.lib.widget.StatusViewLayout;
import com.mvp.lib.presenter.BasePresenter;
import com.mvp.lib.view.IBaseFragmentView;

import java.util.ArrayList;
import java.util.List;

import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.activity.LunchOrderActivity;
import app.vdaoadmin.qidu.adapter.LunchOrderListAdapter;
import app.vdaoadmin.qidu.adapter.OrderListAdapter;
import app.vdaoadmin.qidu.adapter.SeatOrderListAdapter;
import app.vdaoadmin.qidu.bean.LunchBean;
import app.vdaoadmin.qidu.bean.LunchOrderBean;
import app.vdaoadmin.qidu.bean.MeetingSeatOrderBean;
import app.vdaoadmin.qidu.bean.MeetingSeateBean;
import app.vdaoadmin.qidu.bean.Topic;
import app.vdaoadmin.qidu.mvp.contract.OrderTabContract;
import app.vdaoadmin.qidu.mvp.presenter.OrderTabPresenterImpl;
import io.reactivex.processors.PublishProcessor;

/**
 * 订单
 */

public class LunchOrderFragment extends AbsListFragment<OrderTabPresenterImpl> implements OrderTabContract.View{
    protected RecyclerView mRecyclerView;
    protected SwipeRefreshLayout mPtr;
    private String store_img_url;
    protected StatusViewLayout mStatusViewLayout;

    private MultiItemTypeAdapter adapter;
    private int orderType=0;
    private String storeId;
    private String orderState;
    private String title;
    private String storeName;
    public static LunchOrderFragment getInstance(String storeName,String storeId,int orderType,String title,String store_img_url) {
        LunchOrderFragment sf = new LunchOrderFragment();
        sf.store_img_url = store_img_url;
        sf.orderType=orderType;
        sf.storeId=storeId;
        sf.title=title;
        sf.storeName=storeName;
        return sf;
    }

    @Override
    public void loadData(int pageIndex) {
        if(orderType== LunchOrderActivity.LUNCH_ORDER_TYPE){
            /*订单状态 0(已取消)40(默认):未付款;20:已付款;25：已接单：30:已发货;10:已收货;5：待退款，15：退款成功，80：订单完成*/
            if(title.equals("全部")){
                orderState="";
            }else if(title.equals("待付款")){
                orderState="40";
            }else if(title.equals("待接单")){
                orderState="20";
            }else if(title.equals("待配送")){
                orderState="25";
            }else if(title.equals("配送中")){
                orderState="30";
            }else if(title.equals("已收货")){
                orderState="10";
            }else if(title.equals("已完成")){
                orderState="80";
            }else if(title.equals("已取消")){
                orderState="0";
            }
            mPresenter.loadLunchOrderData(pageIndex,storeId,orderState);
        }else if(orderType==LunchOrderActivity.MEETING_ORDER_TYPE||orderType==LunchOrderActivity.SEAT_ORDER_TYPE){//appointment_type 1代表订座订单 2代表会议订单
            //appointment_type=orderState
            if(title.equals("全部")){
                orderState="";
            }else if(title.equals("待接单")){
                orderState="1";
            }else if(title.equals("待入座")||title.equals("待服务")){
                orderState="2";
            }else if(title.equals("入座中")||title.equals("服务中")){
                orderState="3";
            }else if(title.equals("待评价")){
                orderState="4";
            }else if(title.equals("已完成")){
                orderState="5";
            }else if(title.equals("已取消")){
                orderState="6";
            }
            if(orderType==LunchOrderActivity.MEETING_ORDER_TYPE){
                mPresenter.loadMeetingOrderData(pageIndex,storeId,orderState,"1");
            }else if(orderType==LunchOrderActivity.SEAT_ORDER_TYPE){
                mPresenter.loadMeetingOrderData(pageIndex,storeId,orderState,"2");
            }
        }

    }


    @Override
    public View initView(LayoutInflater inflater, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.lib_fragment_base_recyclerview, null);
        return view;
    }

    @Override
    public void initViewsAndEvents(View view, @Nullable Bundle savedInstanceState) {
        if(orderType== LunchOrderActivity.LUNCH_ORDER_TYPE){
            adapter = new LunchOrderListAdapter(this.store_img_url,mContext);
        }else if(orderType==LunchOrderActivity.MEETING_ORDER_TYPE){
            adapter = new SeatOrderListAdapter(storeName,store_img_url,mContext,LunchOrderActivity.MEETING_ORDER_TYPE);
        }else if(orderType==LunchOrderActivity.SEAT_ORDER_TYPE){
            adapter = new SeatOrderListAdapter(storeName,store_img_url,mContext,LunchOrderActivity.SEAT_ORDER_TYPE);
        }
        mStatusViewLayout=findView(R.id.status_view_layout);
        mPtr=findView(R.id.refresh_layout);
        mRecyclerView=findView(R.id.recyclerview);
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_manager_user);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));

        initPagingList(mRecyclerView, adapter, mPtr, mStatusViewLayout);
        /*TextView t3 = new TextView(getActivity());
        t3.setText("HeadView Text");
        headerAndFooterWrapper.addHeaderView(t3);
        headerAndFooterWrapper.addHeaderView(t3);*/

        refreshData();
    }

    @Override
    protected OrderTabPresenterImpl initPresenter() {
        return new OrderTabPresenterImpl();
    }


    @Override
    public void showLunchListSuccess(int pageIndex, LunchBean lunchBean) {
        onDataSuccessReceived(pageIndex,lunchBean.getOrder());
    }

    @Override
    public void showLunchListFailure() {
        mPtr.setRefreshing(false);
        showError(new Exception("网络出小差了!!!"));
    }

    @Override
    public void showMeetingSeatListSuccess(int pageIndex, MeetingSeateBean lunchBean) {
        onDataSuccessReceived(pageIndex,lunchBean.getOrder());
    }

    @Override
    public void showLunchOrderDetail(LunchOrderBean orderBean) {

    }

    @Override
    public void showOrderDetailFailure() {

    }

    @Override
    public void showSeatMeetingOrderDetail(MeetingSeatOrderBean orderBean) {

    }
}