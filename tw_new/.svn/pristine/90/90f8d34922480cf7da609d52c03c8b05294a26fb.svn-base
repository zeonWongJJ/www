package app.odp.qidu.adapter;

import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.text.TextUtils;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.Plan;
import com.app.base.bean.Task;
import com.app.base.netUtil.PlanHttpUtil;
import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.app.base.widget.ScoreStarDialog;
import com.app.base.widget.ZzHorizontalProgressBar;
import com.common.lib.base.AbsBaseFragment;
import com.common.lib.utils.TimeUtil;
import com.common.lib.utils.ToastUtils;

import java.util.HashMap;

import app.odp.qidu.R;
import app.odp.qidu.activity.PlanDetailsActivity;
import app.odp.qidu.activity.PublishPlanActivity;
import app.odp.qidu.fragment.PlanChildFragment;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

//计划适配器
public class PlanAdapter extends CommonAdapter<Plan> {
    private String action;
    private AbsBaseFragment fragment;
    private String userId;
    public PlanAdapter(AbsBaseFragment fragment,String action) {
        super(fragment.getActivity(), R.layout.layout_plan_item);
        this.fragment=fragment;
        this.action=action;
        userId= LoginUtil.getInstance().getLoginUser().getMember_id();
    }

    //周 蓝色表示当前周 灰色过去周  定制计划 勾选了全部人才算公开 否则不公开  周计划才可以评分
    @Override
    protected void convert(ViewHolder holder, final Plan data, int position) {
        holder.setText(R.id.sub_plan_name,data.getSub_plan_name());
        TextView plan_score=holder.getView(R.id.plan_score);
        int planTotalScore=0;
        if(data.getTotal_score()!=0){
            plan_score.setVisibility(View.VISIBLE);
            /*int achieve_score=Integer.parseInt(data.getPlan_achieve_score());
            int plan_score_complete=Integer.parseInt(data.getPlan_score());*/
            planTotalScore=data.getTotal_score();
            plan_score.setText(planTotalScore+"");
        }else{
            plan_score.setText("评");
            plan_score.setOnClickListener(v -> {
                new ScoreStarDialog.Builder(mContext).setOk("提交").setCancel("取消").setTitle("评分").setClickListener(new ScoreStarDialog.OnClickListener() {
                    @Override
                    public void onOkClick(float order_score, float complete_score) {
                        planScore(plan_score,position,order_score,complete_score);
                    }

                    @Override
                    public void onCancelClick() {

                    }
                    @Override
                    public void onDismiss() {

                    }
                }).create();
            });
        }
        TextView plan_type=holder.getView(R.id.plan_type);
        if(data.getPlan_type().equals("1")){
            plan_type.setText("周");
            if(TimeUtil.isThisWeek(Long.parseLong(data.getPlan_add_time())*1000)){//当前周
                plan_type.setBackground(mContext.getResources().getDrawable(R.drawable.shape_blue_solid_circle));
            }else {
                plan_type.setBackground(mContext.getResources().getDrawable(R.drawable.shape_gray_solid_circle));
            }
        }else{
            plan_type.setText("定");
            if(TimeUtil.isThisWeek(Long.parseLong(data.getPlan_add_time())*1000)){//当前周
                plan_type.setBackground(mContext.getResources().getDrawable(R.drawable.shape_green_solid_circle));
            }else {
                plan_type.setBackground(mContext.getResources().getDrawable(R.drawable.shape_gray_solid_circle));
            }
        }
        ImageView plan_type_belong=holder.getView(R.id.plan_type_belong);
        plan_type_belong.setOnClickListener(null);
        if(action.equals(PlanChildFragment.MY_PLAN)){
            plan_type_belong.setImageResource(R.drawable.icon_edit);
            plan_type_belong.setOnClickListener(v -> {
                Intent intent=new Intent(mContext, PublishPlanActivity.class);
                intent.putExtra(IntentParams.KEY_PLAN_ID,data.getPlan_id());
                intent.putExtra(IntentParams.KEY_HANDLE_PLAN_TYPE,PublishPlanActivity.EDIT_PLAN);
                mContext.startActivity(intent);
            });
        }else {
            if(data.getReading()!=null){
                if(data.getReading().equals("1")){//已读
                    plan_type_belong.setImageResource(R.drawable.icon_eyes_unchecked);
                }else {
                    plan_type_belong.setImageResource(R.drawable.icon_eyes_checked);
                    plan_type_belong.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View v) {
                            //String read_status=data.getReading().equals("1")?"0":"1";
                            String read_status="1";
                            changePlanReadStatus(plan_type_belong,position,read_status);
                        }
                    });
                }

            }
        }

        ZzHorizontalProgressBar pb = holder.getView(R.id.pb);
        pb.setMax(100);
        int planProgress=0;
        if(data.getPlan_progress()!=null){
            planProgress=Integer.parseInt(data.getPlan_progress());//服务端可能返回-1
            if(planProgress<0){
                planProgress=0;
            }
            holder.setText(R.id.plan_process_percent,planProgress+"%");
        }
        if(planProgress==0){//设置为空的时候不显示默认的黄色圆点
            pb.setProgressColor(mContext.getResources().getColor(R.color.light_gray));
        }else {
            pb.setProgressColor(mContext.getResources().getColor(R.color.yellow));
            pb.setProgress(planProgress);
        }
        int finalPlanTotalScore = planTotalScore;
        holder.getConvertView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(mContext, PlanDetailsActivity.class);
                intent.putExtra(IntentParams.KEY_PLAN_ID,data.getPlan_id()+"");
                intent.putExtra(IntentParams.KEY_PLAN_SCORE_VALUE, finalPlanTotalScore);
                //intent.putExtra(IntentParams.KEY_DEPARTMENT,data.get)
                mContext.startActivity(intent);
            }
        });
    }


    private void planScore(TextView textView,int position,float plan_score,float plan_achieve_score){
        int score=(int)plan_score;
        int achieve_score=(int)plan_achieve_score;
        fragment.showProgressDialog();
        Plan data=mDatas.get(position);
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("plan_id",data.getPlan_id());
        hashMap.put("plan_score",score+"");
        hashMap.put("plan_achieve_score",achieve_score+"");
        PlanHttpUtil.getInstance().planScore(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String message) {
                int totalScore= (int) (plan_score+plan_achieve_score);
                textView.setText(totalScore+"");
                fragment.dismissProgressDialog();
                mDatas.get(position).setPlan_achieve_score(achieve_score+"");
                mDatas.get(position).setPlan_score(score+"");
                notifyItemChanged(position);
                ToastUtils.show("评分成功");
            }
            @Override
            public void onError(Throwable e) {
                fragment.dismissProgressDialog();
                ToastUtils.show(e.getMessage());
            }
            @Override
            public void onComplete() {
            }
        },Plan.class);
    }


    //标记计划为是否已读状态
    private void changePlanReadStatus(ImageView plan_type_belong,int position,String read_status){
        fragment.showProgressDialog();
        Plan data=mDatas.get(position);
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("plan_id",data.getPlan_id());
        hashMap.put("member_id",userId);
        PlanHttpUtil.getInstance().changePlanReadStatus(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String message) {
                fragment.dismissProgressDialog();
                if(read_status.equals("1")){//已读
                    plan_type_belong.setImageResource(R.drawable.icon_eyes_unchecked);
                    plan_type_belong.setEnabled(false);
                }else {
                    plan_type_belong.setImageResource(R.drawable.icon_eyes_checked);
                }
                mDatas.get(position).setReading(read_status+"");
                notifyItemChanged(position);
                if(read_status.equals("1")){
                    ToastUtils.show("成功标记为已读");
                }else {
                    ToastUtils.show("成功标记为未读");
                }
            }
            @Override
            public void onError(Throwable e) {
                fragment.dismissProgressDialog();
                ToastUtils.show(e.getMessage());
            }
            @Override
            public void onComplete() {
            }
        },Plan.class);
    }
}
