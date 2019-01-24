package app.odp.qidu.adapter;

import android.text.SpannableStringBuilder;
import android.text.Spanned;
import android.text.style.ForegroundColorSpan;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.AbsenceBean;
import com.common.lib.base.AbsBaseActivity;

import app.odp.qidu.R;

//请假记录
public class LeaveListAdapter extends CommonAdapter<AbsenceBean> {
    private AbsBaseActivity activity;
    private View.OnClickListener listener;
    public LeaveListAdapter(AbsBaseActivity activity,View.OnClickListener listener) {
        super(activity, R.layout.layout_leave_item);
        this.activity=activity;
        this.listener=listener;
    }

    @Override
    protected void convert(ViewHolder holder, AbsenceBean data, int position) {
        ImageView status_img=holder.getView(R.id.status_img);
        holder.setText(R.id.content,data.getAbsence_desc());
        TextView status=holder.getView(R.id.status);
        String absence_status=data.getAbsence_status();
        String status_name="";
        if(absence_status.equals("-1")){
            status_name="事假";
        }else if(absence_status.equals("-2")){
            status_name="病假";
        }else if(absence_status.equals("0")){
            status_name="调休";
        }else if(absence_status.equals("1")){
            status_name="婚假";
        }else if(absence_status.equals("2")){
            status_name="产假";
        }else if(absence_status.equals("3")){
            status_name="年休";
        }
        holder.setText(R.id.title,status_name);
        //is_pass ： -1 驳回 0 审批中 1 同意
        holder.setText(R.id.title,status_name);
        String str="状态:";
        if(data.getIs_pass().equals("-1")){
            String all=str+"驳回";
            SpannableStringBuilder builder=new SpannableStringBuilder(all);
            builder.setSpan(new ForegroundColorSpan(mContext.getResources().getColor(R.color.red)), str.length(), all.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
            status.setText(builder);
            status_img.setBackgroundResource(R.drawable.shape_right_radius_red);
            //status_img.setBackgroundColor(mContext.getResources().getColor(R.color.red));
        }else if(data.getIs_pass().equals("0")){
            String all=str+"审批中";
            SpannableStringBuilder builder=new SpannableStringBuilder(all);
            builder.setSpan(new ForegroundColorSpan(mContext.getResources().getColor(R.color.status_yellow)), str.length(), all.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
            status.setText(builder);
            status_img.setBackgroundResource(R.drawable.shape_right_radius_yellow);
            //status_img.setBackgroundColor(mContext.getResources().getColor(R.color.status_yellow));
        }else if(data.getIs_pass().equals("1")){
            String all=str+"已批准";
            SpannableStringBuilder builder=new SpannableStringBuilder(all);
            builder.setSpan(new ForegroundColorSpan(mContext.getResources().getColor(R.color.status_green)), str.length(), all.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
            status.setText(builder);
            status_img.setBackgroundResource(R.drawable.shape_right_radius_green);
            //status_img.setBackgroundColor(mContext.getResources().getColor(R.color.status_green));
        }
        holder.setText(R.id.create_time,data.getAbsence_ask_time());
        holder.setText(R.id.time,"请假时间:"+data.getAbsence_start_time()+"-"+data.getAbsence_end_time());
        //status

        TextView stop_absence=holder.getView(R.id.stop_absence);
        stop_absence.setTag(position);
        stop_absence.setOnClickListener(listener);
        TextView edit_absence=holder.getView(R.id.edit_absence);
        edit_absence.setTag(position);
        edit_absence.setOnClickListener(listener);
    }


}
