package app.odp.qidu.adapter;

import android.content.Context;
import android.view.View;
import android.widget.ImageView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.Project;

import java.util.ArrayList;
import java.util.List;

import app.odp.qidu.R;

/**
 * 项目列表
 */

public class ProjectListAdapter extends CommonAdapter<Project> {
    private int selectPosition=-1;
    private boolean isSingle=true;
    public ProjectListAdapter(Context context,boolean isSingle) {
        super(context, R.layout.layout_project_list_item);
        this.isSingle=isSingle;
    }

    @Override
    protected void convert(ViewHolder holder, final Project data, int position) {
        ImageView img_checked=holder.getView(R.id.img_checked);
        if(isSingle){
            if(selectPosition!=-1&&selectPosition==position){
                img_checked.setImageResource(R.drawable.icon_circle_checked);
            }else {
                img_checked.setImageResource(R.drawable.icon_circle_unchecked);
            }
        }else {
            if(data.isSelect()){
                img_checked.setImageResource(R.drawable.icon_circle_checked);
            }else{
                img_checked.setImageResource(R.drawable.icon_circle_unchecked);
            }
        }
        holder.setText(R.id.project_name, data.getProject_name());
        holder.getConvertView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(isSingle){
                    setSelectPosition(position);
                }else {
                    if(data.isSelect()){
                        mDatas.get(position).setSelect(false);
                    }else {
                        mDatas.get(position).setSelect(true);
                    }
                    if(dataChangeListener!=null){
                        dataChangeListener.onNotifyDataChange();
                    }
                }
            }
        });
    }
    public interface OnNotifyDataChangeListener{
        void onNotifyDataChange();
    }
    private OnNotifyDataChangeListener dataChangeListener;
    public void setSelectCallbackListener(OnNotifyDataChangeListener dataChangeListener){
        this.dataChangeListener=dataChangeListener;
    }

    public List<Project> getSelectList(){
        List<Project> list=new ArrayList<>();
        for(int i=0;i<mDatas.size();i++){
            if(mDatas.get(i).isSelect()){
                list.add(mDatas.get(i));
            }
        }
        return list;
    }
    public void setSelectPosition(int position){
        this.selectPosition=position;
        this.notifyDataSetChanged();
    }
}
