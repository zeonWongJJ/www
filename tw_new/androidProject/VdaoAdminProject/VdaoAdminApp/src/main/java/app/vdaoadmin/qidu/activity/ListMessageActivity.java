package app.vdaoadmin.qidu.activity;

import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.anthony.rvhelper.divider.DividerItemDecoration;
import com.anthony.rvhelper.divider.GridDividerItemDecoration;
import com.app.base.base.AbsListActivity;
import com.common.lib.utils.ScreenUtils;
import com.common.lib.widget.StatusViewLayout;
import com.mvp.lib.presenter.BasePresenter;
import com.mvp.lib.view.IBaseActivityView;

import java.util.ArrayList;
import java.util.List;

import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.adapter.JustSimpleAdapter;
import app.vdaoadmin.qidu.adapter.MessageListAdapter;
import app.vdaoadmin.qidu.bean.MessageBean;
import app.vdaoadmin.qidu.bean.Topic;
import app.vdaoadmin.qidu.mvp.contract.MessageContract;
import app.vdaoadmin.qidu.mvp.presenter.MessagePresenterImpl;
import io.reactivex.processors.PublishProcessor;

/**
 * 消息列表
 */

public class ListMessageActivity extends AbsListActivity<MessagePresenterImpl> implements MessageContract.View{
    protected RecyclerView mRecyclerView;
    protected SwipeRefreshLayout mPtr;
    protected StatusViewLayout mStatusViewLayout;
    private MultiItemTypeAdapter adapter;
    /*@TargetApi(19)
    private void setTranslucentStatus(boolean on) {
        Window win = getActivity().getWindow();
        WindowManager.LayoutParams winParams = win.getAttributes();
        final int bits = WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS;
        if (on) {
            winParams.flags |= bits;
        } else {
            winParams.flags &= ~bits;
        }
        win.setAttributes(winParams);
    }*/

    @Override
    public void loadData(int pageIndex) {
        mPresenter.loadData(pageIndex);
    }
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        ImageView status_view= (ImageView) findViewById(R.id.status_view);
        View status_view_layout=findViewById(R.id.status_bar_layout);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
            setTranslucentStatus(true);
            LinearLayout.LayoutParams params= (LinearLayout.LayoutParams) status_view.getLayoutParams();
            params.height= ScreenUtils.getStatusBarHeight(this);
            //params.setMargins(0, ScreenUtils.getStatusBarHeight(this), 0, 0);
            status_view.setLayoutParams(params);
            status_view_layout.setVisibility(View.VISIBLE);
        }
        View back=findView(R.id.header_left_btn_img);
        back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        TextView title=findView(R.id.header_text);
        title.setText("消息");
        adapter = new MessageListAdapter(this);
        mStatusViewLayout=findView(R.id.status_view_layout);
        mPtr=findView(R.id.refresh_layout);
        mRecyclerView=findView(R.id.recyclerview);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
        initPagingList(mRecyclerView, adapter, mPtr, mStatusViewLayout);
        refreshData();
    }

    @Override
    public View initView(LayoutInflater inflater, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.activity_base_recyclerview, null);
        return view;
    }

    @Override
    protected MessagePresenterImpl initPresenter() {
        return new MessagePresenterImpl();
    }


    @Override
    public void showMessageList(int pageIndex,List<MessageBean> list) {
        onDataSuccessReceived(pageIndex,list);
        if(pageIndex==getInitPageIndex()&&list.size()>0){
            mRecyclerView.scrollToPosition(0);
        }
    }

    @Override
    public void showMessageListFailure() {
        //showError(new Exception("网络出小差了!!!"));
    }
}