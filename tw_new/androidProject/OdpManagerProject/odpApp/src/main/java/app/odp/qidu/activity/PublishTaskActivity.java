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
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.Participant;
import com.app.base.bean.Plan;
import com.app.base.bean.Project;
import com.app.base.bean.Task;
import com.app.base.bean.UserRealm;
import com.app.base.mvp.contract.TaskContract;
import com.app.base.mvp.presenter.TaskPresenterImpl;
import com.app.base.utils.CheckTextUtil;
import com.app.base.utils.CommonKey;
import com.app.base.utils.DataUtils;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.common.lib.utils.TimeUtil;
import com.common.lib.utils.ToastUtils;
import com.luck.picture.lib.entity.LocalMedia;
import com.luck.picture.lib.rxbus2.RxBus;
import com.common.lib.basemvp.presenter.BasePresenter;


import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.adapter.ParticipantListAdapter;
import choose.lm.com.fileselector.model.FileGroupInfo;
import choose.lm.com.fileselector.model.FileInfo;

/**
 * 发布任务
 */

public class PublishTaskActivity extends BasePhotoFileActivity<TaskPresenterImpl> implements TaskContract.View{
    private int requestCodeDatePicker=0x234;//年月选择
    private int reqCode=0x111;
    private int reqPlanCode=0x222;
    private TextView project_name,plan_name,complete_date,project_node;
    private EditText task_details,task_name;
    private RecyclerView participant_recycler;
    private ParticipantListAdapter participantListAdapter;
    private TextView publish;
    private String projectIds="";
    private String planIds="";
    private String task_structure_id;
    public static int EDIT_TASK=1;//编辑任务
    public static int PUBLISH_DEFAULT=0;//默认进来发布任务的
    public static int PUBLISH_BY_PROJECT_CHILD=2;//从项目结构单元进来发布任务
    private int handleTaskType;
    private String task_id;
    private View project_node_layout,project_arrow_tip;
    private String userId;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        handleTaskType=getIntent().getIntExtra(IntentParams.KEY_HANDLE_TASK_TYPE,0);
        userId=LoginUtil.getInstance().getLoginUser().getMember_id();
        TextView titleCenter=findView(R.id.title_center_text);
        ImageView left=findView(R.id.title_left_image);
        left.setOnClickListener(v -> {
            finish();
        });
        project_node_layout=findView(R.id.project_node_layout);
        task_name=findView(R.id.task_name);
        publish=findView(R.id.publish);
        complete_date=findView(R.id.complete_date);
        complete_date.setOnClickListener(v -> {
            Intent intent=new Intent(getActivity(), TimePickerActivity.class);
            intent.putExtra(IntentParams.KEY_DATE_PICKER_DEPARTMENT_PICKER,TimePickerActivity.ONLY_SHOW_DATE_CHOOSE);
            intent.putExtra(IntentParams.KEY_DATE_PICKER_IS_HIDE_DAY,false);
            startActivityForResult(intent,requestCodeDatePicker);
        });
        project_node=findView(R.id.project_node);
        task_details=findView(R.id.task_details);
        project_arrow_tip=findView(R.id.project_arrow_tip);
        plan_name=findView(R.id.plan_name);
        plan_name.setOnClickListener(v -> {
            Intent intent=new Intent(this,ProjectListActivity.class);
            intent.putExtra(IntentParams.KEY_PROJECT_PLAN_LIST,ProjectListActivity.PLAN_LIST);
            intent.putExtra(IntentParams.KEY_PLAN_ID_SELECT,planIds);
            startActivityForResult(intent,reqPlanCode);
        });
        project_name=findView(R.id.project_name);

        participant_recycler=findView(R.id.participant_recycler);
        participant_recycler.setLayoutManager(new LinearLayoutManager(getActivity()));
        participant_recycler.setNestedScrollingEnabled(false);
        participantListAdapter=new ParticipantListAdapter(getActivity());
        participant_recycler.setAdapter(participantListAdapter);



