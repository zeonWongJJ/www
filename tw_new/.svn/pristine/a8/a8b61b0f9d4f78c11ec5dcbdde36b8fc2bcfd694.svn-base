package com.app.base.adapter;

import android.content.Context;
import android.text.TextUtils;
import android.view.View;
import android.widget.AbsListView;
import android.widget.ImageView;
import android.widget.TextView;

import com.app.base.R;
import com.app.base.bean.UserRealm;
import com.common.lib.adapter.AdapterHolder;
import com.common.lib.adapter.BaseListAndGridAdapter;

import java.util.Collection;


public class DialogAssignTaskAdapter extends BaseListAndGridAdapter<UserRealm> {
    private int selectPosition=-1;
    private Context context;
    public DialogAssignTaskAdapter(Context context,AbsListView view, Collection<UserRealm> mDatas) {
        super(view, mDatas, R.layout.layout_dialog_assign_task_item);
        this.context=context;
    }

    @Override
    public void convert(AdapterHolder holder, int position, boolean isScrolling) {
        UserRealm itemData = getItem(position);
        TextView textView=holder.getView(R.id.tv_item_title);
        if(selectPosition==position&&selectPosition!=-1){
            textView.setTextColor(context.getResources().getColor(R.color.blue));
        }else {
            textView.setTextColor(context.getResources().getColor(R.color.black));
        }
        if(itemData.getReal_name()!=null&& !TextUtils.isEmpty(itemData.getReal_name())){
            textView.setText(itemData.getReal_name());
        }else {
            textView.setText(itemData.getMember_name());
        }
    }

    public void setSelectPosition(int position){
        selectPosition=position;
        notifyDataSetChanged();
    }

}
