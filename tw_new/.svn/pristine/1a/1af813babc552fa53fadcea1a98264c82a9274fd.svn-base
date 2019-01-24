package app.odp.qidu.activity;

import android.content.Context;
import android.content.ContextWrapper;
import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v7.widget.DefaultItemAnimator;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

import com.anthony.rvhelper.divider.FullyGridLayoutManager;
import com.app.base.bean.Comment;
import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.PlanComment;
import com.app.base.bean.Task;
import com.app.base.bean.TypeSelect;
import com.app.base.mvp.contract.PublishCommentContract;
import com.app.base.mvp.presenter.PublishCommentPresenterImpl;
import com.app.base.utils.CommonKey;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.IntentParams;
import com.app.base.widget.PlanTypeSelectDialog;
import com.common.lib.utils.StatusBarUtil;
import com.common.lib.utils.ToastUtils;
import com.luck.picture.lib.immersive.LightStatusBarUtils;
import com.luck.picture.lib.rxbus2.RxBus;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.adapter.GridImageAdapter;
import choose.lm.com.fileselector.activitys.ChooseFileActivity;
import choose.lm.com.fileselector.model.FileInfo;

/**
 * 发布任务评论记录-发布计划评论记录
 */

public class PublishCommentActivity extends BasePhotoFileActivity<PublishCommentPresenterImpl> implements PublishCommentContract.View{

    public static String PUBLISH_TASK_COMMENT="publish_task_comment";//发布任务评论
    public static String PUBLISH_PLAN_COMMENT="publish_plan_comment";//发布计划评论
    public static String PUBLISH_ACTION_COMMENT="publish_action_comment";//发布动作
    private String publishType;

    private View sure_publish;
    private EditText comment_desc;
    private View add_action_layout;

    private String task_or_plan_id;
    private String member_id;
    private String task_record_type="";
    private String task_record_id;//回复的id，非必须，默认0为直接评论  //此字段也 判断是回复一级评论列表还是二级评论列表
    private String department;
    private String replyName;
    private int position;
    //private boolean secondReplyType=false;//判断是回复一级评论列表还是二级评论列表

    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        StatusBarUtil.setStatusBarColor(getActivity(),R.color.white);
        LightStatusBarUtils.setLightStatusBar(getActivity(),true);
        //secondReplyType=getIntent().getBooleanExtra(IntentParams.KEY_SECOND_REPLY_TYPE,false);
        View layout_parent=findView(R.id.layout_parent);
        layout_parent.setBackgroundColor(getResources().getColor(R.color.white));
        TextView titleCenter=findView(R.id.title_center_text);
        titleCenter.setTextColor(getResources().getColor(R.color.black));
        comment_desc=findView(R.id.comment_desc);
        publishType=getIntent().getStringExtra(IntentParams.KEY_PUBLISH_COMMENT_OR_ACTION);
        titleCenter.setText("开始记录");
        add_action_layout=findView(R.id.add_action_layout);

