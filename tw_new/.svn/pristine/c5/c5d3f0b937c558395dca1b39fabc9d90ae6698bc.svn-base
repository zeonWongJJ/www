package app.odp.qidu.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.DynamicComment;
import com.app.base.netUtil.PublishCommentHttpUtil;
import com.app.base.utils.CommonKey;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.common.lib.basemvp.presenter.BasePresenter;
import com.common.lib.utils.StatusBarUtil;
import com.common.lib.utils.ToastUtils;
import com.luck.picture.lib.immersive.LightStatusBarUtils;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * Created by 7du-28 on 2018/8/1.
 */

public class PublishDynamicActivity extends BasePhotoActivity<BasePresenter>{
    public static int PUBLISH_DYNAMIC=0;
    public static int FORWARD_DYNAMIC=1;
    private String member_id;
    private EditText commentDesc;
    private int handleType=0;
    private String forwarded_id;
    private String forwarded_user_name,forward_content;
    private TextView forward_des,user_name;
    //private String replyId;

    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        StatusBarUtil.setStatusBarColor(getActivity(),R.color.app_bg);
        LightStatusBarUtils.setLightStatusBar(getActivity(),true);
        View layout_parent=findView(R.id.layout_parent);
        layout_parent.setBackgroundColor(getResources().getColor(R.color.app_bg));
        handleType=getIntent().getIntExtra(IntentParams.KEY_DYNAMIC_TYPE,0);
        member_id= LoginUtil.getInstance().getLoginUser().getMember_id();
        TextView titleCenter=findView(R.id.title_center_text);
        titleCenter.setTextColor(getResources().getColor(R.color.black));
        initSelectPhoto();
        TextView right=findView(R.id.title_right_text);
        right.setTextColor(getResources().getColor(R.color.blue));
        right.setText("发布");
        right.setOnClickListener(v -> {
            publishDynamicComment();
        });
        ImageView back=findView(R.id.title_left_image);
        back.setImageResource(R.drawable.icon_back_black);
        back.setOnClickListener(v -> {
            finish();
        });
        commentDesc=findView(R.id.comment_desc);
        View forward_layout=findView(R.id.forward_layout);
        if(handleType==FORWARD_DYNAMIC){
            titleCenter.setText("转发动态");
            //replyId=getIntent().getStringExtra(IntentParams.KEY_COMMENT_REPLY_ID);
            forwarded_id=getIntent().getStringExtra(IntentParams.KEY_DYNAMIC_FORWARD_ID);
            forwarded_user_name=getIntent().getStringExtra(IntentParams.KEY_DYNAMIC_FORWARD_USER);
            forward_content=getIntent().getStringExtra(IntentParams.KEY_DYNAMIC_FORWARD_CONTENT);
            forward_layout.setVisibility(View.VISIBLE);
            imgRecyclerView.setVisibility(View.GONE);
            forward_des=findView(R.id.forward_des);
            user_name=findView(R.id.user_name);
            user_name.setText(forwarded_user_name);;
            forward_des.setText(forward_content);
        }else {
            titleCenter.setText("发布动态");
            forward_layout.setVisibility(View.GONE);
            imgRecyclerView.setVisibility(View.VISIBLE);
        }
    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        return inflater.inflate(R.layout.activity_publish_dynamic,null);
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

    public void publishDynamicComment(){
        String content=commentDesc.getText().toString().trim();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("member_id",member_id+"");
        if(TextUtils.isEmpty(content)){
            ToastUtils.show("内容不能为空");
            return;
        }
        hashMap.put("content",content+"");
        if(handleType==FORWARD_DYNAMIC){
            hashMap.put("forwarded_id",forwarded_id+"");//转发内容的id
        }else {
            /*if(replyId!=null){
                hashMap.put("id",replyId);
            }*/
            String imgUrl=imgAdapter.getUploadUrls();
            if(!TextUtils.isEmpty(imgUrl)){
                hashMap.put("pic", imgUrl);
            }
        }
        showProgressDialog();
        Disposable disposable= PublishCommentHttpUtil.getInstance().publishDynamicComment(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                dismissProgressDialog();
                try {
                    JSONObject jsonObject=new JSONObject(data);
                    DynamicComment dynamicComment=GsonUtil.getObject(jsonObject.getString("record"),DynamicComment.class);
                    /*CommonEventEntity eventEntity = new CommonEventEntity(CommonKey.KEY_DYNAMIC_COMMENT_SUCCESS_CODE, dynamicComment);
                    RxBus.getDefault().post(eventEntity);*/
                    Intent intent = new Intent(CommonKey.KEY_DYNAMIC_COMMENT_SUCCESS_CODE);
                    intent.putExtra(IntentParams.KEY_DYNAMIC_COMMENT_DATA,dynamicComment);
                    sendBroadcast(intent);
                    if(handleType==FORWARD_DYNAMIC){
                        ToastUtils.show("动态转发成功");
                    }else {
                        ToastUtils.show("发布动态成功");
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                finish();
            }

            @Override
            public void onError(Throwable e) {
                showError(e,true);
                dismissProgressDialog();
            }
            @Override
            public void onComplete() {

            }
        },String.class);
        mPresenter.getCompositeSubscription().add(disposable);
    }
}
