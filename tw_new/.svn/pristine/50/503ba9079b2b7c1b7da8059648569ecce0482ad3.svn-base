package app.vdaoadmin.qidu.adapter;

import android.content.Context;
import android.content.Intent;
import android.text.TextUtils;
import android.util.Log;
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
 * 消息列表
 */

public class ManagerUserListAdapter extends CommonAdapter<User> {
    public ManagerUserListAdapter(Context context) {
        super(context, R.layout.layout_manager_user_item);
    }


    @Override
    protected void convert(ViewHolder holder, final User data, int position) {
        holder.setText(R.id.user_name, data.getUser_name());
        ImageView imageView=holder.getView(R.id.user_photo);
        if(!TextUtils.isEmpty(data.getUser_pic())){
            RequestOptions options=new RequestOptions();
            options.apply(RequestOptions.circleCropTransform());
            options.placeholder(R.drawable.icon_default_user);
            options.error(R.drawable.icon_default_user);
            String url=data.getUser_pic().startsWith("http:")?data.getUser_pic():HttpUrl.API_HOST+data.getUser_pic();
            Glide.with(mContext)
                    .load(url)
                    .apply(options)
                    .into(imageView);
        }else {
            imageView.setImageDrawable(mContext.getResources().getDrawable(R.drawable.icon_default_user));
        }

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
