package app.odp.qidu.widget;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.graphics.drawable.ColorDrawable;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.PopupWindow;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.app.base.bean.Task;
import com.app.base.utils.IntentParams;

import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.activity.TaskDetailsActivity;
import app.odp.qidu.adapter.TaskInStructureListAdapter;

/**
 * 显示节点的任务
 */

public class NodeTaskListPopup extends PopupWindow {
    private View conentView;
    private Activity context;
    private TaskInStructureListAdapter adapter;
    public NodeTaskListPopup(Activity context) {
        super(context);
        this.context=context;
        initView();
    }

    private void initView(){
        LayoutInflater inflater = (LayoutInflater) context
                .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        this.conentView = inflater.inflate(R.layout.layout_node_task_list_dialog, null);
        // 设置SelectPicPopupWindow的View
        this.setContentView(conentView);
        // 设置SelectPicPopupWindow弹出窗体的宽
        //this.setWidth(ViewGroup.LayoutParams.WRAP_CONTENT);
        this.setWidth(RecyclerView.LayoutParams.MATCH_PARENT);
        // 设置SelectPicPopupWindow弹出窗体的高
        this.setHeight(RecyclerView.LayoutParams.WRAP_CONTENT);
        // 设置SelectPicPopupWindow弹出窗体可点击
        this.setFocusable(true);
        this.setOutsideTouchable(true);
        // 刷新状态
        this.update();
        // 实例化一个ColorDrawable颜色为半透明
        ColorDrawable dw = new ColorDrawable(0x00000000);
        // 点back键和其他地方使其消失,设置了这个才能触发OnDismisslistener ，设置其他控件变化等操作
        this.setBackgroundDrawable(dw);

        //this.setBackgroundDrawable(null);
        // 设置SelectPicPopupWindow弹出窗体动画效果
        //this.setAnimationStyle(R.style.operation_popwindow_anim_style_up);
        RecyclerView task_list=this.conentView.findViewById(R.id.task_list);
        adapter=new TaskInStructureListAdapter(context);
        task_list.setLayoutManager(new LinearLayoutManager(context));
        task_list.setAdapter(adapter);
        adapter.setOnItemClickListener(new MultiItemTypeAdapter.OnItemClickListener() {
            @Override
            public void onItemClick(View view, RecyclerView.ViewHolder holder, Object o, int position) {
                Task task=adapter.getDatas().get(position);
                Intent intent=new Intent(context, TaskDetailsActivity.class);
                intent.putExtra(IntentParams.KEY_TASK_ID,task.getTask_id()+"");
                context.startActivity(intent);
            }
            @Override
            public boolean onItemLongClick(View view, RecyclerView.ViewHolder holder, Object o, int position) {
                return false;
            }
        });
    }
    //设置数据
    public void setDataSource(List<Task> taskList) {
        this.adapter.refreshData(taskList);
        this.adapter.notifyDataSetChanged();
    }


    public List<Task> getDataList(){
        return this.adapter.getDatas();
    }
    public void show(View v){
        this.showAsDropDown(v,0,0);
    }
}
