package app.odp.qidu.fragment;

import android.app.Activity;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.DefaultItemAnimator;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import com.app.base.bean.Evaluate;
import com.app.base.bean.MemberRealm;
import com.app.base.bean.TypeSelect;
import com.app.base.bean.UserRealm;
import com.app.base.bean.WorkBean;
import com.app.base.netUtil.AchievementHttpUtil;
import com.app.base.netUtil.MemberHttpUtil;
import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.common.lib.basemvp.presenter.BasePresenter;
import com.common.lib.utils.StatusBarUtil;
import com.common.lib.utils.TimeUtil;
import com.luck.picture.lib.immersive.LightStatusBarUtils;
import com.common.lib.basemvp.base.BaseFragment;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.activity.TimePickerActivity;
import app.odp.qidu.adapter.AttendanceGridAdapter;
import app.odp.qidu.adapter.ThingRecordGridAdapter;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 绩效
 */

public class TabAchievementFragment extends BaseFragment<BasePresenter> {
    private int requestCodeDatePicker=0x234;//年月选择
    private int requestCodeDepartmentPicker=0x235;//查看他人
    private String param;
    private RecyclerView recyclerView,record_grid;
    private TextView choose_date,user_name,department;
    private View look_others;
    private String member_id,query_time;
    private AttendanceGridAdapter attendanceGridAdapter;
    private SwipeRefreshLayout refresh_layout;
    private ThingRecordGridAdapter thingRecordGridAdapter;
    public static TabAchievementFragment getInstance(String param) {
        TabAchievementFragment sf = new TabAchievementFragment();
        sf.param = param;
        return sf;
    }
    @Override
    protected void onVisible() {
        StatusBarUtil.setStatusBarColor(getActivity(),R.color.title_bg);
        LightStatusBarUtils.setLightStatusBar(getActivity(),false);
    }

    @Override
    protected void initViewsAndEvents(View view, Bundle savedInstanceState) {
        refresh_layout=findView(R.id.refresh_layout);
        refresh_layout.setColorSchemeResources(R.color.red, R.color.red);
        MemberRealm user= LoginUtil.getInstance().getLoginUser();
        member_id=user.getMember_id();
        TextView titleCenter=view.findViewById(R.id.title_center_text);
        titleCenter.setText("绩效");
        View back=view.findViewById(R.id.title_left_image);
        back.setVisibility(View.GONE);
        department=findView(R.id.department);
        department.setText(""+user.getDepartment_name());
        look_others=view.findViewById(R.id.look_others);
        user_name=view.findViewById(R.id.user_name);
        user_name.setText(user.getReal_name()+"");
        choose_date=view.findViewById(R.id.choose_date);
        Calendar c = Calendar.getInstance();//
        int mYear = c.get(Calendar.YEAR); // 获取当前年份
        int mMonth = c.get(Calendar.MONTH)+1;// 上个月份
        //mDay = c.get(Calendar.DAY_OF_MONTH);// 获取当日期
        if(mMonth<10){
            query_time = mYear + "-0" + mMonth;
        }else {
            query_time = mYear + "-" + mMonth;
        }
        choose_date.setText(query_time);
        choose_date.setOnClickListener(v -> {
            Intent intent=new Intent(getActivity(), TimePickerActivity.class);
            intent.putExtra(IntentParams.KEY_DATE_PICKER_DEPARTMENT_PICKER,TimePickerActivity.ONLY_SHOW_DATE_CHOOSE);
            intent.putExtra(IntentParams.KEY_IS_LIMIT_DATE,true);
            intent.putExtra(IntentParams.KEY_DATE_PICKER_IS_HIDE_DAY,true);
            startActivityForResult(intent,requestCodeDatePicker);
        });
        look_others.setOnClickListener(v -> {
            Intent intent=new Intent(getActivity(), TimePickerActivity.class);
            intent.putExtra(IntentParams.KEY_DATE_PICKER_DEPARTMENT_PICKER,TimePickerActivity.ONLY_SHOW_DEPARTMENT);
            startActivityForResult(intent,requestCodeDepartmentPicker);
        });
        record_grid=view.findViewById(R.id.record_grid);

        record_grid.setNestedScrollingEnabled(false);
        record_grid.setHasFixedSize(true);
        GridLayoutManager gridManager = new GridLayoutManager(getActivity(), 4, GridLayoutManager.VERTICAL, false);
        record_grid.setLayoutManager(gridManager);
        /*GridSpacingItemDecoration itemDecoration=new GridSpacingItemDecoration(3,10,false);
        record_grid.addItemDecoration(itemDecoration);*/
        ((DefaultItemAnimator) record_grid.getItemAnimator()).setSupportsChangeAnimations(false);
        thingRecordGridAdapter=new ThingRecordGridAdapter(this);
        record_grid.setAdapter(thingRecordGridAdapter);

        List<TypeSelect> listRecord=new ArrayList<>();
        //TypeSelect attendanceBean=new TypeSelect(TypeSelect.attendanceBean,"考勤记录");
        TypeSelect leaveBean=new TypeSelect(TypeSelect.leaveBean,"请假记录");
        TypeSelect approvalBean=new TypeSelect(TypeSelect.approvalBean,"审批记录");
        TypeSelect signInBean=new TypeSelect(TypeSelect.signInBean,"考勤打卡");
        signInBean.setStatus("1");
        //listRecord.add(attendanceBean);
        listRecord.add(leaveBean);
        listRecord.add(approvalBean);
        listRecord.add(signInBean);
        thingRecordGridAdapter.refreshData(listRecord);

        recyclerView=view.findViewById(R.id.recycler_view);
        recyclerView.setNestedScrollingEnabled(false);
        recyclerView.setHasFixedSize(true);
        GridLayoutManager gridMg = new GridLayoutManager(getActivity(), 2, GridLayoutManager.VERTICAL, false);
        recyclerView.setLayoutManager(gridMg);
        ((DefaultItemAnimator) recyclerView.getItemAnimator()).setSupportsChangeAnimations(false);
        attendanceGridAdapter=new AttendanceGridAdapter(getActivity());
        recyclerView.setAdapter(attendanceGridAdapter);
        refresh_layout.setOnRefreshListener(()->{
            initData();
            initSinStatus();
        });
        initSinStatus();
        /*List<Evaluate> evaluateList=new ArrayList<>();
        Evaluate evaluate1=new Evaluate("出勤天数","attendance","20天");
        Evaluate evaluate2=new Evaluate("出勤时间","attendance","30天");

        Evaluate evaluateA=new Evaluate("A级评定","A","30个");
        Evaluate evaluateB=new Evaluate("B级评定","B","30个");
        Evaluate evaluateC=new Evaluate("C级评定","C","30个");
        evaluateList.add(evaluate1);
        evaluateList.add(evaluate2);
        evaluateList.add(evaluateA);
        evaluateList.add(evaluateB);
        evaluateList.add(evaluateC);
        attendanceGridAdapter.refreshData(evaluateList);*/
    }

