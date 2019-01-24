package app.odp.qidu.activity;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.TextView;

import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.MemberRealm;
import com.app.base.bean.Plan;
import com.app.base.bean.ProgressBean;
import com.app.base.bean.Project;
import com.app.base.bean.Task;
import com.app.base.bean.UserRealm;
import com.app.base.flow.FlowTagLayout;
import com.app.base.netUtil.TaskHttpUtil;
import com.app.base.utils.CommonKey;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.app.base.widget.RightAlertDialog;
import com.common.lib.utils.TimeUtil;
import com.common.lib.utils.ToastUtils;
import com.luck.picture.lib.entity.LocalMedia;
import com.luck.picture.lib.rxbus2.RxBus;
import com.common.lib.basemvp.presenter.BasePresenter;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.adapter.ClientProcessListAdapter;
import app.odp.qidu.adapter.TagAdapter;
import choose.lm.com.fileselector.model.FileInfo;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 任务详情
 */

public class TaskDetailsActivity extends BaseShowImgAndFileActivity<BasePresenter>{
    private ClientProcessListAdapter clientProcessListAdapter;
    private RecyclerView clientListView;
    private TextView task_record,task_name,project_name,complete_date,task_details,plan_name,project_node;
    private int reqCode=0x111;
    private TextView add_to_plan;
    private View edit_task;
    private String planIds;
    private String taskId;
    private TagAdapter mColorTagAdapter;
    private View edit_publish_layout,stop_task,project_node_layout;
    private MemberRealm loginUser;
    private Task taskDetail;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        /*布局是RelativeLayout，底部菜单用了android:layout_alignParentBottom="true",*/
        getWindow().setSoftInputMode
                (WindowManager.LayoutParams.SOFT_INPUT_STATE_ALWAYS_HIDDEN|
                        WindowManager.LayoutParams.SOFT_INPUT_ADJUST_PAN);
        taskId=getIntent().getStringExtra(IntentParams.KEY_TASK_ID);
        Log.i("aaaaaaa","任务详情task_id------"+taskId);
        loginUser= LoginUtil.getInstance().getLoginUser();
        TextView titleCenter=findView(R.id.title_center_text);
        titleCenter.setText("任务详情");
        ImageView left=findView(R.id.title_left_image);
        left.setOnClickListener(v -> {
            finish();
        });
        TextView show_img_title=findView(R.id.show_img_title);
        show_img_title.setText("任务图片");
        TextView show_file_title=findView(R.id.show_file_title);
        show_file_title.setText("任务文件");
        stop_task=findView(R.id.stop_task);
        project_node_layout=findView(R.id.project_node_layout);
        project_node=findView(R.id.project_node);
        edit_publish_layout=findView(R.id.edit_publish_layout);
        task_name=findView(R.id.task_name);
        plan_name=findView(R.id.plan_name);
        project_name=findView(R.id.project_name);
        edit_task=findView(R.id.edit_task);
        complete_date=findView(R.id.complete_date);
        task_details=findView(R.id.task_details);
        add_to_plan=findView(R.id.add_to_plan);
        add_to_plan.setOnClickListener(v -> {
            Intent intent=new Intent(this,ProjectListActivity.class);
            intent.putExtra(IntentParams.KEY_PROJECT_PLAN_LIST,ProjectListActivity.PLAN_LIST);
            intent.putExtra(IntentParams.KEY_PLAN_ID_SELECT,planIds);
            startActivityForResult(intent,reqCode);
        });
        stop_task.setOnClickListener(v -> {
            new RightAlertDialog.Builder(getActivity()).setTitle("通知提醒").setMsg("一旦终结此任务,此任务下的流程全部终止").setOk("确定").setCancel("取消").setClickListener(new RightAlertDialog.OnClickListener() {
                @Override
                public void onOkClick() {
                    if(taskDetail!=null){
                        if(taskDetail.getTask_member_id().equals(loginUser.getMember_id())){
                            deleteTask(taskDetail.getTask_id());
                        }
                    }
                }
                @Override
                public void onCancelClick() {

                }
                @Override
                public void onDismiss() {

                }
            }).create();
        });
        clientListView=findView(R.id.process_list_view);
        clientListView.setNestedScrollingEnabled(false);
        clientListView.setLayoutManager(new LinearLayoutManager(this));
        clientProcessListAdapter = new ClientProcessListAdapter(this,taskId);
        clientListView.setAdapter(clientProcessListAdapter);
        task_record=findView(R.id.task_record);
        task_record.setOnClickListener(v -> {
            if(taskId==null){
                return;
            }
            Intent intent=new Intent(getActivity(),TaskRecordListActivity.class);
            intent.putExtra(IntentParams.KEY_TASK_OR_PLAN_RECORD,TaskRecordListActivity.TASK_RECORD);
            //taskId="2";
            intent.putExtra(IntentParams.KEY_TASK_ID,taskId);
            intent.putExtra(IntentParams.KEY_DEPARTMENT,LoginUtil.getInstance().getLoginUser().getDepartment_name());
            startActivity(intent);
        });
        /*参与人*/

        FlowTagLayout mColorFlowTagLayout=findView(R.id.color_flow_layout);
        mColorTagAdapter = new TagAdapter(this,FlowTagLayout.FLOW_TAG_CHECKED_NONE);
        mColorFlowTagLayout.setAdapter(mColorTagAdapter);

        initPictureAndFile();


