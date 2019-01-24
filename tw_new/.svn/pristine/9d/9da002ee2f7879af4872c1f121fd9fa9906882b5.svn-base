package app.vdaoadmin.qidu.adapter;

import android.content.Context;
import android.content.Intent;
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
import app.vdaoadmin.qidu.bean.Goods;
import app.vdaoadmin.qidu.bean.LunchOrderBean;
import app.vdaoadmin.qidu.bean.Topic;

/**
 * 消息列表
 */

public class LunchOrderListAdapter extends CommonAdapter<LunchOrderBean> {
    private String store_img_url;
    public LunchOrderListAdapter(String store_img_url,Context context) {
        super(context, R.layout.layout_lunch_order_item);
        this.store_img_url=store_img_url;
    }


    @Override
    protected void convert(ViewHolder holder, final LunchOrderBean data, int position) {
        holder.setText(R.id.store_name, data.getStore_name());
        holder.setText(R.id.order_num,"订单编号："+data.getOrder_number());
        holder.setText(R.id.user_name, data.getUser_name());
        String goodStr="";
        for(Goods goods:data.getOrder_goods()){
            goodStr=goodStr+goods.getProduct_name()+ " "+goods.getGoods_num()+"份";
        }
        holder.setText(R.id.goods,goodStr);
        holder.setText(R.id.total_money, "￥"+data.getGoods_amount());
        String orderState="";
        if(data.getOrder_state().equals("40")){
            orderState="待付款";
        }else if(data.getOrder_state().equals("20")){
            orderState="待接单";
        }else if(data.getOrder_state().equals("25")){
            orderState="待配送";
        }else if(data.getOrder_state().equals("30")){
            orderState="待配送";
        }else if(data.getOrder_state().equals("10")){
            orderState="已收货";
        }else if(data.getOrder_state().equals("80")){
            orderState="已完成";
        }else if(data.getOrder_state().equals("0")){
            orderState="已取消";
        }
        holder.setText(R.id.order_status, orderState);
        ImageView imageView=holder.getView(R.id.store_img);

        Glide.with(mContext)
                .load(store_img_url)
                .apply(RequestOptions.circleCropTransform())
                .into(imageView);
        ImageView user_img=holder.getView(R.id.user_img);
        RequestOptions options=new RequestOptions();
        options.transform(new GlideRoundTransform(mContext));
        Glide.with(mContext)
                .load(data.getUser_pic())
                .apply(options)
                .into(user_img);
        holder.getConvertView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(mContext, OrderDetailActivity.class);
                intent.putExtra(IntentParams.KEY_ORDER_TYPE,LunchOrderActivity.LUNCH_ORDER_TYPE);
                intent.putExtra(IntentParams.KEY_ORDER_ID,data.getOrder_id());
                mContext.startActivity(intent);
            }
        });
    }


}
