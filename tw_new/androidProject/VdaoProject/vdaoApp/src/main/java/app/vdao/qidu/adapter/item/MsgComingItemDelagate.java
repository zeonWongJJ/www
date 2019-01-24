package app.vdao.qidu.adapter.item;


import android.content.Context;

import com.anthony.rvhelper.base.ItemViewDelegate;
import com.anthony.rvhelper.base.ViewHolder;
import app.vdao.qidu.R;

import app.vdao.qidu.bean.Topic;

/**
 * Created by zhy on 16/6/22.
 */
public class MsgComingItemDelagate implements ItemViewDelegate<Topic>
{

    private Context context;

    public MsgComingItemDelagate(Context context) {
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
        return item.isComMeg();
    }

    @Override
    public void convert(ViewHolder holder, Topic chatMessage, int position)
    {
        holder.setText(R.id.tv_item_title, chatMessage.getContent());
        holder.setBackgroundColor(R.id.tv_item_title,context.getResources().getColor(R.color.colorPrimary));
    }
}
