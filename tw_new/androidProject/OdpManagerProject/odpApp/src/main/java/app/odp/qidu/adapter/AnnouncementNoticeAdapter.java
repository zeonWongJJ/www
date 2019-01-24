package app.odp.qidu.adapter;

import android.content.Context;
import android.content.Intent;
import android.view.View;
import android.widget.ImageView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.Notice;
import com.app.base.netUtil.NoticeHttpUtil;
import com.app.base.utils.IntentParams;
import com.common.lib.base.AbsBaseFragment;
import com.common.lib.utils.ToastUtils;
import com.common.lib.widget.AppDialog;

import java.util.HashMap;

import app.odp.qidu.R;
import app.odp.qidu.activity.AnnouncementDetailsActivity;
import app.odp.qidu.activity.AnnouncementPublishActivity;
import app.odp.qidu.activity.NoticeTabActivity;
import app.odp.qidu.activity.SystemNoticeActivity;
import io.reactivex.observers.DisposableObserver;

/**
 * 通知列表
 */

public class AnnouncementNoticeAdapter extends CommonAdapter<Notice> {
    private String tabType;
    AbsBaseFragment fragment;
    private View.OnClickListener listener;
    public AnnouncementNoticeAdapter(AbsBaseFragment fragment, String tabType, View.OnClickListener listener) {
        super(fragment.getActivity(), R.layout.layout_announcement_notice_item);
        this.fragment=fragment;
        this.tabType=tabType;
        this.listener=listener;
    }


    @Override
    protected void convert(ViewHolder holder, final Notice data, int position) {
        if(tabType.equals("1")){
            View view=holder.getView(R.id.notice_edit_layout);
            view.setVisibility(View.VISIBLE);
            View delete_notice=holder.getView(R.id.delete_notice);
            delete_notice.setTag(position);
            delete_notice.setOnClickListener(listener);
            View edit_notice=holder.getView(R.id.edit_notice);
            edit_notice.setOnClickListener(v -> {
                Intent intent=new Intent(mContext, AnnouncementPublishActivity.class);
                intent.putExtra(IntentParams.KEY_PUBLISH_EDIT_ANNOUNCEMENT,AnnouncementPublishActivity.EDIT);
                intent.putExtra(IntentParams.KEY_ID,data.getId());
                mContext.startActivity(intent);
            });
        }
        holder.setText(R.id.user_name, data.getBulletin_sponsor_name());
        holder.setText(R.id.title, data.getBulletin_title()+"");
        holder.setText(R.id.content, data.getBulletin_content()+"");

        holder.getConvertView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(mContext, AnnouncementDetailsActivity.class);
                intent.putExtra(IntentParams.KEY_ID,data.getId());
                mContext.startActivity(intent);
            }
        });

    }

}
