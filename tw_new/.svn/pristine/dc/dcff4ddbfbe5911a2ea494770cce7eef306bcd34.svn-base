package app.odp.qidu.activity;

import android.app.Activity;
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
import android.widget.ImageView;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.anthony.rvhelper.divider.DividerItemDecoration;
import com.app.base.base.AbsListActivity;
import com.app.base.bean.BaseResponse;
import com.app.base.bean.Plan;
import com.app.base.bean.Project;
import com.app.base.bean.User;
import com.app.base.mvp.presenter.ListPresenterImpl;
import com.app.base.netUtil.PlanHttpUtil;
import com.app.base.netUtil.ProjectHttpUtil;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.common.lib.utils.StatusBarUtil;
import com.common.lib.utils.ToastUtils;
import com.common.lib.widget.StatusViewLayout;
import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import com.luck.picture.lib.immersive.LightStatusBarUtils;
import com.common.lib.basemvp.presenter.BasePresenter;

import org.json.JSONArray;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.adapter.PlanSelectListAdapter;
import app.odp.qidu.adapter.ProjectListAdapter;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 项目列表筛选-----添加到我的计划列表  共用页面
 */

public class ProjectListActivity extends AbsListActivity<BasePresenter> {
    protected SwipeRefreshLayout mPtr;
    protected StatusViewLayout mStatusViewLayout;
    protected RecyclerView mRecyclerView;
    public static String PROJECT_LIST="project_list";
    public static String PLAN_LIST="plan_list";
    private PlanSelectListAdapter planAdapter;
    private ProjectListAdapter projectAdapter;
    private String type;
    private String projectIds="";
    private String planIds="";
    private String userId;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        StatusBarUtil.setStatusBarColor(getActivity(),R.color.white);
        LightStatusBarUtils.setLightStatusBar(getActivity(),true);
        userId= LoginUtil.getInstance().getLoginUser().getMember_id();
        View layout_parent=findView(R.id.layout_parent);
        layout_parent.setBackgroundColor(getResources().getColor(R.color.white));
        TextView titleCenter=findView(R.id.title_center_text);
        titleCenter.setTextColor(getResources().getColor(R.color.black));
        type=getIntent().getStringExtra(IntentParams.KEY_PROJECT_PLAN_LIST);
        if(type.equals(PROJECT_LIST)){
            titleCenter.setText("关联项目");
        }else if(type.equals(PLAN_LIST)){
            titleCenter.setText("添加到我的计划");
        }
        ImageView left=findView(R.id.title_left_image);
        left.setImageResource(R.drawable.icon_delete);
        left.setOnClickListener(v -> {
            finish();
        });
        ImageView right=findView(R.id.title_right_image);
        right.setImageResource(R.drawable.icon_select);
        right.setOnClickListener(v -> {
            if(type.equals(PROJECT_LIST)){
                if(projectAdapter.getSelectList().size()>0){
                    String projectNames="";
                    for(int i=0;i<projectAdapter.getSelectList().size();i++){
                        if(i==0){
                            projectIds=projectAdapter.getSelectList().get(i).getProject_id()+"";
                            projectNames=projectAdapter.getSelectList().get(i).getProject_name()+"";
                        }else {
                            projectIds=projectIds+","+projectAdapter.getSelectList().get(i).getProject_id();
                            projectNames=projectNames+","+projectAdapter.getSelectList().get(i).getProject_name();
                        }
                    }
                    /*if(!TextUtils.isEmpty(projectIds)){*/
                    //不要判断空，这样可以覆盖之前选择的
                    Intent intent=new Intent();
                    intent.putExtra(IntentParams.KEY_PROJECT_ID_SELECT,projectIds);
                    intent.putExtra(IntentParams.KEY_PROJECT_NAMES_SELECT,projectNames);
                    setResult(Activity.RESULT_OK,intent);
                    finish();

                }else {
                    ToastUtils.show("亲，你还没有选择项目");
                }
            }else if(type.equals(PLAN_LIST)){
                if(planAdapter.getSelectList().size()>0){
                    String planNames="";
                    for(int i=0;i<planAdapter.getSelectList().size();i++){
                        if(i==0){
                            planIds=planAdapter.getSelectList().get(i).getPlan_sub_id()+"";
                            planNames=planAdapter.getSelectList().get(i).getPlan_name()+"";
                        }else {
                            planIds=planIds+","+planAdapter.getSelectList().get(i).getPlan_sub_id();
                            planNames=planNames+","+planAdapter.getSelectList().get(i).getPlan_name();
                        }
                    }
                    Intent intent=new Intent();
                    intent.putExtra(IntentParams.KEY_PLAN_ID_SELECT,planIds);
                    intent.putExtra(IntentParams.KEY_PLAN_NAMES_SELECT,planNames);
                    setResult(Activity.RESULT_OK,intent);
                    finish();
                }else {
                    ToastUtils.show("亲，你还没有选择计划");
                }
            }
        });
        mStatusViewLayout=findView(R.id.status_view_layout);
        //mStatusViewLayout.resetEmptyView();
        mPtr=findView(R.id.refresh_layout);
        mRecyclerView=findView(R.id.recyclerview);
        mRecyclerView.setHasFixedSize(true);
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_one);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
        if(type.equals(PROJECT_LIST)){
            projectIds=getIntent().getStringExtra(IntentParams.KEY_PROJECT_ID_SELECT);
            projectAdapter = new ProjectListAdapter(this,false);
            projectAdapter.setSelectCallbackListener(new ProjectListAdapter.OnNotifyDataChangeListener() {
                @Override
                public void onNotifyDataChange() {
                    //必须用代理的adapter同通知数据改变
                    mLoadMoreWrapper.notifyDataSetChanged();
                }
            });
            //mRecyclerView.setAdapter(projectAdapter);
            initPagingListWithoutHeader(mRecyclerView, projectAdapter, mPtr, mStatusViewLayout);
        }else if(type.equals(PLAN_LIST)){
            planIds=getIntent().getStringExtra(IntentParams.KEY_PLAN_ID_SELECT);
            planAdapter = new PlanSelectListAdapter(this,false);
            planAdapter.setSelectCallbackListener(new PlanSelectListAdapter.OnNotifyDataChangeListener() {
                @Override
                public void onNotifyDataChange() {
                    //必须用代理的adapter同通知数据改变
                    mLoadMoreWrapper.notifyDataSetChanged();
                }
            });
            //mRecyclerView.setAdapter(planAdapter);
            initPagingListWithoutHeader(mRecyclerView, planAdapter, mPtr, mStatusViewLayout);
        }
        refreshData();
    }

    @Override
    public View initView(LayoutInflater inflater, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.activity_project_list, null);
        return view;
    }

    @Override
    protected BasePresenter initPresenter() {
        return new BasePresenter() {
            @Override
            public void onCreate() {

            }
            @Override
            public void loadData() {

            }
        };
    }

    @Override
    public void loadData(int pageIndex) {
        if(type.equals(PLAN_LIST)){
            HashMap<String,String> hashMap=new HashMap<>();
            hashMap.put("offset",pageIndex+"");//pageIndex*pageSize
            hashMap.put("rows",pageSize+"");
            hashMap.put("member_id",userId+"");
            Disposable disposable=PlanHttpUtil.getInstance().plansSelectList(hashMap, new DisposableObserver<String>() {
                @Override
                public void onNext(String data) {
                    //planAdapter.refreshData(planList);
                    List<Plan> planList=new ArrayList<>();
                    if(!TextUtils.isEmpty(data)&&!data.equals("")){
                        planList= GsonUtil.getObjectList(data,Plan.class);
                    }
                    onDataSuccessReceived(pageIndex,planList);
                    if(!TextUtils.isEmpty(planIds)){
                        String[] idArray=planIds.split(",");
                        for(int i=0;i<planAdapter.getDatas().size();i++){
                            for(int k=0;k<idArray.length;k++){
                                if((planAdapter.getDatas().get(i).getPlan_id()+"").equals(idArray[k])){
                                    planAdapter.getDatas().get(i).setSelect(true);
                                }
                            }
                        }
                    }
                    planAdapter.notifyDataSetChanged();
                }

                @Override
                public void onError(Throwable e) {
                    showError(e);
                }
                @Override
                public void onComplete() {

                }
            },String.class);
            mPresenter.getCompositeSubscription().add(disposable);
        }else if(type.equals(PROJECT_LIST)){
            HashMap<String,String> hashMap=new HashMap<>();
            hashMap.put("offset",pageIndex+"");//pageIndex*pageSize
            hashMap.put("rows",pageSize+"");
            Disposable disposable= ProjectHttpUtil.getInstance().projectList(hashMap, new DisposableObserver<String>() {
                @Override
                public void onNext(String data) {
                    List<Project> projectList=new ArrayList<>();
                    //projectAdapter.refreshData(projectList);
                    if(!TextUtils.isEmpty(data)&&!data.equals("")){
                        projectList= GsonUtil.getObjectList(data,Project.class);
                    }
                    onDataSuccessReceived(pageIndex,projectList);
                    if(!TextUtils.isEmpty(projectIds)){
                        String[] idArray=projectIds.split(",");
                        for(int i=0;i<projectAdapter.getDatas().size();i++){
                            for(int k=0;k<idArray.length;k++){
                                if((projectAdapter.getDatas().get(i).getProject_id()+"").equals(idArray[k])){
                                    projectAdapter.getDatas().get(i).setSelect(true);
                                }
                            }
                        }
                    }
                    projectAdapter.notifyDataSetChanged();
                }
                @Override
                public void onError(Throwable e) {
                    showError(e);
                }
                @Override
                public void onComplete() {

                }
            },String.class);
            mPresenter.getCompositeSubscription().add(disposable);
        }
    }
}