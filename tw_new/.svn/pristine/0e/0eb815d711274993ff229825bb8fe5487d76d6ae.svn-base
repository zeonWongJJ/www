package app.odp.qidu.adapter;

import android.content.Context;
import android.content.Intent;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.SystemNotice;
import com.app.base.utils.CommonKey;
import com.app.base.utils.IntentParams;

import app.odp.qidu.R;
import app.odp.qidu.activity.SystemNoticeDetailsActivity;

/**
 * 项目列表
 */

public class SystemNoticeListAdapter extends CommonAdapter<SystemNotice> {
    public SystemNoticeListAdapter(Context context) {
        super(context, R.layout.layout_system_notice_list_item);
    }


    @Override
    protected void convert(ViewHolder holder, final SystemNotice data, int position) {
        holder.setText(R.id.date,data.getPost_add());
        TextView textTitle=holder.getView(R.id.content);
        if(data.getNotice_type().equals(CommonKey.KEY_NOTICE_TASK)){
            textTitle.setTextColor(mContext.getResources().getColor(R.color.blue));
            textTitle.setText("你收到任务通知:"+data.getConnect());
        }else if(data.getNotice_type().equals(CommonKey.KEY_NOTICE_PLAN)){
            textTitle.setTextColor(mContext.getResources().getColor(R.color.blue));
            textTitle.setText("你收到计划通知:"+data.getConnect());
        }else {
            textTitle.setTextColor(mContext.getResources().getColor(R.color.gray));
            textTitle.setText(data.getConnect());
        }
        holder.setText(R.id.title, data.getNotice_publisher_name());
        holder.getConvertView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(mContext, SystemNoticeDetailsActivity.class);
                intent.putExtra(IntentParams.KEY_ID,data.getId());
                mContext.startActivity(intent);
            }
        });
    }
}
