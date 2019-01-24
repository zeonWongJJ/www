package app.odp.qidu.fragment;

import android.animation.Animator;
import android.animation.ObjectAnimator;
import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.TextView;

import com.anthony.rvhelper.divider.DividerItemDecoration;
import com.app.base.base.AbsListFragment;
import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.Participant;
import com.app.base.bean.Task;
import com.app.base.bean.TopMenuItem;
import com.app.base.mvp.contract.TaskContract;
import com.app.base.mvp.presenter.TaskPresenterImpl;
import com.app.base.netUtil.TaskHttpUtil;
import com.app.base.utils.CommonKey;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.LoginUtil;
import com.common.lib.basemvp.presenter.BasePresenter;
import com.common.lib.utils.ToastUtils;
import com.common.lib.widget.StatusViewLayout;
import com.luck.picture.lib.rxbus2.RxBus;
import com.luck.picture.lib.rxbus2.Subscribe;
import com.luck.picture.lib.rxbus2.ThreadMode;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.activity.PublishTaskActivity;
import app.odp.qidu.adapter.TaskAdapter;
import io.reactivex.observers.DisposableObserver;

/**
 * 任务和计划导航按钮对应页面--任务和计划共用
 */

public class TaskHomeFragment extends AbsListFragment<BasePresenter>{
    public static String NO_COMPLETE="no_complete";
    public static String COMPLETE="complete";//完成
    private String action;
    private String taskStatus;//含有 未完成，已完成 导航按钮状态
    private String projectId;
    private String taskType="";
    private String userId;
    private TaskAdapter adapter;
    public static TaskHomeFragment getInstance(String param,String taskStatus) {
        TaskHomeFragment sf = new TaskHomeFragment();
        sf.action = param;
        sf.taskStatus=taskStatus;
        return sf;
    }

