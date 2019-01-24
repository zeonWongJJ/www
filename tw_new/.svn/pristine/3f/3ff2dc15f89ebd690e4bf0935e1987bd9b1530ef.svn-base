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
import android.widget.ImageView;
import android.widget.TextView;

import com.androidnetworking.error.ANError;
import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.Participant;
import com.app.base.bean.Plan;
import com.app.base.bean.PlanSubBean;
import com.app.base.bean.Task;
import com.app.base.bean.TypeSelect;
import com.app.base.bean.UserRealm;
import com.app.base.mvp.contract.PlanContract;
import com.app.base.mvp.presenter.PlanPresenterImpl;
import com.app.base.utils.CommonKey;
import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.app.base.widget.PlanTypeSelectDialog;
import com.app.base.widget.RightAlertDialog;
import com.common.lib.utils.TimeUtil;
import com.common.lib.utils.ToastUtils;
import com.luck.picture.lib.entity.LocalMedia;
import com.luck.picture.lib.rxbus2.RxBus;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import app.odp.qidu.R;
import app.odp.qidu.adapter.EditPlanListAdapter;
import app.odp.qidu.adapter.ParticipantListAdapter;
import app.odp.qidu.adapter.TagAdapter;
import choose.lm.com.fileselector.model.FileInfo;

/**
 * 发布计划
 */

