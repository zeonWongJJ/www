package app.odp.qidu.adapter;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.support.design.widget.Snackbar;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.Plan;
import com.app.base.bean.ProgressBean;
import com.app.base.bean.Task;
import com.app.base.bean.TopMenuItem;
import com.app.base.bean.UserRealm;
import com.app.base.flow.FlowTagLayout;
import com.app.base.flow.OnTagClickListener;
import com.app.base.netUtil.TaskHttpUtil;
import com.app.base.utils.CommonKey;
import com.app.base.utils.IntentParams;
import com.app.base.widget.RightAlertDialog;
import com.common.lib.base.AbsBaseActivity;
import com.common.lib.base.AbsBaseFragment;
import com.common.lib.utils.TimeUtil;
import com.common.lib.utils.ToastUtils;
import com.luck.picture.lib.rxbus2.RxBus;
import com.luck.picture.lib.tools.DateUtils;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.activity.PublishTaskActivity;
import app.odp.qidu.activity.TaskDetailsActivity;
import io.reactivex.observers.DisposableObserver;


public class TaskAdapter extends CommonAdapter<Task> {
    private String action="";
    private AbsBaseFragment fragment;
    public TaskAdapter(AbsBaseFragment fragment, String action) {
        super(fragment.getActivity(), R.layout.layout_item_task);
        this.action=action;
        this.fragment=fragment;
    }


    @Override
    protected void convert(ViewHolder holder, final Task task, int position) {
        holder.setText(R.id.task_name,task.getTask_title());
        holder.setText(R.id.complete_date,task.getTask_date_limit());
        holder.setText(R.id.project_name,task.getTask_project_names());
        //发布的任务类型的时候显示
        View edit_publish_layout=holder.getView(R.id.edit_publish_layout);
        //计划任务类型的时候显示
        View plan_task_layout=holder.getView(R.id.plan_task_layout);
        if(action.equals(TopMenuItem.MY_PUBLISH_TASK)){
            edit_publish_layout.setVisibility(View.VISIBLE);
            View stop_task=holder.getView(R.id.stop_task);
            View edit_task=holder.getView(R.id.edit_task);
            stop_task.setOnClickListener(v -> {
                new RightAlertDialog.Builder(mContext).setTitle("通知提醒").setMsg("一旦终结此任务,此任务下的流程全部终止").setCancel("取消").setOk("确定").setClickListener(new RightAlertDialog.OnClickListener() {
                    @Override
                    public void onOkClick() {
                        deleteTask(task.getTask_id(),position);
                    }
                    @Override
                    public void onCancelClick() {

                    }
                    @Override
                    public void onDismiss() {

                    }
                }).create();
            });
            edit_task.setOnClickListener(v -> {
                Intent intent=new Intent(fragment.getActivity(), PublishTaskActivity.class);
                intent.putExtra(IntentParams.KEY_TASK_ID,task.getTask_id());
                intent.putExtra(IntentParams.KEY_HANDLE_TASK_TYPE,PublishTaskActivity.EDIT_TASK);
                fragment.getActivity().startActivity(intent);
            });
        }/*else if(action.equals(TopMenuItem.PLAN_TASK)||action.equals(TopMenuItem.MY_PUBLISH_TASK)||){

        }*/
        plan_task_layout.setVisibility(View.VISIBLE);
        List<Plan> planList=task.getTask_plan_ids_data();
        String plan_name="";
        if(planList!=null&&planList.size()>0){
            for(int i=0;i<planList.size();i++) {
                Plan plan = planList.get(i);
                if (i==0) {
                    plan_name=plan.getPlan_name()+"";
                } else{
                    plan_name=plan_name+","+plan.getPlan_name();
                }
            }
        }
        holder.setText(R.id.task_belong_to,plan_name);
        List<ProgressBean> tagsData=task.getTask_procedures();
        if(tagsData!=null){
            FlowTagLayout mColorFlowTagLayout=holder.getView(R.id.color_flow_layout);
            TagColorAdapter mColorTagAdapter = new TagColorAdapter(mContext,TagAdapter.COLOR_MODEL);
            mColorFlowTagLayout.setAdapter(mColorTagAdapter);
            mColorTagAdapter.onlyAddAll(tagsData);
        }
        holder.getConvertView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(mContext, TaskDetailsActivity.class);
                intent.putExtra(IntentParams.KEY_TASK_ID,task.getTask_id()+"");
                mContext.startActivity(intent);
            }
        });
    }
    public void removeTaskById(String id){
        for(int i=0;i<mDatas.size();i++){
            if(id.equals(mDatas.get(i).getTask_id())){
                mDatas.remove(i);
            }
        }
    }

    private void deleteTask(String task_id,int position){

        fragment.showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("task_id",task_id);
        TaskHttpUtil.getInstance().deleteTask(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String s) {
                fragment.dismissProgressDialog();
                ToastUtils.show("删除任务成功");
                /*mDatas.remove(position);
                notifyItemRemoved(position);*/
                CommonEventEntity eventEntity = new CommonEventEntity(CommonKey.KEY_DELETE_TASK_SUCCESS, task_id);
                RxBus.getDefault().post(eventEntity);
            }

            @Override
            public void onError(Throwable e) {
                fragment.dismissProgressDialog();
                ToastUtils.show(e.getMessage());
            }

            @Override
            public void onComplete() {

            }
        },String.class);
    }

}
