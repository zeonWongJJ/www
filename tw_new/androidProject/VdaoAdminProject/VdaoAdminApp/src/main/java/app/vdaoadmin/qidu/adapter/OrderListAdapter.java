package app.vdaoadmin.qidu.adapter;

import android.content.Context;
import android.content.Intent;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;
import com.common.lib.utils.GlideRoundTransform;
import com.common.lib.utils.TimeUtil;

import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.activity.LunchOrderActivity;
import app.vdaoadmin.qidu.bean.Store;

/**
 * 消息列表
 */

public class OrderListAdapter extends CommonAdapter<Store> {
    public OrderListAdapter(Context context) {
        super(context, R.layout.layout_order_list_item);
    }


    @Override
    protected void convert(ViewHolder holder, final Store data, int position) {
        View lunchOrder=holder.getView(R.id.lunch_order);
        holder.setText(R.id.total_comment_score,"0.0");
        holder.setText(R.id.total_service_score,"0.0");
        holder.setText(R.id.total_quality_score,"0.0");
        holder.setText(R.id.store_open_time,"开店时间："+ TimeUtil.getTime(Long.parseLong(data.getStore_regtime())*1000,"yyyy-MM-dd"));

        lunchOrder.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(mContext, LunchOrderActivity.class);
                intent.putExtra(IntentParams.KEY_ORDER_TYPE,LunchOrderActivity.LUNCH_ORDER_TYPE);
                intent.putExtra(IntentParams.KEY_STORE_IMG_URL,HttpUrl.API_HOST+data.getStore_touxiang());
                intent.putExtra(IntentParams.KEY_STORE_NAME,data.getStore_name());
                intent.putExtra(IntentParams.KEY_STORE_ID,data.getStore_id());
                mContext.startActivity(intent);
            }
        });
        View meetingOrder=holder.getView(R.id.meeting_order);
        meetingOrder.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(mContext, LunchOrderActivity.class);
                intent.putExtra(IntentParams.KEY_ORDER_TYPE,LunchOrderActivity.MEETING_ORDER_TYPE);
                intent.putExtra(IntentParams.KEY_STORE_IMG_URL,HttpUrl.API_HOST+data.getStore_touxiang());
                intent.putExtra(IntentParams.KEY_STORE_NAME,data.getStore_name());
                intent.putExtra(IntentParams.KEY_STORE_ID,data.getStore_id());
                mContext.startActivity(intent);
            }
        });
        View seatOrder=holder.getView(R.id.seat_order);
        seatOrder.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(mContext, LunchOrderActivity.class);
                intent.putExtra(IntentParams.KEY_ORDER_TYPE,LunchOrderActivity.SEAT_ORDER_TYPE);
                intent.putExtra(IntentParams.KEY_STORE_IMG_URL,HttpUrl.API_HOST+data.getStore_touxiang());
                intent.putExtra(IntentParams.KEY_STORE_NAME,data.getStore_name());
                intent.putExtra(IntentParams.KEY_STORE_ID,data.getStore_id());
                mContext.startActivity(intent);
            }
        });
        holder.setText(R.id.store_name, data.getStore_name());
        ImageView imageView=holder.getView(R.id.store_img);
        RequestOptions options=new RequestOptions();
        options.transform(new GlideRoundTransform(mContext));
        Glide.with(mContext)
                .load(HttpUrl.API_HOST+data.getStore_touxiang())
                .apply(options)
                .into(imageView);
        /*holder.getConvertView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(mContext, LunchOrderActivity.class);
                intent.putExtra(IntentParams.KEY_ORDER_TYPE,LunchOrderActivity.LUNCH_ORDER_TYPE);
                mContext.startActivity(intent);
            }
        });*/
    }
}
