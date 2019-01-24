package app.vdaoadmin.qidu.fragment;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.anthony.rvhelper.divider.DividerItemDecoration;
import com.app.base.base.AbsListFragment;
import com.common.lib.widget.StatusViewLayout;
import com.mvp.lib.presenter.BasePresenter;
import com.mvp.lib.view.IBaseFragmentView;

import java.util.ArrayList;
import java.util.List;

import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.adapter.OrderListAdapter;
import app.vdaoadmin.qidu.adapter.StoreListAdapter;
import app.vdaoadmin.qidu.bean.Store;
import app.vdaoadmin.qidu.bean.Topic;
import app.vdaoadmin.qidu.mvp.contract.StoreContract;
import app.vdaoadmin.qidu.mvp.presenter.StorePresenterImpl;
import io.reactivex.processors.PublishProcessor;

/**
 * 订单
 */

public class OrderListFragment extends AbsListFragment<StorePresenterImpl> implements StoreContract.View{
    protected RecyclerView mRecyclerView;
    protected SwipeRefreshLayout mPtr;
    private String mTitle;
    protected StatusViewLayout mStatusViewLayout;

    private MultiItemTypeAdapter adapter;

    public static OrderListFragment getInstance(String title) {
        OrderListFragment sf = new OrderListFragment();
        sf.mTitle = title;
        return sf;
    }
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
        mPresenter.loadData(pageIndex,"");
    }

    @Override
    public View initView(LayoutInflater inflater, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_order_list, null);
        return view;
    }

    @Override
    public void initViewsAndEvents(View view, @Nullable Bundle savedInstanceState) {
        TextView titleCenter=findView(R.id.header_text);
        titleCenter.setText("订单");
        adapter = new OrderListAdapter(mContext);
        mStatusViewLayout=findView(R.id.status_view_layout);
        mPtr=findView(R.id.refresh_layout);
        mRecyclerView=findView(R.id.recyclerview);
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_manager_user);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));

        initPagingList(mRecyclerView, adapter, mPtr, mStatusViewLayout);
        /*TextView t3 = new TextView(getActivity());
        t3.setText("HeadView Text");
        headerAndFooterWrapper.addHeaderView(t3);
        headerAndFooterWrapper.addHeaderView(t3);*/

        refreshData();
    }

    @Override
    protected StorePresenterImpl initPresenter() {
        return new StorePresenterImpl();
    }

    @Override
    public void showStoreList(int pageIndex, List<Store> list) {
        onDataSuccessReceived(pageIndex,list);
        if(pageIndex==getInitPageIndex()&&list.size()>0){
            mRecyclerView.scrollToPosition(0);
        }
    }

    @Override
    public void showStoreListFailure() {

    }
}