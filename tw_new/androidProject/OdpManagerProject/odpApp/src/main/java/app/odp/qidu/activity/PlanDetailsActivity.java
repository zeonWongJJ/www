package app.odp.qidu.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v7.widget.DividerItemDecoration;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.Plan;
import com.app.base.bean.PlanSubBean;
import com.app.base.bean.UserRealm;
import com.app.base.flow.FlowTagLayout;
import com.app.base.netUtil.PlanHttpUtil;
import com.app.base.utils.CommonKey;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.app.base.widget.ScoreStarDialog;
import com.common.lib.utils.TimeUtil;
import com.common.lib.utils.ToastUtils;
import com.luck.picture.lib.entity.LocalMedia;
import com.luck.picture.lib.rxbus2.RxBus;
import com.common.lib.basemvp.presenter.BasePresenter;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.adapter.PlanDetailsPlanListAdapter;
import app.odp.qidu.adapter.TagAdapter;
import choose.lm.com.fileselector.model.FileInfo;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 计划详情
 */

public class PlanDetailsActivity extends BaseShowImgAndFileActivity<BasePresenter>{
    private RecyclerView taskListView;
    private PlanDetailsPlanListAdapter planDetailsTaskListAdapter;
    private TextView task_record,complete_date;
    private String planId;//此处planId为周计划id
    //private String department;
    private TagAdapter mColorTagAdapter;
    private View score_layout,layout_line,time_line_layout,time_select_layout;
    private TextView btnScore;
    private int planTotalScore;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        planId=getIntent().getStringExtra(IntentParams.KEY_PLAN_ID);
        planTotalScore=getIntent().getIntExtra(IntentParams.KEY_PLAN_SCORE_VALUE,0);
        TextView titleCenter=findView(R.id.title_center_text);
        titleCenter.setText("计划详情");
        ImageView left=findView(R.id.title_left_image);
        left.setOnClickListener(v -> {
            finish();
        });
        time_line_layout=findView(R.id.time_line_layout);
        time_select_layout=findView(R.id.time_select_layout);
        layout_line=findView(R.id.layout_line);
        score_layout=findView(R.id.score_layout);
        complete_date=findView(R.id.complete_date);
        taskListView=findView(R.id.process_list_view);
        /*DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_one);
        taskListView.addItemDecoration(decoration);*/
        taskListView.setLayoutManager(new LinearLayoutManager(getActivity()));
        taskListView.setNestedScrollingEnabled(false);
        planDetailsTaskListAdapter = new PlanDetailsPlanListAdapter(this);
        taskListView.setAdapter(planDetailsTaskListAdapter);
        task_record=findView(R.id.task_record);
        task_record.setOnClickListener(v -> {
            Intent intent=new Intent(getActivity(),TaskRecordListActivity.class);
            intent.putExtra(IntentParams.KEY_TASK_OR_PLAN_RECORD,TaskRecordListActivity.PLAN_RECORD);
            intent.putExtra(IntentParams.KEY_TASK_ID,planId);
            intent.putExtra(IntentParams.KEY_DEPARTMENT, LoginUtil.getInstance().getLoginUser().getDepartment_name());
            startActivity(intent);
        });
        btnScore=findView(R.id.score);

        /*参与人*/

        FlowTagLayout mColorFlowTagLayout=findView(R.id.color_flow_layout);
        mColorTagAdapter = new TagAdapter(this,FlowTagLayout.FLOW_TAG_CHECKED_NONE);
        mColorFlowTagLayout.setAdapter(mColorTagAdapter);

        initPictureAndFile();


