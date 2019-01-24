package app.odp.qidu.adapter;

import android.app.Activity;
import android.content.Intent;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;
import android.widget.PopupWindow;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.MemberRealm;
import com.app.base.bean.ProgressBean;
import com.app.base.bean.Task;
import com.app.base.bean.TypeSelect;
import com.app.base.bean.UserRealm;
import com.app.base.netUtil.TaskHttpUtil;
import com.app.base.utils.CommonKey;
import com.app.base.utils.DataUtils;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.app.base.widget.AppScoreStarDialog;
import com.app.base.widget.AssignTaskDialog;
import com.app.base.widget.CustomOperationPopWindow;
import com.app.base.widget.EditProgressDialog;
import com.app.base.widget.ZzHorizontalProgressBar;
import com.common.lib.base.AbsBaseActivity;
import com.common.lib.utils.ToastUtils;
import com.common.lib.widget.AppDialog;
import com.luck.picture.lib.rxbus2.RxBus;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.activity.ActionRecordListActivity;
import io.reactivex.observers.DisposableObserver;

/**
 * 各个端的工作进度列表
 */

public class ClientProcessListAdapter extends CommonAdapter<ProgressBean> {
    //private boolean isArrowUp=false;
    private AbsBaseActivity activity;
    List<TypeSelect> list;
    private List<UserRealm> userRealmList=new ArrayList<>();
    private MemberRealm memberLoginUser;//当前登陆用户
    private UserRealm assignUser;//指派给谁
    private String task_id;
    public ClientProcessListAdapter(AbsBaseActivity context,String task_id) {
        super(context,R.layout.layout_client_process_item);
        this.activity=context;
        this.task_id=task_id;
        memberLoginUser=LoginUtil.getInstance().getLoginUser();
        UserRealm.queryAllUserRealm(new UserRealm.QueryDbCallBack<UserRealm>() {
            @Override
            public void querySuccess(List<UserRealm> items, boolean hasMore) {
                userRealmList.addAll(items);
            }
        });
    }


    @Override
    protected void convert(ViewHolder holder, ProgressBean data, int position) {
        ZzHorizontalProgressBar pb = holder.getView(R.id.pb);
        pb.setProgressColor(mContext.getResources().getColor(R.color.light_gray));
        pb.setMax(100);
        TextView progress_num=holder.getView(R.id.progress_num);
        TextView user_name=holder.getView(R.id.user_name);
        if(data.getReal_name()!=null){
            user_name.setText(""+data.getReal_name());
        }else {
            user_name.setText("");
        }
        TextView score=holder.getView(R.id.score);
        score.setVisibility(View.INVISIBLE);
        TextView textView=holder.getView(R.id.client_name);
        //status :  -1 放弃流程 ,0 未接手, 1 已接手, 2.已完成
        if(data.getStatus()==-1){//
            textView.setTextColor(mContext.getResources().getColor(R.color.light_gray));
            progress_num.setVisibility(View.INVISIBLE);
            pb.setVisibility(View.INVISIBLE);
        }else if(data.getStatus()==0){
            textView.setTextColor(mContext.getResources().getColor(R.color.red));
            progress_num.setVisibility(View.INVISIBLE);
            pb.setVisibility(View.INVISIBLE);
        }else if(data.getStatus()==1){
            textView.setTextColor(mContext.getResources().getColor(R.color.yellow));
            progress_num.setVisibility(View.VISIBLE);
            pb.setVisibility(View.VISIBLE);
            progress_num.setText(data.getTask_progress()+"%");
            int task_progress=Integer.parseInt(data.getTask_progress());
            if(task_progress!=0){//设置为空的时候不显示默认的黄色圆点
                pb.setProgressColor(mContext.getResources().getColor(R.color.yellow));
                pb.setProgress(task_progress);
            }
        }else if(data.getStatus()==2){
            score.setVisibility(View.VISIBLE);
            float scoreLevel=Float.parseFloat(data.getTask_score());
            String level=DataUtils.getLevelByNum(scoreLevel);
            if(scoreLevel>0){
                score.setText(level);
            }else {
                score.setText("评");
            }
            textView.setTextColor(mContext.getResources().getColor(R.color.blue));
            progress_num.setVisibility(View.VISIBLE);
            pb.setVisibility(View.VISIBLE);
            progress_num.setText(data.getTask_progress()+"%");
            int task_progress=Integer.parseInt(data.getTask_progress());
            if(task_progress!=0){//设置为空的时候不显示默认的黄色圆点
                pb.setProgressColor(mContext.getResources().getColor(R.color.yellow));
                pb.setProgress(task_progress);
            }
            //pb.setProgress();
            score.setOnClickListener(v -> {
                //task_procedure_id 流程评分
                new AppScoreStarDialog.Builder(activity).setCancel("取消").setOk("提交").setTitle("评级").setClickListener(new AppScoreStarDialog.OnClickListener() {
                    @Override
                    public void onOkClick(float order_score,String level) {
                        activity.hideKeyboard();
                        procedureScore(order_score,position,level);
                    }
                    @Override
                    public void onCancelClick() {

                    }
                    @Override
                    public void onDismiss() {

                    }
                }).create();
            });
        }else {
            progress_num.setVisibility(View.INVISIBLE);
            pb.setVisibility(View.INVISIBLE);
        }
        textView.setText(data.getDepartment_name());
        ImageView moreAction=holder.getView(R.id.more_action);

        moreAction.setOnClickListener(v -> {
            moreAction.setImageResource(R.drawable.icon_arrow_up);
            initMorePop(moreAction,data,position,user_name,pb);
        });

    }