public class PublishPlanActivity extends BasePhotoFileActivity<PlanPresenterImpl> implements PlanContract.View{
    private int requestCodeDatePicker=0x234;//年月选择
    private int reqCode=0x111;
    private TextView project_name,plan_type,complete_date;
    private View time_line_layout,time_select_layout;
    private EditPlanListAdapter editPlanListAdapter;
    private RecyclerView listView;
    private RecyclerView participant_recycler;
    private ParticipantListAdapter participantListAdapter;
    private String projectIds="";
    private TextView publish;
    public static int EDIT_PLAN=1;//编辑任务
    private int handlePlanType;
    private String plan_id;
    private String planType="1";
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        handlePlanType=getIntent().getIntExtra(IntentParams.KEY_HANDLE_PLAN_TYPE,0);
        TextView titleCenter=findView(R.id.title_center_text);
        if(handlePlanType==EDIT_PLAN){
            plan_id=getIntent().getStringExtra(IntentParams.KEY_PLAN_ID);
            titleCenter.setText("编辑计划");
        }else {
            titleCenter.setText("发布计划");
            new RightAlertDialog.Builder(getActivity()).setTitle("通知提醒").setMsg("一周只能发布一次周任务").setOk("确定").setClickListener(new RightAlertDialog.OnClickListener() {
                @Override
                public void onOkClick() {

                }
                @Override
                public void onCancelClick() {
                }
                @Override
                public void onDismiss() {
                }
            }).create();
        }
        ImageView left=findView(R.id.title_left_image);
        left.setOnClickListener(v -> {
            finish();
        });
        ImageView right=findView(R.id.title_right_image);
        right.setImageResource(R.drawable.icon_circle_white_add);
        right.setOnClickListener(v -> {
            hideKeyboard();
            if(editPlanListAdapter!=null){
                List<Plan> list=new ArrayList<>();
                list.add(new Plan());
                editPlanListAdapter.appendData(list);
                editPlanListAdapter.notifyDataSetChanged();

            }
        });
        time_line_layout=findView(R.id.time_line_layout);
        time_select_layout=findView(R.id.time_select_layout);
        publish=findView(R.id.publish);
        listView = (RecyclerView) findViewById(R.id.plan_list_view);
        listView.setNestedScrollingEnabled(false);
        listView.setLayoutManager(new LinearLayoutManager(getActivity()));
        editPlanListAdapter = new EditPlanListAdapter(this);
        listView.setAdapter(editPlanListAdapter);
        complete_date=findView(R.id.complete_date);
        complete_date.setOnClickListener(v -> {
            Intent intent=new Intent(getActivity(), TimePickerActivity.class);
            intent.putExtra(IntentParams.KEY_DATE_PICKER_DEPARTMENT_PICKER,TimePickerActivity.ONLY_SHOW_DATE_CHOOSE);
            intent.putExtra(IntentParams.KEY_DATE_PICKER_IS_HIDE_DAY,false);
            startActivityForResult(intent,requestCodeDatePicker);
        });
        project_name=findView(R.id.project_name);
        project_name.setOnClickListener(v -> {
            Intent intent=new Intent(this,ProjectListActivity.class);
            intent.putExtra(IntentParams.KEY_PROJECT_ID_SELECT,projectIds);
            intent.putExtra(IntentParams.KEY_PROJECT_PLAN_LIST,ProjectListActivity.PROJECT_LIST);
            startActivityForResult(intent,reqCode);
        });
        plan_type=findView(R.id.plan_type);
        plan_type.setOnClickListener(v -> {
            List<TypeSelect> listPlanType=new ArrayList<>();

            listPlanType.add(new TypeSelect(TypeSelect.weekPlan,"周计划"));
            listPlanType.add(new TypeSelect(TypeSelect.customizedPlan,"定制计划"));
            new PlanTypeSelectDialog.Builder(getActivity()).setOk("确认").setCancel("取消").setMsg(listPlanType).setClickListener(new PlanTypeSelectDialog.OnClickListener() {
                @Override
                public void onOkClick(TypeSelect data) {
                    plan_type.setText(data.getTitle());
                    if(data.getType().equals(TypeSelect.weekPlan)){
                        planType="1";
                        time_line_layout.setVisibility(View.GONE);
                        time_select_layout.setVisibility(View.GONE);
                    }else {
                        planType="2";
                        time_line_layout.setVisibility(View.VISIBLE);
                        time_select_layout.setVisibility(View.VISIBLE);
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

        participant_recycler=findView(R.id.participant_recycler);
        participant_recycler.setLayoutManager(new LinearLayoutManager(getActivity()));
        participant_recycler.setNestedScrollingEnabled(false);
        participantListAdapter=new ParticipantListAdapter(getActivity());
        participant_recycler.setAdapter(participantListAdapter);



        initSelectPhoto();
        initSelectFile();
        mPresenter.departmentAndMembers();

        publish.setOnClickListener(v -> {
            if(checkParams()){
                HashMap<String,String> hashMap=new HashMap<>();
                String planNames=editPlanListAdapter.getPlanList();
                if(!TextUtils.isEmpty(planNames)){
                    //hashMap.put("plan_name",planNames);//任务名称，数组或者逗号分隔的字符串
                    hashMap.put("plan_sub",planNames);
                }else {
                    ToastUtils.show("请填写计划");
                    return;
                }
                showProgressDialog();
                hashMap.put("plan_type",planType);//计划类型
                //类型，1和2，待定
                if(!TextUtils.isEmpty(projectIds)){
                    hashMap.put("plan_project_ids",projectIds);//项目id
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
                        hashMap.put("plan_belonged", userIds);//任务所属人
                    }
                }
                if(planType.equals("2")){//定制计划需要传时间
                    hashMap.put("plan_time_limit",complete_date.getText().toString());//任务时限 必须
                }
                String imgUrls=imgAdapter.getUploadUrls();
                if(!TextUtils.isEmpty(imgUrls)){
                    hashMap.put("plan_pic",imgUrls);//图片
                }
                String fileUrls=fileAdapter.getUploadUrls();
                if(!TextUtils.isEmpty(fileUrls)){
                    hashMap.put("plan_file",fileUrls);//文件
                }
                if(handlePlanType==EDIT_PLAN){
                    hashMap.put("plan_id",plan_id);
                    JSONArray jsonArray=new JSONArray();
                    if(editPlanListAdapter.getDatas().size()>0){
                        for(int k=0;k<editPlanListAdapter.getDatas().size();k++){
                            JSONObject jsonObject=new JSONObject();
                            try {
                                if(!TextUtils.isEmpty(editPlanListAdapter.getDatas().get(k).getPlan_sub_id())){
                                    jsonObject.put("plan_sub_id",editPlanListAdapter.getDatas().get(k).getPlan_sub_id());
                                }else {
                                    jsonObject.put("plan_sub_id","");
                                }
                                if(!TextUtils.isEmpty(editPlanListAdapter.getDatas().get(k).getPlan_name())){
                                    jsonObject.put("plan_name",editPlanListAdapter.getDatas().get(k).getPlan_name());
                                }else {
                                    jsonObject.put("plan_name","");
                                }
                                jsonArray.put(jsonObject);
                            } catch (JSONException e) {
                                e.printStackTrace();
                            }
                        }
                    }
                    hashMap.put("plan_sub",jsonArray.toString());
                    Log.i("aaaaa",hashMap.toString()+"");
                    mPresenter.publishPlan(true,hashMap);
                }else {
                    hashMap.put("plan_member_id", LoginUtil.getInstance().getLoginUser().getMember_id()+"");//文件
                    mPresenter.publishPlan(false,hashMap);
                }
            }
        });
        if(handlePlanType==EDIT_PLAN){
            showProgressDialog();
            mPresenter.planDetails(plan_id);
        }else {
            //如果是发布计划类型，默认让他展示填写两条子计划
            List<Plan> list=new ArrayList<>();
            list.add(new Plan());
            list.add(new Plan());
            editPlanListAdapter.appendData(list);
            editPlanListAdapter.notifyDataSetChanged();
        }
    }
    private boolean checkParams(){
        //CheckTextUtil.getInstance().checkText(project_name,"请选择关联项目");
        if(TextUtils.isEmpty(projectIds)){
            ToastUtils.show("请关联项目");
            return false;
        }
        if(planType.equals("2")&&TextUtils.isEmpty(complete_date.getText().toString())){
            ToastUtils.show("请选择完成日期");
            return false;
        }
        return true;
    }
    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        return inflater.inflate(R.layout.activity_plan_task,null);
    }

    @Override
    protected PlanPresenterImpl initPresenter() {
        return new PlanPresenterImpl();
    }

    @Override
    public void planDetails(PlanSubBean planSub) {
        dismissProgressDialog();
        if(planSub!=null){
            List<Plan> planList=planSub.getSub();
            if(planList!=null){
                if(planList.size()>0) {

                    Plan plan = planList.get(0);
                    if (plan != null) {
                        projectIds=plan.getPlan_project_ids();
                        if(plan.getPlan_time_limit()!=null){
                            complete_date.setText(TimeUtil.getFormatTime(Long.parseLong(plan.getPlan_time_limit())*1000));
                        }
                        project_name.setText(plan.getPlan_project_names()+"");
                        planType=plan.getPlan_type();
                        if(plan.getPlan_type().equals("1")){
                            plan_type.setText("周计划");
                        }else {
                            plan_type.setText("定制计划");
                            time_line_layout.setVisibility(View.VISIBLE);
                            time_select_layout.setVisibility(View.VISIBLE);
                        }
                        //设置参与人
                        List<UserRealm> tagsData = plan.getPlan_belonged_data();
                        if (tagsData != null) {
                            participantListAdapter.setSelectUser(tagsData);
                        }
                        List<LocalMedia> imgList = new ArrayList<>();
                        List<String> picUrls = plan.getPlan_pic_urls();
                        if (picUrls != null) {
                            for (int i = 0; i < picUrls.size(); i++) {
                                LocalMedia localMedia = new LocalMedia();
                                localMedia.setImageUrl(picUrls.get(i));
                                imgList.add(localMedia);
                            }
                            imgAdapter.appendList(imgList);
                            imgAdapter.notifyDataSetChanged();
                        }

                        List<String> plan_file_urls=plan.getPlan_file_urls();

                        if(plan_file_urls!=null){
                            List<FileInfo> listFiles=new ArrayList<>();
                            for(int i=0;i<plan_file_urls.size();i++){
                                FileInfo fileInfo=new FileInfo();
                                fileInfo.setFileUrl(plan_file_urls.get(i));
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
                            fileAdapter.appendData(listFiles);
                            fileAdapter.notifyDataSetChanged();
                        }
                    }
                }
                editPlanListAdapter.refreshData(planList);
                editPlanListAdapter.notifyDataSetChanged();
            }

        }

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
        dismissProgressDialog();
        participantListAdapter.refreshData(list);
        participantListAdapter.notifyDataSetChanged();
    }

    @Override
    public void publishPlanSuccess() {
        dismissProgressDialog();
        if(handlePlanType==EDIT_PLAN){
            ToastUtils.show("编辑计划成功");
        }else {
            ToastUtils.show("发布计划成功");
        }
        //finish();
        String type="";
        CommonEventEntity eventEntity = new CommonEventEntity(CommonKey.KEY_PUBLISH_PLAN_SUCCESS, type);
        RxBus.getDefault().post(eventEntity);

        finish();
    }

    @Override
    public void failure(Throwable error) {
        dismissProgressDialog();
        ToastUtils.show(error.getMessage());
    }
}
