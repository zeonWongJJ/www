package app.odp.qidu.activity;

import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.anthony.rvhelper.divider.DividerItemDecoration;
import com.app.base.base.AbsListActivity;
import com.app.base.bean.AbsenceBean;
import com.app.base.bean.Evaluate;
import com.app.base.netUtil.AchievementHttpUtil;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.common.lib.base.AbsBaseActivity;
import com.common.lib.utils.TimeUtil;
import com.common.lib.utils.ToastUtils;
import com.common.lib.widget.StatusViewLayout;
import com.common.lib.basemvp.presenter.BasePresenter;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.adapter.ApprovalListAdapter;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 审批结果列表---通知待办审批列表
 */

public class ApprovalListActivity extends AbsListActivity<BasePresenter> {

    protected RecyclerView mRecyclerView;
    protected SwipeRefreshLayout mPtr;
    protected StatusViewLayout mStatusViewLayout;
    private String query_time;
    private String member_id;
    private ApprovalListAdapter adapter;
    private String is_todo;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        query_time=getIntent().getStringExtra(IntentParams.KEY_QUERY_TIME);
        is_todo=getIntent().getStringExtra(IntentParams.KEY_APPROVAL_PARAM_LIST_OR_NOTICE);
        member_id= LoginUtil.getInstance().getLoginUser().getMember_id();
        TextView titleCenter= (TextView) findViewById(R.id.title_center_text);
        titleCenter.setText("审批记录");

        ImageView left= (ImageView) findViewById(R.id.title_left_image);
        left.setOnClickListener(v -> {
            finish();
        });
        /*RecyclerView mRecyclerView= (RecyclerView) findViewById(R.id.recyclerview);
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_default);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
        ApprovalListAdapter adapter=new ApprovalListAdapter(getActivity());
        mRecyclerView.setAdapter(adapter);
        List<Evaluate> list=new ArrayList<>();
        for(int i=0;i<10;i++){
            list.add(new Evaluate("","",""));
        }
        adapter.refreshData(list);*/
        mStatusViewLayout=findView(R.id.status_view_layout);
        //mStatusViewLayout.resetEmptyView();
        mPtr=findView(R.id.refresh_layout);
        mRecyclerView=findView(R.id.recyclerview);
        adapter = new ApprovalListAdapter(this,is_todo,listener);
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_default);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
        mRecyclerView.setHasFixedSize(true);
        initPagingListWithoutHeader(mRecyclerView, adapter, mPtr, mStatusViewLayout);
        refreshData();
    }

    @Override
    public View initView(LayoutInflater inflater, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.activity_title_recyclerview_common, null);
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
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("offset",pageIndex+"");//pageIndex*pageSize
        String url= HttpUrl.api_approval_list;
        if(is_todo!=null){
            if(is_todo.equals("1")){
                url=HttpUrl.api_todo_approval_list;
                hashMap.put("is_todo",is_todo+"");//is_not_todo  可以为空   默认是所有状态的数据   1  查阅未审批的数据
            }
        }
        hashMap.put("rows",pageSize+"");
        hashMap.put("member_id", member_id);
        if(!TextUtils.isEmpty(query_time)){
            long timeTemp= TimeUtil.getTimeStamp(query_time,"yyyy-MM")/1000;
            hashMap.put("query_time",timeTemp+"");
        }
        Disposable disposable= AchievementHttpUtil.getInstance().approvalList(url,hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                List<AbsenceBean> absenceBeanList=new ArrayList<>();
                if(!TextUtils.isEmpty(data)){
                    try {
                        JSONObject object=new JSONObject(data);
                        String str=object.getString("list");
                        if(str!=null&&!str.equals("null")) {
                            absenceBeanList = GsonUtil.getObjectList(object.getString("list"), AbsenceBean.class);
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
                onDataSuccessReceived(pageIndex,absenceBeanList);
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


    private View.OnClickListener listener=new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            //is_pass ： -1 驳回 0 审批中 1 同意
            if (v.getId()==R.id.agree){
                int position= (int) v.getTag();
                AbsenceBean data=adapter.getDatas().get(position);
                String isPass="";
                if(data.getIs_pass().equals("-1")){
                    isPass="1";
                }else if(data.getIs_pass().equals("0")){
                    isPass="1";
                }else if(data.getIs_pass().equals("1")){
                    isPass="-1";
                }
                if(!TextUtils.isEmpty(isPass)){
                    updateApproval(position,isPass,data.getAbsence_id());
                }
            }else if(v.getId()==R.id.stop_agree){//驳回按钮
                int position= (int) v.getTag();
                AbsenceBean data=adapter.getDatas().get(position);
                String isPass="";
                if(data.getIs_pass().equals("-1")){//已经驳回了
                    return;
                }else if(data.getIs_pass().equals("0")){
                    isPass="-1";
                }else if(data.getIs_pass().equals("1")){//已经同意
                    isPass="-1";
                }
                if(!TextUtils.isEmpty(isPass)){
                    updateApproval(position,isPass,data.getAbsence_id());
                }
            }
        }
    };


    private void updateApproval(int position,String is_pass,String absence_id){
        showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("is_pass",is_pass+"");//pageIndex*pageSize
        hashMap.put("absence_id",absence_id+"");
        //hashMap.put("member_id", member_id);
        Disposable disposable= AchievementHttpUtil.getInstance().updateApproval(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String message) {
                dismissProgressDialog();
                //is_pass ： -1 驳回 0 审批中 1 同意
                adapter.getDatas().get(position).setIs_pass(is_pass);
                //adapter.notifyItemChanged(position);
                mLoadMoreWrapper.notifyDataSetChanged();
                if(is_pass.equals("-1")){
                    ToastUtils.show("已驳回");
                }else if(is_pass.equals("1")){
                    ToastUtils.show("已同意");
                }
            }

            @Override
            public void onError(Throwable e) {
                dismissProgressDialog();
                ToastUtils.show(e.getMessage());
            }

            @Override
            public void onComplete() {

            }
        },String.class);
    }
}
