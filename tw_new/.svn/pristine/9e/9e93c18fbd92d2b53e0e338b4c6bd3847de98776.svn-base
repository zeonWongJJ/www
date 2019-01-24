package com.app.base.adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;


import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.R;
import com.app.base.bean.TypeSelect;



public class TypeSelectPopuAdapter extends CommonAdapter<TypeSelect> {
    private int type;// 为1的时候是 添加节点页面 更多操作的时候使用
    //构造方法
    public TypeSelectPopuAdapter(Context context) {
        super(context,R.layout.layout_item_operation_popu);
        this.mContext = context;

    }
    public void setType(int type){
        this.type=type;
    }
    @Override
    protected void convert(ViewHolder holder, final TypeSelect data, int position) {
        TextView tv_item_title=holder.getView(R.id.tv_item_title);
        if(type==1){
            tv_item_title.setBackground(mContext.getResources().getDrawable(R.drawable.bg_btn_corner));
            tv_item_title.setTextColor(mContext.getResources().getColor(R.color.white));
        }
        holder.setText(R.id.tv_item_title, data.getTitle());
    }

}
