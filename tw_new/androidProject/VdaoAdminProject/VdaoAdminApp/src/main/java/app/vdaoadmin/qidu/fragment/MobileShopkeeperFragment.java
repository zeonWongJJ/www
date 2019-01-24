package app.vdaoadmin.qidu.fragment;

import android.graphics.Color;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.anthony.rvhelper.divider.DividerItemDecoration;
import com.anthony.rvhelper.divider.GridDividerItemDecoration;
import com.app.base.base.AbsListFragment;
import com.app.base.bean.User;
import com.common.lib.widget.ClearEditText;
import com.common.lib.widget.StatusViewLayout;
import com.mvp.lib.presenter.BasePresenter;
import com.mvp.lib.view.IBaseFragmentView;

import java.util.ArrayList;
import java.util.List;

import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.adapter.JustSimpleAdapter;
import app.vdaoadmin.qidu.adapter.ManagerUserListAdapter;
import app.vdaoadmin.qidu.adapter.MobileShopkeeperAdapter;
import app.vdaoadmin.qidu.bean.Topic;
import app.vdaoadmin.qidu.mvp.contract.UserContract;
import app.vdaoadmin.qidu.mvp.presenter.UserPresenterImpl;
import io.reactivex.processors.PublishProcessor;

/**
 * 会话
 */

public class MobileShopkeeperFragment extends AbsListFragment<UserPresenterImpl> implements UserContract.View {
    protected RecyclerView mRecyclerView;
    protected SwipeRefreshLayout mPtr;
    protected StatusViewLayout mStatusViewLayout;

    private MultiItemTypeAdapter adapter;
    private String mTitle;
    private ClearEditText searchKey;
    private String keywords="";
    private String shopkeeperState="";
    MobileShopkeeperFragment sf;
    public static MobileShopkeeperFragment getInstance(String title) {
        MobileShopkeeperFragment sf = new MobileShopkeeperFragment();
        sf.mTitle = title;
        return sf;
    }
    @Override
    public void loadData(int pageIndex) {
        //"全部为空", "1已通过", "2待处理", "3已拒绝", "4已搁置"
        mPresenter.loadShopKeeperData(pageIndex,keywords,shopkeeperState);
    }

    public void searchShopkeeper(String keywords){
        this.keywords=keywords;
        mPresenter.loadShopKeeperData(getInitPageIndex(),this.keywords,shopkeeperState);
    }
    @Override
    public View initView(LayoutInflater inflater, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.lib_fragment_base_recyclerview, null);
        return view;
    }

    @Override
    public void initViewsAndEvents(View view, @Nullable Bundle savedInstanceState) {
        if(mTitle.equals("全部")){
            shopkeeperState="";
        }else if(mTitle.equals("全部")){
            shopkeeperState="";
        }else if(mTitle.equals("已通过")){
            shopkeeperState="1";
        }else if(mTitle.equals("待处理")){
            shopkeeperState="2";
        }else if(mTitle.equals("已拒绝")){
            shopkeeperState="3";
        }else if(mTitle.equals("已搁置")){
            shopkeeperState="4";
        }
        //layout_mobile_shopkeeper_item
        adapter = new MobileShopkeeperAdapter(mContext);
        mStatusViewLayout=findView(R.id.status_view_layout);
        mPtr=findView(R.id.refresh_layout);
        mRecyclerView=findView(R.id.recyclerview);
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_manager_user);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));

        initPagingList(mRecyclerView, adapter, mPtr, mStatusViewLayout);
        View divide = getActivity().getLayoutInflater().inflate(R.layout.layout_recyclerview_divider,null);
        headerAndFooterWrapper.addHeaderView(divide);

        refreshData();
    }

    @Override
    protected UserPresenterImpl initPresenter() {
        return new UserPresenterImpl();
    }

    @Override
    public void showUserList(int pageIndex, List<User> list) {
        onDataSuccessReceived(pageIndex,list);
        if(pageIndex==getInitPageIndex()&&list.size()>0){
            mRecyclerView.scrollToPosition(0);
        }
    }

    @Override
    public void showUserListFailure() {

    }
}