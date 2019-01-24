package app.odp.qidu.activity;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.widget.ImageView;
import android.widget.TextView;

import com.app.base.bean.AbsenceBean;
import com.app.base.bean.Plan;
import com.app.base.bean.TypeSelect;
import com.app.base.bean.UserRealm;
import com.app.base.flow.FlowTagLayout;
import com.app.base.netUtil.AchievementHttpUtil;
import com.app.base.netUtil.MemberHttpUtil;
import com.app.base.netUtil.PlanHttpUtil;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.IntentParams;
import com.app.base.widget.PlanTypeSelectDialog;
import com.common.lib.base.AbsBaseActivity;
import com.common.lib.utils.TimeUtil;
import com.common.lib.utils.ToastUtils;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.adapter.TagAllUserAdapter;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 申请请假
 */

public class CreateLeaveActivity extends AbsBaseActivity{
    private TextView leave_type,start_time,end_time,reason,commit;
    private String absence_end_time,absence_start_time,absence_status;
    private int requestCodeStart=0x234;//开始
    private int requestCodeEnd=0x235;//结束
    private TagAllUserAdapter mColorTagAdapter;
    private String absenceId;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_create_leave);
        absenceId=getIntent().getStringExtra(IntentParams.KEY_ABSENCE_ID);
        Log.i("vvvvvvv",absenceId+"");
        TextView titleCenter= (TextView) findViewById(R.id.title_center_text);

        ImageView left= (ImageView) findViewById(R.id.title_left_image);
        left.setOnClickListener(v -> {
            finish();
        });

        leave_type= (TextView) findViewById(R.id.leave_type);
        start_time= (TextView) findViewById(R.id.start_time);
        end_time= (TextView) findViewById(R.id.end_time);
        reason= (TextView) findViewById(R.id.reason);
        commit= (TextView) findViewById(R.id.commit);
        if(absenceId!=null){
            titleCenter.setText("编辑请假");
            commit.setText("确认提交");
        }else {
            titleCenter.setText("申请请假");
        }
        List<TypeSelect> listPlanType=new ArrayList<>();

        listPlanType.add(new TypeSelect("-1","事假"));
        listPlanType.add(new TypeSelect("-2","病假"));
        listPlanType.add(new TypeSelect("0","调休"));
        listPlanType.add(new TypeSelect("1","婚假"));
        listPlanType.add(new TypeSelect("2","产假"));
        listPlanType.add(new TypeSelect("3","年假"));
        leave_type.setOnClickListener(v -> {
            new PlanTypeSelectDialog.Builder(getActivity()).setOk("确认").setCancel("取消").setMsg(listPlanType).setClickListener(new PlanTypeSelectDialog.OnClickListener() {
                @Override
                public void onOkClick(TypeSelect data) {
                    absence_status=data.getType();
                    leave_type.setText(data.getTitle());
                }
                @Override
                public void onCancelClick() {

                }
                @Override
                public void onDismiss() {

                }
            }).create();
        });
        start_time.setOnClickListener(v -> {
            Intent intent=new Intent(getActivity(), TimePickerActivity.class);
            intent.putExtra(IntentParams.KEY_DATE_PICKER_DEPARTMENT_PICKER,TimePickerActivity.WHOLE_DATE_CHOOSE);
            //intent.putExtra(IntentParams.KEY_DATE_PICKER_IS_HIDE_DAY,false);
            startActivityForResult(intent,requestCodeStart);
        });
        end_time.setOnClickListener(v -> {
            Intent intent=new Intent(getActivity(), TimePickerActivity.class);
            intent.putExtra(IntentParams.KEY_DATE_PICKER_DEPARTMENT_PICKER,TimePickerActivity.WHOLE_DATE_CHOOSE);
            //intent.putExtra(IntentParams.KEY_DATE_PICKER_IS_HIDE_DAY,false);
            startActivityForResult(intent,requestCodeEnd);
        });
        commit.setOnClickListener(v -> {
            createLeave();
        });

        FlowTagLayout tagLayout= (FlowTagLayout) findViewById(R.id.color_flow_layout);
        mColorTagAdapter = new TagAllUserAdapter(this);
        mColorTagAdapter.setOnSelectClickListener(new TagAllUserAdapter.OnSelectClickListener() {
            @Override
            public void onSelectItemClick(List<UserRealm> selectList) {

            }
        });
        tagLayout.setAdapter(mColorTagAdapter);
        /*UserRealm.queryAllUserRealm(new UserRealm.QueryDbCallBack<UserRealm>() {
            @Override
            public void querySuccess(List<UserRealm> items, boolean hasMore) {
                mColorTagAdapter.clearAndAddAll(items);
            }
        });*/
        getApprovalMember();
    }

    private void createLeave(){
        String absence_desc=reason.getText().toString();
        if(TextUtils.isEmpty(absence_status)){
            ToastUtils.show("请选择请假类型");
            return;
        }
        if(TextUtils.isEmpty(absence_start_time)){
            ToastUtils.show("请选择请假开始时间");
            return;
        }
        if(TextUtils.isEmpty(absence_end_time)){
            ToastUtils.show("请选择请假结束时间");
            return;
        }
        long startTimeTemp=TimeUtil.getTimeStamp(absence_start_time,"yyyy-MM-dd hh:mm")/1000;
        long endTimeTemp=TimeUtil.getTimeStamp(absence_end_time,"yyyy-MM-dd hh:mm")/1000;
        if(startTimeTemp>endTimeTemp){
            ToastUtils.show("开始时间不能晚于结束时间");
            return;
        }
        if(TextUtils.isEmpty(absence_desc)){
            ToastUtils.show("请填写请假原因");
            return;
        }

        List<UserRealm> selectUser=mColorTagAdapter.getSelectList();
        String userIds="";
        if(selectUser.size()>0){
            for(int i=0;i<selectUser.size();i++){
                if(i==0){
                    userIds=selectUser.get(i).getMember_id()+"";
                }else {
                    userIds = userIds + "," + selectUser.get(i).getMember_id();
                }
            }
        }
        if(TextUtils.isEmpty(userIds)){
            ToastUtils.show("请选择审批的人");
            return;
        }
        showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("absence_status",absence_status+"");
        hashMap.put("absence_start_time",startTimeTemp+"");
        hashMap.put("absence_end_time",endTimeTemp+"");
        hashMap.put("absence_desc",absence_desc+"");
        hashMap.put("absence_approval_superior",userIds+"");
        Log.i("aaaaaaa",hashMap.toString());
        if(absenceId==null) {
            Disposable disposable = AchievementHttpUtil.getInstance().createLeave(hashMap, new DisposableObserver<String>() {
                @Override
                public void onNext(String response) {
                    dismissProgressDialog();
                    ToastUtils.show("申请成功");
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
            }, String.class);
        }else {
            hashMap.put("absence_id",absenceId);
            AchievementHttpUtil.getInstance().updateAbsence(hashMap, new DisposableObserver<String>() {
                @Override
                public void onNext(String response) {
                    dismissProgressDialog();
                    ToastUtils.show("编辑成功");
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
            }, String.class);
        }
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if(requestCode==requestCodeStart&&resultCode== Activity.RESULT_OK){
            if(data==null){
                return;
            }
            absence_start_time=data.getStringExtra(IntentParams.KEY_DEPARTMENT_PERSON_SELECT);
            start_time.setText(absence_start_time);
        }else if(requestCode==requestCodeEnd&&resultCode== Activity.RESULT_OK){
            if(data==null){
                return;
            }
            absence_end_time=data.getStringExtra(IntentParams.KEY_DEPARTMENT_PERSON_SELECT);
            end_time.setText(absence_end_time);
        }
    }



    private void getLeaveDetails(AbsenceBean absenceBean){
        if(absenceBean!=null){
            absence_status=absenceBean.getAbsence_status();
            String status_name="";
            if(absence_status.equals("-1")){
                status_name="事假";
            }else if(absence_status.equals("-2")){
                status_name="病假";
            }else if(absence_status.equals("0")){
                status_name="调休";
            }else if(absence_status.equals("1")){
                status_name="婚假";
            }else if(absence_status.equals("2")){
                status_name="产假";
            }else if(absence_status.equals("3")){
                status_name="年休";
            }
            leave_type.setText(status_name);
            absence_start_time=absenceBean.getAbsence_start_time();
            absence_end_time=absenceBean.getAbsence_end_time();
            start_time.setText(absence_start_time);
            end_time.setText(absence_end_time);
            reason.setText(absenceBean.getAbsence_desc());
            String userIds=absenceBean.getAbsence_approval_superior();
            if(userIds!=null&&!TextUtils.isEmpty(userIds)){
                String[] array=userIds.split(",");
                List<UserRealm> list=new ArrayList<>();
                for(int i=0;i<array.length;i++){
                    UserRealm userRealm=new UserRealm();
                    userRealm.setMember_id(array[i]);
                    list.add(userRealm);
                }
                mColorTagAdapter.setSelectUser(list);
            }
        }
    }
    private void getLeaveDetails(){
        showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("absence_id",absenceId);
        Disposable disposable=AchievementHttpUtil.getInstance().absenceDetails(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                dismissProgressDialog();
                AbsenceBean absenceBean=null;
                if(!TextUtils.isEmpty(data)&&!data.equals("")){
                    try {
                        JSONObject object=new JSONObject(data);
                        String str=object.getString("list");
                        if(str!=null&&!str.equals("null")){
                            absenceBean= GsonUtil.getObject(str,AbsenceBean.class);

                            getLeaveDetails(absenceBean);
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
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
    //获取审批人
    private void getApprovalMember(){
        showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        Disposable disposable= MemberHttpUtil.getInstance().approvalMember(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                dismissProgressDialog();
                List<UserRealm> approvalMembers=new ArrayList<>();
                if(!TextUtils.isEmpty(data)&&!data.equals("")){
                    try {
                        JSONObject object=new JSONObject(data);
                        String str=object.getString("list");
                        if(str!=null&&!str.equals("null")){
                            approvalMembers= GsonUtil.getObjectList(str,UserRealm.class);
                            mColorTagAdapter.clearAndAddAll(approvalMembers);
                            if(absenceId!=null){
                                getLeaveDetails();
                            }
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
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