        edit_task.setOnClickListener(v -> {
            Intent intent=new Intent(getActivity(), PublishTaskActivity.class);
            intent.putExtra(IntentParams.KEY_TASK_ID,taskId);
            intent.putExtra(IntentParams.KEY_HANDLE_TASK_TYPE,PublishTaskActivity.EDIT_TASK);
            startActivity(intent);
        });
    }
    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        return inflater.inflate(R.layout.activity_task_details,null);
    }

    private void initTaskDetail(Task task){
        if(task==null){
            return;
        }
        taskDetail=task;
        if(task.getTask_member_id().equals(loginUser.getMember_id())){
            edit_publish_layout.setVisibility(View.VISIBLE);

        }
        String task_structure_id=task.getTask_structure_id();
        if(!TextUtils.isEmpty(task_structure_id)){//如果不为空，判断为根据节点发布的任务，不给编辑
            project_node_layout.setVisibility(View.VISIBLE);
            project_node.setText(task.getNav());
        }
        task_name.setText(task.getTask_title()+"");
        //project_name.setText(task.getTask_project_names()+"");
        List<Project> projectList=task.getTask_project_ids_data();
        if(projectList!=null&&projectList.size()>0){
            for(int i=0;i<projectList.size();i++) {
                Project project = projectList.get(i);
                if (i==0) {
                    project_name.append(project.getProject_name());
                } else{
                    project_name.append(","+project.getProject_name());
                }
            }
        }

        List<Plan> planList=task.getTask_plan_ids_data();
        if(planList!=null&&planList.size()>0){
            for(int i=0;i<planList.size();i++) {
                Plan plan = planList.get(i);
                if (i==0) {
                    planIds=plan.getPlan_id()+"";
                    plan_name.append(plan.getPlan_name()+"");
                } else{
                    planIds=planIds+","+plan.getPlan_id();
                    plan_name.append(","+plan.getPlan_name());
                }
            }
        }
        complete_date.setText(TimeUtil.getFormatTime(Long.parseLong(task.getTask_time_limit())*1000)+"");
        task_details.setText(task.getTask_desc()+"");
        task_record.setText("查看记录"+task.getTask_record_total());
        List<UserRealm> tagsData = task.getTask_belonged_data();
        if(tagsData!=null&&!tagsData.isEmpty()){
            mColorTagAdapter.onlyAddAll(tagsData);
        }
        //各部门
        List<ProgressBean> clientList=task.getTask_procedures();
        if(clientList!=null){
            clientProcessListAdapter.refreshData(clientList);
            clientProcessListAdapter.notifyDataSetChanged();
        }

        List<String> task_pic_urls=task.getTask_pic_urls();
        if(task_pic_urls!=null){
            List<LocalMedia> imgList=new ArrayList<>();
            for(int i=0;i<task_pic_urls.size();i++){
                LocalMedia localMedia=new LocalMedia();
                localMedia.setImageUrl(task_pic_urls.get(i));
                localMedia.setPath(HttpUrl.HOST+task_pic_urls.get(i));
                imgList.add(localMedia);
            }
            imgAdapter.refreshData(imgList);
            imgAdapter.notifyDataSetChanged();
        }

        List<String> task_file_urls=task.getTask_file_urls();

        if (task_file_urls != null) {
            List<FileInfo> listFiles=new ArrayList<>();
            for (int i=0;i<task_file_urls.size();i++){
                FileInfo fileInfo=new FileInfo();
                fileInfo.setFileUrl(task_file_urls.get(i));
                listFiles.add(fileInfo);
            }
            fileAdapter.refreshData(listFiles);
            fileAdapter.notifyDataSetChanged();
        }
    }
    @Override
    protected BasePresenter initPresenter() {
        return new BasePresenter() {
            @Override
            public void onCreate() {

            }
            @Override
            public void loadData() {
                showProgressDialog();
                initData();
            }
        };
    }
    private void initData(){
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("task_id",taskId);
        Disposable disposable=TaskHttpUtil.getInstance().taskDetails(hashMap, new DisposableObserver<Task>() {
            @Override
            public void onNext(Task task) {
                dismissProgressDialog();
                initTaskDetail(task);
            }
            @Override
            public void onError(Throwable e) {
                ToastUtils.show(e.getMessage());
                dismissProgressDialog();
            }
            @Override
            public void onComplete() {

            }
        },Task.class);
        mPresenter.getCompositeSubscription().add(disposable);
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if(reqCode==requestCode&&resultCode== Activity.RESULT_OK){
            if(data==null){
                return;
            }
            String planIds=data.getStringExtra(IntentParams.KEY_PLAN_ID_SELECT);
            String planNames=data.getStringExtra(IntentParams.KEY_PLAN_NAMES_SELECT);
            addToMyPlan(planIds,planNames);
        }
    }


    //添加到我的计划
    private void addToMyPlan(String planIds,String planNames){
        showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("task_id",taskId);
        hashMap.put("plan_sub_id",planIds);
        TaskHttpUtil.getInstance().addToMyPlan(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String s) {
                dismissProgressDialog();
                plan_name.setText(planNames);
                ToastUtils.show(s);
            }

            @Override
            public void onError(Throwable e) {
                dismissProgressDialog();
                ToastUtils.show(e.getMessage());
            }

            @Override
            public void onComplete() {

            }
        },String.class);
    }


    private void deleteTask(String task_id){

        showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("task_id",task_id);
        TaskHttpUtil.getInstance().deleteTask(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String s) {
                CommonEventEntity eventEntity = new CommonEventEntity(CommonKey.KEY_DELETE_TASK_SUCCESS, task_id);
                RxBus.getDefault().post(eventEntity);
                dismissProgressDialog();
                ToastUtils.show("删除任务成功");
                finish();
            }

            @Override
            public void onError(Throwable e) {
                dismissProgressDialog();
                ToastUtils.show(e.getMessage());
            }

            @Override
            public void onComplete() {

            }
        },String.class);
    }
}
