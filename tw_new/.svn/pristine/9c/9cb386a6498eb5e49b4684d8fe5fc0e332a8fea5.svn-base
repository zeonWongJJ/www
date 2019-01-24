package app.odp.qidu.activity;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
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
import com.app.base.bean.Evaluate;
import com.app.base.bean.Task;
import com.app.base.bean.UserRealm;
import com.app.base.netUtil.AchievementHttpUtil;
import com.app.base.netUtil.TaskHttpUtil;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.IntentParams;
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
import app.odp.qidu.adapter.SignInListAdapter;
import io.reactivex.observers.DisposableObserver;

/**
 * 考勤记录-列表
 */

public class SignInRecordActivity extends AbsListActivity<BasePresenter> {
    private int requestCodeDatePicker=0x234;//年月选择
    private RecyclerView mRecyclerView;
    private MultiItemTypeAdapter adapter;
    protected SwipeRefreshLayout mPtr;
    private StatusViewLayout mStatusViewLayout;
    private String query_time;
    private TextView right;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        query_time=getIntent().getStringExtra(IntentParams.KEY_QUERY_TIME);
        TextView titleCenter= (TextView) findViewById(R.id.title_center_text);
        titleCenter.setText("考勤记录");
        right= (TextView) findViewById(R.id.title_right_text);
        right.setText("选择时间");
        right.setOnClickListener(v -> {
            Intent intent=new Intent(getActivity(), TimePickerActivity.class);
            intent.putExtra(IntentParams.KEY_DATE_PICKER_DEPARTMENT_PICKER,TimePickerActivity.ONLY_SHOW_DATE_CHOOSE);
            intent.putExtra(IntentParams.KEY_IS_LIMIT_DATE,true);
            intent.putExtra(IntentParams.KEY_DATE_PICKER_IS_HIDE_DAY,true);
            startActivityForResult(intent,requestCodeDatePicker);
        });
        ImageView left= (ImageView) findViewById(R.id.title_left_image);
        left.setOnClickListener(v -> {
            finish();
        });

        mRecyclerView=findView(R.id.recyclerview);
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_one);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);
        mPtr=findView(R.id.refresh_layout);
        mStatusViewLayout=findView(R.id.status_view_layout);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
        adapter=new SignInListAdapter(getActivity());
        initPagingList(mRecyclerView, adapter, mPtr, mStatusViewLayout);
        refreshData();
        /*List<Evaluate> list=new ArrayList<>();
        for(int i=0;i<10;i++){
            list.add(new Evaluate("","",""));
        }
        adapter.refreshData(list);*/
    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        View view=inflater.inflate(R.layout.activity_leave_list,null);
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
        hashMap.put("rows",pageSize+"");
        if(!TextUtils.isEmpty(query_time)){
            long timeTemp= TimeUtil.getTimeStamp(query_time,"yyyy-MM")/1000;
            hashMap.put("query_time",timeTemp+"");
        }
        AchievementHttpUtil.getInstance().workTimeList(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                List<Evaluate> evaluateList=new ArrayList<>();
                if(!TextUtils.isEmpty(data)){
                    try {
                        JSONObject object=new JSONObject(data);
                        String str=object.getString("list");
                        if(str!=null&&!str.equals("null")) {
                            evaluateList = GsonUtil.getObjectList(object.getString("list"), Evaluate.class);
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
                onDataSuccessReceived(pageIndex,evaluateList);
            }

            @Override
            public void onError(Throwable e) {
                showError(e);
            }

            @Override
            public void onComplete() {

            }
        },String.class);
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if(requestCode==requestCodeDatePicker&&resultCode== Activity.RESULT_OK){
            if(data==null){
                return;
            }
            String a=data.getStringExtra(IntentParams.KEY_DEPARTMENT_PERSON_SELECT);
            query_time=a;
            right.setText(a);
            refreshData();
        }
    }
}
