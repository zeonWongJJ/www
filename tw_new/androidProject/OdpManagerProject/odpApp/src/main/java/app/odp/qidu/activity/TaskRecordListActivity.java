package app.odp.qidu.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.anthony.rvhelper.divider.DividerItemDecoration;
import com.app.base.base.AbsListActivity;
import com.app.base.bean.Comment;
import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.PlanComment;
import com.app.base.bean.Task;
import com.app.base.mvp.contract.CommentListContract;
import com.app.base.mvp.presenter.CommentListPresenterImpl;
import com.app.base.utils.CommonKey;
import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.common.lib.utils.ToastUtils;
import com.common.lib.widget.StatusViewLayout;
import com.luck.picture.lib.entity.EventEntity;
import com.luck.picture.lib.rxbus2.RxBus;
import com.luck.picture.lib.rxbus2.Subscribe;
import com.luck.picture.lib.rxbus2.ThreadMode;
import com.common.lib.basemvp.presenter.BasePresenter;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.adapter.CommentListAdapter;
import app.odp.qidu.adapter.PlanCommentListAdapter;
import app.odp.qidu.adapter.PlanRecordListAdapter;
import app.odp.qidu.adapter.TaskRecordListAdapter;

/**
 * 单条任务对应的记录列表
 */

public class TaskRecordListActivity extends AbsListActivity<CommentListPresenterImpl> implements CommentListContract.View{
    public static String TASK_RECORD="task_record";
    public static String PLAN_RECORD="plan_record";
    public static String recordType;
    private RecyclerView mRecyclerView;
    private MultiItemTypeAdapter adapter;
    protected SwipeRefreshLayout mPtr;
    private StatusViewLayout mStatusViewLayout;
    private String task_id;//这里task_id也可以是计划id
    //private String plan_id;
    private String department;

    @Subscribe(threadMode = ThreadMode.MAIN)
    public void eventBus(CommonEventEntity obj) {
        int code=obj.what;
        if(code==CommonKey.KEY_SEND_TASK_COMMENT_CODE){
            Comment comment= (Comment) obj.obj;
            ((TaskRecordListAdapter)adapter).addNewComment(comment);
            refreshData();
        }else if(code==CommonKey.KEY_SEND_PLAN_COMMENT_CODE){
            PlanComment planComment=(PlanComment) obj.obj;
            ((PlanRecordListAdapter)adapter).addNewComment(planComment);
            refreshData();
        }else if(code==CommonKey.KEY_REPLY_TASK_COMMENT_CODE){
            Comment comment=(Comment) obj.obj;
            int position=comment.getPosition();
            RecyclerView recyclerView=mRecyclerView.getLayoutManager().findViewByPosition(position).findViewById(R.id.comment_recyclerview);
            ((CommentListAdapter)recyclerView.getAdapter()).addNewComment(comment);
            /*((TaskRecordListAdapter)adapter).getDatas().get(position).getSub().add(comment);
            adapter.notifyItemChanged(position,"aaa");*/
            refreshData();
        }else if(code==CommonKey.KEY_REPLY_PLAN_COMMENT_CODE){
            PlanComment comment=(PlanComment) obj.obj;
            int position=comment.getPosition();
            //((PlanRecordListAdapter)adapter).getDatas().get(position).setParent_id("随便设置试试");
            //((PlanRecordListAdapter)adapter).getDatas().get(position).getSub().add(comment);
            //adapter.notifyItemChanged(position,"aaa");
            RecyclerView recyclerView=mRecyclerView.getLayoutManager().findViewByPosition(position).findViewById(R.id.comment_recyclerview);
            ((PlanCommentListAdapter)recyclerView.getAdapter()).addNewComment(comment);
            refreshData();
        }
    }
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        if (!RxBus.getDefault().isRegistered(this)) {
            RxBus.getDefault().register(this);
        }
        recordType=getIntent().getStringExtra(IntentParams.KEY_TASK_OR_PLAN_RECORD);
        TextView right=findView(R.id.title_right_text);
        TextView titleCenter=findView(R.id.title_center_text);
        task_id=getIntent().getStringExtra(IntentParams.KEY_TASK_ID);
        department=getIntent().getStringExtra(IntentParams.KEY_DEPARTMENT);mRecyclerView=findView(R.id.recyclerview);
        mPtr=findView(R.id.refresh_layout);
        mStatusViewLayout=findView(R.id.status_view_layout);

