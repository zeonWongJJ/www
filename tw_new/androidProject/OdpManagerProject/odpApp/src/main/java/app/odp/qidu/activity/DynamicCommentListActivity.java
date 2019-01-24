package app.odp.qidu.activity;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.media.Image;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.app.base.base.AbsListActivity;
import com.app.base.bean.Comment;
import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.DynamicComment;
import com.app.base.bean.MemberRealm;
import com.app.base.bean.TopMenuItem;
import com.app.base.netUtil.PublishCommentHttpUtil;
import com.app.base.utils.CommonKey;
import com.app.base.utils.DataUtils;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.app.base.widget.TopMenuPopupWindow;
import com.common.lib.utils.ScreenUtils;
import com.common.lib.utils.StatusBarUtil;
import com.common.lib.widget.StatusViewLayout;
import com.luck.picture.lib.immersive.LightStatusBarUtils;
import com.common.lib.basemvp.presenter.BasePresenter;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.adapter.DynamicCommentListAdapter;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 单条任务对应的记录列表
 */

public class DynamicCommentListActivity extends AbsListActivity<BasePresenter>{
    private RecyclerView mRecyclerView;
    private MultiItemTypeAdapter adapter;
    protected SwipeRefreshLayout mPtr;
    private StatusViewLayout mStatusViewLayout;
    private String member_id;
    public static int MINE_DYNAMIC=1;
    private int dynamicType=0;
    private List<TopMenuItem> menuList=new ArrayList<>();
    private String PUBLISH_DYNAMIC="publish.dynamic";
    private String MINE_DYNAMIC_LIST="mine.dynamic";
    private MemberRealm loginUser;
    private View dynamicTipLayout;
    private TextView dynamic_count;
    private ImageView user_photo;


    private BroadcastReceiver broadcastReceiver=new BroadcastReceiver() {
        @Override
        public void onReceive(Context context, Intent intent) {
            String action = intent.getAction();
            if(action.equals(CommonKey.KEY_DYNAMIC_COMMENT_SUCCESS_CODE)){
                mStatusViewLayout.showContent();
                DynamicComment dynamicComment= (DynamicComment) intent.getSerializableExtra(IntentParams.KEY_DYNAMIC_COMMENT_DATA);
                //((DynamicCommentListAdapter)adapter).addNewComment(dynamicComment);
                //adapter.getDatas().add(0,dynamicComment);
                ((DynamicCommentListAdapter)adapter).getDatas().add(0,dynamicComment);
                mLoadMoreWrapper.notifyDataSetChanged();
                mRecyclerView.scrollToPosition(0);

            }else if(action.equals(CommonKey.KEY_DYNAMIC_COMMENT_HAVE_READ)){
                if(dynamicType==0){
                    dynamicTipLayout.setVisibility(View.GONE);
                }
            }
        }
    };


    @Override
    protected void onDestroy() {
        super.onDestroy();
        unregisterReceiver(broadcastReceiver);
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        dynamicType=getIntent().getIntExtra(IntentParams.KEY_DYNAMIC_TYPE,0);
        super.onCreate(savedInstanceState);
    }

    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        IntentFilter filter = new IntentFilter();
        filter.addAction(CommonKey.KEY_DYNAMIC_COMMENT_SUCCESS_CODE);
        filter.addAction(CommonKey.KEY_DYNAMIC_COMMENT_HAVE_READ);
        this.registerReceiver(broadcastReceiver, filter);
        TextView titleCenter=findView(R.id.title_center_text);
        mRecyclerView=findView(R.id.recyclerview);
        mPtr=findView(R.id.refresh_layout);
        mStatusViewLayout=findView(R.id.status_view_layout);
        loginUser=LoginUtil.getInstance().getLoginUser();
        member_id= loginUser.getMember_id();

