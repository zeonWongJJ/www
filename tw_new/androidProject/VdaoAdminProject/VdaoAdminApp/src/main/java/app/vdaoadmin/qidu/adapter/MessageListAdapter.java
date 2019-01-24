package app.vdaoadmin.qidu.adapter;

import android.content.Context;
import android.view.View;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.common.lib.utils.TimeUtil;

import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.bean.MessageBean;

/**
 * 消息列表
 */

public class MessageListAdapter extends CommonAdapter<MessageBean> {
    public MessageListAdapter(Context context) {
        super(context, R.layout.layout_message_item);
    }


    @Override
    protected void convert(ViewHolder holder, final MessageBean data, int position) {
        holder.setText(R.id.message_item_content, data.getContent());
        holder.setText(R.id.msg_item_time, TimeUtil.getSmartDate(data.getMess_time()*1000));
        /*holder.getConvertView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {


            }
        });*/
    }
}
