package app.odp.qidu.fragment;

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
import com.app.base.base.AbsListFragment;
import com.app.base.bean.Comment;
import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.PlanComment;
import com.app.base.bean.Task;
import com.app.base.mvp.contract.CommentListContract;
import com.app.base.mvp.presenter.CommentListPresenterImpl;
import com.app.base.utils.CommonKey;
import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.common.lib.widget.StatusViewLayout;
import com.luck.picture.lib.rxbus2.RxBus;
import com.luck.picture.lib.rxbus2.Subscribe;
import com.luck.picture.lib.rxbus2.ThreadMode;
import com.common.lib.basemvp.base.BaseFragment;

import java.util.ArrayList;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.activity.PublishCommentActivity;
import app.odp.qidu.adapter.CommentListAdapter;
import app.odp.qidu.adapter.PlanAdapter;
import app.odp.qidu.adapter.TaskRecordListAdapter;

/**
 * 单条任务对应的记录列表
 */

public class ActionRecordListFragment extends AbsListFragment<CommentListPresenterImpl> implements CommentListContract.View {
    private MultiItemTypeAdapter adapter;
    private String department;
    private String task_id;
    private String actionType;
    private RecyclerView mRecyclerView;
    public static ActionRecordListFragment getInstance(String actionType,String department,String task_id) {
        ActionRecordListFragment sf = new ActionRecordListFragment();
        sf.actionType=actionType;
        sf.department = department;
        sf.task_id=task_id;
        return sf;
    }
    @Subscribe(threadMode = ThreadMode.MAIN)
    public void eventBus(CommonEventEntity obj) {
        int code = obj.what;
        Log.i("aaaaaa","fragment收到消息"+code);
        if(code== CommonKey.KEY_SEND_TASK_ACTION_COMMENT_CODE){
            Comment comment= (Comment) obj.obj;
            String type=comment.getTask_record_type();
            if(type.equals(actionType)){
                ((TaskRecordListAdapter)adapter).addNewComment(comment);
                refreshData();
            }
        }else if(code== CommonKey.KEY_REPLY_TASK_ACTION_COMMENT_CODE){
            Comment comment= (Comment) obj.obj;
            String type=comment.getTask_record_type();
            if(type.equals(actionType)){
                int position=comment.getPosition();
                /*((TaskRecordListAdapter)adapter).getDatas().get(position).getSub().add(comment);
                adapter.notifyDataSetChanged();*/
                RecyclerView recyclerView=mRecyclerView.getLayoutManager().findViewByPosition(position).findViewById(R.id.comment_recyclerview);
                ((CommentListAdapter)recyclerView.getAdapter()).addNewComment(comment);
                refreshData();
            }
        }
    }

    @Override
    public void onResume() {
        super.onResume();
        refreshData();
    }

    @Override
    protected void initViewsAndEvents(View view, Bundle savedInstanceState) {
        if (!RxBus.getDefault().isRegistered(this)) {
            RxBus.getDefault().register(this);
        }
        /*mRecyclerView=findView(R.id.recyclerview);
        adapter = new TaskRecordListAdapter(getActivity(),task_id,mRecyclerView);
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_default);
        mRecyclerView.addItemDecoration(decoration);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
        mRecyclerView.setAdapter(adapter);*/
        StatusViewLayout mStatusViewLayout=findView(R.id.status_view_layout);
        emptyMsgTips="此动作还没有记录哦";
        actionMsg="去记录";
        //mStatusViewLayout.showEmpty("此动作还没有记录哦","去记录~");
        mStatusViewLayout.getEmptyView().setOnClickListener(v -> {
            Intent intent=new Intent(getActivity(),PublishCommentActivity.class);
            intent.putExtra(IntentParams.KEY_PUBLISH_COMMENT_OR_ACTION,PublishCommentActivity.PUBLISH_ACTION_COMMENT);
            intent.putExtra(IntentParams.KEY_TASK_ID,task_id);
            intent.putExtra(IntentParams.KEY_MEMBER_ID, LoginUtil.getInstance().getLoginUser().getMember_id()+"");
            //intent.putExtra(IntentParams.KEY_COMMENT_REPLY_ID,"");
            intent.putExtra(IntentParams.KEY_DEPARTMENT,/*LoginUtil.getInstance().getLoginUser().getDepartment_name()*/department);//不能传自己所在的部门
            startActivity(intent);
        });
        SwipeRefreshLayout mPtr=findView(R.id.refresh_layout);
        mRecyclerView=findView(R.id.recyclerview);
        adapter = new TaskRecordListAdapter(getActivity(),task_id,2);
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_default);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
        initPagingList(mRecyclerView, adapter, mPtr, mStatusViewLayout);

        //refreshData();
    }

    @NonNull
    @Override
    public View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_action_record_list,null);
    }

    @Override
    protected CommentListPresenterImpl initPresenter() {
        return new CommentListPresenterImpl();
    }


    @Override
    public void commentListData(int pageIndex, List<Comment> list) {
        onDataSuccessReceived(pageIndex,list);
    }

    @Override
    public void commentPlanListData(int pageIndex, List<PlanComment> list) {

    }

    @Override
    public void onFailure(Throwable throwable) {
        showError(throwable);
    }

    @Override
    public void loadData(int pageIndex) {
        mPresenter.loadActionRecordList(pageIndex,pageSize,task_id,department,actionType);
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        if (RxBus.getDefault().isRegistered(this)) {
            RxBus.getDefault().unregister(this);
        }
    }
}
