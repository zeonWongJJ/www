package app.odp.qidu.adapter;

import android.app.Activity;
import android.content.Context;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.ImageView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.Plan;
import com.app.base.netUtil.PlanHttpUtil;
import com.app.base.utils.NumberFormatUtil;
import com.common.lib.base.AbsBaseActivity;
import com.common.lib.utils.ToastUtils;


import java.util.HashMap;

import app.odp.qidu.R;
import io.reactivex.observers.DisposableObserver;

//计划详情-计划列表
public class PlanDetailsPlanListAdapter extends CommonAdapter<Plan> {
    private AbsBaseActivity activity;
    public PlanDetailsPlanListAdapter(AbsBaseActivity activity) {
        super(activity, R.layout.layout_plan_detail_task_item);
        this.activity=activity;
    }

    @Override
    protected void convert(ViewHolder holder, Plan data, int position) {
        //formatInteger 参数为0报错
        String chineseNum= NumberFormatUtil.formatInteger(position+1);
        holder.setText(R.id.plan_order,"计划"+chineseNum+":");
        holder.setText(R.id.edit_plan_content,data.getPlan_name()+"");
        View task_list_layout=holder.getView(R.id.task_list_layout);
        ImageView show_task=holder.getView(R.id.show_task);

        RecyclerView task_list=holder.getView(R.id.task_list);
        TaskInPlanListAdapter adapter=new TaskInPlanListAdapter(activity,data.getPlan_sub_id()+"");
        task_list.setLayoutManager(new LinearLayoutManager(activity));
        task_list.setAdapter(adapter);
        task_list.setNestedScrollingEnabled(false);
        if(data.getTasks()!=null){
            if(data.getTasks().size()>0){
                show_task.setVisibility(View.VISIBLE);
                show_task.setOnClickListener(v -> {
                    if(task_list_layout.getVisibility()==View.VISIBLE){
                        show_task.setImageResource(R.drawable.icon_increase);
                        task_list_layout.setVisibility(View.GONE);
                    }else {
                        show_task.setImageResource(R.drawable.icon_reduce);
                        task_list_layout.setVisibility(View.VISIBLE);
                    }
                });
            }else {
                show_task.setVisibility(View.GONE);
            }
            adapter.refreshData(data.getTasks());
            adapter.notifyDataSetChanged();
        }else {
            show_task.setVisibility(View.GONE);
        }
    }

}