    private void initMorePop(ImageView moreAction,ProgressBean data,int position,TextView user_name,ZzHorizontalProgressBar pb){
        List<TypeSelect> list=null;
        //status :  -1 放弃流程 ,0 未接手, 1 已接手, 2.已完成
        if(data.getStatus()==-1){//可以被接手，  是自己发的可以指派
            //if(){}
            list= DataUtils.getTypeListAction(TypeSelect.cancelProcedure);
        }else if(data.getStatus()==0){//未接手   接手 取消流程
            list= DataUtils.getTypeListAction(TypeSelect.unAcceptTask);
        }else if(data.getStatus()==1){//已经接手
            list= DataUtils.getTypeListAction(TypeSelect.acceptTask);
        }else if(data.getStatus()==2){//完成
            list= DataUtils.getTypeListAction(TypeSelect.completeTask);
        }else {
            list= DataUtils.getTypeListAction(TypeSelect.giveUpTask);
        }

        CustomOperationPopWindow customOperationPopWindow = new CustomOperationPopWindow(activity, list);
        customOperationPopWindow.setOnDismissCallBack(new CustomOperationPopWindow.OnDismissCallBack() {
            @Override
            public void onDismissCallback() {
                moreAction.setImageResource(R.drawable.icon_arrow_down);
            }
        });
        customOperationPopWindow.setOnItemMyListener(new CustomOperationPopWindow.OnItemListener() {
            @Override
            public void OnItemListener(int positionIndex, TypeSelect typeSelect) {
                //此处实现列表点击所要进行的操作
                moreAction.setImageResource(R.drawable.icon_arrow_down);
                List<TypeSelect> typeList= DataUtils.getTypeListAction(typeSelect.getType());
                customOperationPopWindow.setDataSource(typeList);
                if(typeSelect.getType().equals(TypeSelect.assignTask)){
                    if(userRealmList.isEmpty()){
                        return;
                    }
                    new AssignTaskDialog.Builder(activity).setTitle("指派任务").setOk("确认").setList(userRealmList).setClickListener(new AssignTaskDialog.OnClickListener() {
                        @Override
                        public void onOkClick() {
                            /*if(!data.getTask_catcher().equals(assignUser.getDepartment_name())){
                                alertDialogTips("该用户不属于该部门,不能操作哦");
                            }*/
                            handleTaskByActionUrl(TypeSelect.assignTask,HttpUrl.api_task_assign,position);
                        }
                        @Override
                        public void onCancelClick() {

                        }
                        @Override
                        public void onItemClick(UserRealm userRealm, int positionIndex) {
                            assignUser=userRealm;
                        }

                        @Override
                        public void onDismiss() {

                        }
                    }).create();
                }else if(typeSelect.getType().equals(TypeSelect.actionRecord)){
                    Intent intent=new Intent(activity, ActionRecordListActivity.class);
                    intent.putExtra(IntentParams.KEY_TASK_ID,task_id);
                    intent.putExtra(IntentParams.KEY_DEPARTMENT,data.getTask_catcher());
                    activity.startActivity(intent);
                }else if(typeSelect.getType().equals(TypeSelect.editProcess)){
                    if(!data.getTask_member_id().equals(memberLoginUser.getMember_id()+"")){
                        alertDialogTips("任务不属于当前用户,不能编辑哦");
                        return;
                    }
                    new EditProgressDialog.Builder(activity).setTitle("编写进度").setOk("确定").setCancel("取消").setClickListener(new EditProgressDialog.OnClickListener() {
                        @Override
                        public void onOkClick(String progress) {
                            activity.hideKeyboard();
                            editProgressByActionUrl(TypeSelect.editProcess,pb,Integer.parseInt(progress),HttpUrl.api_task_progress,position);
                        }

                        @Override
                        public void onCancelClick() {

                        }
                        @Override
                        public void onItemClick(UserRealm data, int positionIndex) {

                        }
                        @Override
                        public void onDismiss() {

                        }
                    }).create();
                }else if(typeSelect.getType().equals(TypeSelect.giveUpTask)){
                    if(!data.getTask_member_id().equals(memberLoginUser.getMember_id()+"")){
                        alertDialogTips("任务不属于当前用户,不能取消任务哦");
                        return;
                    }
                    handleTaskByActionUrl(TypeSelect.giveUpTask,HttpUrl.api_task_giveup,position);

                }else if(typeSelect.getType().equals(TypeSelect.cancelProcedure)){//取消流程  任何人都可以取消流程
                    /*if(!data.getTask_member_id().equals(memberLoginUser.getMember_id()+"")){
                        alertDialogTips("任务不属于当前用户,不能取消任务哦");
                        return;
                    }*/
                    handleTaskByActionUrl(TypeSelect.cancelProcedure,HttpUrl.api_task_unwanted,position);

                }else if(typeSelect.getType().equals(TypeSelect.resetProcedure)){//恢复
                    /*if(!data.getTask_member_id().equals(memberLoginUser.getMember_id()+"")){
                        alertDialogTips("任务不属于当前用户,不能操作哦");
                        return;
                    }*/
                    handleTaskByActionUrl(TypeSelect.resetProcedure,HttpUrl.api_task_recovery,position);

                }else if(typeSelect.getType().equals(TypeSelect.acceptTask)){//领取
                    /*if(!data.getTask_catcher().equals(memberLoginUser.getDepartment_name())){
                        alertDialogTips("当前用户不属于该部门,不能操作哦");
                    }*/
                    handleTaskByActionUrl(TypeSelect.acceptTask,HttpUrl.api_task_receive,position);

                }
            }
        });
        customOperationPopWindow.showPopupWindow(moreAction);//可以传个半透明view v_background过去根据业务需要显示隐藏
    }

