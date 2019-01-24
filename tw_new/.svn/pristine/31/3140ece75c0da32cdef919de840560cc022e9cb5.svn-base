package app.odp.qidu.adapter;

import android.content.Context;
import android.widget.ImageView;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.Evaluate;

import app.odp.qidu.R;

//绩效导航页--出勤评定
public class AttendanceGridAdapter extends CommonAdapter<Evaluate> {
    public AttendanceGridAdapter(Context context) {
        super(context, R.layout.layout_attendance_item);
    }

    @Override
    protected void convert(ViewHolder holder, Evaluate data, int position) {
        TextView title=holder.getView(R.id.title);
        TextView day=holder.getView(R.id.day);
        ImageView status=holder.getView(R.id.status);
        title.setText(data.getTitle());
        day.setText(data.getDate());
        if(data.getType().equals("attendance")){
            status.setBackgroundColor(mContext.getResources().getColor(R.color.blue));
        }else {
            status.setBackgroundColor(mContext.getResources().getColor(R.color.yellow));
        }
    }


}
