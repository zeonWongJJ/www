package app.odp.qidu.adapter;

import android.content.Context;
import android.text.TextUtils;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.DynamicComment;
import com.app.base.bean.DynamicCommentRecord;
import com.app.base.utils.HttpUrl;
import com.bumptech.glide.Glide;

import app.odp.qidu.R;

//绩效导航页--出勤评定
public class DynamicCommentRecordAdapter extends CommonAdapter<DynamicCommentRecord> {
    public DynamicCommentRecordAdapter(Context context) {
        super(context, R.layout.layout_dynamic_record_item);
    }

    @Override
    protected void convert(ViewHolder holder, DynamicCommentRecord data, int position) {
        TextView dynamic_content=holder.getView(R.id.dynamic_content);
        ImageView user_photo=holder.getView(R.id.user_photo);
        holder.setText(R.id.user_name,data.getStorey_name()+"");
        TextView content=holder.getView(R.id.content);
        if(data.getType().equals("1")){//点赞
            content.setText("");
            content.setCompoundDrawablesWithIntrinsicBounds(R.drawable.like_unselect,0,0,0);

        }else if(data.getType().equals("2")){//评论
            content.setCompoundDrawablesWithIntrinsicBounds(R.drawable.icon_comment,0,0,0);
            content.setText(data.getContent());
        }else if(data.getType().equals("3")){//转发
            content.setCompoundDrawablesWithIntrinsicBounds(R.drawable.icon_forward,0,0,0);
            if(data.getContent()!=null){
                content.setText(data.getContent()+"");
            }else {
                content.setText("");
            }
        }
        holder.setText(R.id.time,data.getAdd_date()+"");
        ImageView pic=holder.getView(R.id.pic);

        if(data.getDynamic()!=null){
            DynamicComment dynamicComment=data.getDynamic();
            if(dynamicComment.getPic()!=null){
                if(!TextUtils.isEmpty(dynamicComment.getPic())){
                    dynamic_content.setVisibility(View.GONE);
                    pic.setVisibility(View.VISIBLE);
                    String[] array=dynamicComment.getPic().split(",");
                    Glide.with(mContext).load(HttpUrl.HOST+array[0]).into(pic);
                }else {
                    dynamic_content.setVisibility(View.VISIBLE);
                    pic.setVisibility(View.GONE);
                    dynamic_content.setText(dynamicComment.getContent()+"");
                }
            }else {
                dynamic_content.setVisibility(View.VISIBLE);
                pic.setVisibility(View.GONE);
                dynamic_content.setText(dynamicComment.getContent()+"");
            }
        }else {
            dynamic_content.setVisibility(View.GONE);
            pic.setVisibility(View.GONE);
        }

    }


}
