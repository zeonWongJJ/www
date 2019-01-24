package app.vdaoadmin.qidu.adapter;

import android.content.Context;
import android.content.Intent;
import android.text.TextUtils;
import android.view.View;
import android.widget.ImageView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;
import com.common.lib.utils.GlideRoundTransform;

import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.activity.LunchOrderActivity;
import app.vdaoadmin.qidu.activity.OrderDetailActivity;
import app.vdaoadmin.qidu.bean.MeetingSeatOrderBean;
import app.vdaoadmin.qidu.bean.Topic;

/**
 * 消息列表
 */

public class SeatOrderListAdapter extends CommonAdapter<MeetingSeatOrderBean> {
    private String storeName;
    private String store_img_url;
    private int orderType=0;
    public SeatOrderListAdapter(String storeName,String store_img_url,Context context,int orderType) {
        super(context, R.layout.layout_seat_order_item);
        this.storeName=storeName;
        this.store_img_url=store_img_url;
        this.orderType=orderType;
    }


    @Override
    protected void convert(ViewHolder holder, final MeetingSeatOrderBean data, int position) {
        holder.setText(R.id.store_name,storeName);
        ImageView store_img=holder.getView(R.id.store_img);
        Glide.with(mContext)
                .load(store_img_url)
                .apply(RequestOptions.circleCropTransform())
                .into(store_img);
        ImageView user_img=holder.getView(R.id.user_img);
        RequestOptions options=new RequestOptions();
        options.transform(new GlideRoundTransform(mContext));
        Glide.with(mContext)
                .load(data.getUser_pic())
                .apply(options)
                .into(user_img);
        holder.setText(R.id.order_num,"订单编号："+data.getAppointment_number());
        holder.setText(R.id.user_name,data.getUser_name());
        if(!TextUtils.isEmpty(data.getRoom_name())){
            holder.setText(R.id.seat_room_type,data.getRoom_name());
        }
        if(!TextUtils.isEmpty(data.getOffice_seatname())){
            holder.setText(R.id.seat_room_type,"座位："+data.getOffice_seatname());
        }
        holder.setText(R.id.seat_price,"￥"+data.getActual_pay());
        String orderState="";
        if(data.getAppointment_state().equals("1")){
            orderState="待接单";
        }else if(data.getAppointment_state().equals("2")){
            if(orderType==LunchOrderActivity.SEAT_ORDER_TYPE){
                orderState = "待入座";
            }else if(orderType==LunchOrderActivity.MEETING_ORDER_TYPE) {
                orderState = "待服务";
            }
        }else if(data.getAppointment_state().equals("3")){
            if(orderType==LunchOrderActivity.SEAT_ORDER_TYPE){
                orderState = "入座中";
            }else if(orderType==LunchOrderActivity.MEETING_ORDER_TYPE) {
                orderState = "服务中";
            }
        }else if(data.getAppointment_state().equals("4")){
            orderState="待评价";
        }else if(data.getAppointment_state().equals("5")){
            orderState="已完成";
        }else if(data.getAppointment_state().equals("6")){
            orderState="已取消";
        }
        holder.setText(R.id.order_status,orderState);
        holder.getConvertView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(mContext, OrderDetailActivity.class);
                if(orderType==LunchOrderActivity.SEAT_ORDER_TYPE){
                    intent.putExtra(IntentParams.KEY_ORDER_TYPE,LunchOrderActivity.SEAT_ORDER_TYPE);
                    intent.putExtra(IntentParams.KEY_APPOINTMENT_ID,data.getAppointment_id());
                }else if(orderType==LunchOrderActivity.MEETING_ORDER_TYPE){
                    intent.putExtra(IntentParams.KEY_ORDER_TYPE,LunchOrderActivity.MEETING_ORDER_TYPE);
                    intent.putExtra(IntentParams.KEY_APPOINTMENT_ID,data.getAppointment_id());
                }/*else if(orderType==LunchOrderActivity.LUNCH_ORDER_TYPE){
                    intent.putExtra(IntentParams.KEY_ORDER_TYPE,LunchOrderActivity.LUNCH_ORDER_TYPE);
                }*/
                mContext.startActivity(intent);
            }
        });
    }
}
