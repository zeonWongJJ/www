package app.odp.qidu.adapter;

import android.app.Activity;
import android.content.Intent;
import android.text.SpannableStringBuilder;
import android.text.Spanned;
import android.text.TextPaint;
import android.text.method.LinkMovementMethod;
import android.text.style.ClickableSpan;
import android.text.style.ForegroundColorSpan;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.R;
import com.app.base.bean.PlanComment;
import com.app.base.utils.GlideRoundTransform;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.app.base.widget.NineGridImageLayout;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.bumptech.glide.request.RequestOptions;

import java.util.ArrayList;
import java.util.List;

import app.odp.qidu.activity.PublishCommentActivity;


public class PlanCommentListAdapter extends CommonAdapter<PlanComment> {

    private Activity activity;
    private RequestOptions options = null;
    private int parentPosition;
    public PlanCommentListAdapter(final Activity context,int parentPosition) {
        super(context, R.layout.layout_comment);
        this.activity=context;
        this.parentPosition=parentPosition;
        options = new RequestOptions()
                .centerCrop()
                .transform(new GlideRoundTransform(mContext))
                .diskCacheStrategy(DiskCacheStrategy.ALL);
    }

    public void addNewComment(PlanComment comment){//预处理，添加一条新评论在第一条
        mDatas.add(comment);
        notifyItemRangeInserted(mDatas.size()-1,mDatas.size());
    }
    @Override
    protected void convert(ViewHolder holder, final PlanComment data, int position) {
        holder.setText(R.id.nick_name,data.getMy_name()+"");
        holder.setText(R.id.task_record_add_time, data.getPlan_record_add_date()+"");

        ImageView userHeader=holder.getView(R.id.user_header);
        Glide.with(mContext).load("http://img.zcool.cn/community/010f87596f13e6a8012193a363df45.jpg@1280w_1l_2o_100sh.jpg").apply(options).into(userHeader);

        TextView content=holder.getView(R.id.comment_textview);
        content.setText("");
        content.setMovementMethod(LinkMovementMethod.getInstance());

        String reply="回复";
        String replyWho=reply+data.getReply_name()+":";
        String all=replyWho+data.getPlan_record_desc();
        SpannableStringBuilder builder=new SpannableStringBuilder(all);
        builder.setSpan(new ForegroundColorSpan(activity.getResources().getColor(R.color.black)), 0, reply.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
        builder.setSpan(new ForegroundColorSpan(activity.getResources().getColor(R.color.blue)), reply.length(), replyWho.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
        builder.setSpan(new ForegroundColorSpan(activity.getResources().getColor(R.color.black)), replyWho.length()-1, all.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
        builder.setSpan(new ClickableSpan() {
            @Override
            public void onClick(View widget) {
                Intent intent=new Intent(activity,PublishCommentActivity.class);
                intent.putExtra(IntentParams.KEY_PUBLISH_COMMENT_OR_ACTION,PublishCommentActivity.PUBLISH_PLAN_COMMENT);
                intent.putExtra(IntentParams.KEY_TASK_ID,data.getPlan_id());
                intent.putExtra(IntentParams.KEY_MEMBER_ID, LoginUtil.getInstance().getLoginUser().getMember_id()+"");
                intent.putExtra(IntentParams.KEY_COMMENT_REPLY_ID,data.getPlan_record_id()+"");
                intent.putExtra(IntentParams.KEY_POSITION,parentPosition);
                intent.putExtra(IntentParams.KEY_COMMENT_REPLY_NAME,data.getMy_name());
                //intent.putExtra(IntentParams.KEY_DEPARTMENT,data.getDepartment());
                activity.startActivity(intent);
            }

            @Override
            public void updateDrawState(TextPaint ds) {
                ds.setColor(activity.getResources().getColor(R.color.black));
                ds.setUnderlineText(false);
            }
        }, replyWho.length()-1, all.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
        content.setText(builder);
        NineGridImageLayout nineGridImageLayout=holder.getView(R.id.layout_nine_grid);
        nineGridImageLayout.setActivityContext(activity);
        nineGridImageLayout.setIsShowAll(true);
        List<String> imgList=data.getPlan_record_pic_data();
        if(imgList!=null){
            List<String> imgUrls=new ArrayList<>();
            for(String url:imgList){
                imgUrls.add(HttpUrl.HOST+url);
            }
            nineGridImageLayout.setUrlList(imgUrls);
        }

        List<String> files=data.getPlan_record_file_data();
        LinearLayout fileListView=holder.getView(R.id.file_list);
        fileListView.removeAllViews();
        if(files!=null){
            for(int i=0;i<files.size();i++){
                String path=files.get(i);
                String b = path.substring(path.lastIndexOf("/") + 1, path.length());
                TextView textView=new TextView(activity);
                textView.setText(b);
                fileListView.addView(textView);
            }
        }
    }

}
