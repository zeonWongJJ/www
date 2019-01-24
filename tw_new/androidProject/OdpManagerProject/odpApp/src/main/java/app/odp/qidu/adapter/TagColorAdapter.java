package app.odp.qidu.adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.app.base.bean.ProgressBean;
import com.app.base.bean.UserRealm;
import com.app.base.flow.FlowTagLayout;
import com.app.base.flow.OnInitSelectedPosition;

import java.util.ArrayList;
import java.util.List;

import app.odp.qidu.R;

/**
 * 任务里面里面-显示每个部门的完成状态-用不同的颜色区别
 */
public class TagColorAdapter extends BaseAdapter implements OnInitSelectedPosition {
    private final Context mContext;
    private final List<ProgressBean> mDataList;
    private int tagModel;
    public static int COLOR_MODEL=3;//此参数代表给标签设置不同颜色
    public TagColorAdapter(Context context, int tagModel) {
        this.mContext = context;
        mDataList = new ArrayList<>();
        this.tagModel=tagModel;

    }

    @Override
    public int getCount() {
        return mDataList.size();
    }

    @Override
    public Object getItem(int position) {
        return mDataList.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        View view = LayoutInflater.from(mContext).inflate(R.layout.item_assemble_essay, null);
        TextView textView = (TextView) view.findViewById(R.id.tv_tag);
        ProgressBean data = mDataList.get(position);
        //status :  -1 放弃流程 ,0 未接手, 1 已接手, 2.已完成
        //蓝色完成   黄色进行    红色未接手    灰色取消流程

        if(data.getStatus()==-1){//
            textView.setTextColor(mContext.getResources().getColor(R.color.gray));
        }else if(data.getStatus()==0){
            textView.setTextColor(mContext.getResources().getColor(R.color.red));
        }else if(data.getStatus()==1){
            textView.setTextColor(mContext.getResources().getColor(R.color.yellow));
        }else if(data.getStatus()==2){
            textView.setTextColor(mContext.getResources().getColor(R.color.blue));
        }
        if(data.getDepartment_name()!=null){
            textView.setText(data.getDepartment_name());
        }else {
            textView.setText(data.getTask_catcher());
        }
        return view;
    }


    public List<ProgressBean> getDataList(){
        return mDataList;
    }

    public void onlyAddAll(List<ProgressBean> datas) {
        mDataList.addAll(datas);
        notifyDataSetChanged();
    }

    public void clearAndAddAll(List<ProgressBean> datas) {
        mDataList.clear();
        onlyAddAll(datas);
    }

    @Override
    public boolean isSelectedPosition(int position) {
        if (position % 2 == 0) {
            return true;
        }
        return false;
    }
}
