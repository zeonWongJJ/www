package app.odp.qidu.adapter;

import android.content.Context;
import android.content.Intent;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.Notice;
import com.app.base.bean.Project;
import com.app.base.utils.CommonKey;
import com.app.base.utils.IntentParams;
import com.common.lib.utils.ToastUtils;
import com.flyco.tablayout.widget.MsgView;

import app.odp.qidu.R;
import app.odp.qidu.activity.ApprovalListActivity;
import app.odp.qidu.activity.NoticeTabActivity;
import app.odp.qidu.activity.SystemNoticeActivity;

/**
 * 项目列表
 */

public class NoticeListAdapter extends CommonAdapter<Notice> {
    public NoticeListAdapter(Context context) {
        super(context, R.layout.layout_notice_list_item);
    }


    @Override
    protected void convert(ViewHolder holder, final Notice data, int position) {
        MsgView msgView=holder.getView(R.id.rtv_msg_tip);
        msgView.setVisibility(View.GONE);
        if(data.getUnReadCount()!=null){
            msgView.setVisibility(View.VISIBLE);
            msgView.setText(data.getUnReadCount());
        }
        TextView content=holder.getView(R.id.content);
        content.setText(data.getBulletin_content());
        ImageView img_notice=holder.getView(R.id.img_notice);
        if(data.getMsgType().equals(CommonKey.KEY_NOTICE_SYSTEM)){
            img_notice.setImageResource(R.drawable.icon_system_notice);
        }else if(data.getMsgType().equals(CommonKey.KEY_NOTICE_PUBLIC)){
            img_notice.setImageResource(R.drawable.icon_announcement_notice);
        }else if(data.getMsgType().equals(CommonKey.KEY_NOTICE_APPROVAL)){
            img_notice.setImageResource(R.drawable.icon_approval);
        }
        holder.setText(R.id.title, data.getTitle());
        holder.getConvertView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(data.getMsgType().equals(CommonKey.KEY_NOTICE_SYSTEM)){
                    Intent intent=new Intent(mContext, SystemNoticeActivity.class);
                    mContext.startActivity(intent);
                }else if(data.getMsgType().equals(CommonKey.KEY_NOTICE_PUBLIC)){
                    Intent intent=new Intent(mContext, NoticeTabActivity.class);
                    mContext.startActivity(intent);
                }else if(data.getMsgType().equals(CommonKey.KEY_NOTICE_APPROVAL)){
                    //待办审批通知
                    Intent intent=new Intent(mContext,ApprovalListActivity.class);
                    intent.putExtra(IntentParams.KEY_APPROVAL_PARAM_LIST_OR_NOTICE,"1");
                    mContext.startActivity(intent);
                }
            }
        });
    }
}
