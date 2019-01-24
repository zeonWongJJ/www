package app.odp.qidu.activity;

import android.os.Bundle;
import android.support.annotation.NonNull;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.app.base.bean.AbsenceBean;
import com.app.base.bean.AnnouncementBean;
import com.app.base.netUtil.AchievementHttpUtil;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.IntentParams;
import com.common.lib.base.AbsBaseActivity;
import com.common.lib.basemvp.base.BaseActivity;
import com.common.lib.utils.ToastUtils;
import com.common.lib.basemvp.presenter.BasePresenter;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;

import app.odp.qidu.R;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 申请详情
 */

public class ApprovalDetailsActivity extends BaseActivity<BasePresenter> {
    String absenceId;
    private TextView leave_type,time,reason,stop_agree,agree;
    private AbsenceBean absenceBean;
    private String is_todo;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        is_todo=getIntent().getStringExtra(IntentParams.KEY_APPROVAL_PARAM_LIST_OR_NOTICE);
        absenceId=getIntent().getStringExtra(IntentParams.KEY_APPROVAL_ID);
        setContentView(R.layout.activity_approval_details);
        TextView titleCenter= (TextView) findViewById(R.id.title_center_text);
        titleCenter.setText("审批详情");
        ImageView left= (ImageView) findViewById(R.id.title_left_image);
        left.setOnClickListener(v -> {
            finish();
        });
        leave_type=findView(R.id.leave_type);
        time=findView(R.id.time);
        reason=findView(R.id.reason);
        agree=findView(R.id.agree);
        stop_agree=findView(R.id.stop_agree);
        if(is_todo!=null){
            agree.setOnClickListener(listener);
            stop_agree.setOnClickListener(listener);
        }
        initData();
    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        View view=inflater.inflate(R.layout.activity_approval_details,null);
        return view;
    }
    private void intApprovalDetails(AbsenceBean absenceBean){
        if(absenceBean!=null){
            this.absenceBean=absenceBean;
            leave_type.setText(absenceBean.getAbsence_status());
            time.setText(absenceBean.getAbsence_start_time()+"-"+absenceBean.getAbsence_end_time());
            reason.setText(absenceBean.getAbsence_desc());
            initBtnStatus(absenceBean);
        }
    }
    private void initBtnStatus(AbsenceBean data){
        if(data.getIs_pass().equals("-1")){
            stop_agree.setBackground(getResources().getDrawable(R.drawable.shape_green_radius));
            stop_agree.setTextColor(getResources().getColor(R.color.status_green));
            stop_agree.setText("已驳回");
            String all="同意";
            agree.setTextColor(getResources().getColor(R.color.black));
            agree.setBackground(getResources().getDrawable(R.drawable.shape_gray_radius));
            agree.setText(all);
            agree.setEnabled(true);
            stop_agree.setEnabled(false);
        }else if(data.getIs_pass().equals("0")){
            String all="同意";
            agree.setTextColor(getResources().getColor(R.color.red_text));
            agree.setBackground(getResources().getDrawable(R.drawable.bg_stroke_red));
            agree.setText(all);
            stop_agree.setBackground(getResources().getDrawable(R.drawable.shape_gray_radius));
            stop_agree.setTextColor(getResources().getColor(R.color.black));
            stop_agree.setText("驳回");
            agree.setEnabled(true);
            stop_agree.setEnabled(true);
        }else if(data.getIs_pass().equals("1")){
            String all="已同意";
            agree.setTextColor(getResources().getColor(R.color.status_green));
            agree.setBackground(getResources().getDrawable(R.drawable.shape_green_radius));
            agree.setText(all);
            agree.setEnabled(false);
            stop_agree.setEnabled(true);
            stop_agree.setBackground(getResources().getDrawable(R.drawable.shape_gray_radius));
            stop_agree.setTextColor(getResources().getColor(R.color.black));
            stop_agree.setText("驳回");
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

            }
        };
    }

    private void initData(){
        showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("absence_id",absenceId+"");
        //hashMap.put("member_id", member_id);
        Disposable disposable= AchievementHttpUtil.getInstance().approvalDetails(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                dismissProgressDialog();
                AbsenceBean absenceBean=null;
                if(!TextUtils.isEmpty(data)&&!data.equals("")){
                    try {
                        JSONObject object=new JSONObject(data);
                        String str=object.getString("list");
                        if(str!=null){
                            absenceBean= GsonUtil.getObject(str,AbsenceBean.class);
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
                intApprovalDetails(absenceBean);
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
        mPresenter.getCompositeSubscription().add(disposable);
    }



    private View.OnClickListener listener=new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            if(absenceBean==null){
                return;
            }
            //is_pass ： -1 驳回 0 审批中 1 同意
            if (v.getId()==R.id.agree){
                AbsenceBean data=absenceBean;
                String isPass="";
                if(data.getIs_pass().equals("-1")){
                    isPass="1";
                }else if(data.getIs_pass().equals("0")){
                    isPass="1";
                }else if(data.getIs_pass().equals("1")){
                    isPass="-1";
                }
                if(!TextUtils.isEmpty(isPass)){
                    updateApproval(isPass,data.getAbsence_id());
                }
            }else if(v.getId()==R.id.stop_agree){//驳回按钮
                AbsenceBean data=absenceBean;
                String isPass="";
                if(data.getIs_pass().equals("-1")){//已经驳回了
                    return;
                }else if(data.getIs_pass().equals("0")){
                    isPass="-1";
                }else if(data.getIs_pass().equals("1")){//已经同意
                    isPass="-1";
                }
                if(!TextUtils.isEmpty(isPass)){
                    updateApproval(isPass,data.getAbsence_id());
                }
            }
        }
    };

    private void updateApproval(String is_pass,String absence_id){
        showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("is_pass",is_pass+"");//pageIndex*pageSize
        hashMap.put("absence_id",absence_id+"");
        //hashMap.put("member_id", member_id);
        Disposable disposable= AchievementHttpUtil.getInstance().updateApproval(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String message) {
                dismissProgressDialog();
                absenceBean.setIs_pass(is_pass);
                initBtnStatus(absenceBean);
                if(is_pass.equals("-1")){
                    ToastUtils.show("已驳回");
                }else if(is_pass.equals("1")){
                    ToastUtils.show("已同意");
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
        mPresenter.getCompositeSubscription().add(disposable);
    }
}