        initSelectPhoto();
        initSelectFile();
        publish.setOnClickListener(v -> {
            if(checkParams()){
                HashMap<String,String> hashMap=new HashMap<>();
                hashMap.put("task_title",task_name.getText().toString());//标题 必须
                hashMap.put("task_desc",task_details.getText().toString());//描述 必须
                hashMap.put("member_id",userId);
                if(!TextUtils.isEmpty(projectIds)){
                    hashMap.put("task_project_ids",projectIds);//项目id
                }
                if(!TextUtils.isEmpty(planIds)){
                    hashMap.put("task_plan_ids",planIds);//计划id
                }
                if(!TextUtils.isEmpty(task_structure_id)){
                    hashMap.put("task_structure_id",task_structure_id);
                }
                List<UserRealm> selectUser=participantListAdapter.getSelectUser();
                if(selectUser.size()>0){
                    String userIds="";
                    for(int i=0;i<selectUser.size();i++){
                        if(i==0){
                            userIds=selectUser.get(i).getMember_id()+"";
                        }else {
                            userIds = userIds + "," + selectUser.get(i).getMember_id();
                        }
                    }
                    if(!TextUtils.isEmpty(userIds)){
                        hashMap.put("task_belonged", userIds);//任务所属人
                    }
                }
                hashMap.put("task_time_limit",complete_date.getText().toString());//任务时限 必须
                String imgUrls=imgAdapter.getUploadUrls();
                if(!TextUtils.isEmpty(imgUrls)){
                    hashMap.put("task_pic",imgUrls);//图片
                }
                String fileUrls=fileAdapter.getUploadUrls();
                if(!TextUtils.isEmpty(fileUrls)){
                    hashMap.put("task_file",fileUrls);//文件
                }
                Log.i("aaaaaaaa","hashMap"+hashMap.toString());
                if(handleTaskType==EDIT_TASK){
                    hashMap.put("task_id",task_id);
                    mPresenter.publishTask(true,hashMap);
                }else {
                    mPresenter.publishTask(false,hashMap);
                }
            }
        });

