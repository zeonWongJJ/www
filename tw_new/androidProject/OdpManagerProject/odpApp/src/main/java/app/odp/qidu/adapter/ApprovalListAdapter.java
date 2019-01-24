package app.odp.qidu.adapter;

import android.content.Context;
import android.content.Intent;
import android.text.TextUtils;
import android.view.View;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.AbsenceBean;
import com.app.base.bean.Evaluate;
import com.app.base.netUtil.AchievementHttpUtil;
import com.app.base.utils.IntentParams;
import com.common.lib.base.AbsBaseActivity;
import com.common.lib.utils.ToastUtils;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.activity.ApprovalDetailsActivity;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

//审批记录
public class ApprovalListAdapter extends CommonAdapter<AbsenceBean> {
    private AbsBaseActivity activity;
    private String is_no_todo;
    private View.OnClickListener listener;
    public ApprovalListAdapter(AbsBaseActivity activity,String is_not_todo,View.OnClickListener listener) {
        super(activity, R.layout.layout_approval_item);
        this.activity=activity;
        this.is_no_todo=is_not_todo;
        this.listener=listener;
    }

    @Override
    protected void convert(ViewHolder holder, AbsenceBean data, int position) {
        holder.setText(R.id.user_name,data.getReal_name()+"");
        holder.setText(R.id.content,data.getAbsence_desc());
        TextView stop_agree=holder.getView(R.id.stop_agree);
        TextView agree=holder.getView(R.id.agree);
        if(is_no_todo!=null){
            stop_agree.setOnClickListener(listener);
            stop_agree.setTag(position);
            agree.setOnClickListener(listener);
            agree.setTag(position);
        }
        //is_pass ： -1 驳回 0 审批中 1 同意
        if(data.getIs_pass().equals("-1")){
            agree.setTextColor(mContext.getResources().getColor(R.color.black));
            stop_agree.setBackgroundResource(R.drawable.shape_green_radius);
            stop_agree.setTextColor(mContext.getResources().getColor(R.color.status_green));
            stop_agree.setText("已驳回");
            agree.setEnabled(true);
            stop_agree.setEnabled(false);
            String all="同意";
            agree.setBackgroundResource(R.drawable.shape_gray_radius);
            agree.setText(all);
        }else if(data.getIs_pass().equals("0")){
            String all="同意";
            agree.setTextColor(mContext.getResources().getColor(R.color.red_text));
            agree.setBackgroundResource(R.drawable.bg_stroke_red);
            agree.setText(all);
            stop_agree.setBackgroundResource(R.drawable.shape_gray_radius);
            stop_agree.setTextColor(mContext.getResources().getColor(R.color.black));
            stop_agree.setText("驳回");
            agree.setEnabled(true);
            stop_agree.setEnabled(true);
        }else if(data.getIs_pass().equals("1")){
            String all="已同意";
            agree.setTextColor(mContext.getResources().getColor(R.color.status_green));
            agree.setBackgroundResource(R.drawable.shape_green_radius);
            agree.setText(all);
            agree.setEnabled(false);
            stop_agree.setEnabled(true);
            stop_agree.setBackgroundResource(R.drawable.shape_gray_radius);
            stop_agree.setTextColor(mContext.getResources().getColor(R.color.black));
            stop_agree.setText("驳回");
        }

        holder.setText(R.id.title,data.getAbsence_status());
        holder.setText(R.id.create_time,data.getAbsence_ask_time());
        holder.getConvertView().setOnClickListener(v -> {
            Intent intent=new Intent(mContext, ApprovalDetailsActivity.class);
            if(is_no_todo!=null){
                intent.putExtra(IntentParams.KEY_APPROVAL_PARAM_LIST_OR_NOTICE,"1");
            }
            intent.putExtra(IntentParams.KEY_APPROVAL_ID,data.getAbsence_id());
            mContext.startActivity(intent);
        });
        //status
    }


    /*private View.OnClickListener listener=new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            //is_pass ： -1 驳回 0 审批中 1 同意
            if (v.getId()==R.id.agree){
                int position= (int) v.getTag();
                AbsenceBean data=getDatas().get(position);
                String isPass="";
                if(data.getIs_pass().equals("-1")){
                    isPass="1";
                }else if(data.getIs_pass().equals("0")){
                    isPass="1";
                }else if(data.getIs_pass().equals("1")){
                    return;
                }
                if(!TextUtils.isEmpty(isPass)){
                    updateAbsence(position,isPass,data.getAbsence_id());
                }
            }else if(v.getId()==R.id.stop_agree){//驳回按钮
                int position= (int) v.getTag();
                AbsenceBean data=getDatas().get(position);
                String isPass="";
                if(data.getIs_pass().equals("-1")){//已经驳回了
                    return;
                }else if(data.getIs_pass().equals("0")){
                    isPass="-1";
                }else if(data.getIs_pass().equals("1")){//已经同意
                    //isPass="-1";
                    return;
                }
                if(!TextUtils.isEmpty(isPass)){
                    updateAbsence(position,isPass,data.getAbsence_id());
                }
            }
        }
    };


    private void updateAbsence(int position,String is_pass,String absence_id){
        activity.showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("is_pass",is_pass+"");//pageIndex*pageSize
        hashMap.put("absence_id",absence_id+"");
        //hashMap.put("member_id", member_id);
        Disposable disposable= AchievementHttpUtil.getInstance().updateAbsence(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String message) {
                getDatas().get(position).setIs_pass(is_pass);
                notifyItemChanged(position);
                activity.dismissProgressDialog();
                ToastUtils.show(message);
            }

            @Override
            public void onError(Throwable e) {
                activity.dismissProgressDialog();
                ToastUtils.show(e.getMessage());
            }

            @Override
            public void onComplete() {

            }
        },String.class);
    }*/

}
