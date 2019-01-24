package app.odp.qidu.activity;

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
import com.app.base.bean.AbsenceBean;
import com.app.base.bean.Evaluate;
import com.app.base.bean.UserRealm;
import com.app.base.flow.FlowTagLayout;
import com.app.base.mvp.contract.ListContract;
import com.app.base.mvp.presenter.ListPresenterImpl;
import com.app.base.netUtil.AchievementHttpUtil;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.app.base.widget.RightAlertDialog;
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
import app.odp.qidu.adapter.LeaveListAdapter;
import app.odp.qidu.adapter.TagAllUserAdapter;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 请假记录
 */

public class LeaveListActivity extends AbsListActivity<BasePresenter>{
    protected RecyclerView mRecyclerView;
    protected SwipeRefreshLayout mPtr;
    protected StatusViewLayout mStatusViewLayout;

    private LeaveListAdapter adapter;
    private String query_time;
    private String member_id;
    @Override
    public void loadData(int pageIndex) {
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("offset",pageIndex+"");//pageIndex*pageSize
        hashMap.put("rows",pageSize+"");
        hashMap.put("member_id", member_id);
        if(!TextUtils.isEmpty(query_time)){
            long timeTemp= TimeUtil.getTimeStamp(query_time,"yyyy-MM")/1000;
            hashMap.put("query_time",timeTemp+"");
        }
        Disposable disposable=AchievementHttpUtil.getInstance().absenceList(hashMap, new DisposableObserver<String>() {
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

    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        query_time=getIntent().getStringExtra(IntentParams.KEY_QUERY_TIME);
        member_id=LoginUtil.getInstance().getLoginUser().getMember_id();
        TextView titleCenter=findView(R.id.title_center_text);
        titleCenter.setText("请假记录");
        ImageView left=findView(R.id.title_left_image);
        left.setOnClickListener(v -> {
            finish();
        });
        TextView right=findView(R.id.title_right_text);
        right.setBackground(getResources().getDrawable(R.drawable.shape_white_stroke_corner));
        right.setText("申请请假");
        right.setOnClickListener(v -> {
            Intent intent=new Intent(getActivity(),CreateLeaveActivity.class);
            startActivity(intent);
        });
        mStatusViewLayout=findView(R.id.status_view_layout);
        //mStatusViewLayout.resetEmptyView();
        mPtr=findView(R.id.refresh_layout);
        mRecyclerView=findView(R.id.recyclerview);
        adapter = new LeaveListAdapter(this,listener);
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_default);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));

        initPagingList(mRecyclerView, adapter, mPtr, mStatusViewLayout);
        //refreshData();

    }

    @Override
    public void onResume() {
        super.onResume();
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

    private View.OnClickListener listener=new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            if(v.getId()==R.id.stop_absence){
                int position= (int) v.getTag();
                new RightAlertDialog.Builder(getActivity()).setTitle("提示").setMsg("确定撤销此记录？").setOk("提交").setCancel("取消").setClickListener(new RightAlertDialog.OnClickListener() {
                    @Override
                    public void onOkClick() {
                        deleteAbsence(position);
                    }

                    @Override
                    public void onCancelClick() {

                    }
                    @Override
                    public void onDismiss() {

                    }
                }).create();
            }else if(v.getId()==R.id.edit_absence){
                int position= (int) v.getTag();
                AbsenceBean data=adapter.getDatas().get(position);
                Intent intent=new Intent(getActivity(), CreateLeaveActivity.class);
                intent.putExtra(IntentParams.KEY_ABSENCE_ID,data.getAbsence_id());
                startActivity(intent);
            }

        }
    };


    private void deleteAbsence(int position){
        showProgressDialog();
        AbsenceBean data=adapter.getDatas().get(position);
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("absence_id",data.getAbsence_id());
        Disposable disposable=AchievementHttpUtil.getInstance().absenceDelete(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String s) {
                dismissProgressDialog();
                adapter.getDatas().remove(position);
                mLoadMoreWrapper.notifyDataSetChanged();
                ToastUtils.show("撤销请假成功");
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
        mPresenter.getCompositeSubscription().add(disposable);
    }
}