package app.vdao.qidu.adapter;

import android.content.Context;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import app.vdao.qidu.adapter.item.MsgComingItemDelagate;
import app.vdao.qidu.adapter.item.MsgSendItemDelagate;

import app.vdao.qidu.bean.Topic;

/**
 * Created by zhy on 15/9/4.
 */
public class ChatAdapterForRv extends MultiItemTypeAdapter<Topic>
{
    public ChatAdapterForRv(Context context)
    {
        super(context);
        addItemViewDelegate(new MsgSendItemDelagate(context));
        addItemViewDelegate(new MsgComingItemDelagate(context));
    }
}