        //计划-任务-动作
        task_or_plan_id=getIntent().getStringExtra(IntentParams.KEY_TASK_ID);
        member_id=getIntent().getStringExtra(IntentParams.KEY_MEMBER_ID);
        task_record_id=getIntent().getStringExtra(IntentParams.KEY_COMMENT_REPLY_ID);
        department=getIntent().getStringExtra(IntentParams.KEY_DEPARTMENT);
        replyName=getIntent().getStringExtra(IntentParams.KEY_COMMENT_REPLY_NAME);
        Log.i("aaaaaa","replyName="+replyName+"task_record_id="+task_record_id);
        if(replyName!=null&&!TextUtils.isEmpty(replyName)){
            position=getIntent().getIntExtra(IntentParams.KEY_POSITION,0);
            comment_desc.setHint("回复:"+replyName);
        }
        if(publishType.equals(PUBLISH_TASK_COMMENT)){
            titleCenter.setText("任务记录");
        }else if(publishType.equals(PUBLISH_PLAN_COMMENT)){
            titleCenter.setText("计划点评");//回复/计划点评
        }else if(publishType.equals(PUBLISH_ACTION_COMMENT)){
            titleCenter.setText("动作记录");
            task_record_type=getIntent().getStringExtra(IntentParams.KEY_COMMENT_ACTION_TYPE);
            /*task_or_plan_id=getIntent().getStringExtra(IntentParams.KEY_TASK_ID);
            member_id=getIntent().getStringExtra(IntentParams.KEY_MEMBER_ID);
            task_record_id=getIntent().getStringExtra(IntentParams.KEY_COMMENT_REPLY_ID);
            department=getIntent().getStringExtra(IntentParams.KEY_DEPARTMENT);*/
            //add_action_layout.setVisibility(View.VISIBLE);
            TextView action_name=findView(R.id.action_name);
            View arrow_right_tip=findView(R.id.arrow_right_tip);
            if(task_record_type!=null){
                add_action_layout.setVisibility(View.GONE);
                arrow_right_tip.setVisibility(View.INVISIBLE);
                String name="";
                if(task_record_type.equals("1")){
                    name="日记";
                }else if(task_record_type.equals("2")){
                    name="疑问";
                }else if(task_record_type.equals("3")){
                    name="建议";
                }else if(task_record_type.equals("4")){
                    name="bug";
                }
                action_name.setText(name);
            }else {
                add_action_layout.setVisibility(View.VISIBLE);
                List<TypeSelect> listPlanType = new ArrayList<>();

                listPlanType.add(new TypeSelect(TypeSelect.diaryAction, "日记"));
                listPlanType.add(new TypeSelect(TypeSelect.questionAction, "疑问"));
                listPlanType.add(new TypeSelect(TypeSelect.proposalAction, "建议"));
                listPlanType.add(new TypeSelect(TypeSelect.bugAction, "bug"));
                action_name.setOnClickListener(v -> {
                    new PlanTypeSelectDialog.Builder(getActivity()).setOk("确认").setCancel("取消").setMsg(listPlanType).setClickListener(new PlanTypeSelectDialog.OnClickListener() {
                        @Override
                        public void onOkClick(TypeSelect data) {
                            ////1日记 2疑问 3建议 4bug
                            if (data.getType().equals(TypeSelect.diaryAction)) {
                                task_record_type = "1";
                            } else if (data.getType().equals(TypeSelect.questionAction)) {
                                task_record_type = "2";
                            } else if (data.getType().equals(TypeSelect.proposalAction)) {
                                task_record_type = "3";
                            } else if (data.getType().equals(TypeSelect.bugAction)) {
                                task_record_type = "4";
                            }
                            action_name.setText(data.getTitle());
                        }
                        @Override
                        public void onCancelClick() {}
                        @Override
                        public void onDismiss() {}
                    }).create();
                });
            }
        }

        ImageView left=findView(R.id.title_left_image);
        left.setImageResource(R.drawable.icon_back_black);
        left.setOnClickListener(v -> {
            finish();
        });
        sure_publish=findView(R.id.sure_publish);

        initSelectPhoto();
        initSelectFile();

