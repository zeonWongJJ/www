package app.odp.qidu.adapter;

import android.content.Context;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.Evaluate;

import app.odp.qidu.R;

//考勤记录
public class SignInListAdapter extends CommonAdapter<Evaluate> {
    public SignInListAdapter(Context context) {
        super(context, R.layout.layout_sign_in_item);
    }

    @Override
    protected void convert(ViewHolder holder, Evaluate data, int position) {
        holder.setText(R.id.date,data.getWork_date());
        TextView status=holder.getView(R.id.status);
        if(data.getWork_status().equals("正常")){
            status.setTextColor(mContext.getResources().getColor(R.color.status_green));
        }else if(data.getWork_status().equals("正常")){
            status.setTextColor(mContext.getResources().getColor(R.color.status_yellow));
        }else if(data.getWork_status().equals("缺卡")){
            status.setTextColor(mContext.getResources().getColor(R.color.status_yellow));
        }else if(data.getWork_status().equals("迟到")){
            status.setTextColor(mContext.getResources().getColor(R.color.status_yellow));
        }else if(data.getWork_status().equals("早退")){
            status.setTextColor(mContext.getResources().getColor(R.color.status_yellow));
        }else if(data.getWork_status().equals("休息")){
            status.setTextColor(mContext.getResources().getColor(R.color.black));
        }else if(data.getWork_status().equals("请假")){
            status.setTextColor(mContext.getResources().getColor(R.color.blue));
        }else if(data.getWork_status().equals("矿工")){
            status.setTextColor(mContext.getResources().getColor(R.color.red));
        }
        status.setText(data.getWork_status());
        holder.setText(R.id.start_time,data.getWork_time());

        holder.setText(R.id.end_time,data.getUnwork_time());
    }


}