        if(recordType.equals(TASK_RECORD)){
            emptyMsgTips="此任务还没有记录哦";
            actionMsg="去记录";
            mStatusViewLayout.getEmptyView().setOnClickListener(v -> {
                Intent intent=new Intent(getActivity(),PublishCommentActivity.class);
                intent.putExtra(IntentParams.KEY_PUBLISH_COMMENT_OR_ACTION,PublishCommentActivity.PUBLISH_TASK_COMMENT);
                intent.putExtra(IntentParams.KEY_TASK_ID,task_id);
                intent.putExtra(IntentParams.KEY_MEMBER_ID, LoginUtil.getInstance().getLoginUser().getMember_id()+"");
                //intent.putExtra(IntentParams.KEY_COMMENT_REPLY_ID,"");
                intent.putExtra(IntentParams.KEY_DEPARTMENT,LoginUtil.getInstance().getLoginUser().getDepartment_name());
                startActivity(intent);
            });
            //mStatusViewLayout.showEmpty(
            titleCenter.setText("任务记录");
            right.setText("开始记录");
            right.setBackground(getResources().getDrawable(R.drawable.shape_white_stroke_corner));
            right.setOnClickListener(v -> {
                Intent intent=new Intent(getActivity(),PublishCommentActivity.class);
                intent.putExtra(IntentParams.KEY_PUBLISH_COMMENT_OR_ACTION,PublishCommentActivity.PUBLISH_TASK_COMMENT);
                intent.putExtra(IntentParams.KEY_TASK_ID,task_id);
                intent.putExtra(IntentParams.KEY_MEMBER_ID, LoginUtil.getInstance().getLoginUser().getMember_id()+"");
                //intent.putExtra(IntentParams.KEY_COMMENT_REPLY_ID,"");
                intent.putExtra(IntentParams.KEY_DEPARTMENT,LoginUtil.getInstance().getLoginUser().getDepartment_name());
                startActivity(intent);
            });
        }else if(recordType.equals(PLAN_RECORD)){
            emptyMsgTips="此计划还没有记录哦";
            actionMsg="去记录";
            mStatusViewLayout.getEmptyView().setOnClickListener(v -> {
                Intent intent=new Intent(getActivity(),PublishCommentActivity.class);
                intent.putExtra(IntentParams.KEY_PUBLISH_COMMENT_OR_ACTION,PublishCommentActivity.PUBLISH_PLAN_COMMENT);
                intent.putExtra(IntentParams.KEY_TASK_ID,task_id);
                intent.putExtra(IntentParams.KEY_MEMBER_ID, LoginUtil.getInstance().getLoginUser().getMember_id()+"");
                //intent.putExtra(IntentParams.KEY_COMMENT_REPLY_ID,"");
                intent.putExtra(IntentParams.KEY_DEPARTMENT,LoginUtil.getInstance().getLoginUser().getDepartment_name());
                startActivity(intent);
             });
            //plan_id=getIntent().getStringExtra(IntentParams.KEY_PLAN_ID);
            titleCenter.setText("计划点评");
            right.setText("去点评");
            right.setBackground(getResources().getDrawable(R.drawable.shape_white_stroke_corner));
            right.setOnClickListener(v -> {
                Intent intent=new Intent(getActivity(),PublishCommentActivity.class);
                intent.putExtra(IntentParams.KEY_PUBLISH_COMMENT_OR_ACTION,PublishCommentActivity.PUBLISH_PLAN_COMMENT);
                intent.putExtra(IntentParams.KEY_TASK_ID,task_id);
                intent.putExtra(IntentParams.KEY_MEMBER_ID, LoginUtil.getInstance().getLoginUser().getMember_id()+"");
                //intent.putExtra(IntentParams.KEY_COMMENT_REPLY_ID,"");
                intent.putExtra(IntentParams.KEY_DEPARTMENT,LoginUtil.getInstance().getLoginUser().getDepartment_name());
                startActivity(intent);
            });
        }

        ImageView left=findView(R.id.title_left_image);
        left.setOnClickListener(v -> {
            finish();
        });
        //topicList=DataTest.getDataList();
        if(recordType.equals(TASK_RECORD)){
            adapter = new TaskRecordListAdapter(getActivity(),task_id,1);
        }else if(recordType.equals(PLAN_RECORD)){
            adapter = new PlanRecordListAdapter(getActivity(),task_id);
        }
        /*DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_default);
        //decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);*/
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
        initPagingList(mRecyclerView, adapter, mPtr, mStatusViewLayout);
        refreshData();

    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        return inflater.inflate(R.layout.activity_task_record_list,null);
    }

    @Override
    protected CommentListPresenterImpl initPresenter() {
        return new CommentListPresenterImpl();
    }

    @Override
    public void loadData(int pageIndex) {
        if(recordType.equals(TASK_RECORD)){
            mPresenter.loadData(pageIndex,pageSize,task_id,department);
        }else if(recordType.equals(PLAN_RECORD)){
            mPresenter.loadPlanData(pageIndex,pageSize,task_id,department);
        }
    }

    @Override
    public void commentListData(int pageIndex, List<Comment> list) {
        onDataSuccessReceived(pageIndex,list);
    }

    @Override
    public void commentPlanListData(int pageIndex, List<PlanComment> list) {
        onDataSuccessReceived(pageIndex,list);
    }

    @Override
    public void onFailure(Throwable throwable) {
        showError(throwable);
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        if (RxBus.getDefault().isRegistered(this)) {
            RxBus.getDefault().unregister(this);
        }
    }
}