        sure_publish.setOnClickListener(v -> {
            String desc=comment_desc.getText().toString();
            if(TextUtils.isEmpty(desc)){
                ToastUtils.show("请填写评论内容");
                return;
            }
            HashMap<String,String> hashMap=new HashMap<>();
            if(publishType.equals(PUBLISH_TASK_COMMENT)){
                hashMap.put("task_id",task_or_plan_id);
                hashMap.put("member_id",member_id);
                hashMap.put("task_record_desc",desc);
                if(!TextUtils.isEmpty(task_record_id)){
                    hashMap.put("task_record_id",task_record_id);//回复的id，非必须，默认0为直接评论
                }
                String fileUrls=fileAdapter.getUploadUrls();
                String imgUrls=imgAdapter.getUploadUrls();
                if(imgUrls!=null&&!TextUtils.isEmpty(imgUrls)){
                    hashMap.put("task_record_pic",imgUrls);
                }
                if(fileUrls!=null&&!TextUtils.isEmpty(fileUrls)){
                    hashMap.put("task_record_file",fileUrls);
                }
                showProgressDialog();
                mPresenter.publishTaskCommentRecord(hashMap);
            }else if(publishType.equals(PUBLISH_PLAN_COMMENT)){
                hashMap.put("plan_id",task_or_plan_id);
                hashMap.put("member_id",member_id);
                hashMap.put("plan_record_desc",desc);
                if(!TextUtils.isEmpty(task_record_id)){
                    hashMap.put("plan_record_id",task_record_id);//回复的id，非必须，默认0为直接评论
                }
                String fileUrls=fileAdapter.getUploadUrls();
                String imgUrls=imgAdapter.getUploadUrls();
                if(!TextUtils.isEmpty(imgUrls)){
                    hashMap.put("plan_record_pic",imgUrls);
                }
                if(!TextUtils.isEmpty(fileUrls)){
                    hashMap.put("plan_record_file",fileUrls);
                }
                showProgressDialog();
                mPresenter.publishPlanCommentRecord(hashMap);
            }else if(publishType.equals(PUBLISH_ACTION_COMMENT)){
                hashMap.put("task_id",task_or_plan_id);
                hashMap.put("member_id",member_id);
                if(TextUtils.isEmpty(task_record_type)){
                    ToastUtils.show("请选择发布的动作类型");
                    return;
                }
                hashMap.put("task_record_type",task_record_type);
                hashMap.put("task_record_desc",desc);
                if(!TextUtils.isEmpty(task_record_id)){
                    hashMap.put("task_record_id",task_record_id);//回复的id，非必须，默认0为直接评论
                }
                hashMap.put("department",department);
                String fileUrls=fileAdapter.getUploadUrls();
                String imgUrls=imgAdapter.getUploadUrls();
                if(!TextUtils.isEmpty(imgUrls)){
                    hashMap.put("task_record_pic",imgUrls);
                }
                if(!TextUtils.isEmpty(fileUrls)){
                    hashMap.put("task_record_file",fileUrls);
                }
                Log.i("aaaaaa","发布动作记录======="+hashMap.toString()+"");
                mPresenter.publishActionCommentRecord(hashMap);
            }
        });
    }


    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        return inflater.inflate(R.layout.activity_publish_comment,null);
    }

    @Override
    protected PublishCommentPresenterImpl initPresenter() {
        return new PublishCommentPresenterImpl();
    }


    @Override
    public void publishCommentSuccess(String msg) {
        dismissProgressDialog();
        ToastUtils.show("发布成功");
        if(publishType.equals(PUBLISH_TASK_COMMENT)){
            try {
                JSONObject object = new JSONObject(msg);
                Comment comment = GsonUtil.getObject(object.getJSONObject("record").toString(), Comment.class);
                CommonEventEntity eventEntity=null;
                if(task_record_id!=null&&!TextUtils.isEmpty(task_record_id)){
                    comment.setPosition(position);
                    eventEntity = new CommonEventEntity(CommonKey.KEY_REPLY_TASK_COMMENT_CODE, comment);
                }else {
                    eventEntity = new CommonEventEntity(CommonKey.KEY_SEND_TASK_COMMENT_CODE, comment);
                }
                RxBus.getDefault().post(eventEntity);
            } catch (JSONException e) {
                e.printStackTrace();
            }

        }else if(publishType.equals(PUBLISH_PLAN_COMMENT)){
            Log.i("aaaa",msg);
            try {
                JSONObject object = new JSONObject(msg);
                PlanComment comment = GsonUtil.getObject(object.getJSONObject("record").toString(), PlanComment.class);
                CommonEventEntity eventEntity=null;
                if(task_record_id!=null&&!TextUtils.isEmpty(task_record_id)){
                    comment.setPosition(position);
                    eventEntity = new CommonEventEntity(CommonKey.KEY_REPLY_PLAN_COMMENT_CODE, comment);
                }else {
                    eventEntity = new CommonEventEntity(CommonKey.KEY_SEND_PLAN_COMMENT_CODE, comment);
                }
                RxBus.getDefault().post(eventEntity);
            } catch (JSONException e) {
                e.printStackTrace();
            }
        }else if(publishType.equals(PUBLISH_ACTION_COMMENT)){
            try {
                JSONObject object = new JSONObject(msg);
                Comment comment = GsonUtil.getObject(object.getJSONObject("record").toString(), Comment.class);
                comment.setTask_record_type(task_record_type);
                CommonEventEntity eventEntity=null;
                if(task_record_id!=null&&!TextUtils.isEmpty(task_record_id)){
                    comment.setPosition(position);
                    eventEntity = new CommonEventEntity(CommonKey.KEY_REPLY_TASK_ACTION_COMMENT_CODE, comment);
                }else {
                    eventEntity = new CommonEventEntity(CommonKey.KEY_SEND_TASK_ACTION_COMMENT_CODE, comment);
                }
                RxBus.getDefault().post(eventEntity);

            } catch (JSONException e) {
                e.printStackTrace();
            }
        }
        finish();

    }

    @Override
    public void publishCommentFailure(String tips) {
        dismissProgressDialog();
        ToastUtils.show(tips);
    }
}