        ImageView left=findView(R.id.title_left_image);
        left.setOnClickListener(v -> {
            finish();
        });
        adapter=new DynamicCommentListAdapter(getActivity(),mRecyclerView);
        /*DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_one);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);*/
        LinearLayoutManager linearLayoutManager=new LinearLayoutManager(getActivity());
        //linearLayoutManager.setStackFromEnd(true);
        mRecyclerView.setLayoutManager(linearLayoutManager);
        initPagingList(mRecyclerView, adapter, mPtr, mStatusViewLayout);
        if(dynamicType!=0){
            StatusBarUtil.setStatusBarColor(getActivity(),R.color.white);
            LightStatusBarUtils.setLightStatusBar(getActivity(),true);
            TextView right=findView(R.id.title_right_text);
            left.setImageResource(R.drawable.icon_back_black);
            titleCenter.setTextColor(getResources().getColor(R.color.black));
            right.setTextColor(getResources().getColor(R.color.black));
            right.setText("消息");
            View layout_parent=findView(R.id.layout_parent);
            layout_parent.setBackgroundColor(getResources().getColor(R.color.white));
            titleCenter.setText("我的动态");
            right.setOnClickListener(v -> {
                /*Intent intent=new Intent(getActivity(),PublishDynamicActivity.class);
                intent.putExtra(IntentParams.KEY_DYNAMIC_TYPE,PublishDynamicActivity.PUBLISH_DYNAMIC);
                startActivity(intent);*/
                Intent intent=new Intent(getActivity(),DynamicCommentRecordActivity.class);
                startActivity(intent);
            });
            View headerView=LayoutInflater.from(this).inflate(R.layout.layout_header_mine_dynamic,null);
            ViewGroup.LayoutParams layoutParams=new ViewGroup.LayoutParams(ViewGroup.LayoutParams.MATCH_PARENT, ViewGroup.LayoutParams.WRAP_CONTENT);
            headerView.setLayoutParams(layoutParams);
            TextView userName=headerView.findViewById(R.id.user_name);
            TextView departmentName=headerView.findViewById(R.id.department_name);
            if(loginUser.getReal_name()!=null){
                userName.setText("- "+loginUser.getReal_name());
            }else {
                userName.setText("- "+loginUser.getMember_name());
            }
            if(loginUser.getMajor()!=null){
                departmentName.setText(loginUser.getMajor());
            }else {
                departmentName.setText(loginUser.getDepartment_name());
            }
            headerAndFooterWrapper.addHeaderView(headerView);
            ((DynamicCommentListAdapter)adapter).setHeaderAndFooterWrapper(headerAndFooterWrapper);
        }else {
            /*StatusBarUtil.setStatusBarColor(getActivity(),R.color.transparent);
            LightStatusBarUtils.setLightStatusBar(getActivity(),true);
            View layout_parent=findView(R.id.layout_parent);
            layout_parent.setBackgroundColor(getResources().getColor(R.color.transparent));
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
                setTranslucentStatus(true);
                LinearLayout.LayoutParams params= (LinearLayout.LayoutParams) layout_parent.getLayoutParams();
                //params.topMargin= ScreenUtils.getStatusBarHeight(this);
                params.setMargins(0, ScreenUtils.getStatusBarHeight(this), 0, 0);
                layout_parent.setLayoutParams(params);
            }*/

            titleCenter.setText("动态圈");
            ImageView right=findView(R.id.title_right_image);
            right.setImageResource(R.drawable.icon_more);
            TopMenuItem publishDynamic=new TopMenuItem("发帖子",PUBLISH_DYNAMIC);
            TopMenuItem mineDynamic=new TopMenuItem("我的动态",MINE_DYNAMIC_LIST);
            menuList.add(publishDynamic);
            menuList.add(mineDynamic);
            right.setOnClickListener(v -> {
                showPopMore(v);
            });
            View headerView=LayoutInflater.from(this).inflate(R.layout.layout_header_dynamic,null);
            dynamicTipLayout=headerView.findViewById(R.id.dynamic_tip_layout);
            dynamicTipLayout.setOnClickListener(v -> {
                Intent intent=new Intent(getActivity(),DynamicCommentRecordActivity.class);
                startActivity(intent);
            });
            user_photo= headerView.findViewById(R.id.user_photo_tip);
            dynamic_count=headerView.findViewById(R.id.dynamic_count);
            ViewGroup.LayoutParams layoutParams=new ViewGroup.LayoutParams(ViewGroup.LayoutParams.MATCH_PARENT, ViewGroup.LayoutParams.WRAP_CONTENT);
            headerView.setLayoutParams(layoutParams);
            headerAndFooterWrapper.addHeaderView(headerView);
            ((DynamicCommentListAdapter)adapter).setHeaderAndFooterWrapper(headerAndFooterWrapper);
        }
        refreshData();
    }

    private void showPopMore(View v){

        new TopMenuPopupWindow(getActivity()).builder().setSheetItems(menuList).setOnSheetItemClickListener((data, which) -> {
            String action=data.getAction();
            if(action.equals(PUBLISH_DYNAMIC)){
                Intent intent=new Intent(getActivity(),PublishDynamicActivity.class);
                intent.putExtra(IntentParams.KEY_DYNAMIC_TYPE,PublishDynamicActivity.PUBLISH_DYNAMIC);
                startActivity(intent);
            }else if(action.equals(MINE_DYNAMIC_LIST)){
                Intent intent=new Intent(getActivity(),DynamicCommentListActivity.class);
                intent.putExtra(IntentParams.KEY_DYNAMIC_TYPE,1);
                startActivity(intent);
            }
        }).showPop(v);
    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        if(dynamicType!=0){
            return inflater.inflate(R.layout.activity_title_recyclerview_common,null);
        }
        return inflater.inflate(R.layout.activity_dynamic_comment_list,null);
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
        String url= HttpUrl.api_dynamic_list;
        hashMap.put("offset",pageIndex+"");
        hashMap.put("rows",pageSize+"");
        hashMap.put("member_id",member_id+"");
        if(dynamicType!=0){//我的动态
            hashMap.put("dynamic_member_id",member_id);
        }
        Disposable disposable= PublishCommentHttpUtil.getInstance().dynamicCommentList(url,hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                List<DynamicComment> commentList=new ArrayList<>();
                if(!TextUtils.isEmpty(data)&&!data.equals("")){
                    try {
                        JSONObject jsonObject=new JSONObject(data);
                        String str=jsonObject.getString("list");
                        if(str!=null&&!str.equals("null")) {
                            commentList = GsonUtil.getObjectList(str, DynamicComment.class);
                        }
                        int count=jsonObject.getInt("count");
                        if(count>0&&dynamicType==0){
                            dynamicTipLayout.setVisibility(View.VISIBLE);
                            //user_photo
                            dynamic_count.setText(count+"条新消息");
                        }else if(count==0&&dynamicType==0){
                            dynamicTipLayout.setVisibility(View.GONE);
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
                onDataSuccessReceived(pageIndex,commentList);
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


    ///dynamicTipLayout
    /*public void dynamicCommentCount() {
        HashMap<String,String> hashMap=new HashMap<>();
        Disposable disposable= PublishCommentHttpUtil.getInstance().dynamicCommentCount(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                if(dynamicType!=0){
                    dynamicTipLayout.setVisibility(View.VISIBLE);
                    //user_photo
                    dynamic_count.setText("条新消息");
                }
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
    }*/
}
