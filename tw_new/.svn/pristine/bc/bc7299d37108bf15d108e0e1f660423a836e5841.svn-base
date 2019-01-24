package app.odp.qidu.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.anthony.rvhelper.divider.DividerItemDecoration;
import com.app.base.base.AbsListActivity;
import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.DynamicComment;
import com.app.base.bean.DynamicCommentRecord;
import com.app.base.netUtil.PublishCommentHttpUtil;
import com.app.base.utils.CommonKey;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.common.lib.utils.StatusBarUtil;
import com.common.lib.utils.ToastUtils;
import com.common.lib.widget.AppDialog;
import com.common.lib.widget.StatusViewLayout;
import com.luck.picture.lib.immersive.LightStatusBarUtils;
import com.common.lib.basemvp.presenter.BasePresenter;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.adapter.DynamicCommentRecordAdapter;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 动态评论消息
 */

public class DynamicCommentRecordActivity extends AbsListActivity<BasePresenter>{
    private RecyclerView mRecyclerView;
    private MultiItemTypeAdapter adapter;
    protected SwipeRefreshLayout mPtr;
    private StatusViewLayout mStatusViewLayout;
    private String member_id;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        StatusBarUtil.setStatusBarColor(getActivity(),R.color.white);
        LightStatusBarUtils.setLightStatusBar(getActivity(),true);
        View layout_parent=findView(R.id.layout_parent);
        layout_parent.setBackgroundColor(getResources().getColor(R.color.white));
        member_id= LoginUtil.getInstance().getLoginUser().getMember_id();
        TextView titleCenter=findView(R.id.title_center_text);
        titleCenter.setTextColor(getResources().getColor(R.color.black));
        titleCenter.setText("动态消息");
        TextView right=findView(R.id.title_right_text);
        right.setTextColor(getResources().getColor(R.color.blue));
        right.setText("清空");
        ImageView left=findView(R.id.title_left_image);
        left.setOnClickListener(v -> {
            finish();
        });
        left.setImageResource(R.drawable.icon_back_black);
        right.setOnClickListener(v -> {
            new AppDialog.Builder(getActivity()).setCancel("取消").setOk("确定").setMsg("清空所有消息？").setClickListener(new AppDialog.OnClickListener() {
                @Override
                public void onOkClick() {
                    clearAllMessage();
                }
                @Override
                public void onCancelClick() {}
                @Override
                public void onDismiss() {}
            }).create();
        });
        mRecyclerView=findView(R.id.recyclerview);
        mPtr=findView(R.id.refresh_layout);
        mStatusViewLayout=findView(R.id.status_view_layout);
        adapter=new DynamicCommentRecordAdapter(this);
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_one);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
        initPagingList(mRecyclerView, adapter, mPtr, mStatusViewLayout);
        refreshData();
    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        return inflater.inflate(R.layout.activity_title_recyclerview_common,null);
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

    @Override
    public void loadData(int pageIndex) {
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("offset",pageIndex+"");
        hashMap.put("rows",pageSize+"");
        hashMap.put("member_id",member_id+"");

        Disposable disposable= PublishCommentHttpUtil.getInstance().dynamicCommentMessage(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                List<DynamicCommentRecord> commentList=new ArrayList<>();
                /*if(!TextUtils.isEmpty(data)&&!data.equals("")){
                    commentList= GsonUtil.getObjectList(data,DynamicCommentRecord.class);
                }*/
                try {
                    JSONObject jsonObject=new JSONObject(data);
                    String str=jsonObject.getString("list");
                    if(str!=null&&!str.equals("null")) {
                        commentList= GsonUtil.getObjectList(str,DynamicCommentRecord.class);
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                onDataSuccessReceived(pageIndex,commentList);
                Intent intent = new Intent(CommonKey.KEY_DYNAMIC_COMMENT_HAVE_READ);
                sendBroadcast(intent);
            }

            @Override
            public void onError(Throwable e) {
                showError(e);
            }
            @Override
            public void onComplete() {

            }
        },String.class);
        mPresenter.getCompositeSubscription().add(disposable);
    }


    private void clearAllMessage(){
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("member_id",member_id);
        Disposable disposable= PublishCommentHttpUtil.getInstance().dynamicMessageClear(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                onDataSuccessReceived(0,new ArrayList());
                ToastUtils.show("消息已清空");
            }

            @Override
            public void onError(Throwable e) {
                showError(e);
            }
            @Override
            public void onComplete() {

            }
        },String.class);
        mPresenter.getCompositeSubscription().add(disposable);
    }
}
