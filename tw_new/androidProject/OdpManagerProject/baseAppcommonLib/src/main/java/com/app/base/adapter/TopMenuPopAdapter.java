package com.app.base.adapter;

import android.content.Context;
import android.view.View;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.R;
import com.app.base.bean.TopMenuItem;
/**
 * 只有一种viewType
 */

public class TopMenuPopAdapter extends CommonAdapter<TopMenuItem> {
    public TopMenuPopAdapter(Context context) {
        super(context, R.layout.layout_top_menu_item);
    }


    @Override
    protected void convert(ViewHolder holder, final TopMenuItem data, int position) {
        holder.setText(R.id.tv_item_title, data.getTitle());
        /*holder.getConvertView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {


            }
        });*/
    }
}