        initData();
    }


    private void initPlanDetails(PlanSubBean planSub){
        //getPlan_belonged_data
        if(planSub!=null){
            if(!LoginUtil.getInstance().getLoginUser().getMember_id().equals("0")){//此处后面加个是否是管理员判断
                layout_line.setVisibility(View.VISIBLE);
                score_layout.setVisibility(View.VISIBLE);
            }
            task_record.setEnabled(true);
            task_record.setText("查看回复"+planSub.getPlan_record_total());
            List<Plan> planList=planSub.getSub();
            if(planList!=null){
                if(planList.size()>0) {
                    Plan plan = planList.get(0);
                    if (plan != null) {
                        /*int plan_score=0;
                        int achieve_score=0;
                        if(plan.getPlan_score()!=null){
                            plan_score=Integer.parseInt(plan.getPlan_score());
                        }
                        if(plan.getPlan_achieve_score()!=null){
                            achieve_score=Integer.parseInt(plan.getPlan_achieve_score());
                        }
                        int totalScore=plan_score+achieve_score;*/
                        if(planTotalScore!=0){
                            btnScore.setText(planTotalScore+"");
                        }else {
                            btnScore.setText("评");
                        }
                        btnScore.setOnClickListener(v -> {
                            //评分弹框
                            new ScoreStarDialog.Builder(getActivity()).setOk("提交").setCancel("取消").setTitle("评分").setClickListener(new ScoreStarDialog.OnClickListener() {
                                @Override
                                public void onOkClick(float order_score, float complete_score) {
                                    planScore(btnScore,order_score,complete_score);
                                }
                                @Override
                                public void onCancelClick() {}
                                @Override
                                public void onDismiss() {}
                            }).create();
                            /*if(plan.getPlan_type().equals("1")){//周计划才可以被评分
                                //评分弹框
                                new ScoreStarDialog.Builder(getActivity()).setOk("提交").setCancel("取消").setTitle("评分").setClickListener(new ScoreStarDialog.OnClickListener() {
                                    @Override
                                    public void onOkClick(float order_score, float complete_score) {
                                        planScore(btnScore,order_score,complete_score);
                                    }
                                    @Override
                                    public void onCancelClick() {}
                                    @Override
                                    public void onDismiss() {}
                                }).create();
                            }else {
                                ToastUtils.show("定制计划不能被评分");
                            }*/
                        });
                        if(!plan.getPlan_type().equals("1")){//定制计划才有时间
                            time_line_layout.setVisibility(View.VISIBLE);
                            time_select_layout.setVisibility(View.VISIBLE);
                            complete_date.setText(TimeUtil.getFormatTime(Long.parseLong(plan.getPlan_time_limit())*1000));
                        }
                        //设置参与人
                        List<UserRealm> tagsData = plan.getPlan_belonged_data();
                        if (tagsData != null) {
                            mColorTagAdapter.onlyAddAll(tagsData);
                        }
                        List<LocalMedia> imgList = new ArrayList<>();
                        List<String> picUrls = plan.getPlan_pic_urls();
                        if (picUrls != null) {
                            for (int i = 0; i < picUrls.size(); i++) {
                                LocalMedia localMedia = new LocalMedia();
                                localMedia.setImageUrl(picUrls.get(i));
                                localMedia.setPath(HttpUrl.HOST+picUrls.get(i));
                                imgList.add(localMedia);
                            }
                            imgAdapter.refreshData(imgList);
                            imgAdapter.notifyDataSetChanged();
                        }
                        List<String> fileList = plan.getPlan_file_urls();
                        if (fileList != null) {
                            List<FileInfo> listFiles=new ArrayList<>();
                            for (int i=0;i<fileList.size();i++){
                                FileInfo fileInfo=new FileInfo();
                                fileInfo.setFileUrl(fileList.get(i));
                                listFiles.add(fileInfo);
                            }
                            fileAdapter.refreshData(listFiles);
                            fileAdapter.notifyDataSetChanged();
                        }
                    }
                }

                planDetailsTaskListAdapter.refreshData(planList);
                planDetailsTaskListAdapter.notifyDataSetChanged();
            }

        }
    }
    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        return inflater.inflate(R.layout.activity_plan_details,null);
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

    private void initData(){
        showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("plan_id",planId);
        Disposable disposable= PlanHttpUtil.getInstance().planDetails(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                dismissProgressDialog();
                if(!TextUtils.isEmpty(data)){
                    PlanSubBean planSubBean= GsonUtil.getObject(data,PlanSubBean.class);
                    initPlanDetails(planSubBean);
                }else {
                    ToastUtils.show("暂无数据");
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
        mPresenter.getCompositeSubscription().add(disposable);
    }


    private void planScore(TextView textView,float plan_score,float plan_achieve_score){
        int score=(int)plan_score;
        int achieve_score=(int)plan_achieve_score;
        showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("plan_id",planId);
        hashMap.put("plan_score",score+"");
        hashMap.put("plan_achieve_score",achieve_score+"");
        Disposable disposable= PlanHttpUtil.getInstance().planScore(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String message) {
                int totalScore= (int) (plan_score+plan_achieve_score);
                textView.setText(totalScore+"");
                dismissProgressDialog();
                ToastUtils.show(message);
                //评分成功、刷新计划的列表显示
                String type="";
                CommonEventEntity eventEntity = new CommonEventEntity(CommonKey.KEY_PUBLISH_PLAN_SUCCESS, type);
                RxBus.getDefault().post(eventEntity);
            }
            @Override
            public void onError(Throwable e) {
                dismissProgressDialog();
                ToastUtils.show(e.getMessage());
            }
            @Override
            public void onComplete() {
            }
        },Plan.class);
        mPresenter.getCompositeSubscription().add(disposable);
    }
}
