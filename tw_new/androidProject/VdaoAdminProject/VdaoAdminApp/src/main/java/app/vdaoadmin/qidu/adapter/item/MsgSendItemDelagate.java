package app.vdaoadmin.qidu.adapter.item;


import android.content.Context;

import com.anthony.rvhelper.base.ItemViewDelegate;
import com.anthony.rvhelper.base.ViewHolder;

import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.bean.Topic;

/**
 * Created by zhy on 16/6/22.
 */
public class MsgSendItemDelagate implements ItemViewDelegate<Topic>
{
    private Context context;

    public MsgSendItemDelagate(Context context) {
        this.context = context;
    }

    @Override
    public int getItemViewLayoutId()
    {
        return R.layout.layout_prj_just_title;
    }

    @Override
    public boolean isForViewType(Topic item, int position)
    {
        return !item.isComMeg();
    }

    @Override
    public void convert(ViewHolder holder, Topic chatMessage, int position)
    {
        holder.setText(R.id.tv_item_title, chatMessage.getTitle());
        holder.setBackgroundColor(R.id.tv_item_title,context.getResources().getColor(R.color.red));

    }
}