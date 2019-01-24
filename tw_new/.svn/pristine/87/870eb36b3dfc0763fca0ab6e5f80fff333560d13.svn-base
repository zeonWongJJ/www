package app.odp.qidu.adapter;

import android.content.Context;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.view.View;
import android.widget.AbsListView;
import android.widget.EditText;
import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.Plan;
import com.app.base.netUtil.PlanHttpUtil;
import com.app.base.utils.NumberFormatUtil;
import com.app.base.widget.RightAlertDialog;
import com.common.lib.base.AbsBaseActivity;
import com.common.lib.utils.ToastUtils;

import org.json.JSONArray;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import io.reactivex.observers.DisposableObserver;


public class EditPlanListAdapter extends CommonAdapter<Plan> {
    private AbsBaseActivity activity;
    public EditPlanListAdapter(AbsBaseActivity activity) {
        super(activity, R.layout.layout_publish_plan_item);
        this.activity=activity;
    }

    @Override
    protected void convert(ViewHolder holder, Plan data, int position) {
        String chineseNum= NumberFormatUtil.formatInteger(position+1);
        holder.setText(R.id.plan_order,"计划"+chineseNum+":");
        EditText editText=holder.getView(R.id.edit_plan_content);

        if(((TextWatcher)editText.getTag()) instanceof TextWatcher){
            editText.removeTextChangedListener((TextWatcher)editText.getTag());
        }
        editText.setText(data.getPlanName());
        TextWatcher textWatcher=new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {}
            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {}
            @Override
            public void afterTextChanged(Editable s) {
                mDatas.get(position).setPlan_name(s.toString());
            }
        };
        editText.addTextChangedListener(textWatcher);
        editText.setTag(textWatcher);
        if(data.getPlan_name()!=null){
            editText.setText(data.getPlan_name()+"");
        }
        View delete_plan=holder.getView(R.id.delete_plan);
        delete_plan.setOnClickListener(v -> {
            if(mDatas.size()>0){
                if(!TextUtils.isEmpty(data.getPlan_sub_id())){
                    new RightAlertDialog.Builder(activity).setCancel("取消").setOk("确定").setTitle("提醒").setMsg("确定删除此条计划？").setClickListener(new RightAlertDialog.OnClickListener() {
                        @Override
                        public void onOkClick() {
                            deleteChildrenPlan(position);
                        }
                        @Override
                        public void onCancelClick() {

                        }
                        @Override
                        public void onDismiss() {

                        }
                    }).create();
                }else {
                    mDatas.remove(position);
                    //notifyItemRemoved(position);
                    notifyDataSetChanged();
                }

            }
        });
    }


    public String getPlanList(){
        JSONArray array=new JSONArray();
        String planNames="";
        List<Plan> planList=new ArrayList<>();
        for(int i=0;i<mDatas.size();i++){
            if(!TextUtils.isEmpty(mDatas.get(i).getPlan_name())){
                planList.add(mDatas.get(i));
            }
        }
        for(int i=0;i<planList.size();i++){
            /*if(i==0){
                planNames=planList.get(i).getPlan_name();
            }else {
                planNames=planNames+","+planList.get(i).getPlan_name();
            }*/
            array.put(planList.get(i).getPlan_name());
        }
        planNames=array.toString();
        return planNames;
    }



    //删除子计划
    private void deleteChildrenPlan(int position){
        activity.showProgressDialog();
        Plan data=mDatas.get(position);
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("plan_sub_id",data.getPlan_sub_id());
        PlanHttpUtil.getInstance().deleteChildrenPlan(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String s) {
                activity.dismissProgressDialog();
                mDatas.remove(position);
                notifyItemRemoved(position);
                ToastUtils.show("删除子计划成功");
            }

            @Override
            public void onError(Throwable e) {
                activity.dismissProgressDialog();
                ToastUtils.show("删除子计划失败");
            }
            @Override
            public void onComplete() {

            }
        },String.class);
    }
}
