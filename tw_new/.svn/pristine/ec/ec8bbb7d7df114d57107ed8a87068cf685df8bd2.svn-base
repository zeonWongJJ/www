package app.odp.qidu.activity;

import android.content.Intent;
import android.os.Bundle;
import android.text.SpannableStringBuilder;
import android.text.Spanned;
import android.text.style.UnderlineSpan;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.app.base.bean.AbsenceBean;
import com.app.base.bean.SystemNotice;
import com.app.base.netUtil.NoticeHttpUtil;
import com.app.base.utils.CommonKey;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.IntentParams;
import com.common.lib.base.AbsBaseActivity;
import com.common.lib.utils.StatusBarUtil;
import com.common.lib.utils.ToastUtils;
import com.luck.picture.lib.immersive.LightStatusBarUtils;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;

import app.odp.qidu.R;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 系统通知详情
 */

public class SystemNoticeDetailsActivity extends AbsBaseActivity{
    private String id;
    private TextView date,content;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_system_notice_details);
        StatusBarUtil.setStatusBarColor(getActivity(),R.color.white);
        LightStatusBarUtils.setLightStatusBar(getActivity(),true);
        id=getIntent().getStringExtra(IntentParams.KEY_ID);
        View layout_parent=findViewById(R.id.layout_parent);
        date= (TextView) findViewById(R.id.date);
        content= (TextView) findViewById(R.id.content);
        layout_parent.setBackgroundColor(getResources().getColor(R.color.white));
        TextView titleCenter= (TextView) findViewById(R.id.title_center_text);
        titleCenter.setTextColor(getActivity().getResources().getColor(R.color.black));
        titleCenter.setText("公告详情");
        ImageView back= (ImageView) findViewById(R.id.title_left_image);
        back.setImageResource(R.drawable.icon_back_black);
        back.setOnClickListener(v -> {
            finish();
        });
        systemNoticeDetails(id);
    }
    private void systemNoticeDetails(SystemNotice systemNotice){
        date.setText(systemNotice.getPost_add()+"");
        if(systemNotice.getNotice_type().equals(CommonKey.KEY_NOTICE_TASK)){
            String taskId=systemNotice.getBelong_id();
            content.setTextColor(getResources().getColor(R.color.blue));
            content.setOnClickListener(v -> {
                if(taskId!=null) {
                    Intent intent = new Intent(getActivity(), TaskDetailsActivity.class);
                    intent.putExtra(IntentParams.KEY_TASK_ID, taskId);
                    startActivity(intent);
                }
            });
            SpannableStringBuilder builder = new SpannableStringBuilder(systemNotice.getConnect());
            builder.setSpan(new UnderlineSpan(), 0, systemNotice.getConnect().length(), Spanned.SPAN_INCLUSIVE_EXCLUSIVE);
            content.setText(builder);
        }else if(systemNotice.getNotice_type().equals(CommonKey.KEY_NOTICE_PLAN)){
            content.setTextColor(getResources().getColor(R.color.blue));
            String planId=systemNotice.getBelong_id();
            content.setOnClickListener(v -> {
                Intent intent=new Intent(getActivity(), PlanDetailsActivity.class);
                intent.putExtra(IntentParams.KEY_PLAN_ID,planId+"");
                startActivity(intent);
            });
            SpannableStringBuilder builder = new SpannableStringBuilder(systemNotice.getConnect());
            builder.setSpan(new UnderlineSpan(), 0, systemNotice.getConnect().length(), Spanned.SPAN_INCLUSIVE_EXCLUSIVE);
            content.setText(builder);
        }else {
            content.setTextColor(getResources().getColor(R.color.gray));
            content.setText(systemNotice.getConnect());
        }
    }

    private void systemNoticeDetails(String id){
        showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("id",id+"");//pageIndex*pageSize
        Disposable disposable= NoticeHttpUtil.getInstance().systemNoticeDetails(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                SystemNotice systemNotice=null;
                try {
                    JSONObject object=new JSONObject(data);
                    String str=object.getString("list");
                    if(str!=null&&!str.equals("null")) {
                        systemNotice = GsonUtil.getObject(object.getString("list"), SystemNotice.class);
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                systemNoticeDetails(systemNotice);
                dismissProgressDialog();
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
