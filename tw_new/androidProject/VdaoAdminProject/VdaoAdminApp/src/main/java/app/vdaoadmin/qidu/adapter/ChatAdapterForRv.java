package app.vdaoadmin.qidu.adapter;

import android.content.Context;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;

import app.vdaoadmin.qidu.adapter.item.MsgComingItemDelagate;
import app.vdaoadmin.qidu.adapter.item.MsgSendItemDelagate;
import app.vdaoadmin.qidu.bean.Topic;

public class ChatAdapterForRv extends MultiItemTypeAdapter<Topic>
{
    public ChatAdapterForRv(Context context)
    {
        super(context);
        addItemViewDelegate(new MsgSendItemDelagate(context));
        addItemViewDelegate(new MsgComingItemDelagate(context));
    }
}