    private void initData(WorkBean workBean){
        List<Evaluate> evaluateList=new ArrayList<>();
        Evaluate evaluate1=new Evaluate("出勤天数","attendance",workBean.getWork_total_date()+"天");
        Evaluate evaluate2=new Evaluate("出勤时间","attendance",workBean.getWork_total_time()+"小时");
        evaluateList.add(evaluate1);
        evaluateList.add(evaluate2);
        if(workBean.getList()!=null){
            for(int i=0;i<workBean.getList().size();i++){
                int num=workBean.getList().get(i).getNum();
                if(num<0){//兼容php返回负数的错误
                    num=0;
                }
                Evaluate evaluate=new Evaluate(workBean.getList().get(i).getGrade(),"",num+"个");
                evaluateList.add(evaluate);
            }
            attendanceGridAdapter.refreshData(evaluateList);
            attendanceGridAdapter.notifyDataSetChanged();
        }
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
            choose_date.setText(a);
            initData();
        }else if(requestCode==requestCodeDepartmentPicker&&resultCode== Activity.RESULT_OK){
            if(data==null){
                return;
            }
            UserRealm user= (UserRealm) data.getSerializableExtra(IntentParams.KEY_DEPARTMENT_PERSON_SELECT);
            if(user!=null){
                member_id=user.getMember_id();
                if(user.getReal_name()!=null){
                    user_name.setText(""+user.getReal_name());
                }else {
                    user_name.setText(""+user.getMember_name());
                }
                department.setText(""+user.getDepartment_name());
                initData();
            }
        }
    }

    @Override
    public View initView(LayoutInflater inflater, @Nullable Bundle savedInstanceState) {
        View view=inflater.inflate(R.layout.fragment_tab_achievement,null);;
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
                initData();
            }
        };
    }

    public String getQuery_time(){
        return query_time;
    }
    private void initData(){
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("member_id",member_id+"");
        if(!TextUtils.isEmpty(query_time)){
            long timeTemp= TimeUtil.getTimeStamp(query_time,"yyyy-MM")/1000;
            hashMap.put("query_time",timeTemp+"");
        }
        Log.i("aaaa",hashMap.toString());
        Disposable disposable= AchievementHttpUtil.getInstance().workStaticsList(hashMap, new DisposableObserver<WorkBean>() {
            @Override
            public void onNext(WorkBean workBean) {
                refresh_layout.setRefreshing(false);
                if(workBean!=null){
                    initData(workBean);
                }
            }

            @Override
            public void onError(Throwable e) {
                refresh_layout.setRefreshing(false);
            }
            @Override
            public void onComplete() {

            }
        },WorkBean.class);
        mPresenter.getCompositeSubscription().add(disposable);
    }

    //获取签到状态
    private void initSinStatus(){
        HashMap<String,String> hashMap=new HashMap<>();
        Disposable disposable= MemberHttpUtil.getInstance().signStatus(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String s) {
                try {
                    JSONObject jsonObject=new JSONObject(s);
                    int is_sign=jsonObject.getInt("is_sign");
                    if(is_sign==1){
                        for(int i=0;i<thingRecordGridAdapter.getDatas().size();i++){
                            if(thingRecordGridAdapter.getDatas().get(i).getType().equals(TypeSelect.signInBean)){
                                thingRecordGridAdapter.getDatas().get(i).setStatus("1");
                                thingRecordGridAdapter.notifyItemChanged(i);
                            }
                        }
                    }else {
                        for(int i=0;i<thingRecordGridAdapter.getDatas().size();i++){
                            if(thingRecordGridAdapter.getDatas().get(i).getType().equals(TypeSelect.signInBean)){
                                thingRecordGridAdapter.getDatas().get(i).setStatus("0");
                                thingRecordGridAdapter.notifyItemChanged(i);
                            }
                        }
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }

            }
            @Override
            public void onError(Throwable e) {

            }
            @Override
            public void onComplete() {

            }
        },String.class);
        mPresenter.getCompositeSubscription().add(disposable);
    }
}
