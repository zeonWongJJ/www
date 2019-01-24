package app.vdaoadmin.qidu.activity;

import android.os.Build;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;

import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.base.lv.ListGridUtils;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;
import com.common.lib.global.AppUtils;
import com.common.lib.utils.ScreenUtils;
import com.common.lib.utils.TimeUtil;
import com.common.lib.utils.ToastUtils;
import com.mvp.lib.base.BaseActivity;
import com.mvp.lib.presenter.BasePresenter;
import com.mvp.lib.view.IBaseActivityView;

import java.util.ArrayList;

import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.adapter.LunchDetailItemAdapter;
import app.vdaoadmin.qidu.bean.LunchBean;
import app.vdaoadmin.qidu.bean.LunchOrderBean;
import app.vdaoadmin.qidu.bean.MeetingSeatOrderBean;
import app.vdaoadmin.qidu.bean.MeetingSeateBean;
import app.vdaoadmin.qidu.mvp.contract.OrderTabContract;
import app.vdaoadmin.qidu.mvp.presenter.OrderTabPresenterImpl;

/**
 * 订单详情-会议-餐饮-座位
 */

public class OrderDetailActivity extends BaseActivity<OrderTabPresenterImpl> implements OrderTabContract.View{
    private int orderType;
    private ListView listView;
    private LunchDetailItemAdapter lunchDetailItemAdapter;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        ImageView status_view= (ImageView) findViewById(R.id.status_view);
        View status_view_layout=findViewById(R.id.status_bar_layout);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
            setTranslucentStatus(true);
            LinearLayout.LayoutParams params= (LinearLayout.LayoutParams) status_view.getLayoutParams();
            params.height= ScreenUtils.getStatusBarHeight(this);
            //params.setMargins(0, ScreenUtils.getStatusBarHeight(this), 0, 0);
            status_view.setLayoutParams(params);
            status_view_layout.setVisibility(View.VISIBLE);
        }
        TextView titleCenter= (TextView) findViewById(R.id.header_text);
        View back=findView(R.id.header_left_btn_img);
        back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        showProgressDialog();
        if(orderType==LunchOrderActivity.LUNCH_ORDER_TYPE){
            titleCenter.setText("餐饮订单详情");
            String orderId=getIntent().getStringExtra(IntentParams.KEY_ORDER_ID);
            listView=findView(R.id.listview);
            lunchDetailItemAdapter=new LunchDetailItemAdapter(listView,new ArrayList<>());
            listView.setAdapter(lunchDetailItemAdapter);
            mPresenter.lunchOrderDetail(orderId);
        }else if(orderType==LunchOrderActivity.MEETING_ORDER_TYPE){
            titleCenter.setText("会议订单详情");
            String appointmentId=getIntent().getStringExtra(IntentParams.KEY_APPOINTMENT_ID);
            mPresenter.meetingSeatOrderDetail(appointmentId);
        }else if(orderType==LunchOrderActivity.SEAT_ORDER_TYPE){
            titleCenter.setText("座位订单详情");
            String appointmentId=getIntent().getStringExtra(IntentParams.KEY_APPOINTMENT_ID);
            mPresenter.meetingSeatOrderDetail(appointmentId);
        }
    }
    private void initLunchData(LunchOrderBean orderBean){
        lunchDetailItemAdapter.refresh(orderBean.getOrder_goods());
        ListGridUtils.setListViewHeightBasedOnChildren(listView);
        TextView user_name=findView(R.id.user_name);
        user_name.setText(orderBean.getUser_name());
        ImageView user_photo=findView(R.id.user_photo);
        RequestOptions options=new RequestOptions();
        options.apply(RequestOptions.circleCropTransform());
        options.placeholder(R.drawable.icon_default_user);
        options.error(R.drawable.icon_default_user_detail);
        Glide.with(this)
                .load(orderBean.getUser_pic())
                .apply(options)
                .into(user_photo);
        TextView shipping_fee=findView(R.id.shipping_fee);
        shipping_fee.setText(orderBean.getShipping_fee());
        TextView use_points=findView(R.id.use_points);
        use_points.setText(orderBean.getUse_points());
        TextView total_goods_money=findView(R.id.total_goods_money);
        total_goods_money.setText("合计 ￥"+orderBean.getGoods_amount());
        TextView time_delay=findView(R.id.time_delay);
        time_delay.setText(orderBean.getTime_delay());
        TextView order_number=findView(R.id.order_number);
        order_number.setText(orderBean.getOrder_number());
        TextView copy_order_number=findView(R.id.copy_order_number);
        copy_order_number.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                AppUtils.copy2clipboard(getActivity(),orderBean.getOrder_number());
                ToastUtils.show("已经复制订单号到粘贴板");
            }
        });
        TextView payment_code=findView(R.id.payment_code);
