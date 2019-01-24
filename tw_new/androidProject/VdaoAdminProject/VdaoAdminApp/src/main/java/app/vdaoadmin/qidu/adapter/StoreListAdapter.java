package app.vdaoadmin.qidu.adapter;

import android.content.Context;
import android.content.Intent;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;
import com.common.lib.utils.GlideRoundTransform;

import java.math.BigDecimal;

import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.activity.LunchOrderActivity;
import app.vdaoadmin.qidu.activity.UserDetailActivity;
import app.vdaoadmin.qidu.bean.Store;
import app.vdaoadmin.qidu.bean.Topic;

/**
 * 消息列表
 */

public class StoreListAdapter extends CommonAdapter<Store> {
    public StoreListAdapter(Context context) {
        super(context, R.layout.layout_store_list_item);
    }


    @Override
    protected void convert(ViewHolder holder, final Store data, int position) {
        holder.setText(R.id.store_name, data.getStore_name());
        //进店人数
        holder.setText(R.id.store_visitorall,data.getStore_visitorall());
        //当前在店人数
        holder.setText(R.id.store_visitorcur,data.getStore_visitorcur());
        holder.setText(R.id.store_visitorlea,data.getStore_visitorlea());
        holder.setText(R.id.store_address,"地址："+data.getStore_address());
        String contactWay=data.getStore_linkman();
        if(data.getStore_contact()!=null&& !TextUtils.isEmpty(contactWay)){//store_contact
            contactWay=contactWay+" "+data.getStore_contact();
        }else if(data.getStore_contact()!=null&& TextUtils.isEmpty(contactWay)){
            contactWay=data.getStore_contact();
        }
        holder.setText(R.id.contact_way,"联系方式："+contactWay);//	store_linkman
        ImageView imageView=holder.getView(R.id.store_img);
        RequestOptions options=new RequestOptions();
        options.transform(new GlideRoundTransform(mContext));
        Glide.with(mContext)
                .load(HttpUrl.API_HOST+data.getStore_touxiang())
                .apply(options)
                .into(imageView);
        holder.getConvertView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });

        //商品平均分
        double averageGoodsScore=0.0;
        double averageServiceScore=0.0;
        double averageTotalScore=0.0f;
        if(data.getComment().size()>0){
            for(int i=0;i<data.getComment().size();i++){
                averageGoodsScore+=Double.parseDouble(data.getComment().get(i).getGoods_score());
                averageServiceScore+=Double.parseDouble(data.getComment().get(i).getService_score());
            }

            averageGoodsScore=averageGoodsScore/data.getComment().size();
            averageServiceScore=averageServiceScore/data.getComment().size();
            averageTotalScore=(averageGoodsScore+averageServiceScore)/2;

            BigDecimal bdGoodsScore = new BigDecimal(averageGoodsScore);
            double goodsScore = bdGoodsScore.setScale(1, BigDecimal.ROUND_HALF_UP).doubleValue();
            BigDecimal bdServiceScore = new BigDecimal(averageServiceScore);
            double serviceScore = bdServiceScore.setScale(1, BigDecimal.ROUND_HALF_UP).doubleValue();
            BigDecimal bdTotalScore = new BigDecimal(averageTotalScore);
            double totalScore = bdTotalScore.setScale(1, BigDecimal.ROUND_HALF_UP).doubleValue();

            holder.setText(R.id.total_comment_score,""+totalScore);
            holder.setText(R.id.total_service_score,""+serviceScore);
            holder.setText(R.id.total_quality_score,""+goodsScore);
        }

        View lunchOrder=holder.getView(R.id.lunch_order);
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
    }
}
