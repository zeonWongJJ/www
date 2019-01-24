package app.odp.qidu.adapter;

import android.content.Context;
import android.content.Intent;
import android.widget.ImageView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.TypeSelect;
import com.app.base.netUtil.MemberHttpUtil;
import com.app.base.utils.IntentParams;
import com.common.lib.base.AbsBaseFragment;
import com.common.lib.utils.ToastUtils;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;

import app.odp.qidu.R;
import app.odp.qidu.activity.ApprovalListActivity;
import app.odp.qidu.activity.LeaveListActivity;
import app.odp.qidu.activity.NoticeHomeActivity;
import app.odp.qidu.activity.SignInRecordActivity;
import app.odp.qidu.fragment.TabAchievementFragment;
import io.reactivex.observers.DisposableObserver;

//绩效导航页--事务记录
public class ThingRecordGridAdapter extends CommonAdapter<TypeSelect> {
    private TabAchievementFragment fragment;
    public ThingRecordGridAdapter(TabAchievementFragment fragment) {
        super(fragment.getActivity(), R.layout.layout_thing_record_item);
        this.fragment=fragment;
    }

    @Override
    protected void convert(ViewHolder holder, TypeSelect data, int position) {
        holder.setText(R.id.title,data.getTitle());
        ImageView img=holder.getView(R.id.img);
        if(data.getType().equals("attendanceBean")){
            img.setImageResource(R.drawable.icon_attendance);
        }else if(data.getType().equals("leaveBean")){
            img.setImageResource(R.drawable.icon_leave);
        }else if(data.getType().equals("approvalBean")){
            img.setImageResource(R.drawable.icon_approval_corner);
        }else if(data.getType().equals("notice")){
            img.setImageResource(R.drawable.icon_notice_home);
        }else if(data.getType().equals(TypeSelect.signInBean)){
            if(data.getStatus().equals("0")){
                img.setImageResource(R.drawable.icon_have_sign);
            }else {
                img.setImageResource(R.drawable.icon_un_sign);
            }
        }
        holder.getConvertView().setOnClickListener(v -> {
            if(data.getType().equals("attendanceBean")){
                //考勤记录
                Intent intent=new Intent(mContext, SignInRecordActivity.class);
                intent.putExtra(IntentParams.KEY_QUERY_TIME,fragment.getQuery_time());
                mContext.startActivity(intent);
            }else if(data.getType().equals("leaveBean")){
                //请假记录
                Intent intent=new Intent(mContext,LeaveListActivity.class);
                intent.putExtra(IntentParams.KEY_QUERY_TIME,fragment.getQuery_time());
                mContext.startActivity(intent);
            }else if(data.getType().equals("approvalBean")){
                //审批记录
                Intent intent=new Intent(mContext,ApprovalListActivity.class);
                intent.putExtra(IntentParams.KEY_QUERY_TIME,fragment.getQuery_time());
                mContext.startActivity(intent);
            }else if(data.getType().equals("notice")){
                //公告通知
                Intent intent=new Intent(mContext,NoticeHomeActivity.class);
                mContext.startActivity(intent);
            }else if(data.getType().equals(TypeSelect.signInBean)&&data.getStatus().equals("1")){
                signIn(position);
            }else if(data.getType().equals(TypeSelect.signInBean)&&data.getStatus().equals("0")){
                ToastUtils.show("你已经签到过了");
            }
        });
    }
    //签到
    private void signIn(int position){
        fragment.showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        MemberHttpUtil.getInstance().signIn(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String s) {
                fragment.dismissProgressDialog();
                try {
                    JSONObject jsonObject=new JSONObject(s);
                    int status=jsonObject.getInt("status");
                    if(status==0){
                        ToastUtils.show("你已经签到过了");
                    }
                    mDatas.get(position).setStatus("0");
                    notifyItemChanged(position);

                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }

            @Override
            public void onError(Throwable e) {
                fragment.dismissProgressDialog();
                ToastUtils.show("签到失败,请重试");
            }
            @Override
            public void onComplete() {

            }
        },String.class);
    }


}