/*payment_code 支付方式名称代码 offline微信付款、online在线支付、alipay支付宝、unionpay银联网关支付、cashier线下支付*/
        if(orderBean.getPayment_code().equals("offline")){
            payment_code.setText("微信支付");
        }else if(orderBean.getPayment_code().equals("online")){
            payment_code.setText("在线支付");
        }else if(orderBean.getPayment_code().equals("alipay")){
            payment_code.setText("支付宝支付");
        }else if(orderBean.getPayment_code().equals("unionpay")){
            payment_code.setText("银联网关支付");
        }else if(orderBean.getPayment_code().equals("cashier")){
            payment_code.setText("线下支付");
        }
        TextView time_create=findView(R.id.time_create);
        time_create.setText(TimeUtil.getTime(Long.parseLong(orderBean.getTime_create())*1000,"yyyy-MM-dd hh:mm:ss"));
        TextView contact_info=findView(R.id.contact_info);
        contact_info.setText(orderBean.getAddres());
        if(!TextUtils.isEmpty(orderBean.getReciver_name())&&!TextUtils.isEmpty(orderBean.getAddres())&&!TextUtils.isEmpty(orderBean.getMob_phone())){
            String contactInfo=orderBean.getAddres()+"\n"+orderBean.getReciver_name()+" "+orderBean.getMob_phone();
            contact_info.setText(contactInfo);
        }else if(TextUtils.isEmpty(orderBean.getAddres())){
            contact_info.setText(orderBean.getReciver_name()+" "+orderBean.getMob_phone());
        }
    }
    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        orderType=getIntent().getIntExtra(IntentParams.KEY_ORDER_TYPE,0);
        View view=null;
        if(orderType==LunchOrderActivity.LUNCH_ORDER_TYPE){
            view = inflater.inflate(R.layout.activity_lunch_order_detail, null);
        }else if(orderType==LunchOrderActivity.MEETING_ORDER_TYPE){
            view = inflater.inflate(R.layout.activity_meeting_order_detail, null);
        }else if(orderType==LunchOrderActivity.SEAT_ORDER_TYPE){
            view = inflater.inflate(R.layout.activity_seat_order_detail, null);
        }
        return view;
    }

    @Override
    protected OrderTabPresenterImpl initPresenter() {
        return new OrderTabPresenterImpl();
    }

    @Override
    public void showLunchListSuccess(int pageIndex, LunchBean lunchBean) {

    }
    @Override
    public void showLunchListFailure() {

    }
    @Override
    public void showMeetingSeatListSuccess(int pageIndex, MeetingSeateBean lunchBean) {

    }

    @Override
    public void showLunchOrderDetail(LunchOrderBean orderBean) {
        initLunchData(orderBean);
        dismissProgressDialog();
    }


    @Override
    public void showOrderDetailFailure() {
        dismissProgressDialog();
    }

    @Override
    public void showSeatMeetingOrderDetail(MeetingSeatOrderBean orderBean) {
        if(orderType==LunchOrderActivity.MEETING_ORDER_TYPE){
            initMeetingOrderDetailData(orderBean);
        }else {
            initSeatOrderDetailData(orderBean);
        }
        dismissProgressDialog();
    }


    private void initMeetingOrderDetailData(MeetingSeatOrderBean orderBean){
        TextView user_name=findView(R.id.user_name);
        user_name.setText(orderBean.getUser_name());
        ImageView user_photo=findView(R.id.user_photo);
        RequestOptions options=new RequestOptions();
        options.apply(RequestOptions.circleCropTransform());
        options.placeholder(R.drawable.icon_default_user);
        options.error(R.drawable.icon_default_user_detail);
        Glide.with(this)
                .load(orderBean.getUser_pic())
                .apply(options)
                .into(user_photo);
        TextView seat_room_type=findView(R.id.seat_room_type);
        seat_room_type.setText(orderBean.getRoom_name());
        TextView machine=findView(R.id.machine);
        machine.setText(orderBean.getRoom().getRoom_description());
        TextView time_delay=findView(R.id.time_delay);
        time_delay.setText(orderBean.getArrival_time());
        TextView order_number=findView(R.id.order_number);
        order_number.setText(orderBean.getAppointment_number());
        TextView copy_order_number=findView(R.id.copy_order_number);
        copy_order_number.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                AppUtils.copy2clipboard(getActivity(),orderBean.getAppointment_number());
                ToastUtils.show("已经复制订单号到粘贴板");
            }
        });
        TextView payment_code=findView(R.id.payment_code);
