package app.vdaoadmin.qidu.adapter;

import android.content.Context;
import android.view.View;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;

import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.bean.Topic;

/**
 * 只有一种viewType
 */

public class JustSimpleAdapter extends CommonAdapter<Topic> {
    public JustSimpleAdapter(Context context) {
        super(context, R.layout.layout_prj_just_title);
    }


    @Override
    protected void convert(ViewHolder holder, final Topic topic, int position) {
        holder.setText(R.id.tv_item_title, topic.getTitle());
        holder.getConvertView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {


            }
        });
    }
}
