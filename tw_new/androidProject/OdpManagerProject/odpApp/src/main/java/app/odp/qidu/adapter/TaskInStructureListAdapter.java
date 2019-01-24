package app.odp.qidu.adapter;

import android.content.Context;
import android.text.SpannableString;
import android.text.Spanned;
import android.text.style.ForegroundColorSpan;
import android.view.View;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.Task;
import com.app.base.bean.TypeSelect;
import com.app.base.netUtil.PlanHttpUtil;
import com.app.base.widget.PlanTypeSelectDialog;
import com.common.lib.base.AbsBaseActivity;
import com.common.lib.global.AppUtils;
import com.common.lib.utils.ToastUtils;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 计划详情页面里面的任务列表
 */

public class TaskInStructureListAdapter extends CommonAdapter<Task> {
    private Context context;
    public TaskInStructureListAdapter(Context context) {
        super(context, R.layout.layout_task_item_in_plan_details);
        this.context=context;
    }

    @Override
    protected void convert(ViewHolder holder, final Task data, int position) {
        TextView textView=holder.getView(R.id.task_title);
        String defaultStr="任务: ";
        String taskTitle=defaultStr+data.getTask_title();
        SpannableString spannableString = new SpannableString(taskTitle);
        ForegroundColorSpan colorSpan = new ForegroundColorSpan(mContext.getResources().getColor(R.color.blue));
        spannableString.setSpan(colorSpan, 0,defaultStr.length(), Spanned.SPAN_INCLUSIVE_EXCLUSIVE);
        textView.setText(spannableString);
        /*holder.getConvertView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                List<TypeSelect> listPlanType=new ArrayList<>();
                listPlanType.add(new TypeSelect("copy","复制"));
                listPlanType.add(new TypeSelect("delete","移除"));
                new PlanTypeSelectDialog.Builder(mContext).setOk("确认").setCancel("取消").setMsg(listPlanType).setClickListener(new PlanTypeSelectDialog.OnClickListener() {
                    @Override
                    public void onOkClick(TypeSelect typeSelect) {
                        if(typeSelect.getType().equals("copy")){
                            AppUtils.copy2clipboard(mContext,data.getTask_title());
                            ToastUtils.show("任务内容已复制到粘贴板");
                        }else if(typeSelect.getType().equals("delete")){
                            removeTaskFromPlan(data.getTask_id()+"",position);
                        }
                    }
                    @Override
                    public void onCancelClick() {

                    }
                    @Override
                    public void onDismiss() {}
                }).create();
            }
        });*/
    }

    //把任务从家计划中移除
    /*private void removeTaskFromPlan(String taskId,int position){
        activity.showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("task_id",taskId);
        hashMap.put("plan_sub_id",plan_sub_id+"");
        Disposable disposable= PlanHttpUtil.getInstance().removeTaskFromPlan(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String message) {
                activity.dismissProgressDialog();
                mDatas.remove(position);
                notifyItemRemoved(position);
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
