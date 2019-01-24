package app.odp.qidu.fragment;

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
import com.anthony.rvhelper.divider.DividerItemDecoration;
import com.app.base.base.AbsListFragment;
import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.Plan;
import com.app.base.bean.Task;
import com.app.base.netUtil.PlanHttpUtil;
import com.app.base.utils.CommonKey;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.LoginUtil;
import com.common.lib.basemvp.presenter.BasePresenter;
import com.common.lib.utils.ToastUtils;
import com.common.lib.widget.StatusViewLayout;
import com.luck.picture.lib.rxbus2.RxBus;
import com.luck.picture.lib.rxbus2.Subscribe;
import com.luck.picture.lib.rxbus2.ThreadMode;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.activity.PublishPlanActivity;
import app.odp.qidu.adapter.PlanAdapter;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * Created by 7du-28 on 2018/5/22.
 */

public class PlanChildFragment extends AbsListFragment<BasePresenter>{
    private String param;
    private String action;
    public static String MY_PLAN="my.plan";
    public static String JOIN_PLAN="join.plan";
    public static String OTHER_PLAN="other.plan";
    private String userId="";
    //
    public static PlanChildFragment getInstance(String action,String param) {
        PlanChildFragment sf = new PlanChildFragment();
        sf.action = action;
        sf.param=param;
        return sf;
    }
    @Subscribe(threadMode = ThreadMode.MAIN)
    public void eventBus(CommonEventEntity obj) {
        int code = obj.what;
        if(code== CommonKey.KEY_PUBLISH_PLAN_SUCCESS){
            refreshData();
        }
    }

    @Override
    public void onResume() {
        super.onResume();
        refreshData();
    }

    @Override
    public View initView(LayoutInflater inflater, @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_plan_child,null);
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
        if(action.equals(MY_PLAN)){
            /*spannable.setSpan(new ForegroundColorSpan(Color.RED),startIndex,endIndex,Spannable.SPAN_EXCLUSIVE_EXCLUSIVE);
            textView.setText(spannable);*/
            emptyMsgTips="您还没有计划哦";
            actionMsg="去发布~";
            //mStatusViewLayout.showEmpty("您还没有计划哦","去发布~");
            mStatusViewLayout.getEmptyView().setOnClickListener(v -> {
                Intent intent=new Intent(getActivity(),PublishPlanActivity.class);
                getActivity().startActivity(intent);
            });
        }else{
            emptyMsgTips="小伙伴们还没有发布计划哦";
            //actionMsg="去记录";
            //mStatusViewLayout.showEmpty("小伙伴们还没有发布计划哦","");
        }
        //mStatusViewLayout.resetEmptyView();
        SwipeRefreshLayout mPtr=findView(R.id.refresh_layout);
        RecyclerView mRecyclerView=findView(R.id.recyclerview);
        adapter = new PlanAdapter(this,action);
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_default);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
        initPagingList(mRecyclerView, adapter, mPtr, mStatusViewLayout);

        refreshData();
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
        hashMap.put("offset",pageIndex+"");
        hashMap.put("rows",pageSize+"");
        hashMap.put("member_id",userId+"");
        if(action.equals(MY_PLAN)){
            hashMap.put("type","1");
        }else if(action.equals(JOIN_PLAN)){
            hashMap.put("type","2");
        }else if(action.equals(OTHER_PLAN)){
            hashMap.put("type","3");
        }
        Disposable disposable=PlanHttpUtil.getInstance().plansWeekList(hashMap, new DisposableObserver<List<Plan>>() {
            @Override
            public void onNext(List<Plan> planList) {
                if(planList==null){
                    planList=new ArrayList<>();
                }
                onDataSuccessReceived(pageIndex,planList);
            }
            @Override
            public void onError(Throwable e) {
                showError(e,true);
                showError(e);
            }
            @Override
            public void onComplete() {

            }
        });
        mPresenter.getCompositeSubscription().add(disposable);
    }

}