    private void alertDialogTips(String tip){
        new AppDialog.Builder(activity).setOk("确定").setTitle("提示").setMsg(tip).setClickListener(new AppDialog.OnClickListener() {
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
    //任务领取流程
    private void handleTaskByActionUrl(String action,String url,int position){
        ProgressBean data=mDatas.get(position);
        //String real_name="";
        String task_member_id="";
        String task_catcher="";
        if(action.equals(TypeSelect.assignTask)){
            //real_name=assignUser.getReal_name();
            task_member_id=assignUser.getMember_id()+"";
        }else {
            /*task_member_id=data.getTask_member_id()+"";
            task_catcher=data.getTask_catcher()+"";*/
            task_member_id=memberLoginUser.getMember_id()+"";
        }
        task_catcher=data.getTask_catcher()+"";//当前流程是什么部门就什么部门
        activity.showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("task_id",task_id);
        hashMap.put("task_procedure_id",data.getTask_procedure_id());
        hashMap.put("task_member_id",task_member_id);
        hashMap.put("task_catcher",task_catcher);
        //Log.i("vvvvv",hashMap.toString()+"====="+url);
        TaskHttpUtil.getInstance().handleTaskByActionUrl(url,hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String response) {
                //-1 放弃流程 ,0 未接手, 1 已接手, 2.已完成
                activity.dismissProgressDialog();
                if(action.equals(TypeSelect.assignTask)){
                    mDatas.get(position).setStatus(1);//指派给某个部门的人请求执行了，设置为已经接手的状态
                    mDatas.get(position).setReal_name(assignUser.getReal_name());
                    mDatas.get(position).setTask_member_id(assignUser.getMember_id());
                    mDatas.get(position).setTask_progress("0");
                    notifyItemChanged(position);
                    ToastUtils.show("成功指派给"+assignUser.getReal_name());
                    assignUser=null;
                }else if(action.equals(TypeSelect.giveUpTask)){
                    mDatas.get(position).setStatus(0);//放弃请求执行了，设置为未接手的状态
                    mDatas.get(position).setReal_name("");
                    mDatas.get(position).setTask_progress("0");
                    mDatas.get(position).setTask_member_id("");
                    notifyItemChanged(position);
                    ToastUtils.show("放弃任务成功");
                }/*else if(action.equals(TypeSelect.unAcceptTask)){//接手完了，设置为已接手
                    mDatas.get(position).setStatus(1);
                    mDatas.get(position).setReal_name(memberLoginUser.getReal_name());
                    mDatas.get(position).setTask_progress("0");
                    notifyItemChanged(position);
                    ToastUtils.show("已经接手任务");
                }*/else if(action.equals(TypeSelect.acceptTask)){//接手完了，设置为可以放弃
                    try {
                        JSONObject jsonObject=new JSONObject(response);
                        String task_procedure_id=jsonObject.getString("task_procedure_id");
                        mDatas.get(position).setTask_procedure_id(task_procedure_id);
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                    mDatas.get(position).setStatus(1);//放弃请求执行了，设置为未接手的状态
                    mDatas.get(position).setReal_name(memberLoginUser.getReal_name());
                    mDatas.get(position).setTask_member_id(memberLoginUser.getMember_id());
                    mDatas.get(position).setTask_progress("0");
                    notifyItemChanged(position);
                    ToastUtils.show("成功接手任务");
                }else if(action.equals(TypeSelect.cancelProcedure)){//放弃流程请求完成  设置为已经接手
                    try {
                        JSONObject jsonObject=new JSONObject(response);
                        String task_procedure_id=jsonObject.getString("task_procedure_id");
                        mDatas.get(position).setTask_procedure_id(task_procedure_id);
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                    mDatas.get(position).setStatus(-1);
                    notifyItemChanged(position);
                    ToastUtils.show("已放弃流程");
                }else if(action.equals(TypeSelect.resetProcedure)){
                    mDatas.get(position).setStatus(0);//流程被恢复后重置为未接手状态
                    notifyItemChanged(position);
                    ToastUtils.show("已恢复流程");
                }


                String type="";
                CommonEventEntity eventEntity = new CommonEventEntity(CommonKey.KEY_HANDLE_PROCEDURE_SUCCESS, type);
                RxBus.getDefault().post(eventEntity);
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
    }


    //编辑进度
    private void editProgressByActionUrl(String action,ZzHorizontalProgressBar pb,int task_progress,String url,int position){
        ProgressBean data=getDatas().get(position);
        activity.showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        String procedure_id=data.getTask_procedure_id()+"";
        //String task_catcher=data.getTask_catcher()+"";
        hashMap.put("task_procedure_id",procedure_id);
        hashMap.put("task_member_id",memberLoginUser.getMember_id()+"");
        //hashMap.put("task_catcher",memberLoginUser.getDepartment_name());
        hashMap.put("task_progress",task_progress+"");
        Log.i("aaaaa",hashMap.toString());
        TaskHttpUtil.getInstance().handleTaskByActionUrl(url,hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String response) {
                activity.dismissProgressDialog();
                ToastUtils.show("编辑进度成功");
                if(action.equals(TypeSelect.editProcess)){
                    //pb.setProgress(task_progress);
                    if(task_progress==100){
                        mDatas.get(position).setStatus(2);
                    }
                    mDatas.get(position).setTask_progress(task_progress+"");
                    notifyItemChanged(position);

                    String type="";
                    CommonEventEntity eventEntity = new CommonEventEntity(CommonKey.KEY_HANDLE_PROCEDURE_SUCCESS, type);
                    RxBus.getDefault().post(eventEntity);
                }
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
    }

    //流程评分
    private void procedureScore(float task_score,int position,String level){
        ProgressBean data=getDatas().get(position);
        HashMap<String,String> hashMap=new HashMap<>();
        String procedure_id=data.getTask_procedure_id()+"";
        //String task_catcher=data.getTask_catcher()+"";
        hashMap.put("task_procedure_id",procedure_id);
        hashMap.put("task_member_id",memberLoginUser.getMember_id()+"");
        hashMap.put("task_catcher",data.getDepartment_name());
        hashMap.put("task_score",task_score+"");
        Log.i("aaaaa",hashMap.toString());
        activity.showProgressDialog();
        TaskHttpUtil.getInstance().procedureScore(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String response) {
                activity.dismissProgressDialog();
                mDatas.get(position).setTask_score((int)task_score+"");
                notifyItemChanged(position);
                ToastUtils.show("评分成功");

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
    }
}
