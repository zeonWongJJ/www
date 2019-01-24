package app.odp.qidu.adapter;

import android.content.Context;
import android.content.Intent;
import android.widget.ImageView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.TypeSelect;
import com.app.base.utils.IntentParams;

import app.odp.qidu.R;
import app.odp.qidu.activity.DynamicCommentListActivity;
import app.odp.qidu.activity.NoticeHomeActivity;

//绩效导航页--事务记录
public class MoreGridAdapter extends CommonAdapter<TypeSelect> {
    public MoreGridAdapter(Context context) {
        super(context, R.layout.layout_thing_record_item);
    }

    @Override
    protected void convert(ViewHolder holder, TypeSelect data, int position) {
        holder.setText(R.id.title,data.getTitle());
        ImageView img=holder.getView(R.id.img);
        if(data.getType().equals("dynamic")){
            img.setImageResource(R.drawable.icon_dynamic);
        }else if(data.getType().equals("notice")){
            img.setImageResource(R.drawable.icon_notice_home);
        }
        holder.getConvertView().setOnClickListener(v -> {
            if(data.getType().equals("notice")){
                //公告通知
                Intent intent=new Intent(mContext,NoticeHomeActivity.class);
                mContext.startActivity(intent);
            }else if(data.getType().equals("dynamic")){
                Intent intent=new Intent(mContext,DynamicCommentListActivity.class);
                intent.putExtra(IntentParams.KEY_DYNAMIC_TYPE,0);
                mContext.startActivity(intent);
            }
        });
    }



}