        mPresenter.departmentAndMembers();//获取所有部门人员需要在请求任务详情之前执行，不然无法匹配已经选择的人
        if(handleTaskType==EDIT_TASK){
            task_id=getIntent().getStringExtra(IntentParams.KEY_TASK_ID);
            titleCenter.setText("编辑任务");
        }else if(handleTaskType==PUBLISH_BY_PROJECT_CHILD){
            String structure_project_name=getIntent().getStringExtra(IntentParams.KEY_PROJECT_NAME);
            String structure_node_name=getIntent().getStringExtra(IntentParams.KEY_NODE_NAME);
            String structure_node_parent_name=getIntent().getStringExtra(IntentParams.KEY_NODE_PARENT_NAME);
            projectIds=getIntent().getStringExtra(IntentParams.KEY_PROJECT_ID);
            project_name.setText(structure_project_name+"");
            project_node.setText(""+structure_node_parent_name+"-"+structure_node_name);
            project_name.setOnClickListener(null);//设置不可点击
            project_arrow_tip.setVisibility(View.GONE);
            task_structure_id=getIntent().getStringExtra(IntentParams.KEY_NODE_ID);//选中的节点的id
            titleCenter.setText("发布任务");
            project_node_layout.setVisibility(View.VISIBLE);
        }else {
            titleCenter.setText("发布任务");
            project_name.setOnClickListener(v -> {
                Intent intent=new Intent(this,ProjectListActivity.class);
                intent.putExtra(IntentParams.KEY_PROJECT_ID_SELECT,projectIds);
                intent.putExtra(IntentParams.KEY_PROJECT_PLAN_LIST,ProjectListActivity.PROJECT_LIST);
                startActivityForResult(intent,reqCode);
            });
        }
    }

    private void initTaskDetail(Task task){
        /*projectIds=task.getTask_project_ids();
        planIds=task.getTask_plan_ids();*/
        task_structure_id=task.getTask_structure_id();
        if(!TextUtils.isEmpty(task_structure_id)){//如果不为空，判断为根据节点发布的任务，不给编辑
            project_name.setOnClickListener(null);
            project_arrow_tip.setVisibility(View.GONE);
            project_node_layout.setVisibility(View.VISIBLE);
            project_name.setText(task.getTask_project_names()+"");

            project_node.setText(task.getNav());
        }else {//编辑任务 获取到详情才可以点击
            project_name.setOnClickListener(v -> {
                Intent intent=new Intent(this,ProjectListActivity.class);
                intent.putExtra(IntentParams.KEY_PROJECT_ID_SELECT,projectIds);
                intent.putExtra(IntentParams.KEY_PROJECT_PLAN_LIST,ProjectListActivity.PROJECT_LIST);
                startActivityForResult(intent,reqCode);
            });
        }
        task_details.setText(task.getTask_desc()+"");
        task_name.setText(task.getTask_title()+"");
        List<Project> projectList=task.getTask_project_ids_data();
        if(projectList!=null&&projectList.size()>0){
            for(int i=0;i<projectList.size();i++) {
                Project project = projectList.get(i);
                if (i==0) {
                    projectIds=project.getProject_id()+"";
                    project_name.append(project.getProject_name());
                } else{
                    projectIds=projectIds+","+project.getProject_id()+"";
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
                    planIds=planIds+","+plan.getPlan_id()+"";
                    plan_name.append(","+plan.getPlan_name());
                }
            }
        }

        //complete_date.setText(TimeUtil.getFormatTime(task.getTask_time_limit())+"");
        complete_date.setText(TimeUtil.getFormatTime(Long.parseLong(task.getTask_time_limit())*1000)+"");
        task_details.setText(task.getTask_desc()+"");
        List<UserRealm> tagsData = task.getTask_belonged_data();
        if(tagsData!=null&&!tagsData.isEmpty()){
            participantListAdapter.setSelectUser(tagsData);
        }
        //各部门
        //List<ProgressBean> clientList=task.getTask_details();

        List<String> task_pic_urls=task.getTask_pic_urls();
        if(task_pic_urls!=null){
            List<LocalMedia> imgList=new ArrayList<>();
            for(int i=0;i<task_pic_urls.size();i++){
                LocalMedia localMedia=new LocalMedia();
                localMedia.setPath(HttpUrl.HOST+task_pic_urls.get(i));
                localMedia.setImageUrl(task_pic_urls.get(i));
                imgList.add(localMedia);
            }
            imgAdapter.setList(imgList);
            imgAdapter.notifyDataSetChanged();
        }

        List<String> task_file_urls=task.getTask_file_urls();

        if(task_file_urls!=null){
            List<FileInfo> listFiles=new ArrayList<>();
            for(int i=0;i<task_file_urls.size();i++){
                FileInfo fileInfo=new FileInfo();
                fileInfo.setFileUrl(task_file_urls.get(i));
                String path=fileInfo.getFileUrl();
                String b = path.substring(path.lastIndexOf("/") + 1, path.length());
                fileInfo.setFile_name(b);
                /*String suffixes="avi|mpeg|3gp|mp3|mp4|wav|jpeg|gif|jpg|png|apk|exe|pdf|rar|zip|docx|doc";
                Pattern pat=Pattern.compile("[\\w]+[\\.]("+suffixes+")");//正则判断
                Matcher mc=pat.matcher(b);//条件匹配
                while(mc.find()){
                    String substring = mc.group();//截取文件名后缀名
                    Log.e("substring:", substring);
                    fileInfo.setFile_type(substring);
                }*/
                String fileType = b.substring(b.lastIndexOf(".") + 1, b.length());
                if(!TextUtils.isEmpty(fileType)){
                    fileInfo.setFile_type(fileType);
                }
                listFiles.add(fileInfo);
            }
            fileAdapter.setList(listFiles);
            fileAdapter.notifyDataSetChanged();
        }

    }

    private boolean checkParams(){
        //CheckTextUtil.getInstance().checkText(project_name,"请选择关联项目");
        if(TextUtils.isEmpty(task_name.getText().toString())){
            ToastUtils.show("请填写任务标题");
            return false;
        }
        if(TextUtils.isEmpty(complete_date.getText().toString())){
            ToastUtils.show("请选择完成日期");
            return false;
        }
        if(TextUtils.isEmpty(task_details.getText().toString())){
            ToastUtils.show("请填写任务描述");
            return false;
        }
        return true;
    }
    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        return inflater.inflate(R.layout.activity_publish_task,null);
    }

    @Override
    protected TaskPresenterImpl initPresenter() {
        return new TaskPresenterImpl();
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if(reqCode==requestCode&&resultCode== Activity.RESULT_OK){
            if(data==null){
                return;
            }
            projectIds=data.getStringExtra(IntentParams.KEY_PROJECT_ID_SELECT);
            String projectNames=data.getStringExtra(IntentParams.KEY_PROJECT_NAMES_SELECT);
            project_name.setText(projectNames);
        }else if(reqPlanCode==requestCode&&resultCode== Activity.RESULT_OK){
            if(data==null){
                return;
            }
            planIds=data.getStringExtra(IntentParams.KEY_PLAN_ID_SELECT);
            String planNames=data.getStringExtra(IntentParams.KEY_PLAN_NAMES_SELECT);
            plan_name.setText(planNames);
        }else if(requestCode==requestCodeDatePicker&&resultCode== Activity.RESULT_OK){
            if(data==null){
                return;
            }
            String a=data.getStringExtra(IntentParams.KEY_DEPARTMENT_PERSON_SELECT);
            complete_date.setText(a);
        }
    }

    @Override
    public void showParticipantListSuccess(List<Participant> list) {
        participantListAdapter.refreshData(list);
        participantListAdapter.notifyDataSetChanged();
        if(handleTaskType==EDIT_TASK){
            showProgressDialog();
            HashMap<String,String> hashMap=new HashMap<>();
            hashMap.put("task_id",task_id);
            mPresenter.getTaskDetails(hashMap);
        }
    }

    @Override
    public void publishTaskSuccess() {
        if(handleTaskType==EDIT_TASK){
            ToastUtils.show("编辑任务成功");
        }else {
            ToastUtils.show("发布任务成功");
        }
        //finish();
        String type="";
        CommonEventEntity eventEntity = new CommonEventEntity(CommonKey.KEY_PUBLISH_TASK_SUCCESS, type);
        RxBus.getDefault().post(eventEntity);

        finish();
    }

    @Override
    public void failure() {
        dismissProgressDialog();
        ToastUtils.show("发布任务失败");
    }

    @Override
    public void getTaskDetails(Task task) {
        if(task!=null){
            initTaskDetail(task);
        }
        dismissProgressDialog();
    }
}
