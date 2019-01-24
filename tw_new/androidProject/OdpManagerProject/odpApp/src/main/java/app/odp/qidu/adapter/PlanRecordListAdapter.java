package app.odp.qidu.adapter;

import android.app.Activity;
import android.content.Intent;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.PopupWindow;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.Comment;
import com.app.base.bean.PlanComment;
import com.app.base.utils.CommentTagHandler;
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

import app.odp.qidu.R;
import app.odp.qidu.activity.PublishCommentActivity;


/**
 * 查看单条动态-计划评论列表
 */
public class PlanRecordListAdapter extends CommonAdapter<PlanComment> {

    private Activity activity;
    private CommentTagHandler.OnCommentClickListener listener;

    private String myId = "";
    private String task_or_plan_id;
    private RequestOptions options = null;
    /**/
    public PlanRecordListAdapter(Activity activity, String task_or_plan_id) {
        super(activity, R.layout.layout_task_record_item);
        this.task_or_plan_id=task_or_plan_id;
        myId= LoginUtil.getInstance().getLoginUser().getMember_id()+"";
        this.activity = activity;
        options = new RequestOptions()
                .centerCrop()
                .transform(new GlideRoundTransform(mContext))
                .diskCacheStrategy(DiskCacheStrategy.ALL);
    }
    public void addNewComment(PlanComment comment){//预处理，添加一条新评论在第一条
        mDatas.add(comment);
        notifyItemRangeInserted(mDatas.size()-1,mDatas.size());
    }

    public void addChildrenItemComment(int position,PlanComment comment){
        mDatas.get(position).getSub().add(comment);
    }

    @Override
    protected void convert(ViewHolder holder, final PlanComment data, int position) {
        //holder.setText(R.id.task_record_add_time, TimeUtil.getFormatCommentTime(data.getTask_record_add_time()));
        holder.setText(R.id.nick_name,data.getMy_name()+"");
        holder.setText(R.id.task_record_add_time, data.getPlan_record_add_date()+"");
        List<PlanComment> commentList=data.getSub();
        ImageView userHeader=holder.getView(R.id.user_header);
        //Glide.with(mContext).load("http://img.zcool.cn/community/010f87596f13e6a8012193a363df45.jpg@1280w_1l_2o_100sh.jpg").apply(options).into(userHeader);
        TextView content=holder.getView(R.id.tv_item_title);
        content.setText(data.getPlan_record_desc()+"");
        content.setOnClickListener(v -> {
            Intent intent=new Intent(activity,PublishCommentActivity.class);
            intent.putExtra(IntentParams.KEY_PUBLISH_COMMENT_OR_ACTION,PublishCommentActivity.PUBLISH_PLAN_COMMENT);
            intent.putExtra(IntentParams.KEY_TASK_ID,data.getPlan_id());
            intent.putExtra(IntentParams.KEY_MEMBER_ID, LoginUtil.getInstance().getLoginUser().getMember_id()+"");
            intent.putExtra(IntentParams.KEY_COMMENT_REPLY_ID,data.getPlan_record_id()+"");
            intent.putExtra(IntentParams.KEY_COMMENT_REPLY_NAME,data.getMy_name());
            //intent.putExtra(IntentParams.KEY_DEPARTMENT,data.getDepartment());
            activity.startActivity(intent);
        });
        Log.i("aaaaa","计划列表position====>"+position);
        RecyclerView commentRecyclerView=holder.getView(R.id.comment_recyclerview);
        commentRecyclerView.setLayoutManager(new LinearLayoutManager(mContext));
        final PlanCommentListAdapter adapter = new PlanCommentListAdapter(activity,position);
        commentRecyclerView.setAdapter(adapter);
        if(commentList!=null){
            adapter.refreshData(commentList);
        }


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
