package com.app.base.adapter;

import android.content.Context;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.R;
import com.app.base.bean.Project;
import com.app.base.bean.TypeSelect;


public class PopProjectSelectPopuAdapter extends CommonAdapter<Project> {
    private int selectPosition=-1;
    //构造方法
    public PopProjectSelectPopuAdapter(Context context) {
        super(context,R.layout.layout_item_project_popu);
        this.mContext = context;

    }
    @Override
    protected void convert(ViewHolder holder, final Project data, int position) {
        TextView title=holder.getView(R.id.tv_item_title);
        if(selectPosition!=-1&&selectPosition==position){
            title.setTextColor(mContext.getResources().getColor(R.color.blue));
        }else {
            title.setTextColor(mContext.getResources().getColor(R.color.black));
        }
        title.setText(data.getProject_name());
    }

    public void setSelectPosition(int position){
        this.selectPosition=position;
        notifyDataSetChanged();
    }

}