    @Subscribe(threadMode = ThreadMode.MAIN)
    public void eventBus(CommonEventEntity obj) {
        int code=obj.what;
        if(code== CommonKey.KEY_CHANGE_PROJECT){//切换项目的时候
            projectId= (String) obj.obj;
            refreshData();
        }else if(code==CommonKey.KEY_PUBLISH_TASK_SUCCESS){//发布、编辑任务的时候
            refreshData();
        }else if(code==CommonKey.KEY_HANDLE_PROCEDURE_SUCCESS){//操作流程成功的时候
            refreshData();
        }else if(code==CommonKey.KEY_DELETE_TASK_SUCCESS){//终止任务的时候
            String task_id= (String) obj.obj;
            adapter.removeTaskById(task_id);
            mLoadMoreWrapper.notifyDataSetChanged();
            refreshData();
        }
    }
    @Override
    public void onResume() {
        super.onResume();
        refreshData();
    }
    @Override
    public void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
        if(action!=null){
            outState.putSerializable("action", action);
        }
    }

    @Override
    public void onViewStateRestored(@Nullable Bundle savedInstanceState) {
        super.onViewStateRestored(savedInstanceState);
        if(savedInstanceState!=null){
            String action1 = (String) savedInstanceState.getSerializable("action");
            if(action1!=null){
                action=action1;
            }
        }
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        if (RxBus.getDefault().isRegistered(this)) {
            RxBus.getDefault().unregister(this);
        }
    }

    @Override
    protected void initViewsAndEvents(View view, Bundle savedInstanceState) {
        if (!RxBus.getDefault().isRegistered(this)) {
            RxBus.getDefault().register(this);
        }
        userId= LoginUtil.getInstance().getLoginUser().getMember_id();
        StatusViewLayout mStatusViewLayout=findView(R.id.status_view_layout);
        //mStatusViewLayout.resetEmptyView();
        SwipeRefreshLayout mPtr=findView(R.id.refresh_layout);
        RecyclerView mRecyclerView=findView(R.id.recyclerview);
        /*mRecyclerView.addOnScrollListener(new RecyclerView.OnScrollListener() {
            @Override
            public void onScrollStateChanged(RecyclerView recyclerView, int newState) {
            }
            @Override
            public void onScrolled(RecyclerView recyclerView, int dx, int dy) {
                if (dy > 0 ){
                    hidenFabAnim();
                }else{
                    showFabAnim();
                }
            }
        });*/
        adapter = new TaskAdapter(this,action);
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_default);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
        initPagingListWithoutHeader(mRecyclerView, adapter, mPtr, mStatusViewLayout);

        refreshData();
    }

    @Override
    public View initView(LayoutInflater inflater, @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_task_home,null);
    }

    @Override
    protected TaskPresenterImpl initPresenter() {
        return new TaskPresenterImpl();
    }


    @Override
    public void loadData(int pageIndex) {
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("offset",pageIndex+"");//pageIndex*pageSize
        hashMap.put("rows",pageSize+"");
        if(action.equals(TopMenuItem.ALL_TASK)){
            /*projectId="";*/
            taskType="";
        }else if(action.equals(TopMenuItem.PLAN_TASK)){
            taskType="2";
        }else if(action.equals(TopMenuItem.MY_TASK)){
            taskType="1";
        }else if(action.equals(TopMenuItem.MY_PUBLISH_TASK)){
            taskType="3";
        }else if(action.equals(TopMenuItem.BILLBOARD)){
            taskType="4";
        }
        hashMap.put("type",taskType);
        hashMap.put("member_id",userId);
        if(!TextUtils.isEmpty(projectId)){
            hashMap.put("project_id",projectId+"");
        }
        String task_status="";
        if(!TextUtils.isEmpty(taskStatus)){
            if(taskStatus.equals(NO_COMPLETE)){
                task_status="-1";
            }else if(taskStatus.equals(COMPLETE)){
                task_status="1";
            }
            hashMap.put("task_status",task_status+"");
        }
        TaskHttpUtil.getInstance().taskList(hashMap, new DisposableObserver<List<Task>>() {
            @Override
            public void onNext(List<Task> taskList) {
                if(taskList==null){
                    taskList= new ArrayList<>();
                }
                onDataSuccessReceived(pageIndex,taskList);
            }
            @Override
            public void onError(Throwable e) {
                Log.i("aaaaaaaaa",e.getMessage());
                showError(e,true);
                showError(e);
            }

            @Override
            public void onComplete() {

            }
        });
    }


    //private boolean isFabAnimg;
    /**
     * 动画隐藏浮动按钮
     */
    /*private void hidenFabAnim() {
        if (!isFabAnimg && mActionButton != null && mActionButton.getVisibility() == View.VISIBLE) {
            Animator animator = ObjectAnimator.ofFloat(mActionButton, "translationY", 0f, 100f);
            animator.setDuration(500);
            animator.addListener(new Animator.AnimatorListener() {
                @Override
                public void onAnimationStart(Animator animation) {
                    isFabAnimg = true;
                }
                @Override
                public void onAnimationEnd(Animator animation) {
                    isFabAnimg = false;
                    mActionButton.setVisibility(View.GONE);
                }

                @Override
                public void onAnimationCancel(Animator animation) {
                    isFabAnimg = false;
                }

                @Override
                public void onAnimationRepeat(Animator animation) {

                }
            });
            animator.start();
        }
    }*/

    /**
     * 动画显示浮动按钮
     */
    /*private void showFabAnim(){
        if (mActionButton != null && !isFabAnimg && mActionButton.getVisibility() == View.GONE) {
            Animator animator =  ObjectAnimator.ofFloat(mActionButton,"translationY",100f,0f);
            animator.setDuration(500);
            animator.addListener(new Animator.AnimatorListener() {
                @Override
                public void onAnimationStart(Animator animation) {
                    isFabAnimg = true;
                }

                @Override
                public void onAnimationEnd(Animator animation) {
                    isFabAnimg = false;
                }

                @Override
                public void onAnimationCancel(Animator animation) {
                    isFabAnimg = false;
                }

                @Override
                public void onAnimationRepeat(Animator animation) {

                }
            });
            mActionButton.setVisibility(View.VISIBLE);
            animator.start();
        }
    }*/
}
