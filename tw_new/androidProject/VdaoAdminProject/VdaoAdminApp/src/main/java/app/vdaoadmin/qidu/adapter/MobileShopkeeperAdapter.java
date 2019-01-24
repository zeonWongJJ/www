package app.vdaoadmin.qidu.adapter;

import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.text.Spannable;
import android.text.SpannableString;
import android.text.style.ForegroundColorSpan;
import android.view.View;
import android.widget.ImageView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.User;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;
import com.common.lib.utils.TimeUtil;

import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.activity.UserDetailActivity;
import app.vdaoadmin.qidu.bean.Topic;

/**
 * 移动店主
 */

public class MobileShopkeeperAdapter extends CommonAdapter<User> {
    public MobileShopkeeperAdapter(Context context) {
        super(context, R.layout.layout_mobile_shopkeeper_item);
    }


    @Override
    protected void convert(ViewHolder holder, final User data, int position) {
        //"已通过", "待处理", "已拒绝", "已搁置"
        if(data.getIs_shopman().equals("1")){
            holder.setText(R.id.shopkeeper_state,"已通过");
        }else if(data.getIs_shopman().equals("2")){
            holder.setText(R.id.shopkeeper_state,"待处理");
        }else if(data.getIs_shopman().equals("3")){
            holder.setText(R.id.shopkeeper_state,"已拒绝");
        }else if(data.getIs_shopman().equals("4")){
            holder.setText(R.id.shopkeeper_state,"已搁置");
        }
        holder.setText(R.id.user_name, data.getUser_name());
        //referee_consume 推荐的人消费总金额 [ 自己下级的消费总数 ]   referee_count 推荐人总数 [自己的下级总数]


        holder.setText(R.id.referee_consume, data.getReferee_consume());
        holder.setText(R.id.referee_count, data.getReferee_count());
        holder.setText(R.id.time, TimeUtil.getTime(Long.parseLong(data.getUser_regtime())*1000,"yyyy-MM-dd"));

        ImageView imageView=holder.getView(R.id.user_photo);
        RequestOptions options=new RequestOptions();
        options.apply(RequestOptions.circleCropTransform());
        options.placeholder(R.drawable.icon_default_user);
        options.error(R.drawable.icon_default_user);
        String url=data.getUser_pic().startsWith("http:")?data.getUser_pic(): HttpUrl.API_HOST+data.getUser_pic();
        Glide.with(mContext)
                .load(url)
                .apply(options)
                .into(imageView);
        holder.getConvertView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(mContext, UserDetailActivity.class);
                intent.putExtra(IntentParams.KEY_USER_INFO,data);
                mContext.startActivity(intent);
            }
        });
    }
}