/*payment_code 支付方式名称代码 offline微信付款、online在线支付、alipay支付宝、unionpay银联网关支付、cashier线下支付*/
        if(orderBean.getPay_type().equals("2")){
            payment_code.setText("微信支付");
        }else if(orderBean.getPay_type().equals("1")){
            payment_code.setText("支付宝支付");
        }else if(orderBean.getPay_type().equals("3")){
            payment_code.setText("银联网关支付");
        }
        TextView time_create=findView(R.id.time_create);
        time_create.setText(TimeUtil.getTime(Long.parseLong(orderBean.getAppointment_time())*1000,"yyyy-MM-dd hh:mm:ss"));
        TextView contact_info=findView(R.id.contact_info);
        contact_info.setText(orderBean.getLinkman()+" "+orderBean.getLink_phone());
    }

    private void initSeatOrderDetailData(MeetingSeatOrderBean orderBean){
        TextView user_name=findView(R.id.user_name);
        user_name.setText(orderBean.getUser_name());
        ImageView user_photo=findView(R.id.user_photo);
        RequestOptions options=new RequestOptions();
        options.apply(RequestOptions.circleCropTransform());
        options.placeholder(R.drawable.icon_default_user);
        options.error(R.drawable.icon_default_user_detail);
        Glide.with(this)
                .load(orderBean.getUser_pic())
                .apply(options)
                .into(user_photo);
        TextView total_goods_money=findView(R.id.total_goods_money);
        total_goods_money.setText("合计 ￥"+orderBean.getActual_pay());
        TextView begin_time=findView(R.id.begin_time);
        begin_time.setText(TimeUtil.getTime(Long.parseLong(orderBean.getAppointment_date())*1000,"yyyy-MM-dd hh:mm"));
        /*TextView time_delay=findView(R.id.time_delay);
        time_delay.setText(orderBean.getArrival_time());*/
        TextView order_number=findView(R.id.order_number);
        order_number.setText(orderBean.getAppointment_number());
        TextView copy_order_number=findView(R.id.copy_order_number);
        copy_order_number.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                AppUtils.copy2clipboard(getActivity(),orderBean.getAppointment_number());
                ToastUtils.show("已经复制订单号到粘贴板");
            }
        });
        TextView payment_code=findView(R.id.payment_code);
/*payment_code 支付方式名称代码 offline微信付款、online在线支付、alipay支付宝、unionpay银联网关支付、cashier线下支付*/
        if(orderBean.getPay_type().equals("2")){
            payment_code.setText("微信支付");
        }else if(orderBean.getPay_type().equals("1")){
            payment_code.setText("支付宝支付");
        }else if(orderBean.getPay_type().equals("3")){
            payment_code.setText("银联网关支付");
        }
        TextView seat_name=findView(R.id.seat_name);
        seat_name.setText("座位："+orderBean.getOffice_seatname());
        TextView time_create=findView(R.id.time_create);
        time_create.setText(TimeUtil.getTime(Long.parseLong(orderBean.getAppointment_time())*1000,"yyyy-MM-dd hh:mm:ss"));
        TextView contact_info=findView(R.id.contact_info);
        contact_info.setText(orderBean.getLinkman()+" "+orderBean.getLink_phone());
    }
}
