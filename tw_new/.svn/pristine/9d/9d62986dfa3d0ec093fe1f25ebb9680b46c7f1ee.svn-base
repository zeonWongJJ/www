package com.app.base.adapter;

import android.view.View;
import android.widget.AbsListView;
import android.widget.EditText;
import android.widget.ImageView;

import com.app.base.R;
import com.app.base.bean.TypeSelect;
import com.common.lib.adapter.AdapterHolder;
import com.common.lib.adapter.BaseListAndGridAdapter;

import java.util.Collection;



public class DialogPlanTypeAdapter extends BaseListAndGridAdapter<TypeSelect> {
    private int selectPosition=-1;
    public DialogPlanTypeAdapter(AbsListView view, Collection<TypeSelect> mDatas) {
        super(view, mDatas, R.layout.layout_dialog_plan_type_item);
    }

    @Override
    public void convert(AdapterHolder holder, int position, boolean isScrolling) {
        TypeSelect itemData =getItem(position);
        holder.setText(R.id.tv_item_title,itemData.getTitle());
        View item=holder.getView(R.id.item);
        ImageView img_checked=holder.getView(R.id.img_checked);
        if(selectPosition==position){
            img_checked.setImageResource(R.drawable.icon_circle_checked);
        }else {
            img_checked.setImageResource(R.drawable.icon_circle_unchecked);
        }
    }

    public void setSelectPosition(int position){
        selectPosition=position;
        notifyDataSetChanged();
    }

    public int getSelectPosition(){
        return selectPosition;
    }

}
